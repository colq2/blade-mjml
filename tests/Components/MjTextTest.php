<?php

use function PHPUnit\Framework\assertMatchesRegularExpression;
use function PHPUnit\Framework\assertStringContainsString;

it('renders text with default styling', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-text>
                    Hello world
                </mj-text>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    // Überprüft, ob der Text gerendert wurde
    assertStringContainsString('Hello world', $viewString);

    // Überprüft die Default-Attribute
    assertStringContainsString('font-family:Ubuntu, Helvetica, Arial, sans-serif', $viewString);
    assertStringContainsString('font-size:13px', $viewString);
    assertStringContainsString('line-height:1', $viewString);
    assertStringContainsString('text-align:left', $viewString);
    assertStringContainsString('color:#000000', $viewString);

    expect($viewString)->toEqualMjmlHtml($template);
});

it('applies custom text alignment', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-text align="center">
                    Centered Text
                </mj-text>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('text-align:center', $viewString);

    expect($viewString)->toEqualMjmlHtml($template);
});

it('applies custom font family', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-text font-family="Arial, sans-serif">
                    Text with Custom Font
                </mj-text>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('font-family:Arial, sans-serif', $viewString);

    expect($viewString)->toEqualMjmlHtml($template);
});

it('applies custom font size', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-text font-size="18px">
                    Bigger Text
                </mj-text>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('font-size:18px', $viewString);

    expect($viewString)->toEqualMjmlHtml($template);
});

it('applies custom line height', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-text line-height="1.5">
                    Text with Larger Line Height
                </mj-text>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('line-height:1.5', $viewString);
    expect($viewString)->toEqualMjmlHtml($template);
});

it('applies custom color', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-text color="#FF0000">
                    Red Text
                </mj-text>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('color:#FF0000', $viewString);

    expect($viewString)->toEqualMjmlHtml($template);
});

it('applies custom text decoration', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-text text-decoration="underline">
                    Underlined Text
                </mj-text>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('text-decoration:underline', $viewString);
    expect($viewString)->toEqualMjmlHtml($template);
});

it('applies custom text transform', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-text text-transform="uppercase">
                    Text in uppercase
                </mj-text>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('text-transform:uppercase', $viewString);

    expect($viewString)->toEqualMjmlHtml($template);
});

it('applies custom padding', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-text padding="20px 15px">
                    Padded Text
                </mj-text>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('padding:20px 15px', $viewString);

    expect($viewString)->toEqualMjmlHtml($template);
});

it('applies directional padding', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-text padding-top="20px" padding-left="10px">
                    Padded Text with Directional Padding
                </mj-text>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('padding-top:20px', $viewString);
    assertStringContainsString('padding-left:10px', $viewString);

    expect($viewString)->toEqualMjmlHtml($template);
});

it('applies custom background color', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-text background-color="#F0F0F0">
                    Text with Background Color
                </mj-text>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    expect($viewString)->toEqualMjmlHtml($template);
});

it('applies custom container background color', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-text container-background-color="#E0E0E0">
                    Text with Container Background Color
                </mj-text>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('background:#E0E0E0', $viewString);

    expect($viewString)->toEqualMjmlHtml($template);
});

it('applies font style', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-text font-style="italic">
                    Italic Text
                </mj-text>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('font-style:italic', $viewString);

    expect($viewString)->toEqualMjmlHtml($template);
});

it('applies font weight', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-text font-weight="bold">
                    Bold Text
                </mj-text>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('font-weight:bold', $viewString);

    expect($viewString)->toEqualMjmlHtml($template);
});

it('applies letter spacing', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-text letter-spacing="2px">
                    Text with Letter Spacing
                </mj-text>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('letter-spacing:2px', $viewString);

    expect($viewString)->toEqualMjmlHtml($template);
});

it('handles html content correctly', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-text>
                    <h1>Heading</h1>
                    <p>Paragraph <a href="https://example.com">with a link</a></p>
                </mj-text>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('<h1>Heading</h1>', $viewString);
    assertStringContainsString('<p>Paragraph <a href="https://example.com">with a link</a></p>', $viewString);

    expect($viewString)->toEqualMjmlHtml($template);
});

it('adds height attribute with outlook fallback when specified', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-text height="200px">
                    Fixed Height Text
                </mj-text>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    // Text sollte mit height-Attribut gerendert werden
    assertStringContainsString('height:200px', $viewString);

    // Outlook bedingte Kommentare sollten vorhanden sein
    assertMatchesRegularExpression(
        pattern: '/<!--\[if mso \| IE\]>.*?<table[^>]*>.*?<tr><td height="200px".*?<!\[endif\]-->/s',
        string: $viewString
    );

    expect($viewString)->toEqualMjmlHtml($template);
});

it('renders css class when provided', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-text css-class="custom-text-class">
                    Text with ccs class
                </mj-text>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('custom-text-class', $viewString);

    expect($viewString)->toEqualMjmlHtml($template);
});
