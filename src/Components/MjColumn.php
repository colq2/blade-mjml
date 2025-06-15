<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use colq2\BladeMjml\Helpers\WidthParser;
use Illuminate\Contracts\View\View;

class MjColumn extends MjmlBodyComponent
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public ?string $mjClass = null,
        public string $backgroundColor = '',
        public string $border = '',
        public string $borderBottom = '',
        public string $borderLeft = '',
        public string $borderRadius = '',
        public string $borderRight = '',
        public string $borderTop = '',
        public string $direction = 'ltr',
        public string $innerBackgroundColor = '',
        public string $paddingBottom = '',
        public string $paddingLeft = '',
        public string $paddingRight = '',
        public string $paddingTop = '',
        public string $innerBorder = '',
        public string $innerBorderBottom = '',
        public string $innerBorderLeft = '',
        public string $innerBorderRadius = '',
        public string $innerBorderRight = '',
        public string $innerBorderTop = '',
        public string $padding = '',
        public string $verticalAlign = 'top',
        public string $width = '',
        public string $cssClass = '',
        public int $nonRawSiblings = 1,
    ) {
        parent::__construct($bladeMjmlContext, $mjClass);
    }

    public function getComponentName(): string
    {
        return 'mj-column';
    }

    public function allowedAttributes(): array
    {
        return [
            'background-color' => 'color',
            'border' => 'string',
            'border-bottom' => 'string',
            'border-left' => 'string',
            'border-radius' => 'unit(px,%){1,4}',
            'border-right' => 'string',
            'border-top' => 'string',
            'direction' => 'enum(ltr,rtl)',
            'inner-background-color' => 'color',
            'padding-bottom' => 'unit(px,%)',
            'padding-left' => 'unit(px,%)',
            'padding-right' => 'unit(px,%)',
            'padding-top' => 'unit(px,%)',
            'inner-border' => 'string',
            'inner-border-bottom' => 'string',
            'inner-border-left' => 'string',
            'inner-border-radius' => 'unit(px,%){1,4}',
            'inner-border-right' => 'string',
            'inner-border-top' => 'string',
            'padding' => 'unit(px,%){1,4}',
            'vertical-align' => 'enum(top,bottom,middle)',
            'width' => 'unit(px,%)',
        ];
    }

    public function getChildContext(): array
    {
        $parentWidth = $this->context()['containerWidth'] ?? null;

        $boxWidths = $this->getBoxWidths();
        $borders = $boxWidths['borders'];
        $paddings = $boxWidths['paddings'];

        $innerBorders =
            $this->getShorthandBorderValue('left', 'inner-border') +
            $this->getShorthandBorderValue('right', 'inner-border');

        $allPaddings = $paddings + $borders + $innerBorders;

        $calculatedWidth = floatval($parentWidth) / $this->nonRawSiblings;
        $containerWidth = $this->getAttribute('width') ?? "{$calculatedWidth}px";

        $widthParserResult = WidthParser::widthParser($containerWidth, [
            'parseFloatToInt' => false,
        ]);

        $parsedWidth = $widthParserResult['parsedWidth'];
        $unit = $widthParserResult['unit'];

        if ($unit === '%') {
            $containerWidth = (floatval($parentWidth) * $parsedWidth / 100 - $allPaddings).'px';
        } else {
            $containerWidth = ($parsedWidth - $allPaddings).'px';
        }

        return array_merge($this->context(), [
            'containerWidth' => $containerWidth,
            'wrapperFn' => function ($content, MjmlBodyComponent $component) {
                return '
                    <tr>
                      <td
                        '.$component->htmlAttributes([
                    'align' => $component->getAttribute('align'),
                    'class' => $component->getAttribute('css-class'),
                    'style' => [
                        'background' => $component->getAttribute('container-background-color'),
                        'font-size' => '0px',
                        'padding' => $component->getAttribute('padding'),
                        'padding-top' => $component->getAttribute('padding-top'),
                        'padding-right' => $component->getAttribute('padding-right'),
                        'padding-bottom' => $component->getAttribute('padding-bottom'),
                        'padding-left' => $component->getAttribute('padding-left'),
                        'word-break' => 'break-word',
                    ],
                ]).'
                      >'.$content.'
                      </td>
                    </tr>
                    ';
            },
        ]);
    }

    public function getStyles(): array
    {
        $tableStyle = [
            'background-color' => $this->getAttribute('background-color'),
            'border' => $this->getAttribute('border'),
            'border-bottom' => $this->getAttribute('border-bottom'),
            'border-left' => $this->getAttribute('border-left'),
            'border-radius' => $this->getAttribute('border-radius'),
            'border-right' => $this->getAttribute('border-right'),
            'border-top' => $this->getAttribute('border-top'),
            'vertical-align' => $this->getAttribute('vertical-align'),
        ];

        return [
            'div' => [
                'font-size' => '0px',
                'text-align' => 'left',
                'direction' => $this->getAttribute('direction'),
                'display' => 'inline-block',
                'vertical-align' => $this->getAttribute('vertical-align'),
                'width' => $this->getMobileWidth(),
            ],
            'table' => $this->hasGutter() ? [
                'background-color' => $this->getAttribute('inner-background-color'),
                'border' => $this->getAttribute('inner-border'),
                'border-bottom' => $this->getAttribute('inner-border-bottom'),
                'border-left' => $this->getAttribute('inner-border-left'),
                'border-radius' => $this->getAttribute('inner-border-radius'),
                'border-right' => $this->getAttribute('inner-border-right'),
                'border-top' => $this->getAttribute('inner-border-top'),
            ] : $tableStyle,
            'tdOutlook' => [
                'vertical-align' => $this->getAttribute('vertical-align'),
                'width' => $this->getWidthAsPixel(),
            ],
            'gutter' => array_merge($tableStyle, [
                'padding' => $this->getAttribute('padding'),
                'padding-top' => $this->getAttribute('padding-top'),
                'padding-right' => $this->getAttribute('padding-right'),
                'padding-bottom' => $this->getAttribute('padding-bottom'),
                'padding-left' => $this->getAttribute('padding-left'),
            ]),
        ];
    }

    protected function getMobileWidth(): string
    {
        $containerWidth = $this->context()['containerWidth'] ?? 600;
        $width = $this->getAttribute('width');
        $mobileWidth = $this->getAttribute('mobileWidth');

        if ($mobileWidth !== 'mobileWidth') {
            return '100%';
        }

        if (empty($width)) {
            return (100 / $this->nonRawSiblings).'%';
        }

        if (preg_match('/^(\d*\.?\d+)(px|%)$/', $width, $matches)) {
            $parsedWidth = (float) $matches[1];
            $unit = $matches[2];

            if ($unit === '%') {
                return $width;
            }

            return ($parsedWidth / (int) $containerWidth * 100).'%';
        }

        return $width;
    }

    protected function getWidthAsPixel(): string
    {
        $containerWidth = (float) ($this->context()['containerWidth'] ?? 600);
        $width = $this->getParsedWidth(true);

        if (preg_match('/^(\d*\.?\d+)(px|%)$/', $width, $matches)) {
            $parsedWidth = (float) $matches[1];
            $unit = $matches[2];

            if ($unit === '%') {
                return ($containerWidth * $parsedWidth / 100).'px';
            }

            return $parsedWidth.'px';
        }

        return $width;
    }

    protected function getParsedWidth(bool $toString = false): string|array
    {
        $width = $this->getAttribute('width') ?? (100 / $this->nonRawSiblings).'%';
        $parsedWidth = 0;
        $unit = 'px';

        if (preg_match('/^(\d*\.?\d+)(px|%)$/', $width, $matches)) {
            $parsedWidth = (float) $matches[1];
            $unit = $matches[2];
        }

        if ($toString) {
            return $parsedWidth.$unit;
        }

        return [
            'unit' => $unit,
            'parsedWidth' => $parsedWidth,
        ];
    }

    protected function getColumnClass(): string
    {
        $parsed = $this->getParsedWidth();
        $parsedWidth = $parsed['parsedWidth'];
        $unit = $parsed['unit'];

        $formattedClassNb = str_replace('.', '-', (string) $parsedWidth);

        switch ($unit) {
            case '%':
                $className = "mj-column-per-{$formattedClassNb}";
                break;
            case 'px':
            default:
                $className = "mj-column-px-{$formattedClassNb}";
                break;
        }

        // Fügt die Media Query für responsive Design hinzu
        $this->bladeMjmlContext->addMediaQuery($className, [
            'parsedWidth' => $parsedWidth,
            'unit' => $unit,
        ]);

        return $className;
    }

    protected function hasGutter(): bool
    {
        $attributes = ['padding', 'padding-bottom', 'padding-left', 'padding-right', 'padding-top'];

        foreach ($attributes as $attr) {
            if ($this->getAttribute($attr) !== null) {
                return true;
            }
        }

        return false;
    }

    protected function renderGutter(): string
    {
        return '
      <table
        '.$this->htmlAttributes([
            'border' => '0',
            'cellpadding' => '0',
            'cellspacing' => '0',
            'role' => 'presentation',
            'width' => '100%',
        ]).'
      >
        <tbody>
          <tr>
            <td '.$this->htmlAttributes(['style' => 'gutter']).'>
              '.$this->renderColumn().'
            </td>
          </tr>
        </tbody>
      </table>
    ';
    }

    protected function renderColumn(): string
    {
        return '
      <table
        '.$this->htmlAttributes([
            'border' => '0',
            'cellpadding' => '0',
            'cellspacing' => '0',
            'role' => 'presentation',
            'style' => 'table',
            'width' => '100%',
        ]).'
      >
        <tbody>
          {{ $slot }}
        </tbody>
      </table>
    ';
    }

    public function renderMjml(array $data): View|string
    {
        $classesName = $this->getColumnClass().' mj-outlook-group-fix';

        $cssClass = $this->getAttribute('css-class');
        if ($cssClass) {
            $classesName .= ' '.$cssClass;
        }

        $inner =
            $this->hasGutter()
                ? $this->renderGutter()
                : $this->renderColumn();

        return '<!--[if mso | IE]>
        <td '.$this->htmlAttributes([
            'align' => $this->getAttribute('align'),
            'class' => $this->getAttribute('css-class'),
            'style' => 'tdOutlook',
        ]).'
        >
        <![endif]-->
      <div
        '.$this->htmlAttributes([
            'class' => $classesName,
            'style' => 'div',
        ]).'
      >
        '.$inner.'
      </div>
      
      <!--[if mso | IE]>
      </td>
      <![endif]-->
    ';
    }
}
