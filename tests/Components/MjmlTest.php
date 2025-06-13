<?php

namespace colq2\BladeMjml\Tests;

it('can render skeleton', function () {
    $template = <<<'HTML'
<mjml>
</mjml>
HTML;

    $view = blade($template);

    // We do not compare the full HTML output here, because mjml fails without head and body tags
    // But we want to ensure that the view is rendered correctly.
    expect((string) $view)->toBeString()
        ->toContain('<html')
        ->not->toContain('<mjml>');
});

it('can render mj-title', function () {
    $template = <<<'HTML'
<mjml>
    <mj-head>
        <mj-title>Test</mj-title>
    </mj-head>
    <mj-body></mj-body>
</mjml>
HTML;

    $view = blade($template);

    expect((string) $view)->toBeString()
        ->toContain('<title>Test</title>')
        ->toEqualMjmlHtml($template);
});
