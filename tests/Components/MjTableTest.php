<?php

it('renders table with default attributes', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-table>
                    <tr>
                        <td>Cell 1</td>
                        <td>Cell 2</td>
                    </tr>
                </mj-table>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies custom align, border, cellpadding, cellspacing, and width', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-table align="center" border="2px solid #000" cellpadding="4" cellspacing="2" width="400px">
                    <tr>
                        <td>Cell 1</td>
                        <td>Cell 2</td>
                    </tr>
                </mj-table>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies all font and color attributes', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-table color="#ff0000" font-family="Arial" font-size="20px" font-weight="bold" line-height="30px">
                    <tr>
                        <td>Cell 1</td>
                        <td>Cell 2</td>
                    </tr>
                </mj-table>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies all padding attributes', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-table padding="20px" padding-top="10px" padding-right="15px" padding-bottom="5px" padding-left="8px">
                    <tr>
                        <td>Cell 1</td>
                        <td>Cell 2</td>
                    </tr>
                </mj-table>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});

it('applies table-layout, vertical-align, role, and container-background-color', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-table table-layout="fixed" vertical-align="middle" role="presentation" container-background-color="#eee">
                    <tr>
                        <td>Cell 1</td>
                        <td>Cell 2</td>
                    </tr>
                </mj-table>
            </mj-column>
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
      <mj-column>
        <mj-table>
          <tr style="border-bottom:1px solid #ecedee;text-align:left;padding:15px 0;">
            <th style="padding: 0 15px 0 0;">Year</th>
            <th style="padding: 0 15px;">Language</th>
            <th style="padding: 0 0 0 15px;">Inspired from</th>
          </tr>
          <tr>
            <td style="padding: 0 15px 0 0;">1995</td>
            <td style="padding: 0 15px;">PHP</td>
            <td style="padding: 0 0 0 15px;">C, Shell Unix</td>
          </tr>
          <tr>
            <td style="padding: 0 15px 0 0;">1995</td>
            <td style="padding: 0 15px;">JavaScript</td>
            <td style="padding: 0 0 0 15px;">Scheme, Self</td>
          </tr>
        </mj-table>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});
