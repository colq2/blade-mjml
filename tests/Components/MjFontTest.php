<?php

it('can use custom font', function () {
    $template = <<<'HTML'
<mjml>
    <mj-head>
        <mj-font name="Raleway" href="https://fonts.googleapis.com/css?family=Raleway" />
    </mj-head>
    <mj-body>
    <mj-section>
        <mj-column>
            <mj-text font-family="Raleway, Arial">
                Hello World!
            </mj-text>
        </mj-column>
    </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});


it('ignores unused font', function () {
    $template = <<<'HTML'
<mjml>
    <mj-head>
        <mj-font name="Raleway" href="https://fonts.googleapis.com/css?family=Raleway" />
    </mj-head>
    <mj-body>
    <mj-section>
        <mj-column>
            <mj-text>
                Hello World!
            </mj-text>
        </mj-column>
    </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});
