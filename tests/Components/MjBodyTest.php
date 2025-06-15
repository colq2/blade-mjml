<?php

use function PHPUnit\Framework\assertMatchesRegularExpression;

it('can set background color', closure: function () {
    $template = <<<'HTML'
<mjml>
    <mj-head>
        <mj-title>Test</mj-title>
    </mj-head>
    <mj-body background-color="#0000ff">
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $view->assertSee('background-color:#0000ff');

    $viewString = (string) $view;

    assertMatchesRegularExpression(
        pattern: '/style=".*background-color:\s*#0000ff.*"/',
        string: $viewString
    );

    expect($viewString)->toEqualMjmlHtml($template);
});

it('can set css class', function () {
    $template = <<<'HTML'
<mjml>
    <mj-head>
        <mj-title>Test</mj-title>
    </mj-head>
    <mj-body css-class="test-class">
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string) $view;

    $view->assertSee('class="test-class"', escape: false);

    expect($viewString)->toEqualMjmlHtml($template);
});

it('can merges blade and mjml classes', function () {
    $template = <<<'HTML'
<mjml>
    <mj-head>
        <mj-title>Test</mj-title>
    </mj-head>
    <mj-body class="test-class" css-class="test-class-2">
    </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $view->assertSee('class="test-class-2 test-class"', escape: false);

    // we do not compare mjml output here, because mjml does not support class attributes
});
