<?php

it('renders hero', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-hero>
    </mj-hero>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('renders hero with background', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-hero
      mode="fixed-height"
      height="469px"
      background-width="600px"
      background-height="469px"
      background-url=
          "https://cloud.githubusercontent.com/assets/1830348/15354890/1442159a-1cf0-11e6-92b1-b861dadf1750.jpg"
      background-color="#2a3448"
      padding="100px 0px">
    </mj-hero>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies a custom background color and url', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-hero background-color="#FF0000" background-url="https://example.com/bg.jpg"></mj-hero>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies custom background position, size and repeat', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-hero background-position="top left" background-width="600" background-height="400" mode="fluid-height"></mj-hero>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies custom border radius and height', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-hero border-radius="20px" height="400px"></mj-hero>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies custom width and vertical align', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-hero width="600px" vertical-align="middle"></mj-hero>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies custom padding and inner padding', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-hero padding="40px" padding-top="10px" padding-bottom="20px" padding-left="5px" padding-right="15px"></mj-hero>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('renders fixed height example', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-hero
      mode="fixed-height"
      height="469px"
      background-width="600px"
      background-height="469px"
      background-url=
          "https://cloud.githubusercontent.com/assets/1830348/15354890/1442159a-1cf0-11e6-92b1-b861dadf1750.jpg"
      background-color="#2a3448"
      padding="100px 0px">
      <mj-text
        padding="20px"
        color="#ffffff"
        font-family="Helvetica"
        align="center"
        font-size="45px"
        line-height="45px"
        font-weight="900">
        GO TO SPACE
      </mj-text>
      <mj-button href="https://mjml.io/" align="center">
        ORDER YOUR TICKET NOW
      </mj-button>
    </mj-hero>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('renders fluid height example', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-hero
      mode="fluid-height"
      background-width="600px"
      background-height="469px"
      background-url=
          "https://cloud.githubusercontent.com/assets/1830348/15354890/1442159a-1cf0-11e6-92b1-b861dadf1750.jpg"
      background-color="#2a3448"
      padding="100px 0px">
      <mj-text
        padding="20px"
        color="#ffffff"
        font-family="Helvetica"
        align="center"
        font-size="45px"
        line-height="45px"
        font-weight="900">
        GO TO SPACE
      </mj-text>
      <mj-button href="https://mjml.io/" align="center">
        ORDER YOUR TICKET NOW
      </mj-button>
    </mj-hero>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});
