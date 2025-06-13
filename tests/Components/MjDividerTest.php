<?php

it('renders divider with default attributes', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-divider></mj-divider>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies a custom border color', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-divider border-color="#FF0000"></mj-divider>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies a custom border style and width', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-divider border-style="dotted" border-width="5px"></mj-divider>
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
                <mj-divider width="50%" align="left"></mj-divider>
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
                <mj-divider padding="20px 10px"></mj-divider>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies a container background color', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-divider container-background-color="#FAFAFA"></mj-divider>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});
