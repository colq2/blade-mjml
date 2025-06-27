<?php

namespace colq2\BladeMjml;

use colq2\BladeMjml\Helpers\OutlookConditionals;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\View;

class BladeMjmlCompilerEngine extends CompilerEngine
{
    /**
     * Whether mjml processing is enabled
     */
    protected static bool $enabled = true;

    protected static int $renderDepth = 0;

    /**
     * Get the evaluated contents of the view
     */
    public function get($path, array $data = [])
    {
        static::$renderDepth++;

        $contents = parent::get($path, $data);

        static::$renderDepth--;

        if (
            static::$renderDepth === 0 &&
            str_contains($contents, '<mjml')
        ) {
            // preprocess the contents, it converts mjml tags to blade components
            // for example <mjml> to <x-mjml>
            // also adds child and sibling counts to the tags
            $preprocessor = new BladeMjmlPreprocessor;
            $prepared = $preprocessor->preprocess($contents);

            $tempView = $this->preparedTempView($prepared, $data);

            $contents = parent::get($tempView->getPath(), $tempView->gatherData());

            //            $contents = $this->applyPostProcessors($contents);
        }

        return $contents;
    }

    protected function preparedTempView(string $prepared, array $data): View
    {
        // put prepared contents into a temporary file
        $tempDirectory = sys_get_temp_dir();

        // @phpstan-ignore-next-line
        if (! in_array($tempDirectory, ViewFacade::getFinder()->getPaths())) {
            ViewFacade::addLocation(sys_get_temp_dir());
        }

        $tempFileInfo = pathinfo(tempnam($tempDirectory, 'laravel-blade'));

        $tempFile = $tempFileInfo['dirname'].'/'.$tempFileInfo['filename'].'.blade.php';

        file_put_contents($tempFile, $prepared);

        return view($tempFileInfo['filename'], $data);
    }

    protected function getPostProcessors(): array
    {
        return [
            'outlookConditionals' => function (string $content) {
                return OutlookConditionals::process($content);
            },
        ];
    }

    protected function applyPostProcessors(string $contents): string
    {
        foreach ($this->getPostProcessors() as $name => $processor) {
            $contents = $processor($contents);
        }

        return $contents;
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
