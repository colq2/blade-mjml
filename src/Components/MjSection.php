<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;

class MjSection extends MjmlBodyComponent
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public string $backgroundColor = '',
        public string $backgroundUrl = '',
        public string $backgroundRepeat = 'repeat',
        public string $backgroundSize = 'auto',
        public string $backgroundPosition = 'top center',
        public string $backgroundPositionX = '',
        public string $backgroundPositionY = '',
        public string $border = '',
        public string $borderBottom = '',
        public string $borderLeft = '',
        public string $borderRadius = '',
        public string $borderRight = '',
        public string $borderTop = '',
        public string $direction = 'ltr',
        public string|bool $fullWidth = false,
        public string $padding = '20px 0',
        public string $paddingTop = '',
        public string $paddingBottom = '',
        public string $paddingLeft = '',
        public string $paddingRight = '',
        public string $textAlign = 'center',
        public string $textPadding = '4px 4px 4px 0',
        public string $cssClass = '',
    ) {
        parent::__construct($bladeMjmlContext);
    }

    public function getComponentName(): string
    {
        return 'mj-section';
    }

    public function allowedAttributes(): array
    {
        return [
            'background-color' => 'color',
            'background-url' => 'string',
            'background-repeat' => 'enum(repeat,no-repeat)',
            'background-size' => 'string',
            'background-position' => 'string',
            'background-position-x' => 'string',
            'background-position-y' => 'string',
            'border' => 'string',
            'border-bottom' => 'string',
            'border-left' => 'string',
            'border-radius' => 'string',
            'border-right' => 'string',
            'border-top' => 'string',
            'direction' => 'enum(ltr,rtl)',
            'full-width' => 'enum(full-width,false,)',
            'padding' => 'unit(px,%){1,4}',
            'padding-top' => 'unit(px,%)',
            'padding-bottom' => 'unit(px,%)',
            'padding-left' => 'unit(px,%)',
            'padding-right' => 'unit(px,%)',
            'text-align' => 'enum(left,center,right)',
            'text-padding' => 'unit(px,%){1,4}',
        ];
    }

    public function getChildContext(): array
    {
        return array_merge($this->context(), [
            'containerWidth' => $this->bladeMjmlContext->containerWidth,
        ]);
    }

    protected function hasBackground(): bool
    {

        return ! empty($this->getAttribute('background-url'));
    }

    protected function isFullWidth(): bool
    {
        $fullWidth = $this->getAttribute('full-width');

        return $fullWidth === 'full-width' || $fullWidth === true;
    }

    protected function makeBackgroundString(array $parts): string
    {
        return implode(' ', array_filter($parts, fn ($part) => ! empty($part)));
    }

    protected function getBackground(): string
    {
        $parts = [$this->getAttribute('background-color')];

        if ($this->hasBackground()) {
            $parts = array_merge($parts, [
                "url('{$this->getAttribute('background-url')}')",
                $this->getBackgroundString(),
                "/ {$this->getAttribute('background-size')}",
                $this->getAttribute('background-repeat'),
            ]);
        }

        return $this->makeBackgroundString($parts);
    }

    protected function getBackgroundString(): string
    {
        $position = $this->getBackgroundPosition();

        return "{$position['posX']} {$position['posY']}";
    }

    protected function getBackgroundPosition(): array
    {
        $parsed = $this->parseBackgroundPosition();

        return [
            'posX' => ! empty($this->getAttribute('background-position-x')) ? $this->getAttribute('background-position-x') : $parsed['x'],
            'posY' => ! empty($this->getAttribute('background-position-y')) ? $this->getAttribute('background-position-y') : $parsed['y'],
        ];
    }

    protected function parseBackgroundPosition(): array
    {
        $posSplit = explode(' ', $this->getAttribute('background-position'));

        if (count($posSplit) === 1) {
            $val = $posSplit[0];

            if (in_array($val, ['top', 'bottom'])) {
                return [
                    'x' => 'center',
                    'y' => $val,
                ];
            }

            return [
                'x' => $val,
                'y' => 'center',
            ];
        }

        if (count($posSplit) === 2) {
            $val1 = $posSplit[0];
            $val2 = $posSplit[1];

            if (in_array($val1, ['top', 'bottom']) ||
                ($val1 === 'center' && in_array($val2, ['left', 'right']))) {
                return [
                    'x' => $val2,
                    'y' => $val1,
                ];
            }

            return [
                'x' => $val1,
                'y' => $val2,
            ];
        }

        // Default for unsupported values
        return ['x' => 'center', 'y' => 'top'];
    }

    public function getStyles(): array
    {
        $containerWidth = $this->context()['containerWidth'] ?? $this->bladeMjmlContext->containerWidth;

        $fullWidth = $this->isFullWidth();

        $background = $this->hasBackground() ? [
            'background' => $this->getBackground(),
            'background-position' => $this->getBackgroundString(),
            'background-repeat' => $this->getAttribute('background-repeat'),
            'background-size' => $this->getAttribute('background-size'),
        ] : [
            'background' => $this->getAttribute('background-color'),
            'background-color' => $this->getAttribute('background-color'),
        ];

        return [
            'tableFullwidth' => array_merge(
                $fullWidth ? $background : [],
                [
                    'width' => '100%',
                    'border-radius' => $this->getAttribute('border-radius'),
                ]
            ),
            'table' => array_merge(
                $fullWidth ? [] : $background,
                [
                    'width' => '100%',
                    'border-radius' => $this->getAttribute('border-radius'),
                ]
            ),
            'td' => [
                'border' => $this->getAttribute('border'),
                'border-bottom' => $this->getAttribute('border-bottom'),
                'border-left' => $this->getAttribute('border-left'),
                'border-right' => $this->getAttribute('border-right'),
                'border-top' => $this->getAttribute('border-top'),
                'direction' => $this->getAttribute('direction'),
                'font-size' => '0px',
                'padding' => $this->getAttribute('padding'),
                'padding-bottom' => $this->getAttribute('padding-bottom'),
                'padding-left' => $this->getAttribute('padding-left'),
                'padding-right' => $this->getAttribute('padding-right'),
                'padding-top' => $this->getAttribute('padding-top'),
                'text-align' => $this->getAttribute('text-align'),
            ],
            'div' => array_merge(
                $fullWidth ? [] : $background,
                [
                    'margin' => '0px auto',
                    'border-radius' => $this->getAttribute('border-radius'),
                    'max-width' => $containerWidth,
                ]
            ),
            'innerDiv' => [
                'line-height' => '0',
                'font-size' => '0',
            ],
        ];
    }

    protected function renderBefore(): string
    {
        $containerWidth = Arr::get($this->context(), 'containerWidth', $this->bladeMjmlContext->containerWidth);
        $bgcolorAttr = ! empty($this->getAttribute('background-color')) ? ['bgcolor' => $this->getAttribute('background-color')] : [];
        $cssClass = $this->getAttribute('css-class');

        return '
      <!--[if mso | IE]>
      <table
        '.$this->htmlAttributes([
            'align' => 'center',
            'border' => '0',
            'cellpadding' => '0',
            'cellspacing' => '0',
            'class' => $cssClass ? $cssClass.'-outlook' : null,
            'role' => 'presentation',
            'style' => ['width' => $containerWidth],
            'width' => (int) $containerWidth,
            ...$bgcolorAttr,
        ]).'
      >
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
    ';
    }

    protected function renderAfter(): string
    {
        return '
      <!--[if mso | IE]>
          </td>
        </tr>
      </table>
      <![endif]-->
    ';
    }

    protected function renderWrappedChildren(): string
    {
        return '
      <!--[if mso | IE]>
        <tr>
      <![endif]-->
        {{ $slot }}
      <!--[if mso | IE]>
        </tr>
      <![endif]-->
    ';
    }

    protected function renderWithBackground(string $content): string
    {
        $containerWidth = $this->context()['containerWidth'] ?? $this->bladeMjmlContext->containerWidth;
        $fullWidth = $this->isFullWidth();

        $isPercentage = function ($str) {
            return preg_match('/^\d+(\.\d+)?%$/', $str);
        };

        $position = $this->getBackgroundPosition();
        $bgPosX = $position['posX'];
        $bgPosY = $position['posY'];

        // Convert position values
        switch ($bgPosX) {
            case 'left':
                $bgPosX = '0%';
                break;
            case 'center':
                $bgPosX = '50%';
                break;
            case 'right':
                $bgPosX = '100%';
                break;
            default:
                if (! $isPercentage($bgPosX)) {
                    $bgPosX = '50%';
                }
                break;
        }

        switch ($bgPosY) {
            case 'top':
                $bgPosY = '0%';
                break;
            case 'center':
                $bgPosY = '50%';
                break;
            case 'bottom':
                $bgPosY = '100%';
                break;
            default:
                if (! $isPercentage($bgPosY)) {
                    $bgPosY = '0%';
                }
                break;
        }

        // Calculate VML attributes
        $vOriginX = '0.5';
        $vPosX = '0.5';
        $vOriginY = '0';
        $vPosY = '0';

        // Process X coordinate
        $bgRepeat = $this->getAttribute('background-repeat') === 'repeat';

        if ($isPercentage($bgPosX)) {
            preg_match('/^(\d+(\.\d+)?)%$/', $bgPosX, $matches);
            $decimal = (int) $matches[1] / 100;

            if ($bgRepeat) {
                $vOriginX = $decimal;
                $vPosX = $decimal;
            } else {
                $vOriginX = (-50 + $decimal * 100) / 100;
                $vPosX = (-50 + $decimal * 100) / 100;
            }
        } elseif (! $bgRepeat) {
            $vOriginX = '0';
            $vPosX = '0';
        }

        // Process Y coordinate
        if ($isPercentage($bgPosY)) {
            preg_match('/^(\d+(\.\d+)?)%$/', $bgPosY, $matches);
            $decimal = (int) $matches[1] / 100;

            if ($bgRepeat) {
                $vOriginY = $decimal;
                $vPosY = $decimal;
            } else {
                $vOriginY = (-50 + $decimal * 100) / 100;
                $vPosY = (-50 + $decimal * 100) / 100;
            }
        } elseif ($bgRepeat) {
            $vOriginY = '0';
            $vPosY = '0';
        } else {
            $vOriginY = '-0.5';
            $vPosY = '-0.5';
        }

        // Background size attributes
        $vSizeAttributes = [];
        $backgroundSize = $this->getAttribute('background-size');

        if ($backgroundSize === 'cover' || $backgroundSize === 'contain') {
            $vSizeAttributes = [
                'size' => '1,1',
                'aspect' => $backgroundSize === 'cover' ? 'atleast' : 'atmost',
            ];
        } elseif ($backgroundSize !== 'auto') {
            $bgSplit = explode(' ', $backgroundSize);

            if (count($bgSplit) === 1) {
                $vSizeAttributes = [
                    'size' => $backgroundSize,
                    'aspect' => 'atmost', // simulates height auto
                ];
            } else {
                $vSizeAttributes = [
                    'size' => implode(',', $bgSplit),
                ];
            }
        }

        // Type of VML
        $vmlType = $this->getAttribute('background-repeat') === 'no-repeat' ? 'frame' : 'tile';

        if ($backgroundSize === 'auto') {
            $vmlType = 'tile';
            $vOriginX = '0.5';
            $vPosX = '0.5';
            $vOriginY = '0';
            $vPosY = '0';
        }

        return '
      <!--[if mso | IE]>
        <v:rect '.$this->htmlAttributes([
            'style' => $fullWidth ? ['mso-width-percent' => '1000'] : ['width' => $containerWidth],
            'xmlns:v' => 'urn:schemas-microsoft-com:vml',
            'fill' => 'true',
            'stroke' => 'false',
        ]).'>
        <v:fill '.$this->htmlAttributes([
            'origin' => "{$vOriginX}, {$vOriginY}",
            'position' => "{$vPosX}, {$vPosY}",
            'src' => $this->getAttribute('background-url'),
            'color' => $this->getAttribute('background-color'),
            'type' => $vmlType,
            ...$vSizeAttributes,
        ]).' />
        <v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0">
      <![endif]-->
          '.$content.'
        <!--[if mso | IE]>
        </v:textbox>
      </v:rect>
    <![endif]-->
    ';
    }

    protected function renderSection(): string
    {
        $hasBackground = $this->hasBackground();

        $cssClass = $this->isFullWidth() ? null : $this->getAttribute('css-class');
        if ($this->attributes->has('class')) {
            $cssClass = $cssClass ? $cssClass.' '.$this->attributes->get('class') : $this->attributes->get('class');
        }

        return '
      <div '.$this->htmlAttributes([
            'class' => $cssClass,
            'style' => 'div',
        ]).'>
        '.($hasBackground ? '<div '.$this->htmlAttributes(['style' => 'innerDiv']).'>' : '').'
        <table '.$this->htmlAttributes([
            'align' => 'center',
            'background' => $this->isFullWidth() ? null : $this->getAttribute('background-url'),
            'border' => '0',
            'cellpadding' => '0',
            'cellspacing' => '0',
            'role' => 'presentation',
            'style' => 'table',
        ]).'>
          <tbody>
            <tr>
              <td '.$this->htmlAttributes([
            'style' => 'td',
        ]).'>
                <!--[if mso | IE]>
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <![endif]-->
                  '.$this->renderWrappedChildren().'
                <!--[if mso | IE]>
                  </table>
                <![endif]-->
              </td>
            </tr>
          </tbody>
        </table>
        '.($hasBackground ? '</div>' : '').'
      </div>
    ';
    }

    protected function renderFullWidth(): string
    {

        $content = $this->hasBackground()
            ? $this->renderWithBackground('
                '.$this->renderBefore().'
                '.$this->renderSection().'
                '.$this->renderAfter().'
              ')
            : '
                '.$this->renderBefore().'
                '.$this->renderSection().'
                '.$this->renderAfter().'
              ';

        $cssClass = $this->getAttribute('css-class');
        if ($this->attributes->has('class')) {
            $cssClass = $cssClass ? $cssClass.' '.$this->attributes->get('class') : $this->attributes->get('class');
        }

        return '
      <table '.$this->htmlAttributes([
            'align' => 'center',
            'class' => $cssClass,
            'background' => $this->getAttribute('background-url'),
            'border' => '0',
            'cellpadding' => '0',
            'cellspacing' => '0',
            'role' => 'presentation',
            'style' => 'tableFullwidth',
        ]).'>
        <tbody>
          <tr>
            <td>
              '.$content.'
            </td>
          </tr>
        </tbody>
      </table>
    ';
    }

    public function renderSimple(): string
    {
        $section = $this->renderSection();

        return $this->renderBefore()
            .($this->hasBackground() ? $this->renderWithBackground($section) : $section)
            .$this->renderAfter();
    }

    public function renderMjml(array $data): View|string
    {
        return $this->isFullWidth()
            ? $this->renderFullWidth()
            : $this->renderSimple();
    }
}
