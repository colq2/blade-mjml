<?php

it('renders navbar with default attributes and links', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-navbar>
                    <mj-navbar-link href="/home">Home</mj-navbar-link>
                    <mj-navbar-link href="/about">About</mj-navbar-link>
                </mj-navbar>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

function extractNavbarId(string $input): ?string
{
    if (preg_match('/<input type="checkbox" id="([^"]+)" class="mj-menu-checkbox"/', $input, $matches)) {
        return $matches[1];
    }
    return null;
}

it('renders navbar with hamburger menu', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-navbar hamburger="hamburger" ico-open="&#9776;" ico-close="&#8855;">
                    <mj-navbar-link href="/menu">Menu</mj-navbar-link>
                </mj-navbar>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    $expectedHtml = convertMjml($template);
    // extract input id from <input type="checkbox" id="9f0b08bad717f4d8"
    $expectedNavbarId = extractNavbarId($expectedHtml);

    $renderedHtml = (string) blade($template);
    $renderedNavbarId = extractNavbarId($renderedHtml);

    // replace the rendered id with the expected id
    $renderedHtml = str_replace($renderedNavbarId, $expectedNavbarId, $renderedHtml);

    expect($renderedHtml)->toEqualHtml($expectedHtml);
});

it('applies all navbar attributes', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-navbar
                    align="left"
                    base-url="https://example.com"
                    ico-align="right"
                    ico-color="#ff0000"
                    ico-font-size="40px"
                    ico-font-family="Arial"
                    ico-text-transform="lowercase"
                    ico-padding="20px"
                    ico-padding-left="5px"
                    ico-padding-top="6px"
                    ico-padding-right="7px"
                    ico-padding-bottom="8px"
                    ico-text-decoration="underline"
                    ico-line-height="40px"
                    padding="30px"
                    padding-left="10px"
                    padding-top="11px"
                    padding-right="12px"
                    padding-bottom="13px"
                >
                    <mj-navbar-link href="/foo">Foo</mj-navbar-link>
                </mj-navbar>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies all navbar-link attributes', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-navbar>
                    <mj-navbar-link
                        color="#123456"
                        font-family="Arial"
                        font-size="18px"
                        font-style="italic"
                        font-weight="bold"
                        href="/bar"
                        name="bar"
                        target="_self"
                        rel="noopener"
                        letter-spacing="2px"
                        line-height="30px"
                        padding="20px"
                        padding-top="5px"
                        padding-left="6px"
                        padding-right="7px"
                        padding-bottom="8px"
                        text-decoration="underline"
                        text-transform="capitalize"
                        css-class="custom-link"
                    >Bar</mj-navbar-link>
                </mj-navbar>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});
