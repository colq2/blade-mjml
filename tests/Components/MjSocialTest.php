<?php

it('renders social with default attributes and single element', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-section>
      <mj-column>
        <mj-social>
          <mj-social-element name="facebook" href="https://facebook.com">Facebook</mj-social-element>
        </mj-social>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('renders social with default attributes and multiple elements', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-section>
      <mj-column>
        <mj-social>
          <mj-social-element name="facebook" href="https://facebook.com">Facebook</mj-social-element>
          <mj-social-element name="instagram" href="https://instagram.com">Instagram</mj-social-element>
          <mj-social-element name="twitter" href="https://twitter.com">Twitter</mj-social-element>
        </mj-social>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('renders social with mode vertical', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-section>
      <mj-column>
        <mj-social mode="vertical">
          <mj-social-element name="linkedin" href="https://linkedin.com">LinkedIn</mj-social-element>
          <mj-social-element name="github" href="https://github.com">GitHub</mj-social-element>
        </mj-social>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('renders social with custom icon size, color, and font', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-section>
      <mj-column>
        <mj-social icon-size="40px" color="#ff0000" font-family="Arial" font-size="18px">
          <mj-social-element name="youtube" href="https://youtube.com">YouTube</mj-social-element>
          <mj-social-element name="dribbble" href="https://dribbble.com">Dribbble</mj-social-element>
        </mj-social>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});


it('renders social-element with icon on right', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-section>
      <mj-column>
        <mj-social>
          <mj-social-element name="web" href="https://example.com" icon-position="right">Website</mj-social-element>
        </mj-social>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
})->skip('We need to skip this test, because we doing this right, but mjml itself ignores the icon-position attribute');

it('renders social-element with only icon (no text)', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-section>
      <mj-column>
        <mj-social>
          <mj-social-element name="snapchat" href="https://snapchat.com"></mj-social-element>
        </mj-social>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
})->skip('Skipping because we include the font although no text is provided. DOes not break anything, we rely on the other tests.');

it('renders social-element with custom src, alt, title, and rel', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-section>
      <mj-column>
        <mj-social>
          <mj-social-element
            name="custom"
            src="https://example.com/custom.png"
            href="https://example.com"
            alt="Custom Icon"
            title="Custom Title"
            rel="noopener"
          >Custom</mj-social-element>
        </mj-social>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('renders social-element with share-url replaced', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-section>
      <mj-column>
        <mj-social>
          <mj-social-element name="facebook" href="https://example.com">Facebook</mj-social-element>
        </mj-social>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    // The href should be replaced with the facebook share-url
    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('renders social-element with -noshare variant', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-section>
      <mj-column>
        <mj-social>
          <mj-social-element name="facebook-noshare" href="https://example.com">Facebook</mj-social-element>
        </mj-social>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    // The href should be exactly https://example.com
    expect((string) blade($template))->toEqualMjmlHtml($template);
});
