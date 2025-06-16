<?php

namespace colq2\BladeMjml\Components;

use Illuminate\Support\Arr;

class MjWrapper extends MjSection
{

    public function getComponentName(): string
    {
        return 'mj-wrapper';
    }

    public function getChildContext(): array
    {
        ['box' => $box] = $this->getBoxWidths();

        return array_merge($this->context(), [
            'containerWidth' => "{$box}px",
            'wrapperFn' => function ($content, MjmlBodyComponent $component) {
                if($component->isRawElement()) {
                    return $content;
                }

                return '
                    <!--[if mso | IE]>
                    <tr>
                      <td
                        '.$component->htmlAttributes([
                        'align' => $component->getAttribute('align'),
                        'class' => $component->getAttribute('css-class'),
                        'width' => Arr::get($component->context(), 'containerWidth'),
                    ]).'
                      >
                      <![endif]-->
                      '.$content.'
                      <!--[if mso | IE]>
                      </td>
                    </tr>
                    <![endif]-->
                    ';
            },
        ]);
    }

    protected function renderWrappedChildren(): string
    {
        return '{{ $slot }}';
    }
}
