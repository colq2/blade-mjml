<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use Illuminate\Contracts\View\View;

class MjHero extends MjmlBodyComponent
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public ?string $mjClass = null,
        public string $mode = 'fixed-height',
        public string $height = '0px',
        public string $backgroundUrl = '',
        public string $backgroundWidth = '',
        public string $backgroundHeight = '',
        public string $backgroundPosition = 'center center',
        public string $borderRadius = '',
        public string $containerBackgroundColor = '#ffffff',
        public string $innerBackgroundColor = '',
        public string $innerPadding = '',
        public string $innerPaddingTop = '',
        public string $innerPaddingLeft = '',
        public string $innerPaddingRight = '',
        public string $innerPaddingBottom = '',
        public string $padding = '0px',
        public string $paddingBottom = '',
        public string $paddingLeft = '',
        public string $paddingRight = '',
        public string $paddingTop = '',
        public string $backgroundColor = '#ffffff',
        public string $verticalAlign = 'top',
        public string $width = '',
        public string $cssClass = '',
        public string $align = '',
    ) {
        parent::__construct($bladeMjmlContext, $mjClass);
    }

    public function getComponentName(): string
    {
        return 'mj-hero';
    }

    public function allowedAttributes(): array
    {
        return [
            'mode' => 'string',
            'height' => 'unit(px,%)',
            'background-url' => 'string',
            'background-width' => 'unit(px,%)',
            'background-height' => 'unit(px,%)',
            'background-position' => 'string',
            'border-radius' => 'string',
            'container-background-color' => 'color',
            'inner-background-color' => 'color',
            'inner-padding' => 'unit(px,%){1,4}',
            'inner-padding-top' => 'unit(px,%)',
            'inner-padding-left' => 'unit(px,%)',
            'inner-padding-right' => 'unit(px,%)',
            'inner-padding-bottom' => 'unit(px,%)',
            'padding' => 'unit(px,%){1,4}',
            'padding-bottom' => 'unit(px,%)',
            'padding-left' => 'unit(px,%)',
            'padding-right' => 'unit(px,%)',
            'padding-top' => 'unit(px,%)',
            'background-color' => 'color',
            'vertical-align' => 'enum(top,bottom,middle)',
            'width' => 'unit(px,%)',
            'align' => 'enum(left,center,right)',
        ];
    }

    public function getChildContext(): array
    {
        $context = $this->context();
        $containerWidth = (float) ($context['containerWidth'] ?? 600);
        $paddingSize =
            $this->getShorthandAttrValue('padding', 'left') +
            $this->getShorthandAttrValue('padding', 'right');

        $currentContainerWidth = (float) $containerWidth;
        if ($this->width && str_ends_with($this->width, '%')) {
            $percent = floatval(rtrim($this->width, '%'));
            $currentContainerWidth = ($containerWidth * $percent / 100) - $paddingSize;
        } elseif ($this->width && str_ends_with($this->width, 'px')) {
            $currentContainerWidth = floatval(rtrim($this->width, 'px')) - $paddingSize;
        } else {
            $currentContainerWidth = $containerWidth - $paddingSize;
        }

        return array_merge($context, [
            'containerWidth' => $currentContainerWidth.'px',
            'wrapperFn' => function ($content, MjmlBodyComponent $component) {
                return '
                    <tr>
                      <td
                        '.$component->htmlAttributes([
                    'align' => $component->getAttribute('align'),
                    'background' => $component->getAttribute('container-background-color'),
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
        $containerWidth = $this->context()['containerWidth'] ?? 600;
        if (str_contains($containerWidth, 'px')) {
            $containerWidth = intval(rtrim($containerWidth, 'px'));
        }

        $backgroundWidth = (float) ($this->backgroundWidth ?: $containerWidth);
        $backgroundHeight = (float) ($this->backgroundHeight ?: $this->height);
        $backgroundRatio = ($backgroundWidth && $backgroundHeight)
            ? round(($backgroundHeight / $backgroundWidth) * 100)
            : 0;

        return [
            'div' => [
                'margin' => '0 auto',
                'max-width' => is_numeric($containerWidth) ? $containerWidth.'px' : $containerWidth,
            ],
            'table' => [
                'width' => '100%',
            ],
            'tr' => [
                'vertical-align' => 'top',
            ],
            'td-fluid' => [
                'width' => '0.01%',
                'padding-bottom' => $backgroundRatio ? $backgroundRatio.'%' : null,
                'mso-padding-bottom-alt' => '0',
            ],
            'outlook-table' => [
                'width' => is_numeric($containerWidth) ? $containerWidth.'px' : $containerWidth,
            ],
            'outlook-td' => [
                'line-height' => 0,
                'font-size' => 0,
                'mso-line-height-rule' => 'exactly',
            ],
            'outlook-inner-table' => [
                'width' => is_numeric($containerWidth) ? $containerWidth.'px' : $containerWidth,
            ],
            'outlook-image' => [
                'border' => '0',
                'height' => $backgroundHeight,
                'mso-position-horizontal' => 'center',
                'position' => 'absolute',
                'top' => 0,
                'width' => $backgroundWidth,
                'z-index' => '-3',
            ],
            'outlook-inner-td' => [
                'background-color' => $this->innerBackgroundColor,
                'padding' => $this->innerPadding,
                'padding-top' => $this->innerPaddingTop,
                'padding-left' => $this->innerPaddingLeft,
                'padding-right' => $this->innerPaddingRight,
                'padding-bottom' => $this->innerPaddingBottom,
            ],
            'inner-table' => [
                'width' => '100%',
                'margin' => '0px',
            ],
            'inner-div' => [
                'background-color' => $this->innerBackgroundColor,
                'float' => $this->align,
                'margin' => '0px auto',
                'width' => $this->width,
            ],
            'inner-td' => [
                // MJML wraps children in a td, we do the same
            ],
        ];
    }

    protected function getBackground(): string
    {
        $bg = $this->getAttribute('background-color');
        $url = $this->getAttribute('background-url');
        $pos = $this->getAttribute('background-position');
        if ($url) {
            return trim($bg." url('{$url}') no-repeat {$pos} / cover");
        }

        return $bg;
    }

    protected function renderContent(): string
    {
        $containerWidth = $this->context()['containerWidth'] ?? 600;

        return '
      <!--[if mso | IE]>
        <table
          '.$this->htmlAttributes([
            'align' => $this->getAttribute('align'),
            'border' => '0',
            'cellpadding' => '0',
            'cellspacing' => '0',
            'style' => 'outlook-inner-table',
            'width' => is_numeric($containerWidth) ? $containerWidth : '',
        ]).'
        >
          <tr>
            <td '.$this->htmlAttributes(['style' => 'outlook-inner-td']).'>
      <![endif]-->
      <div
        '.$this->htmlAttributes([
            'align' => $this->getAttribute('align'),
            'class' => 'mj-hero-content',
            'style' => 'inner-div',
        ]).'
      >
        <table
          '.$this->htmlAttributes([
            'border' => '0',
            'cellpadding' => '0',
            'cellspacing' => '0',
            'role' => 'presentation',
            'style' => 'inner-table',
        ]).'
        >
          <tbody>
            <tr>
              <td '.$this->htmlAttributes(['style' => 'inner-td']).'>
                <table
                  '.$this->htmlAttributes([
            'border' => '0',
            'cellpadding' => '0',
            'cellspacing' => '0',
            'role' => 'presentation',
            'style' => 'inner-table',
        ]).'
                >
                  <tbody>
                    {{ $slot }}
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!--[if mso | IE]>
            </td>
          </tr>
        </table>
      <![endif]-->
        ';
    }

    protected function renderMode(): string
    {
        $commonAttributes = [
            'background' => $this->getAttribute('background-url'),
            'style' => [
                'background' => $this->getBackground(),
                'background-position' => $this->getAttribute('background-position'),
                'background-repeat' => 'no-repeat',
                'border-radius' => $this->getAttribute('border-radius'),
                'padding' => $this->getAttribute('padding'),
                'padding-top' => $this->getAttribute('padding-top'),
                'padding-left' => $this->getAttribute('padding-left'),
                'padding-right' => $this->getAttribute('padding-right'),
                'padding-bottom' => $this->getAttribute('padding-bottom'),
                'vertical-align' => $this->getAttribute('vertical-align'),
            ],
        ];

        switch ($this->getAttribute('mode')) {
            case 'fluid-height':
                $magicTd = $this->htmlAttributes(['style' => 'td-fluid']);

                return '
                  <td '.$magicTd.'></td>
                  <td '.$this->htmlAttributes($commonAttributes).'>
                    '.$this->renderContent().'
                  </td>
                  <td '.$magicTd.'></td>
                ';
            case 'fixed-height':
            default:
                $height = intval($this->getAttribute('height')) -
                    $this->getShorthandAttrValue('padding', 'top') -
                    $this->getShorthandAttrValue('padding', 'bottom');

                return '
                  <td
                    '.$this->htmlAttributes(array_merge($commonAttributes, [
                    'height' => $height,
                    'style' => array_merge($commonAttributes['style'], [
                        'height' => $height.'px',
                    ]),
                ])).'
                  >
                    '.$this->renderContent().'
                  </td>
                ';
        }
    }

    public function renderMjml(array $data): View|string
    {
        $containerWidth = $this->context()['containerWidth'] ?? 600;

        return '
      <!--[if mso | IE]>
        <table
          '.$this->htmlAttributes([
            'align' => 'center',
            'border' => '0',
            'cellpadding' => '0',
            'cellspacing' => '0',
            'role' => 'presentation',
            'style' => 'outlook-table',
            'width' => is_numeric($containerWidth) ? $containerWidth : '',
        ]).'
        >
          <tr>
            <td '.$this->htmlAttributes(['style' => 'outlook-td']).'>
              <v:image
                '.$this->htmlAttributes([
            'style' => 'outlook-image',
            'src' => $this->getAttribute('background-url'),
            'xmlns:v' => 'urn:schemas-microsoft-com:vml',
        ]).'
              />
      <![endif]-->
      <div
        '.$this->htmlAttributes([
            'align' => $this->getAttribute('align'),
            'class' => $this->getAttribute('css-class'),
            'style' => 'div',
        ]).'
      >
        <table
          '.$this->htmlAttributes([
            'border' => '0',
            'cellpadding' => '0',
            'cellspacing' => '0',
            'role' => 'presentation',
            'style' => 'table',
        ]).'
        >
          <tbody>
            <tr
              '.$this->htmlAttributes([
            'style' => 'tr',
        ]).'
            >
              '.$this->renderMode().'
            </tr>
          </tbody>
        </table>
      </div>
      <!--[if mso | IE]>
            </td>
          </tr>
        </table>
      <![endif]-->
        ';
    }
}
