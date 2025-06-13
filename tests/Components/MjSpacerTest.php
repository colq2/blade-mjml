<?php

it('renders spacer with default attributes', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-spacer></mj-spacer>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies a custom height', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-spacer height="50px"></mj-spacer>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies custom border styles', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-spacer border="1px solid #000" border-top="2px dashed #f00" border-bottom="3px solid #00f" border-left="4px dotted #0f0" border-right="5px double #ff0"></mj-spacer>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies container background color', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-spacer container-background-color="#FAFAFA"></mj-spacer>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies custom padding', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-spacer padding="20px 10px" padding-top="5px" padding-bottom="15px" padding-left="8px" padding-right="12px"></mj-spacer>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});
