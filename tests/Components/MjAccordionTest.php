<?php

it('renders accordion with default attributes and one element', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-section>
      <mj-column>
        <mj-accordion>
          <mj-accordion-element>
            <mj-accordion-title>Section 1</mj-accordion-title>
            <mj-accordion-text>This is the first section</mj-accordion-text>
          </mj-accordion-element>
        </mj-accordion>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('renders accordion with multiple elements', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-section>
      <mj-column>
        <mj-accordion>
          <mj-accordion-element>
            <mj-accordion-title>Section 1</mj-accordion-title>
            <mj-accordion-text>First section content</mj-accordion-text>
          </mj-accordion-element>
          <mj-accordion-element>
            <mj-accordion-title>Section 2</mj-accordion-title>
            <mj-accordion-text>Second section content</mj-accordion-text>
          </mj-accordion-element>
        </mj-accordion>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies all accordion attributes', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-section>
      <mj-column>
        <mj-accordion
          container-background-color="#fafafa"
          border="3px dashed #333"
          font-family="Arial"
          icon-align="top"
          icon-width="40px"
          icon-height="40px"
          icon-wrapped-url="https://example.com/plus.png"
          icon-wrapped-alt="open"
          icon-unwrapped-url="https://example.com/minus.png"
          icon-unwrapped-alt="close"
          icon-position="left"
          padding="20px"
          padding-top="5px"
          padding-bottom="6px"
          padding-left="7px"
          padding-right="8px"
        >
          <mj-accordion-element>
            <mj-accordion-title>Section</mj-accordion-title>
            <mj-accordion-text>Content</mj-accordion-text>
          </mj-accordion-element>
        </mj-accordion>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies all accordion-element attributes', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-section>
      <mj-column>
        <mj-accordion>
          <mj-accordion-element
            background-color="#eee"
            border="1px solid #000"
            font-family="Verdana"
            icon-align="bottom"
            icon-width="24px"
            icon-height="24px"
            icon-wrapped-url="https://example.com/plus.png"
            icon-wrapped-alt="open"
            icon-unwrapped-url="https://example.com/minus.png"
            icon-unwrapped-alt="close"
            icon-position="left"
            css-class="my-accordion-element"
          >
            <mj-accordion-title>Title</mj-accordion-title>
            <mj-accordion-text>Text</mj-accordion-text>
          </mj-accordion-element>
        </mj-accordion>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies all accordion-title and accordion-text attributes', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-section>
      <mj-column>
        <mj-accordion>
          <mj-accordion-element>
            <mj-accordion-title
              background-color="#222"
              color="#fff"
              font-size="18px"
              font-family="Tahoma"
              padding="10px"
              padding-top="2px"
              padding-bottom="3px"
              padding-left="4px"
              padding-right="5px"
              icon-align="middle"
              icon-width="20px"
              icon-height="20px"
              icon-wrapped-url="https://example.com/plus.png"
              icon-wrapped-alt="open"
              icon-unwrapped-url="https://example.com/minus.png"
              icon-unwrapped-alt="close"
              icon-position="right"
              css-class="my-title"
            >Title</mj-accordion-title>
            <mj-accordion-text
              background-color="#fafafa"
              font-size="15px"
              font-family="Georgia"
              font-weight="bold"
              letter-spacing="1px"
              line-height="1.5"
              color="#333"
              padding="8px"
              padding-top="1px"
              padding-bottom="2px"
              padding-left="3px"
              padding-right="4px"
              border="1px solid #ccc"
              css-class="my-text"
            >Text</mj-accordion-text>
          </mj-accordion-element>
        </mj-accordion>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('renders missing title and text automatically', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-section>
      <mj-column>
        <mj-accordion>
          <mj-accordion-element>
            Content without explicit title or text
          </mj-accordion-element>
        </mj-accordion>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    // Hier erwarten wir, dass ein title und text automatisch generiert werden.
    expect((string) blade($template))->toEqualMjmlHtml($template);
})->skip('Not implemented yet.');
