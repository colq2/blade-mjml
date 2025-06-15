<?php

use function PHPUnit\Framework\assertStringNotContainsString;

it('does not render inner node', function () {
    $template = <<<'HTML'
<mjml>
  <mj-head>
    <mj-attributes>
      <mj-text padding="0" />
      <mj-class name="blue" color="blue" />
      <mj-class name="big" font-size="20px" />
      <mj-all font-family="Arial" />
    </mj-attributes>
  </mj-head>
  <mj-body>
    <mj-section>
      <mj-column>
        <mj-text mj-class="blue big">
          Hello World!
        </mj-text>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    $view = blade($template);
    $viewString = (string) $view;

    assertStringNotContainsString('mj-text', $viewString);
    assertStringNotContainsString('mj-class', $viewString);
    assertStringNotContainsString('mj-all', $viewString);
});

it('can set defaults for mj-text', function () {
    $template = <<<'HTML'
<mjml>
  <mj-head>
    <mj-attributes>
      <mj-text padding="0" />
    </mj-attributes>
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

it('can overrides global mj-text defaults', function () {
    $template = <<<'HTML'
<mjml>
  <mj-head>
    <mj-attributes>
      <mj-text padding="0" />
    </mj-attributes>
  </mj-head>
  <mj-body>
    <mj-section>
      <mj-column>
        <mj-text padding="10px">
          Hello World!
        </mj-text>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('can use mj-class', function () {
    $template = <<<'HTML'
<mjml>
  <mj-head>
    <mj-attributes>
      <mj-text padding="0" />
      <mj-class name="blue" color="blue" />
    </mj-attributes>
  </mj-head>
  <mj-body>
    <mj-section>
      <mj-column>
        <mj-text mj-class="blue">
          Hello World!
        </mj-text>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('can use multiple mj-class', function () {
    $template = <<<'HTML'
<mjml>
  <mj-head>
    <mj-attributes>
      <mj-text padding="0" />
      <mj-class name="blue" color="blue" />
      <mj-class name="big" font-size="20px" />
    </mj-attributes>
  </mj-head>
  <mj-body>
    <mj-section>
      <mj-column>
        <mj-text mj-class="blue big">
          Hello World!
        </mj-text>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('can use mj-all', function () {
    $template = <<<'HTML'
<mjml>
  <mj-head>
    <mj-attributes>
      <mj-text padding="0" />
      <mj-class name="blue" color="blue" />
      <mj-class name="big" font-size="20px" />
      <mj-all font-family="Arial" />
    </mj-attributes>
  </mj-head>
  <mj-body>
    <mj-section>
      <mj-column>
        <mj-text mj-class="blue big">
          Hello World!
        </mj-text>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});


it('can use set defaults for mj-button', function () {
    $template = <<<'HTML'
<mjml>
    <mj-head>
        <mj-attributes>
        <mj-button padding="0" />
        </mj-attributes>
    </mj-head>
    <mj-body>
        <mj-section>
        <mj-column>
            <mj-button>
            Click Me!
            </mj-button>
        </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});
