<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use colq2\BladeMjml\Helpers\WidthParser;
use Illuminate\Contracts\View\View;

class MjTable extends MjmlBodyComponent
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public ?string $mjClass = null,
        public string $align = 'left',
        public string $border = 'none',
        public string $cellpadding = '0',
        public string $cellspacing = '0',
        public string $containerBackgroundColor = '',
        public string $color = '#000000',
        public string $fontFamily = 'Ubuntu, Helvetica, Arial, sans-serif',
        public string $fontSize = '13px',
        public string $fontWeight = '',
        public string $lineHeight = '22px',
        public string $paddingBottom = '',
        public string $paddingLeft = '',
        public string $paddingRight = '',
        public string $paddingTop = '',
        public string $padding = '10px 25px',
        public string $role = '',
        public string $tableLayout = 'auto',
        public string $verticalAlign = '',
        public string $width = '100%',
        public string $cssClass = '',
    ) {
        parent::__construct($bladeMjmlContext, $mjClass);
    }

    public function getComponentName(): string
    {
        return 'mj-table';
    }

    public function allowedAttributes(): array
    {
        return [
            'align' => 'enum(left,right,center)',
            'border' => 'string',
            'cellpadding' => 'integer',
            'cellspacing' => 'integer',
            'container-background-color' => 'color',
            'color' => 'color',
            'font-family' => 'string',
            'font-size' => 'unit(px)',
            'font-weight' => 'string',
            'line-height' => 'unit(px,%,)',
            'padding-bottom' => 'unit(px,%)',
            'padding-left' => 'unit(px,%)',
            'padding-right' => 'unit(px,%)',
            'padding-top' => 'unit(px,%)',
            'padding' => 'unit(px,%){1,4}',
            'role' => 'enum(none,presentation)',
            'table-layout' => 'enum(auto,fixed,initial,inherit)',
            'vertical-align' => 'enum(top,bottom,middle)',
            'width' => 'unit(px,%)',
        ];
    }

    public function getStyles(): array
    {
        return [
            'table' => [
                'color' => $this->getAttribute('color'),
                'font-family' => $this->getAttribute('font-family'),
                'font-size' => $this->getAttribute('font-size'),
                'line-height' => $this->getAttribute('line-height'),
                'table-layout' => $this->getAttribute('table-layout'),
                'width' => $this->getAttribute('width'),
                'border' => $this->getAttribute('border'),
            ],
        ];
    }

    protected function getWidth()
    {
        $width = $this->getAttribute('width');
        ['parsedWidth' => $parsedWidth, 'unit' => $unit] = WidthParser::widthParser($width);

        return $unit === '%' ? $width : $parsedWidth;
    }

    public function renderMjml(array $data): View|string
    {
        return '
        <table '.$this->htmlAttributes([
            'cellpadding' => $this->getAttribute('cellpadding'),
            'cellspacing' => $this->getAttribute('cellspacing'),
            'role' => $this->getAttribute('role') ?: null,
            'width' => $this->getWidth(),
            'border' => '0',
            'style' => 'table',
        ]).'>
            {{ $slot }}
        </table>';

    }
}
