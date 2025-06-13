<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use colq2\BladeMjml\Helpers\WidthParser;
use Illuminate\Contracts\View\View;

class MjDivider extends MjmlBodyComponent
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public string|null            $borderColor = '#000000',
        public string|null            $borderStyle = 'solid',
        public string|null            $borderWidth = '4px',
        public string|null            $containerBackgroundColor = null,
        public string|null            $padding = '10px 25px',
        public string|null            $paddingBottom = null,
        public string|null            $paddingLeft = null,
        public string|null            $paddingRight = null,
        public string|null            $paddingTop = null,
        public string|null            $width = '100%',
        public string|null            $align = 'center',
    )
    {
        parent::__construct($bladeMjmlContext);
    }

    public function getComponentName(): string
    {
        return 'mj-divider';
    }

    public function allowedAttributes(): array
    {
        return [
            'border-color' => 'color',
            'border-style' => 'string',
            'border-width' => 'unit(px)',
            'container-background-color' => 'color',
            'padding' => 'unit(px,%){1,4}',
            'padding-bottom' => 'unit(px,%)',
            'padding-left' => 'unit(px,%)',
            'padding-right' => 'unit(px,%)',
            'padding-top' => 'unit(px,%)',
            'width' => 'unit(px,%)',
            'align' => 'enum(left,center,right)',
        ];
    }

    public function getStyles(): array
    {
        $computeAlign = '0px auto';
        if ($this->getAttribute('align') === 'left') {
            $computeAlign = '0px';
        } elseif ($this->getAttribute('align') === 'right') {
            $computeAlign = '0px 0px 0px auto';
        }

        $p = [
            'border-top' => implode(' ', [
                $this->getAttribute('border-style'),
                $this->getAttribute('border-width'),
                $this->getAttribute('border-color'),
            ]),
            'font-size' => '1px',
            'margin' => $computeAlign,
            'width' => $this->getAttribute('width'),
        ];

        return [
            'p' => $p,
            'outlook' => array_merge($p, [
                'width' => $this->getOutlookWidth(),
            ]),
        ];
    }

    protected function getOutlookWidth(): string
    {
        $containerWidth = (float) ($this->context()['containerWidth'] ?? 600);
        $paddingSize = $this->getShorthandAttrValue('padding', 'left')
            + $this->getShorthandAttrValue('padding', 'right');

        $width = $this->getAttribute('width') ?: '100%';
        $parsed = WidthParser::widthParser($width, ['parseFloatToInt' => false]);
        $parsedWidth = $parsed['parsedWidth'];
        $unit = $parsed['unit'];

        switch ($unit) {
            case '%':
                $effectiveWidth = $containerWidth - $paddingSize;
                $percentMultiplier = floatval($parsedWidth) / 100;
                return ($effectiveWidth * $percentMultiplier) . 'px';
            case 'px':
                return $width;
            default:
                return ($containerWidth - $paddingSize) . 'px';
        }
    }

    protected function renderAfter(): string
    {
        return '
          <!--[if mso | IE]>
            <table
              '.$this->htmlAttributes([
                'align' => $this->getAttribute('align'),
                'border' => '0',
                'cellpadding' => '0',
                'cellspacing' => '0',
                'style' => 'outlook',
                'role' => 'presentation',
                'width' => $this->getOutlookWidth(),
            ]).'
            >
              <tr>
                <td style="height:0;line-height:0;">
                  &nbsp;
                </td>
              </tr>
            </table>
          <![endif]-->
        ';
    }

    public function renderMjml(array $data): View|string
    {
        return $this->innerColumnWrap('
          <p
            '.$this->htmlAttributes([
                'style' => 'p',
            ]).'
          ></p>
          '.$this->renderAfter().'
        ');
    }
}
