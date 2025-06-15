<?php

it('supports simple mj-style head component', function () {
    $template = <<<'HTML'
<mjml>
  <mj-head>
    <mj-style>
      .red-text div {
        color: red !important;
        text-decoration: underline !important;
      }
    </mj-style>
  </mj-head>
  <mj-body>
    <mj-section>
      <mj-column>
        <mj-text css-class="red-text">I'm red and underlined</mj-text>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
HTML;

    expect((string) blade($template))->toEqualMjmlHtml($template);
});


// Tests failing, need to be fixed to support inline styles

//it('supports inline mj-style head component', function () {
//    $template = <<<'HTML'
//<mjml>
//  <mj-head>
//    <mj-style inline="inline">
//      .red-text div {
//        color: red !important;
//        text-decoration: underline !important;
//      }
//    </mj-style>
//  </mj-head>
//  <mj-body>
//    <mj-section>
//      <mj-column>
//        <mj-text css-class="red-text">I'm red and underlined</mj-text>
//      </mj-column>
//    </mj-section>
//  </mj-body>
//</mjml>
//HTML;
//
//    expect((string) blade($template))->toEqualMjmlHtml($template);
//});
//
//it('renders mj-style example correctly', function () {
//    $template = <<<'HTML'
//<mjml>
//  <mj-head>
//    <mj-attributes>
//      <mj-class name="mjclass" color="green" font-size="30px" />
//    </mj-attributes>
//    <mj-style inline="inline">
//      .blue-text div {
//        color: blue !important;
//      }
//    </mj-style>
//    <mj-style>
//      .red-text div {
//        color: red !important;
//        text-decoration: underline !important;
//      }
//    </mj-style>
//  </mj-head>
//  <mj-body>
//    <mj-section>
//      <mj-column>
//        <mj-text css-class="red-text">I'm red and underlined</mj-text>
//        <mj-text css-class="blue-text">I'm blue because of inline</mj-text>
//        <mj-text mj-class="mjclass">I'm green</mj-text>
//      </mj-column>
//    </mj-section>
//  </mj-body>
//</mjml>
//HTML;
//
//    expect((string) blade($template))->toEqualMjmlHtml($template);
//});