<?php

it('renders button with default attributes', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-button>Click me</mj-button>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies a custom background color', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-button background-color="#FF0000">Click me</mj-button>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies custom border and radius', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-button border="2px solid #000" border-radius="10px">Click me</mj-button>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies custom font and color', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-button font-family="Arial" font-size="20px" color="#333333">Click me</mj-button>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies custom href, target and rel', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-button href="https://example.com" target="_self" rel="noopener">Click me</mj-button>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies custom padding and inner-padding', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-button padding="30px" inner-padding="20px 40px">Click me</mj-button>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies custom width and alignment', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-button width="200px" align="left">Click me</mj-button>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});
