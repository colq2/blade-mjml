<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use colq2\BladeMjml\Helpers\ConditionalTag;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class MjCarousel extends MjmlBodyComponent
{

    public string $carouselId;

    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public ?string                $mjClass = null,
        public string                 $align = 'center',
        public string                 $borderRadius = '6px',
        public string                 $containerBackgroundColor = '',
        public string                 $iconWidth = '44px',
        public string                 $leftIcon = 'https://i.imgur.com/xTh3hln.png',
        public string                 $padding = '',
        public string                 $paddingTop = '',
        public string                 $paddingBottom = '',
        public string                 $paddingLeft = '',
        public string                 $paddingRight = '',
        public string                 $rightIcon = 'https://i.imgur.com/os7o9kz.png',
        public string                 $thumbnails = 'visible',
        public string                 $tbBorder = '2px solid transparent',
        public string                 $tbBorderRadius = '6px',
        public string                 $tbHoverBorderColor = '#fead0d',
        public string                 $tbSelectedBorderColor = '#ccc',
        public string                 $tbWidth = '',
        public string                 $cssClass = '',
        public int                    $childrenCount = 0,
    )
    {
        $this->carouselId = Str::random();
        parent::__construct($bladeMjmlContext, $mjClass);
    }

    public function getComponentName(): string
    {
        return 'mj-carousel';
    }

    public function allowedAttributes(): array
    {
        return [
            'align' => 'enum(left,center,right)',
            'border-radius' => 'unit(px,%){1,4}',
            'container-background-color' => 'color',
            'icon-width' => 'unit(px,%)',
            'left-icon' => 'string',
            'padding' => 'unit(px,%){1,4}',
            'padding-top' => 'unit(px,%)',
            'padding-bottom' => 'unit(px,%)',
            'padding-left' => 'unit(px,%)',
            'padding-right' => 'unit(px,%)',
            'right-icon' => 'string',
            'thumbnails' => 'enum(visible,hidden)',
            'tb-border' => 'string',
            'tb-border-radius' => 'unit(px,%)',
            'tb-hover-border-color' => 'color',
            'tb-selected-border-color' => 'color',
            'tb-width' => 'unit(px,%)',
        ];
    }

    public function componentHeadStyle(): ?\Closure
    {
        $length = $this->childrenCount;
        $carouselId = $this->carouselId;

        return function () use ($carouselId, $length) {
            if (!$length) return '';

            $carouselCss = "
  .mj-carousel {
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
  }

  .mj-carousel-{$carouselId}-icons-cell {
    display: table-cell !important;
    width: " . $this->getAttribute('icon-width') . " !important;
  }

  .mj-carousel-radio,
  .mj-carousel-next,
  .mj-carousel-previous {
    display: none !important;
  }

  .mj-carousel-thumbnail,
  .mj-carousel-next,
  .mj-carousel-previous {
    touch-action: manipulation;
  }

  " . implode(',', array_map(function ($i) use ($carouselId, $length) {
                    return ".mj-carousel-{$carouselId}-radio:checked " . str_repeat('+ * ', $i) . "+ .mj-carousel-content .mj-carousel-image";
                }, range(0, $length - 1))) . " {
    display: none !important;
  }

  " . implode(',', array_map(function ($i) use ($carouselId, $length) {
                    return ".mj-carousel-{$carouselId}-radio-" . ($i + 1) . ":checked " . str_repeat('+ * ', $length - $i - 1) . "+ .mj-carousel-content .mj-carousel-image-" . ($i + 1);
                }, range(0, $length - 1))) . " {
    display: block !important;
  }

  .mj-carousel-previous-icons,
  .mj-carousel-next-icons,
  " . implode(',', array_map(function ($i) use ($carouselId, $length) {
                    return ".mj-carousel-{$carouselId}-radio-" . ($i + 1) . ":checked " . str_repeat('+ * ', $length - $i - 1) . "+ .mj-carousel-content .mj-carousel-next-" . ((($i + (1 % $length) + $length) % $length) + 1);
                }, range(0, $length - 1))) . ",
  " . implode(',', array_map(function ($i) use ($carouselId, $length) {
                    return ".mj-carousel-{$carouselId}-radio-" . ($i + 1) . ":checked " . str_repeat('+ * ', $length - $i - 1) . "+ .mj-carousel-content .mj-carousel-previous-" . ((($i - (1 % $length) + $length) % $length) + 1);
                }, range(0, $length - 1))) . " {
    display: block !important;
  }

  " . implode(',', array_map(function ($i) use ($carouselId, $length) {
                    return ".mj-carousel-{$carouselId}-radio-" . ($i + 1) . ":checked " . str_repeat('+ * ', $length - $i - 1) . "+ .mj-carousel-content .mj-carousel-{$carouselId}-thumbnail-" . ($i + 1);
                }, range(0, $length - 1))) . " {
    border-color: " . $this->getAttribute('tb-selected-border-color') . " !important;
  }

  .mj-carousel-image img + div,
  .mj-carousel-thumbnail img + div {
    display: none !important;
  }

  " . implode(',', array_map(function ($i) use ($carouselId, $length) {
                    return ".mj-carousel-{$carouselId}-thumbnail:hover " . str_repeat('+ * ', $length - $i - 1) . "+ .mj-carousel-main .mj-carousel-image";
                }, range(0, $length - 1))) . " {
    display: none !important;
  }

  .mj-carousel-thumbnail:hover {
    border-color: " . $this->getAttribute('tb-hover-border-color') . " !important;
  }

  " . implode(',', array_map(function ($i) use ($carouselId, $length) {
                    return ".mj-carousel-{$carouselId}-thumbnail-" . ($i + 1) . ":hover " . str_repeat('+ * ', $length - $i - 1) . "+ .mj-carousel-main .mj-carousel-image-" . ($i + 1);
                }, range(0, $length - 1))) . " {
    display: block !important;
  }
  ";

            $fallback = "
    .mj-carousel noinput { display:block !important; }
    .mj-carousel noinput .mj-carousel-image-1 { display: block !important;  }
    .mj-carousel noinput .mj-carousel-arrows,
    .mj-carousel noinput .mj-carousel-thumbnails { display: none !important; }

    [owa] .mj-carousel-thumbnail { display: none !important; }
    
    @media screen yahoo {
        .mj-carousel-{$carouselId}-icons-cell,
        .mj-carousel-previous-icons,
        .mj-carousel-next-icons {
            display: none !important;
        }

        .mj-carousel-{$carouselId}-radio-1:checked " . str_repeat('+ *', $length - 1) . "+ .mj-carousel-content .mj-carousel-{$carouselId}-thumbnail-1 {
            border-color: transparent;
        }
    }
  ";

            return $carouselCss . "\n" . $fallback;
        };

    }

    public function getChildContext(): array
    {
        $length = count($this->bladeMjmlContext->contextStack);

        Arr::set($this->bladeMjmlContext->contextStack, $length - 1 . '.childrenBucket', []);


        return array_merge($this->context(), [
            'carouselId' => $this->carouselId,
            'tb-width' => $this->getAttribute('tb-width'),
            'wrapperFn' => null,
            'attributes' => [
                'tb-border' => $this->getAttribute('tb-border'),
                'tb-border-radius' => $this->getAttribute('tb-border-radius'),
                'tb-width' => $this->thumbnailsWidth(),
                'carouselId' => $this->carouselId,
                'border-radius' => $this->getAttribute('border-radius'),
            ],
        ]);
    }

    public function getStyles(): array
    {
        return [
            'carousel' => [
                'div' => [
                    'display' => 'table',
                    'width' => '100%',
                    'table-layout' => 'fixed',
                    'text-align' => 'center',
                    'font-size' => '0px',
                ],
                'table' => [
                    'caption-side' => 'top',
                    'display' => 'table-caption',
                    'table-layout' => 'fixed',
                    'width' => '100%',
                ],
            ],
            'images' => [
                'td' => [
                    'padding' => '0px',
                ]
            ],
            'controls' => [
                'div' => [
                    'display' => 'none',
                    'mso-hide' => 'all',
                ],
                'img' => [
                    'display' => 'block',
                    'width' => $this->getAttribute('icon-width'),
                    'height' => 'auto',
                ],
                'td' => [
                    'font-size' => '0px',
                    'display' => 'none',
                    'mso-hide' => 'all',
                    'padding' => '0px',
                ]
            ],
            // from children
            'radio' => [
                'input' => [
                    'display' => 'none',
                    'mso-hide' => 'all',
                ],
            ],
        ];
    }

    public function thumbnailsWidth()
    {
        if ($this->childrenCount === 0) {
            return 0;
        }

        return $this->getAttribute('tb-width') ?: min(
                Arr::get($this->context(), 'parentWidth', 600) / $this->childrenCount,
                110
            ) . 'px';
    }

    public function imagesAttribute(): string
    {
        return '';
    }

    public function generateRadios(): string
    {
        return collect($this->context()['childrenBucket'] ?? [])
            ->map(function ($child) {
                return $child['renderedRadio'];
            })
            ->join(" ");
    }

    public function generateThumbnails(): string
    {
        return collect($this->context()['childrenBucket'] ?? [])
            ->map(function ($child) {
                return $child['renderedThumbnail'];
            })
            ->join(" ");
    }

    public function generateControls(string $direction, string $icon): string
    {
        $inner = collect(range(0, $this->childrenCount - 1))
            ->map(function ($i) use ($direction, $icon) {
                $next = $i+1;
                return '
                    <label ' .
                    $this->htmlAttributes([
                        'for' => "mj-carousel-{$this->carouselId}-radio-{$next}",
                        'class' => "mj-carousel-{$direction} mj-carousel-{$direction}-{$next}",
                    ]) . '>
                        <img ' .
                    $this->htmlAttributes([
                        'src' => $icon,
                        'alt' => $direction,
                        'style' => 'controls.img',
                        'width' => (int)$this->getAttribute('icon-width'),
                    ], ['alt']) . '
                        />
                    </label>
                ';
            })
            ->join(" ");

        return '
            <td ' .
            $this->htmlAttributes([
                'class' => "mj-carousel-{$this->carouselId}-icons-cell",
                'style' => 'controls.td',
            ]) . '
            >
                <div ' .
            $this->htmlAttributes([
                'class' => "mj-carousel-{$direction}-icons",
                'style' => 'controls.div',
            ]) . '
                >
                    ' . $inner . '
                </div>
            </td>
        ';
    }

    public function generateImages(): string
    {
        return '
            <td ' .
            $this->htmlAttributes([
                'style' => 'images.td',
            ]) . '
            >
                <div ' .
            $this->htmlAttributes([
                'class' => 'mj-carousel-images'
            ]) . '
                >
                    {{ $slot }}
                </div>
            </td>
        ';
    }

    public function generateCarousel(): string
    {
        return '
            <table ' .
            $this->htmlAttributes([
                'style' => 'carousel.table',
                'border' => '0',
                'cellpadding' => '0',
                'cellspacing' => '0',
                'width' => '100%',
                'role' => 'presentation',
                'class' => 'mj-carousel-main',
            ]) . '
            >
                <tbody>
                    <tr>
                        ' . $this->generateControls('previous', $this->getAttribute('left-icon')) . '
                        ' . $this->generateImages() . '
                        ' . $this->generateControls('next', $this->getAttribute('right-icon')) . '
                    </tr>
                </tbody>
            </table>
        ';
    }

    public function renderFallback(): string
    {
        if ($this->childrenCount === 0) {
            return '';
        }

        $firstChildContent = Arr::get($this->context(), 'childrenBucket.0.renderedContent', '');

        return ConditionalTag::msoConditionalTag($firstChildContent);
    }

    public function renderMjml(array $data): View|string
    {
        return ConditionalTag::msoConditionalTag('
            <div ' .
                $this->htmlAttributes([
                    'class' => 'mj-carousel'
                ]) . '
            >
            ' . $this->generateRadios() . '
                <div ' .
                $this->htmlAttributes([
                    'class' => "mj-carousel-content mj-carousel-{$this->carouselId}-content",
                    'style' => 'carousel.div',
                ]) . '
                >
                    ' . $this->generateThumbnails() . '
                    ' . $this->generateCarousel() . '
                </div>
            </div>
        ', true)
            . ' ' .
            $this->renderFallback();
    }
}
