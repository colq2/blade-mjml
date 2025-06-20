<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use colq2\BladeMjml\Helpers\WidthParser;
use Illuminate\Contracts\View\View;

class MjGroup extends MjmlBodyComponent
{
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public ?string $mjClass = null,
        public string $backgroundColor = '',
        public string $direction = 'ltr',
        public string $verticalAlign = '',
        public string $width = '',
        public string $cssClass = '',
        public int $nonRawSiblings = 1,
    ) {
        parent::__construct($bladeMjmlContext, $mjClass);
    }

    public function getComponentName(): string
    {
        return 'mj-group';
    }

    public function allowedAttributes(): array
    {
        return [
            'background-color' => 'color',
            'direction' => 'enum(ltr,rtl)',
            'vertical-align' => 'enum(top,bottom,middle)',
            'width' => 'unit(px,%)',
        ];
    }

    public function getChildContext(): array
    {
        $parentWidth = $this->context()['containerWidth'] ?? 600;
        $nonRawSiblings = $this->nonRawSiblings;
        $paddingSize =
            $this->getShorthandAttrValue('padding', 'left') +
            $this->getShorthandAttrValue('padding', 'right');

        $containerWidth = $this->getAttribute('width') ?: (floatval($parentWidth) / $nonRawSiblings).'px';

        $widthParserResult = WidthParser::widthParser($containerWidth, [
            'parseFloatToInt' => false,
        ]);
        $parsedWidth = $widthParserResult['parsedWidth'];
        $unit = $widthParserResult['unit'];

        if ($unit === '%') {
            $containerWidth = ((floatval($parentWidth) * $parsedWidth / 100) - $paddingSize).'px';
        } else {
            $containerWidth = ($parsedWidth - $paddingSize).'px';
        }

        $contextContainerWidth = $this->context()['containerWidth'];
        $groupWidth = $containerWidth;

        $getElementWidth = function ($width) use ($contextContainerWidth, $groupWidth, $nonRawSiblings) {
            if (! $width) {
                return ((int) $contextContainerWidth / (int) $nonRawSiblings).'px';
            }

            ['unit' => $unit, 'parsedWidth' => $parsedWidth] = WidthParser::widthParser($width, [
                'parseFloatToInt' => false,
            ]);

            if ($unit === '%') {
                return ((100 * $parsedWidth) / ((float) $groupWidth)).'px';
            }

            return $parsedWidth.$unit;
        };

        return array_merge($this->context(), [
            'containerWidth' => $containerWidth,
            'attributes' => [
                'mobile-width' => 'mobileWidth',
            ],
            'wrapperFn' => function ($content, MjmlBodyComponent $component) use ($getElementWidth) {
                return '
                    <!--[if mso | IE]>
                      <td
                        '.$component->htmlAttributes([
                    'style' => [
                        'align' => $component->getAttribute('align'),
                        'vertical-align' => $component->getAttribute('vertical-align'),
                        'width' => $getElementWidth(method_exists($component, 'getWidthAsPixel')
                            ? $component->getWidthAsPixel()
                            : $component->getAttribute('width'),
                        ),
                    ],
                ]).'
                      >
                      <![endif]-->
                      '.$content.'
                      <!--[if mso | IE]>
                      </td>
                      <![endif]-->
                    ';
            },
        ]);
    }

    public function getStyles(): array
    {
        return [
            'div' => [
                'font-size' => '0',
                'line-height' => '0',
                'text-align' => 'left',
                'display' => 'inline-block',
                'width' => '100%',
                'direction' => $this->getAttribute('direction'),
                'vertical-align' => $this->getAttribute('vertical-align'),
                'background-color' => $this->getAttribute('background-color'),
            ],
            'tdOutlook' => [
                'vertical-align' => $this->getAttribute('vertical-align'),
                'width' => $this->getWidthAsPixel(),
            ],
        ];
    }

    protected function getParsedWidth(bool $toString = false): string|array
    {
        $nonRawSiblings = $this->nonRawSiblings;
        $width = $this->getAttribute('width') ?: (100 / $nonRawSiblings).'%';

        $widthParserResult = WidthParser::widthParser($width, [
            'parseFloatToInt' => false,
        ]);
        $parsedWidth = $widthParserResult['parsedWidth'];
        $unit = $widthParserResult['unit'];

        if ($toString) {
            return $parsedWidth.$unit;
        }

        return [
            'unit' => $unit,
            'parsedWidth' => $parsedWidth,
        ];
    }

    public function getWidthAsPixel(): string
    {
        $containerWidth = $this->context()['containerWidth'] ?? 600;
        ['parsedWidth' => $parsedWidth, 'unit' => $unit] = $this->getParsedWidth();

        if ($unit === '%') {
            return ((float) $containerWidth * $parsedWidth / 100).'px';
        }

        return $parsedWidth.'px';
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

        $this->bladeMjmlContext->addMediaQuery($className, [
            'parsedWidth' => $parsedWidth,
            'unit' => $unit,
        ]);

        return $className;
    }

    public function renderMjml(array $data): View|string
    {
        $classesName = $this->getColumnClass().' mj-outlook-group-fix';
        $cssClass = $this->getAttribute('css-class');
        if ($cssClass) {
            $classesName .= ' '.$cssClass;
        }

        return '
      <div
        '.$this->htmlAttributes([
            'class' => $classesName,
            'style' => 'div',
        ]).'
      >
        <!--[if mso | IE]>
        <table
          '.$this->htmlAttributes([
            'bgcolor' => $this->getAttribute('background-color') === 'none' ? null : $this->getAttribute('background-color'),
            'border' => '0',
            'cellpadding' => '0',
            'cellspacing' => '0',
            'role' => 'presentation',
        ]).'
        >
          <tr>
        <![endif]-->
          {{ $slot }}
        <!--[if mso | IE]>
          </tr>
          </table>
        <![endif]-->
      </div>
    ';
    }
}
