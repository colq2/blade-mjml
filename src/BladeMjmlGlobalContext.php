<?php

namespace colq2\BladeMjml;

use Illuminate\Support\Arr;

class BladeMjmlGlobalContext
{
    public string $backgroundColor = '';

    public string $beforeDoctype = '';

    public string $breakpoint = '480px';

    public array $classes = [];

    public array $classesDefault = [];

    public array $defaultAttributes = [];

    public array $htmlAttributes = [];

    public array $fonts = [
        'Open Sans' => 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,700',
        'Droid Sans' => 'https://fonts.googleapis.com/css?family=Droid+Sans:300,400,500,700',
        'Lato' => 'https://fonts.googleapis.com/css?family=Lato:300,400,500,700',
        'Roboto' => 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700',
        'Ubuntu' => 'https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700',
    ];

    public array $usedFonts = [];

    public array $inlineStyle = [];

    public array $headStyle = [];

    public array $componentsHeadStyle = [];

    public array $headRaw = [];

    public array $mediaQueries = [];

    public string $preview = '';

    public array $style = [];

    public string $title = '';

    public bool $forceOWADesktop = false;

    public string $lang = 'und';

    public string $dir = 'auto'; // ltr, rtl, auto

    // Our, not mjml
    public string $containerWidth = '600px';

    public array $contextStack = [];

    public bool $printerSupport = false;

    public static function make()
    {
        return app()->make(static::class);
    }

    public function __construct() {}

    // handle context
    public function push($data)
    {
        $this->contextStack[] = array_merge($this->read(), $data);
    }

    public function read(): array
    {
        return Arr::last($this->contextStack) ?? [];
    }

    public function pop()
    {
        array_pop($this->contextStack);
    }

    public function setDir(string $dir): static
    {
        // validate $dir
        if (! in_array($dir, ['ltr', 'rtl', 'auto'])) {
            throw new \InvalidArgumentException('Invalid dir value. Allowed values are: ltr, rtl, auto.');
        }

        $this->dir = $dir;

        return $this;
    }

    public function title(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function preview(string $preview): static
    {
        $this->preview = $preview;

        return $this;
    }

    public function setBackgroundColor(string $backgroundColor): static
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }

    public function setContainerWidth(string $width): static
    {
        $this->containerWidth = $width;

        return $this;
    }

    /**
     * Adds a media query for a class
     *
     * @param  string  $className  The class name
     * @param  array  $options  Options for the media query
     */
    public function addMediaQuery(string $className, array $options): void
    {
        $this->mediaQueries = \colq2\BladeMjml\Helpers\MediaQueries::addMediaQuery(
            $this->mediaQueries,
            $className,
            $options
        );
    }

    /**
     * Generates the media query tags
     *
     * @param  array  $options  Optional settings for the media queries
     * @return string The generated media query CSS tags
     */
    public function generateMediaQueries(array $options = []): string
    {
        return \colq2\BladeMjml\Helpers\MediaQueries::buildMediaQueriesTags(
            $this->breakpoint,
            $this->mediaQueries,
            $options
        );
    }

    public function addFontUsage(string $fontName): void
    {
        $fontString = 'style="font-family:'.$fontName.';"';
        if (! in_array($fontString, $this->usedFonts)) {
            $this->usedFonts[] = $fontString;
        }
    }

    public function addDefaultAttributes(string $tagName, array $attributes): static
    {
        if (! isset($this->defaultAttributes[$tagName])) {
            $this->defaultAttributes[$tagName] = [];
        }

        $this->defaultAttributes[$tagName] = array_merge(
            $this->defaultAttributes[$tagName],
            $attributes
        );

        return $this;
    }

    public function addDefaultClasses(string $className, array $classes): static
    {
        if (! isset($this->classesDefault[$className])) {
            $this->classesDefault[$className] = [];
        }

        $this->classesDefault[$className] = array_merge(
            $this->classesDefault[$className],
            $classes
        );

        return $this;
    }

    public function addHeadStyle(string $name, \Closure $callback): static
    {
        $this->headStyle[$name] = $callback;

        return $this;
    }
}
