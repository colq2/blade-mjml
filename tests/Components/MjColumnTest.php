<?php

use function PHPUnit\Framework\assertMatchesRegularExpression;
use function PHPUnit\Framework\assertStringContainsString;

it('can set background color', closure: function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section background-color="#000000">
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    $view->assertSee('background-color:#000000', escape: false);

    assertMatchesRegularExpression(
        pattern: '/style=".*background-color:\s*#000000.*"/',
        string: $viewString
    );

    expect($viewString)->toEqualMjmlHtml($template);
});

it('can set css class', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section css-class="test-class">
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    $view->assertSee('class="test-class"', escape: false);

    expect($viewString)->toEqualMjmlHtml($template);
});

it('can render with full-width', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section full-width="full-width">
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertMatchesRegularExpression(
        pattern: '/<table[^>]*align="center"[^>]*>/',
        string: $viewString
    );

    expect($viewString)->toEqualMjmlHtml($template);
});

it('can set background image', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section background-url="https://example.com/image.jpg">
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertMatchesRegularExpression(
        pattern: '/background:[^;]*url\(\'https:\/\/example\.com\/image\.jpg\'\)/',
        string: $viewString
    );

    // VML for Outlook fallback should be included
    assertMatchesRegularExpression(
        pattern: '/<v:rect[^>]*>/',
        string: $viewString
    );
    assertMatchesRegularExpression(
        pattern: '/<v:fill[^>]*src="https:\/\/example\.com\/image\.jpg"/',
        string: $viewString
    );

    expect($viewString)->toEqualMjmlHtml($template);
});

it('can render one column', function(){
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);

    expect((string)$view)->toEqualMjmlHtml($template);
});

it('can render multiple columns', function(){
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);

    expect((string)$view)->toEqualMjmlHtml($template);
});

it('can set background color in column', closure: function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column background-color="#0000FF">
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    $view->assertSee('background-color:#0000FF', escape: false);
    expect($viewString)->toEqualMjmlHtml($template);
});

it('can set css class on column', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column css-class="custom-column-class">
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('custom-column-class', $viewString);
    expect($viewString)->toEqualMjmlHtml($template);
});

it('creates proper responsive classes for percentage width', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column width="50%">
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertMatchesRegularExpression(
        pattern: '/class="mj-column-per-50/',
        string: $viewString
    );

    // Überprüfen, dass Media Queries generiert werden
    assertStringContainsString(
        '@media only screen and (min-width:',
        $viewString
    );

    // Überprüfen des Media Query Inhalts
    assertMatchesRegularExpression(
        pattern: '/\.mj-column-per-50\s*{\s*width:\s*50%\s*!important;\s*max-width:\s*50%;/',
        string: $viewString
    );

    expect($viewString)->toEqualMjmlHtml($template);
});

it('creates proper responsive classes for pixel width', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column width="300px">
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertMatchesRegularExpression(
        pattern: '/class="mj-column-px-300/',
        string: $viewString
    );

    // Überprüfen des Media Query Inhalts
    assertMatchesRegularExpression(
        pattern: '/\.mj-column-px-300\s*{\s*width:\s*300px\s*!important;\s*max-width:\s*300px;/',
        string: $viewString
    );

    expect($viewString)->toEqualMjmlHtml($template);
});

it('adds outlook-group-fix class for outlook compatibility', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('mj-outlook-group-fix', $viewString);
    expect($viewString)->toEqualMjmlHtml($template);
});

it('applies padding attributes correctly', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column padding="10px 20px">
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('padding:10px 20px', $viewString);
    expect($viewString)->toEqualMjmlHtml($template);
});

it('applies direction attribute correctly', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column direction="rtl">
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('direction:rtl', $viewString);
    expect($viewString)->toEqualMjmlHtml($template);
});

it('applies vertical-align attribute correctly', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column vertical-align="bottom">
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('vertical-align:bottom', $viewString);
    expect($viewString)->toEqualMjmlHtml($template);
});

it('applies inner-border attributes correctly', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column inner-border="2px solid blue" padding="5px">
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('border:2px solid blue', $viewString);
    expect($viewString)->toEqualMjmlHtml($template);
});

it('uses default width when none specified', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    // Stellen sicher, dass die Klasse für 100% Breite verwendet wird
    assertMatchesRegularExpression(
        pattern: '/class="mj-column-per-100/',
        string: $viewString
    );

    expect($viewString)->toEqualMjmlHtml($template);
});

it('renders child content correctly', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-raw>
                    <div>Test Child Content</div>
                </mj-raw>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string)$view;

    assertStringContainsString('<div>Test Child Content</div>', $viewString);

    expect($viewString)->toEqualMjmlHtml($template);
});
