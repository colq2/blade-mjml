<?php

namespace colq2\BladeMjml\Components;

use Closure;
use colq2\BladeMjml\BladeMjmlGlobalContext;
use colq2\BladeMjml\Helpers\MakeLowerBreakpoint;
use colq2\BladeMjml\Helpers\WidthParser;
use Illuminate\Contracts\View\View;

class MjImage extends MjmlBodyComponent
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public ?string $mjClass = null,
        public string $alt = '',
        public string $href = '',
        public string $name = '',
        public string $src = '',
        public string $srcset = '',
        public string $sizes = '',
        public string $title = '',
        public string $rel = '',
        public string $align = 'center',
        public string $border = '0',
        public string $borderBottom = '',
        public string $borderLeft = '',
        public string $borderRight = '',
        public string $borderTop = '',
        public string $borderRadius = '',
        public string $containerBackgroundColor = '',
        public string $fluidOnMobile = '',
        public string $padding = '10px 25px',
        public string $paddingBottom = '',
        public string $paddingLeft = '',
        public string $paddingRight = '',
        public string $paddingTop = '',
        public string $target = '_blank',
        public string $width = '',
        public string $height = 'auto',
        public string $maxHeight = '',
        public string $fontSize = '13px',
        public string $usemap = '',
        public string $cssClass = '',
    ) {
        parent::__construct($bladeMjmlContext, $mjClass);
    }

    public function getComponentName(): string
    {
        return 'mj-image';
    }

    public function allowedAttributes(): array
    {
        return [
            'alt' => 'string',
            'href' => 'string',
            'name' => 'string',
            'src' => 'string',
            'srcset' => 'string',
            'sizes' => 'string',
            'title' => 'string',
            'rel' => 'string',
            'align' => 'enum(left,center,right)',
            'border' => 'string',
            'border-bottom' => 'string',
            'border-left' => 'string',
            'border-right' => 'string',
            'border-top' => 'string',
            'border-radius' => 'unit(px,%){1,4}',
            'container-background-color' => 'color',
            'fluid-on-mobile' => 'boolean',
            'padding' => 'unit(px,%){1,4}',
            'padding-bottom' => 'unit(px,%)',
            'padding-left' => 'unit(px,%)',
            'padding-right' => 'unit(px,%)',
            'padding-top' => 'unit(px,%)',
            'target' => 'string',
            'width' => 'unit(px)',
            'height' => 'unit(px,auto)',
            'max-height' => 'unit(px,%)',
            'font-size' => 'unit(px)',
            'usemap' => 'string',
        ];
    }

    public function getStyles(): array
    {
        $width = $this->getContentWidth();
        $fullWidth = $this->getAttribute('full-width') === 'full-width';

        ['parsedWidth' => $parsedWidth, 'unit' => $unit] = WidthParser::widthParser($width);

        return [
            'img' => [
                'border' => $this->getAttribute('border'),
                'border-left' => $this->getAttribute('border-left'),
                'border-right' => $this->getAttribute('border-right'),
                'border-top' => $this->getAttribute('border-top'),
                'border-bottom' => $this->getAttribute('border-bottom'),
                'border-radius' => $this->getAttribute('border-radius'),
                'display' => 'block',
                'outline' => 'none',
                'text-decoration' => 'none',
                'height' => $this->getAttribute('height'),
                'max-height' => $this->getAttribute('max-height'),
                'min-width' => $fullWidth ? '100%' : null,
                'width' => '100%',
                'max-width' => $fullWidth ? '100%' : null,
                'font-size' => $this->getAttribute('font-size'),
            ],
            'td' => [
                'width' => $fullWidth ? null : "{$parsedWidth}{$unit}",
            ],
            'table' => [
                'min-width' => $fullWidth ? '100%' : null,
                'max-width' => $fullWidth ? '100%' : null,
                'width' => $fullWidth ? "{$parsedWidth}{$unit}" : null,
                'border-collapse' => 'collapse',
                'border-spacing' => '0px',
            ],
        ];
    }

    public function getContentWidth()
    {
        $width = $this->getAttribute('width')
            ? (int) $this->getAttribute('width')
            : INF;

        ['box' => $box] = $this->getBoxWidths();

        return min($width, $box);
    }

    public function renderImage()
    {
        $height = $this->getAttribute('height');

        $img = '<img'
            .$this->htmlAttributes([
                'alt' => $this->getAttribute('alt'),
                'src' => $this->getAttribute('src'),
                'srcset' => $this->getAttribute('srcset'),
                'sizes' => $this->getAttribute('sizes'),
                'style' => 'img',
                'title' => $this->getAttribute('title'),
                'width' => $this->getContentWidth(),
                'height' => $height ? ($height === 'auto' ? $height : (int) $height) : null,
                'usemap' => $this->getAttribute('usemap'),
            ], ['alt'])
            .'/>';

        if ($this->getAttribute('href')) {
            $img = '<a'
                .$this->htmlAttributes([
                    'href' => $this->getAttribute('href'),
                    'target' => $this->getAttribute('target'),
                    'rel' => $this->getAttribute('rel'),
                    'name' => $this->getAttribute('name'),
                    'title' => $this->getAttribute('title'),
                ])
                .'>'.$img.'</a>';
        }

        return $img;
    }

    public function headStyle(): Closure|null
    {
        return function ($breakpoint) {
            $maxWidth = MakeLowerBreakpoint::makeLowerBreakpoint($breakpoint);

            return "
            @media only screen and (max-width:{$maxWidth}) {
              table.mj-full-width-mobile { width: 100% !important; }
              td.mj-full-width-mobile { width: auto !important; }
            }";
        };
    }

    public function renderMjml(array $data): View|string
    {
        return '
      <table
        '.$this->htmlAttributes([
            'border' => '0',
            'cellpadding' => '0',
            'cellspacing' => '0',
            'role' => 'presentation',
            'style' => 'table',
            'class' => $this->getAttribute('fluid-on-mobile') ? 'mj-full-width-mobile' : null,
        ]).'
      >
        <tbody>
          <tr>
            <td '.$this->htmlAttributes([
                'class' => $this->getAttribute('fluid-on-mobile') ? 'mj-full-width-mobile' : null,
                'style' => 'td',
            ]).'>
              '.$this->renderImage().'
            </td>
          </tr>
        </tbody>
      </table>
      ';
    }
}
