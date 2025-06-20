<?php

namespace colq2\BladeMjml;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\View\Engines\CompilerEngine;

class PostProcessingCompilerEngine extends CompilerEngine
{
    /**
     * Array of post-processing callbacks
     */
    protected static array $postProcessors = [];

    /**
     * Whether post-processing is enabled
     */
    protected static bool $enabled = true;

    /**
     * Get the evaluated contents of the view
     */
    public function get($path, array $data = [])
    {
        $contents = parent::get($path, $data);

        if (static::$enabled && ! empty(static::$postProcessors)) {
            // only apply post processors if data missing bladeMjmlContext
            // We do this because it else post processes each child component,
            // we only want post process main component
            if(Arr::get($data, 'componentName') === 'mjml') {
                $contents = $this->applyPostProcessors($contents, $path, $data);
            }
        }

        return $contents;
    }

    /**
     * Apply all registered post-processors
     */
    protected function applyPostProcessors(string $contents, string $path, array $data): string
    {
        foreach (static::$postProcessors as $name => $processor) {
            $contents = $processor($contents, $path, $data);
        }

        return $contents;
    }

    /**
     * Register a post-processor callback
     */
    public static function postProcess(string $name, Closure $callback): void
    {
        static::$postProcessors[$name] = $callback;
    }

    /**
     * Register a post-processor callback (alternative syntax)
     */
    public static function addPostProcessor(Closure $callback): void
    {
        static::$postProcessors[] = $callback;
    }

    /**
     * Remove a post-processor by name
     */
    public static function removePostProcessor(string $name): void
    {
        unset(static::$postProcessors[$name]);
    }

    /**
     * Clear all post-processors
     */
    public static function clearPostProcessors(): void
    {
        static::$postProcessors = [];
    }

    /**
     * Get all registered post-processors
     */
    public static function getPostProcessors(): array
    {
        return static::$postProcessors;
    }

    /**
     * Enable post-processing
     */
    public static function enable(): void
    {
        static::$enabled = true;
    }

    /**
     * Disable post-processing
     */
    public static function disable(): void
    {
        static::$enabled = false;
    }

    /**
     * Check if post-processing is enabled
     */
    public static function isEnabled(): bool
    {
        return static::$enabled;
    }
}
