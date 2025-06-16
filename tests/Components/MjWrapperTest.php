<?php

it('use mj-wrapper', closure: function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-wrapper border="1px solid #000000" padding="50px 30px">
      <mj-section border-top="1px solid #aaaaaa" border-left="1px solid #aaaaaa" border-right="1px solid #aaaaaa" padding="20px">
        <mj-column>
          <mj-text>Test</mj-text>
        </mj-column>
      </mj-section>
      <mj-section border-left="1px solid #aaaaaa" border-right="1px solid #aaaaaa" padding="20px" border-bottom="1px solid #aaaaaa">
        <mj-column border="1px solid #dddddd">
          <mj-text padding="20px"> First line of text </mj-text>
        </mj-column>
      </mj-section>
    </mj-wrapper>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('renders mj-wrapper with multiple sections and columns', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-wrapper border="2px dashed #ff0000" padding="10px">
      <mj-section>
        <mj-column>
          <mj-text>Column 1</mj-text>
        </mj-column>
        <mj-column>
          <mj-text>Column 2</mj-text>
        </mj-column>
      </mj-section>
      <mj-section>
        <mj-column>
          <mj-text>Another section</mj-text>
        </mj-column>
      </mj-section>
    </mj-wrapper>
  </mj-body>
</mjml>
HTML;
    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('renders mj-wrapper with background color and image', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-wrapper background-color="#f0f0f0" background-url="https://via.placeholder.com/600x200" background-repeat="no-repeat" background-size="cover">
      <mj-section>
        <mj-column>
          <mj-text>With background image</mj-text>
        </mj-column>
      </mj-section>
    </mj-wrapper>
  </mj-body>
</mjml>
HTML;
    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('renders mj-wrapper with css-class and custom attributes', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-wrapper css-class="my-wrapper" border-radius="10px" direction="rtl">
      <mj-section>
        <mj-column>
          <mj-text>RTL and custom class</mj-text>
        </mj-column>
      </mj-section>
    </mj-wrapper>
  </mj-body>
</mjml>
HTML;
    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('renders mj-wrapper with nested mj-section and mj-raw', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-wrapper>
      <mj-section>
        <mj-column>
          <mj-text>Text before raw</mj-text>
        </mj-column>
      </mj-section>
      <mj-raw>
        <!-- This is a raw HTML block -->
        <div>Raw HTML content</div>
      </mj-raw>
      <mj-section>
        <mj-column>
          <mj-text>Text after raw</mj-text>
        </mj-column>
      </mj-section>
    </mj-wrapper>
  </mj-body>
</mjml>
HTML;
    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('renders mj-wrapper with full-width attribute', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-wrapper full-width="full-width" background-color="#e0e0e0">
      <mj-section>
        <mj-column>
          <mj-text>Full width wrapper</mj-text>
        </mj-column>
      </mj-section>
    </mj-wrapper>
  </mj-body>
</mjml>
HTML;
    expect((string) blade($template))->toEqualMjmlHtml($template);
});
