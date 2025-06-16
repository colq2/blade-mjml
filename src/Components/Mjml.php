<?php

namespace colq2\BladeMjml\Components;

use Closure;
use colq2\BladeMjml\BladeMjmlGlobalContext;
use colq2\BladeMjml\Helpers\Fonts;
use colq2\BladeMjml\Helpers\MediaQueries;
use colq2\BladeMjml\Helpers\Styles;
use colq2\BladeMjml\StyleBuilder;
use Illuminate\Contracts\View\View;

class Mjml extends MjmlComponent
{
    protected BladeMjmlGlobalContext $bladeMjml;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // create a new BladeMjml instance and bind it to the container
        app()->singleton(BladeMjmlGlobalContext::class, function () {
            return new BladeMjmlGlobalContext;
        });

        $this->bladeMjml = app(BladeMjmlGlobalContext::class);
    }

    public function bodyStyle(): string
    {
        return StyleBuilder::build([
            'word-spacing' => 'normal',
            'background-color' => $this->bladeMjml->backgroundColor,
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->bladeMjml->push([
            'containerWidth' => $this->bladeMjml->containerWidth,
        ]);

        return function (array $data) {
            // $data['componentName'];
            // $data['attributes'];
            // $data['slot'];
            $view = view('blade-mjml::components.mjml', [
                'title' => $this->bladeMjml->title,
                'bodyStyle' => $this->bodyStyle(),
                'dir' => $this->bladeMjml->dir,
                'lang' => $this->bladeMjml->lang,
                'preview' => $this->bladeMjml->preview,
                'buildFontsTags' => Fonts::buildFontsTags(
                    content: implode(' ', $this->bladeMjml->usedFonts),
                    inlineStyle: $this->bladeMjml->inlineStyle,
                    fonts: $this->bladeMjml->fonts
                ),
                'builtMediaQueriesTags' => MediaQueries::buildMediaQueriesTags(
                    breakpoint: $this->bladeMjml->breakpoint,
                    mediaQueries: $this->bladeMjml->mediaQueries,
                    options: [
                        'forceOWADesktop' => $this->bladeMjml->forceOWADesktop,
                        'printerSupport' => $this->bladeMjml->printerSupport,
                    ]
                ),
                'buildStyleFromComponents' => Styles::buildStyleFromComponents(
                    breakpoint: $this->bladeMjml->breakpoint,
                    componentsHeadStyles: $this->bladeMjml->componentsHeadStyle,
                    headStylesObject: $this->bladeMjml->headStyle,
                ),
                'builtStyleFromTags' => Styles::buildStyleFromTags(
                    breakpoint: $this->bladeMjml->breakpoint,
                    styles: $this->bladeMjml->style,
                ),
                // todo: raw head
            ]);

            // pop context
            $this->bladeMjml->pop();

            return $view;
        };
    }

    public function getComponentName(): string
    {
        return 'mjml';
    }

    /**
     * Get component styles.
     */
    public function getStyles(): array
    {
        return [];
    }
}
