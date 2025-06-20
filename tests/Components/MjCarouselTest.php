<?php

function extractMjCarouselId(string $input): ?string
{
    if (preg_match('/\.mj-carousel-([a-zA-Z0-9]+)-icons-cell\s*\{/', $input, $matches)) {
        return $matches[1];
    }
    return null;
}

function prepareMjCarouselHtml(string $mjmlTemplate): array
{
    $expectedHtml = convertMjml($mjmlTemplate);
    $expectedCarouselId = extractMjCarouselId($expectedHtml);

    $generatedHtml = (string)blade($mjmlTemplate);
    $generatedCarouselId = extractMjCarouselId($generatedHtml);

    return [
        'expectedHtml' => $expectedHtml,
        'generatedHtml' => str_replace($generatedCarouselId, $expectedCarouselId, $generatedHtml)
    ];
}

it('renders carousel with default attributes', function () {
    $template = <<<'HTML'
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-carousel>
                    <mj-carousel-image src="https://t3.ftcdn.net/jpg/00/32/03/66/360_F_32036622_NuwnV5znOJWyDo9dLlWHJG9ASW8w9IQM.jpg" />
                    <mj-carousel-image src="https://t3.ftcdn.net/jpg/00/32/03/66/360_F_32036622_NuwnV5znOJWyDo9dLlWHJG9ASW8w9IQM.jpg" />
                    <mj-carousel-image src="https://t3.ftcdn.net/jpg/00/32/03/66/360_F_32036622_NuwnV5znOJWyDo9dLlWHJG9ASW8w9IQM.jpg" />
                </mj-carousel>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
HTML;


    ['expectedHtml' => $expectedHtml, 'generatedHtml' =>  $generatedHtml] = prepareMjCarouselHtml($template);

    expect($generatedHtml)->toEqualHtml($expectedHtml);

});