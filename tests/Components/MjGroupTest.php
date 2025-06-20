<?php

it('renders group with default attributes', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-group>
                <mj-column>
                    <mj-text>Group 1</mj-text>
                </mj-column>
                <mj-column>
                    <mj-text>Group 2</mj-text>
                </mj-column>
            </mj-group>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies background color, direction and vertical-align', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-group background-color="#f0f0f0" direction="rtl" vertical-align="middle">
                <mj-column>
                    <mj-text>Col 1</mj-text>
                </mj-column>
            </mj-group>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies custom width', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-group width="300px">
                <mj-column>
                    <mj-text>Col 1</mj-text>
                </mj-column>
            </mj-group>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies css-class', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-group css-class="my-group">
                <mj-column>
                    <mj-text>Col 1</mj-text>
                </mj-column>
                <mj-column>
                    <mj-text>Col 2</mj-text>
                </mj-column>
            </mj-group>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('renders mjml example', function () {
    $template = <<<'HTML'
<mjml>
  <mj-body>
    <mj-section>
      <mj-group>
        <mj-column>
          <mj-image width="137px" height="185px" padding="0"    src="https://mjml.io/assets/img/easy-and-quick.png" />
          <mj-text align="center">
            <h2>Easy and quick</h2>
            <p>Write less code, save time and code more efficiently with MJML’s semantic syntax.</p>
          </mj-text>
        </mj-column>
        <mj-column>
          <mj-image width="166px" height="185px" padding="0" src="https://mjml.io/assets/img/responsive.png" />
          <mj-text align="center">
            <h2>Responsive</h2>
            <p>MJML is responsive by design on most-popular email clients, even Outlook.</p>
          </mj-text>
        </mj-column>
      </mj-group>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});
