<?php

use function PHPUnit\Framework\assertMatchesRegularExpression;

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
    $viewString = (string) $view;

    $view->assertSee('background-color:#000000', escape: false);

    expect($viewString)->toEqualMjmlHtml($template);

    assertMatchesRegularExpression(
        pattern: '/style=".*background-color:\s*#000000.*"/',
        string: $viewString
    );
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
    $view->assertSee('class="test-class"', escape: false);

    expect((string) $view)->toEqualMjmlHtml($template);
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
    $viewString = (string) $view;

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
    $viewString = (string) $view;

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
