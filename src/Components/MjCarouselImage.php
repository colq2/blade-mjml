<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use colq2\BladeMjml\Helpers\SuffixCssClasses;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;

class MjCarouselImage extends MjmlBodyComponent
{
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public ?string                $mjClass = null,
        public string                 $alt = '',
        public string                 $href = '',
        public string                 $rel = '',
        public string                 $target = '_blank',
        public string                 $title = '',
        public string                 $src = '',
        public string                 $thumbnailsSrc = '',
        public string                 $borderRadius = '',
        public string                 $tbBorder = '',
        public string                 $tbBorderRadius = '',
        public string                 $tbWidth = '',
        public string                 $cssClass = '',
        public string                 $carouselId = '',
        public int                    $index = 0,
    )
    {
        parent::__construct($bladeMjmlContext, $mjClass);
    }

    public function getComponentName(): string
    {
        return 'mj-carousel-image';
    }

    public function allowedAttributes(): array
    {
        return [
            'alt' => 'string',
            'href' => 'string',
            'rel' => 'string',
            'target' => 'string',
            'title' => 'string',
            'src' => 'string',
            'thumbnails-src' => 'string',
            'border-radius' => 'unit(px,%){1,4}',
            'tb-border' => 'string',
            'tb-border-radius' => 'unit(px,%){1,4}',
            'tb-width' => 'unit(px,%)',
        ];
    }

    public function getStyles(): array
    {
        return [
            'images' => [
                'img' => [
                    'border-radius' => $this->getAttribute('border-radius'),
                    'display' => 'block',
                    'width' => $this->context()['containerWidth'],
                    'max-width' => '100%',
                    'height' => 'auto',
                ],
                'firstImageDiv' => [],
                'otherImageDiv' => [
                    'display' => 'none',
                    'mso-hide' => 'all',
                ]
            ],
            'radio' => [
                'input' => [
                    'display' => 'none',
                    'mso-hide' => 'all',
                ]
            ],
            'thumbnails' => [
                'a' => [
                    'border' => $this->getAttribute('tb-border'),
                    'border-radius' => $this->getAttribute('tb-border-radius'),
                    'display' => 'inline-block',
                    'overflow' => 'hidden',
                    'width' => $this->getAttribute('tb-width'),
                ],
                'img' => [
                    'display' => 'block',
                    'width' => '100%',
                    'height' => 'auto',
                ]
            ],
        ];
    }


    public function renderThumbnail(): string
    {
        $carouselId = $this->context()['carouselId'];
        $imgIndex = $this->index + 1;
        $cssClass = SuffixCssClasses::suffixCssClasses(
            $this->getAttribute('css-class') ?? '',
            'thumbnail'
        );
        $src = $this->getAttribute('src');
        $alt = $this->getAttribute('alt');
        $width = $this->getAttribute('tb-width');

        return '
            <a ' . $this->htmlAttributes([
                'style' => 'thumbnails.a',
                'href' => '#' . $imgIndex,
                'target' => $this->getAttribute('target'),
                'class' => "mj-carousel-thumbnail mj-carousel-{$carouselId}-thumbnail mj-carousel-{$carouselId}-thumbnail-{$imgIndex} {$cssClass}"
            ]) . '
            >
                <label ' . $this->htmlAttributes([
                'for' => "mj-carousel-{$carouselId}-radio-{$imgIndex}"
            ]) . '>
                    <img ' .
            $this->htmlAttributes([
                'style' => 'thumbnails.img',
                'src' => $this->getAttribute('thumbnails-src') ?: $src,
                'alt' => $alt,
                'width' => (int)$width,
            ], ['alt'])
            . ' />
                </label>
            </a>
        ';
    }

    public function renderRadio(): string
    {
        $carouselId = $this->context()['carouselId'];
        $index = $this->index;
        $next = $index + 1;
        return '
            <input
                ' . $this->htmlAttributes([
                    'class' => "mj-carousel-radio mj-carousel-{$carouselId}-radio mj-carousel-{$carouselId}-radio-{$next}",
                    'checked' => $index === 0 ? 'checked' : null,
                    'type' => 'radio',
                    'name' => "mj-carousel-radio-{$carouselId}",
                    'id' => "mj-carousel-{$carouselId}-radio-{$next}",
                    'style' => 'radio.input'
                ]) . '
            />
        ';
    }


    public function renderMjml(array $data): View|string
    {

        // maybe we can set something for the parent?
        $image = '<img ' .
            $this->htmlAttributes([
                'title' => $this->getAttribute('title'),
                'src' => $this->getAttribute('src'),
                'alt' => $this->getAttribute('alt'),
                'style' => 'images.img',
                'width' => (int)$this->context()['containerWidth'],
                'border' => '0',
            ], ['alt']) . ' />
        ';

        $cssClass = $this->getAttribute('css-class');

        if ($this->getAttribute('href')) {
            $image = '<a ' . $this->htmlAttributes([
                    'href' => $this->getAttribute('href'),
                    'rel' => $this->getAttribute('rel'),
                    'target' => $this->getAttribute('target'),
                ]) . '>' . $image . '</a>';
        }


        $index = $this->index;
        $nextIndex = $index + 1;

        $content = '
            <div ' .
                $this->htmlAttributes([
                    'class' => "mj-carousel-image mj-carousel-image-{$nextIndex} {$cssClass}",
                    'style' => $index === 0 ? 'images.firstImageDiv' : 'images.otherImageDiv',
                ]) . '>
            ' . $image . '
            </div>
        ';

        // store content for parent

        // set children context for parent, else it is not poossible currently
        $contextLength = count($this->bladeMjmlContext->contextStack);
        $childrenBucketLength = count($this->bladeMjmlContext->contextStack[$contextLength - 2]['childrenBucket'] ?? []);
        Arr::set($this->bladeMjmlContext->contextStack, $contextLength - 2 . '.childrenBucket.' . $childrenBucketLength, [
            'css-class' => $this->getAttribute('css-class'),

            'renderedThumbnail' => $this->renderThumbnail(),
            'renderedRadio' => $this->renderRadio(),
            'renderedContent' => $content,
        ]);

        return $content;
    }
}
