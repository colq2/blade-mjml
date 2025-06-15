<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use Illuminate\Contracts\View\View;

class MjButton extends MjmlBodyComponent
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public ?string $mjClass = null,
        public string $align = 'center',
        public string $backgroundColor = '#414141',
        public string $border = 'none',
        public string $borderBottom = '',
        public string $borderLeft = '',
        public string $borderRadius = '3px',
        public string $borderRight = '',
        public string $borderTop = '',
        public string $color = '#ffffff',
        public string $containerBackgroundColor = '',
        public string $fontFamily = 'Ubuntu, Helvetica, Arial, sans-serif',
        public string $fontSize = '13px',
        public string $fontStyle = '',
        public string $fontWeight = 'normal',
        public string $height = '',
        public string $href = '',
        public string $name = '',
        public string $title = '',
        public string $innerPadding = '10px 25px',
        public string $letterSpacing = '',
        public string $lineHeight = '120%',
        public string $paddingBottom = '',
        public string $paddingLeft = '',
        public string $paddingRight = '',
        public string $paddingTop = '',
        public string $padding = '10px 25px',
        public string $rel = '',
        public string $target = '_blank',
        public string $textDecoration = 'none',
        public string $textTransform = 'none',
        public string $verticalAlign = 'middle',
        public string $textAlign = '',
        public string $width = '',
        public string $cssClass = '',
    ) {
        parent::__construct($bladeMjmlContext, $mjClass);

        $this->bladeMjmlContext->addFontUsage($this->fontFamily);
    }

    public function getComponentName(): string
    {
        return 'mj-button';
    }

    public function allowedAttributes(): array
    {
        return [
            'align' => 'enum(left,center,right)',
            'background-color' => 'color',
            'border-bottom' => 'string',
            'border-left' => 'string',
            'border-radius' => 'string',
            'border-right' => 'string',
            'border-top' => 'string',
            'border' => 'string',
            'color' => 'color',
            'container-background-color' => 'color',
            'font-family' => 'string',
            'font-size' => 'unit(px)',
            'font-style' => 'string',
            'font-weight' => 'string',
            'height' => 'unit(px,%)',
            'href' => 'string',
            'name' => 'string',
            'title' => 'string',
            'inner-padding' => 'unit(px,%){1,4}',
            'letter-spacing' => 'unitWithNegative(px,em)',
            'line-height' => 'unit(px,%,)',
            'padding-bottom' => 'unit(px,%)',
            'padding-left' => 'unit(px,%)',
            'padding-right' => 'unit(px,%)',
            'padding-top' => 'unit(px,%)',
            'padding' => 'unit(px,%){1,4}',
            'rel' => 'string',
            'target' => 'string',
            'text-decoration' => 'string',
            'text-transform' => 'string',
            'vertical-align' => 'enum(top,bottom,middle)',
            'text-align' => 'enum(left,right,center)',
            'width' => 'unit(px,%)',
        ];
    }

    public function getStyles(): array
    {
        $width = $this->getAttribute('width');
        $backgroundColor = $this->getAttribute('background-color');
        $borderRadius = $this->getAttribute('border-radius');
        $fontFamily = $this->getAttribute('font-family');
        $fontSize = $this->getAttribute('font-size');
        $fontStyle = $this->getAttribute('font-style');
        $fontWeight = $this->getAttribute('font-weight');
        $lineHeight = $this->getAttribute('line-height');
        $letterSpacing = $this->getAttribute('letter-spacing');
        $color = $this->getAttribute('color');
        $textDecoration = $this->getAttribute('text-decoration');
        $textTransform = $this->getAttribute('text-transform');
        $innerPadding = $this->getAttribute('inner-padding');
        $border = $this->getAttribute('border');
        $borderBottom = $this->getAttribute('border-bottom');
        $borderLeft = $this->getAttribute('border-left');
        $borderRight = $this->getAttribute('border-right');
        $borderTop = $this->getAttribute('border-top');
        $height = $this->getAttribute('height');
        $textAlign = $this->getAttribute('text-align');

        return [
            'table' => [
                'border-collapse' => 'separate',
                'width' => $width,
                'line-height' => '100%',
            ],
            'td' => [
                'border' => $border,
                'border-bottom' => $borderBottom,
                'border-left' => $borderLeft,
                'border-radius' => $borderRadius,
                'border-right' => $borderRight,
                'border-top' => $borderTop,
                'cursor' => 'auto',
                'font-style' => $fontStyle,
                'height' => $height,
                'mso-padding-alt' => $innerPadding,
                'text-align' => $textAlign,
                'background' => $backgroundColor,
            ],
            'content' => [
                'display' => 'inline-block',
                'width' => $this->calculateAWidth($width),
                'background' => $backgroundColor,
                'color' => $color,
                'font-family' => $fontFamily,
                'font-size' => $fontSize,
                'font-style' => $fontStyle,
                'font-weight' => $fontWeight,
                'line-height' => $lineHeight,
                'letter-spacing' => $letterSpacing,
                'margin' => '0',
                'text-decoration' => $textDecoration,
                'text-transform' => $textTransform,
                'padding' => $innerPadding,
                'mso-padding-alt' => '0px',
                'border-radius' => $borderRadius,
            ],
        ];
    }

    protected function calculateAWidth($width)
    {
        if (! $width) {
            return null;
        }
        if (str_ends_with($width, '%')) {
            return null;
        }
        if (preg_match('/^(\d+)(px)$/', $width, $matches)) {
            $parsedWidth = (int) $matches[1];
            $borders = $this->getBoxWidths()['borders'];
            $innerPaddings =
                $this->getShorthandAttrValue('inner-padding', 'left') +
                $this->getShorthandAttrValue('inner-padding', 'right');

            return ($parsedWidth - $innerPaddings - $borders).'px';
        }

        return null;
    }

    public function renderMjml(array $data): View|string
    {
        $tag = $this->getAttribute('href') ? 'a' : 'p';

        return '
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
          <tr>
            <td
              '.$this->htmlAttributes([
            'align' => 'center',
            'bgcolor' => $this->getAttribute('background-color') === 'none' ? null : $this->getAttribute('background-color'),
            'role' => 'presentation',
            'style' => 'td',
            'valign' => $this->getAttribute('vertical-align'),
        ]).'
            >
              <'.$tag.'
                '.$this->htmlAttributes([
            'href' => $this->getAttribute('href'),
            'name' => $this->getAttribute('name'),
            'rel' => $this->getAttribute('rel'),
            'title' => $this->getAttribute('title'),
            'style' => 'content',
            'target' => $tag === 'a' ? $this->getAttribute('target') : null,
        ]).'
              >
                {{ $slot }}
              </'.$tag.'>
            </td>
          </tr>
        </tbody>
      </table>
      ';
    }
}
