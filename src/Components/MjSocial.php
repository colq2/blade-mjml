<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use Illuminate\Contracts\View\View;

class MjSocial extends MjmlBodyComponent
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public ?string                $mjClass = null,
        public string                 $align = 'center',
        public string                 $borderRadius = '3px',
        public string                 $containerBackgroundColor = '',
        public string                 $color = '#333333',
        public string                 $fontFamily = 'Ubuntu, Helvetica, Arial, sans-serif',
        public string                 $fontSize = '13px',
        public string                 $fontStyle = '',
        public string                 $fontWeight = '',
        public string                 $iconSize = '20px',
        public string                 $iconHeight = '',
        public string                 $iconPadding = '',
        public ?string                $innerPadding = null,
        public string                 $lineHeight = '22px',
        public string                 $mode = 'horizontal',
        public string                 $paddingBottom = '',
        public string                 $paddingLeft = '',
        public string                 $paddingRight = '',
        public string                 $paddingTop = '',
        public string                 $padding = '10px 25px',
        public string                 $tableLayout = '',
        public string                 $textPadding = '',
        public string                 $textDecoration = 'none',
        public string                 $verticalAlign = '',
        public string                 $cssClass = '',
    )
    {
        parent::__construct($bladeMjmlContext, $mjClass);
    }

    public function getComponentName(): string
    {
        return 'mj-social';
    }

    public function allowedAttributes(): array
    {
        return [
            'align' => 'enum(left,right,center)',
            'border-radius' => 'unit(px,%)',
            'container-background-color' => 'color',
            'color' => 'color',
            'font-family' => 'string',
            'font-size' => 'unit(px)',
            'font-style' => 'string',
            'font-weight' => 'string',
            'icon-size' => 'unit(px,%)',
            'icon-height' => 'unit(px,%)',
            'icon-padding' => 'unit(px,%){1,4}',
            'inner-padding' => 'unit(px,%){1,4}',
            'line-height' => 'unit(px,%,)',
            'mode' => 'enum(horizontal,vertical)',
            'padding-bottom' => 'unit(px,%)',
            'padding-left' => 'unit(px,%)',
            'padding-right' => 'unit(px,%)',
            'padding-top' => 'unit(px,%)',
            'padding' => 'unit(px,%){1,4}',
            'table-layout' => 'enum(auto,fixed)',
            'text-padding' => 'unit(px,%){1,4}',
            'text-decoration' => 'string',
            'vertical-align' => 'enum(top,bottom,middle)',
        ];
    }

    public function getStyles(): array
    {
        return [
            'tableVertical' => [
                'margin' => '0px',
            ],
        ];
    }

    public function getChildContext(): array
    {
        $isHorizontal = $this->getAttribute('mode') === 'horizontal';


        return array_merge($this->context(), [
            'containerWidth' => $this->context()['containerWidth'] ?? 600,
            'attributes' => $this->getSocialElementAttributes(),
            'wrapperFn' => $isHorizontal
                ? function ($content, MjmlBodyComponent $component) {



                    return '
                    <!--[if mso | IE]>
                      <td>
                    <![endif]-->
                      <table 
                       ' . $component->htmlAttributes([
                            'align' => $component->getAttribute('align'),
                            'border' => '0',
                            'cellpadding' => '0',
                            'cellspacing' => '0',
                            'role' => 'presentation',
                            'style' => [
                                'float' => 'none',
                                'display' => 'inline-table',
                            ]
                        ]) . ' 
                     >
                        <tbody>
                          ' . $content . '
                        </tbody>
                      </table>
                    <!--[if mso | IE]>
                      </td>
                    <![endif]-->
                    ';
                }
                : function ($content, MjmlBodyComponent $component) {
                    return $content;
                },
        ]);
    }


    public function renderMjml(array $data): View|string
    {
        $mode = $this->getAttribute('mode') ?? 'horizontal';

        if ($mode === 'horizontal') {
            return $this->renderHorizontal();
        }
        return $this->renderVertical();
    }

    protected function getSocialElementAttributes(): array
    {
        $base = [];
        if ($this->getAttribute('inner-padding')) {
            $base['padding'] = $this->getAttribute('inner-padding');
        }

        foreach ([
                     'border-radius',
                     'color',
                     'font-family',
                     'font-size',
                     'font-weight',
                     'font-style',
                     'icon-size',
                     'icon-height',
                     'icon-padding',
                     'text-padding',
                     'line-height',
                     'text-decoration',
                 ] as $attr) {
            $val = $this->getAttribute($attr);
            if ($val !== null && $val !== '') {
                $base[$attr] = $val;
            }
        }
        return $base;
    }

    protected function renderHorizontal(): string
    {
        return '
     <!--[if mso | IE]>
      <table
        ' . $this->htmlAttributes([
                'align' => $this->getAttribute('align'),
                'border' => '0',
                'cellpadding' => '0',
                'cellspacing' => '0',
                'role' => 'presentation',
            ]) . '
      >
        <tr>
            <![endif]-->
            {{ $slot }}
            <!--[if mso | IE]>
        </tr>
      </table>
      <![endif]-->
        ';
    }

    protected function renderVertical(): string
    {
        return '
      <table
        ' . $this->htmlAttributes([
                'border' => '0',
                'cellpadding' => '0',
                'cellspacing' => '0',
                'role' => 'presentation',
                'style' => 'tableVertical',
            ]) . '
      >
        <tbody>
           {{ $slot }}
        </tbody>
      </table>
        ';
    }
}
