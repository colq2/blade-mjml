<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use colq2\BladeMjml\Helpers\ConditionalTag;
use Illuminate\Contracts\View\View;

class MjText extends MjmlBodyComponent
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public string $align = 'left',
        public string $backgroundColor = '',
        public string $color = '#000000',
        public string $containerBackgroundColor = '',
        public string $fontFamily = 'Ubuntu, Helvetica, Arial, sans-serif',
        public string $fontSize = '13px',
        public string $fontStyle = '',
        public string $fontWeight = '',
        public string $height = '',
        public string $letterSpacing = '',
        public string $lineHeight = '1',
        public string $paddingBottom = '',
        public string $paddingLeft = '',
        public string $paddingRight = '',
        public string $paddingTop = '',
        public string $padding = '10px 25px',
        public string $textDecoration = '',
        public string $textTransform = '',
        public string $verticalAlign = '',
        public string $cssClass = '',
    ) {
        parent::__construct($bladeMjmlContext);

        // register font
        $this->bladeMjmlContext->addFontUsage($this->fontFamily);
    }

    public function getComponentName(): string
    {
        return 'mj-text';
    }

    public function allowedAttributes(): array
    {
        return [
            'align' => 'enum(left,right,center,justify)',
            'background-color' => 'color',
            'color' => 'color',
            'container-background-color' => 'color',
            'font-family' => 'string',
            'font-size' => 'unit(px)',
            'font-style' => 'string',
            'font-weight' => 'string',
            'height' => 'unit(px,%)',
            'letter-spacing' => 'unitWithNegative(px,em)',
            'line-height' => 'unit(px,%,)',
            'padding-bottom' => 'unit(px,%)',
            'padding-left' => 'unit(px,%)',
            'padding-right' => 'unit(px,%)',
            'padding-top' => 'unit(px,%)',
            'padding' => 'unit(px,%){1,4}',
            'text-decoration' => 'string',
            'text-transform' => 'string',
            'vertical-align' => 'enum(top,bottom,middle)',
        ];
    }

    public function getChildContext(): array
    {
        return array_merge($this->context(), [
            'containerWidth' => $this->context()['containerWidth'] ?? $this->bladeMjmlContext->containerWidth,
        ]);
    }

    public function getStyles(): array
    {
        return [
            'text' => [
                'font-family' => $this->getAttribute('font-family'),
                'font-size' => $this->getAttribute('font-size'),
                'font-style' => $this->getAttribute('font-style'),
                'font-weight' => $this->getAttribute('font-weight'),
                'letter-spacing' => $this->getAttribute('letter-spacing'),
                'line-height' => $this->getAttribute('line-height'),
                'text-align' => $this->getAttribute('align'),
                'text-decoration' => $this->getAttribute('text-decoration'),
                'text-transform' => $this->getAttribute('text-transform'),
                'color' => $this->getAttribute('color'),
                'height' => $this->getAttribute('height'),
            ],
            'table' => [
                'background' => $this->getAttribute('container-background-color'),
                'border-collapse' => 'collapse',
                'border' => '0',
                'border-spacing' => '0',
                'width' => '100%',
                'vertical-align' => 'top',
            ],
            'td' => [
                'background-color' => $this->getAttribute('background-color'),
                'font-size' => '0px',
                'word-break' => 'break-word',
                'padding' => $this->getAttribute('padding'),
                'padding-top' => $this->getAttribute('padding-top'),
                'padding-right' => $this->getAttribute('padding-right'),
                'padding-bottom' => $this->getAttribute('padding-bottom'),
                'padding-left' => $this->getAttribute('padding-left'),
                'vertical-align' => $this->getAttribute('vertical-align'),
            ],
        ];
    }

    protected function renderContent(): string
    {
        return $this->innerColumnWrap('
          <div
            '.$this->htmlAttributes([
            'style' => 'text',
        ]).'
          >{{ $slot }}</div>
        ');
    }

    public function renderMjml(array $data): View|string
    {
        $height = $this->getAttribute('height');

        if ($height) {
            $conditionalContent = '<table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td height="'.$height.'" style="vertical-align:top;height:'.$height.';">';

            return ConditionalTag::conditionalTag($conditionalContent)
                .'
                '
                .$this->renderContent()
                .'
                '
                .ConditionalTag::conditionalTag('</td></tr></table>')
                .'
                ';
        }

        return $this->renderContent();
    }
}
