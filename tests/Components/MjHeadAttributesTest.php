<?php

use function PHPUnit\Framework\assertStringContainsString;
use function PHPUnit\Framework\assertStringNotContainsString;

it('does not render inner node', function() {
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
    $viewString = (string)$view;

    assertStringNotContainsString('mj-text', $viewString);
    assertStringNotContainsString('mj-class', $viewString);
    assertStringNotContainsString('mj-all', $viewString);
});