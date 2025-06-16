<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use Illuminate\Contracts\View\View;

class MjSocialElement extends MjmlBodyComponent
{
    protected static array $defaultSocialNetworks = [
        'facebook' => [
            'share-url' => 'https://www.facebook.com/sharer/sharer.php?u=[[URL]]',
            'background-color' => '#3b5998',
            'src' => 'https://www.mailjet.com/images/theme/v1/icons/ico-social/facebook.png',
        ],
        'twitter' => [
            'share-url' => 'https://twitter.com/intent/tweet?url=[[URL]]',
            'background-color' => '#55acee',
            'src' => 'https://www.mailjet.com/images/theme/v1/icons/ico-social/twitter.png',
        ],
        'x' => [
            'share-url' => 'https://twitter.com/intent/tweet?url=[[URL]]',
            'background-color' => '#000000',
            'src' => 'https://www.mailjet.com/images/theme/v1/icons/ico-social/twitter-x.png',
        ],
        'google' => [
            'share-url' => 'https://plus.google.com/share?url=[[URL]]',
            'background-color' => '#dc4e41',
            'src' => 'https://www.mailjet.com/images/theme/v1/icons/ico-social/google-plus.png',
        ],
        'pinterest' => [
            'share-url' => 'https://pinterest.com/pin/create/button/?url=[[URL]]&media=&description=',
            'background-color' => '#bd081c',
            'src' => 'https://www.mailjet.com/images/theme/v1/icons/ico-social/pinterest.png',
        ],
        'linkedin' => [
            'share-url' => 'https://www.linkedin.com/shareArticle?mini=true&url=[[URL]]&title=&summary=&source=',
            'background-color' => '#0077b5',
            'src' => 'https://www.mailjet.com/images/theme/v1/icons/ico-social/linkedin.png',
        ],
        'instagram' => [
            'background-color' => '#3f729b',
            'src' => 'https://www.mailjet.com/images/theme/v1/icons/ico-social/instagram.png',
        ],
        'web' => [
            'background-color' => '#4BADE9',
            'src' => 'https://www.mailjet.com/images/theme/v1/icons/ico-social/web.png',
        ],
        'snapchat' => [
            'background-color' => '#FFFA54',
            'src' => 'https://www.mailjet.com/images/theme/v1/icons/ico-social/snapchat.png',
        ],
        'youtube' => [
            'background-color' => '#EB3323',
            'src' => 'https://www.mailjet.com/images/theme/v1/icons/ico-social/youtube.png',
        ],
        'tumblr' => [
            'share-url' => 'https://www.tumblr.com/widgets/share/tool?canonicalUrl=[[URL]]',
            'background-color' => '#344356',
            'src' => 'https://www.mailjet.com/images/theme/v1/icons/ico-social/tumblr.png',
        ],
        'github' => [
            'background-color' => '#000000',
            'src' => 'https://www.mailjet.com/images/theme/v1/icons/ico-social/github.png',
        ],
        'xing' => [
            'share-url' => 'https://www.xing.com/app/user?op=share&url=[[URL]]',
            'background-color' => '#296366',
            'src' => 'https://www.mailjet.com/images/theme/v1/icons/ico-social/xing.png',
        ],
        'vimeo' => [
            'background-color' => '#53B4E7',
            'src' => 'https://www.mailjet.com/images/theme/v1/icons/ico-social/vimeo.png',
        ],
        'medium' => [
            'background-color' => '#000000',
            'src' => 'https://www.mailjet.com/images/theme/v1/icons/ico-social/medium.png',
        ],
        'soundcloud' => [
            'background-color' => '#EF7F31',
            'src' => 'https://www.mailjet.com/images/theme/v1/icons/ico-social/soundcloud.png',
        ],
        'dribbble' => [
            'background-color' => '#D95988',
            'src' => 'https://www.mailjet.com/images/theme/v1/icons/ico-social/dribbble.png',
        ],
    ];

    // Füge -noshare Varianten hinzu
    protected static function getSocialNetworks(): array
    {
        $networks = static::$defaultSocialNetworks;
        foreach ($networks as $key => $val) {
            $networks["{$key}-noshare"] = array_merge($val, ['share-url' => '[[URL]]']);
        }

        return $networks;
    }

    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public ?string $mjClass = null,
        public string $alt = '',
        public string $align = 'center',
        public string $iconPosition = 'left',
        public string $backgroundColor = '',
        public string $color = '#000',
        public string $borderRadius = '3px',
        public string $fontFamily = 'Ubuntu, Helvetica, Arial, sans-serif',
        public string $fontSize = '13px',
        public string $fontStyle = '',
        public string $fontWeight = '',
        public string $href = '',
        public string $iconSize = '',
        public string $iconHeight = '',
        public string $iconPadding = '',
        public string $lineHeight = '1',
        public string $name = '',
        public string $paddingBottom = '',
        public string $paddingLeft = '',
        public string $paddingRight = '',
        public string $paddingTop = '',
        public string $padding = '4px',
        public string $textPadding = '4px 4px 4px 0',
        public string $rel = '',
        public string $src = '',
        public string $srcset = '',
        public string $sizes = '',
        public string $title = '',
        public string $target = '_blank',
        public string $textDecoration = 'none',
        public string $verticalAlign = 'middle',
        public string $cssClass = '',
    ) {
        parent::__construct($bladeMjmlContext, $mjClass);
    }

    public function getComponentName(): string
    {
        return 'mj-social-element';
    }

    public function allowedAttributes(): array
    {
        return [
            'alt' => 'string',
            'align' => 'enum(left,center,right)',
            'icon-position' => 'enum(left,right)',
            'background-color' => 'color',
            'color' => 'color',
            'border-radius' => 'unit(px)',
            'font-family' => 'string',
            'font-size' => 'unit(px)',
            'font-style' => 'string',
            'font-weight' => 'string',
            'href' => 'string',
            'icon-size' => 'unit(px,%)',
            'icon-height' => 'unit(px,%)',
            'icon-padding' => 'unit(px,%){1,4}',
            'line-height' => 'unit(px,%,)',
            'name' => 'string',
            'padding-bottom' => 'unit(px,%)',
            'padding-left' => 'unit(px,%)',
            'padding-right' => 'unit(px,%)',
            'padding-top' => 'unit(px,%)',
            'padding' => 'unit(px,%){1,4}',
            'text-padding' => 'unit(px,%){1,4}',
            'rel' => 'string',
            'src' => 'string',
            'srcset' => 'string',
            'sizes' => 'string',
            'title' => 'string',
            'target' => 'string',
            'text-decoration' => 'string',
            'vertical-align' => 'enum(top,middle,bottom)',
        ];
    }

    protected function getSocialAttributes(): array
    {
        $networks = static::getSocialNetworks();
        $name = $this->getAttribute('name');
        $network = $name && isset($networks[$name]) ? $networks[$name] : [];

        $href = $this->getAttribute('href');
        if ($href && isset($network['share-url'])) {
            $href = str_replace('[[URL]]', $href, $network['share-url']);
        }

        return [
            'icon-size' => $this->getAttribute('icon-size') ?: ($network['icon-size'] ?? '20px'),
            'icon-height' => $this->getAttribute('icon-height') ?: ($network['icon-height'] ?? null),
            'srcset' => $this->getAttribute('srcset') ?: ($network['srcset'] ?? ''),
            'sizes' => $this->getAttribute('sizes') ?: ($network['sizes'] ?? ''),
            'src' => $this->getAttribute('src') ?: ($network['src'] ?? ''),
            'background-color' => $this->getAttribute('background-color') ?: ($network['background-color'] ?? ''),
            'href' => $href,
        ];
    }

    public function getStyles(): array
    {
        [
            'icon-size' => $iconSize,
            'icon-height' => $iconHeight,
            'background-color' => $backgroundColor
        ] = $this->getSocialAttributes();

        return [
            'td' => [
                'padding' => $this->getAttribute('padding'),
                'padding-top' => $this->getAttribute('padding-top'),
                'padding-right' => $this->getAttribute('padding-right'),
                'padding-bottom' => $this->getAttribute('padding-bottom'),
                'padding-left' => $this->getAttribute('padding-left'),
                'vertical-align' => $this->getAttribute('vertical-align'),
            ],
            'table' => [
                'background' => $backgroundColor,
                'border-radius' => $this->getAttribute('border-radius'),
                'width' => $iconSize,
            ],
            'icon' => [
                'padding' => $this->getAttribute('icon-padding'),
                'font-size' => '0',
                'height' => $iconHeight ?: $iconSize,
                'vertical-align' => 'middle',
                'width' => $iconSize,
            ],
            'img' => [
                'border-radius' => $this->getAttribute('border-radius'),
                'display' => 'block',
            ],
            'tdText' => [
                'vertical-align' => 'middle',
                'padding' => $this->getAttribute('text-padding'),
            ],
            'text' => [
                'color' => $this->getAttribute('color'),
                'font-size' => $this->getAttribute('font-size'),
                'font-weight' => $this->getAttribute('font-weight'),
                'font-style' => $this->getAttribute('font-style'),
                'font-family' => $this->getAttribute('font-family'),
                'line-height' => $this->getAttribute('line-height'),
                'text-decoration' => $this->getAttribute('text-decoration'),
            ],
        ];
    }

    public function renderMjml(array $data): View|string
    {
        [
            'src' => $src,
            'srcset' => $srcset,
            'sizes' => $sizes,
            'href' => $href,
            'icon-size' => $iconSize,
            'icon-height' => $iconHeight,
        ] = $this->getSocialAttributes();

        $hasLink = ! empty($this->getAttribute('href'));
        $iconPosition = $this->getAttribute('icon-position') ?? 'left';

        $iconTd = '
        <td '.$this->htmlAttributes(['style' => 'td']).'>
          <table
            '.$this->htmlAttributes([
            'border' => '0',
            'cellpadding' => '0',
            'cellspacing' => '0',
            'role' => 'presentation',
            'style' => 'table',
        ]).'
          >
            <tbody>
              <tr>
                <td '.$this->htmlAttributes(['style' => 'icon']).'>
                  '.($hasLink ? '<a '.$this->htmlAttributes([
            'href' => $href,
            'rel' => $this->getAttribute('rel'),
            'target' => $this->getAttribute('target'),
        ]).'>' : '').'
                    <img
                      '.$this->htmlAttributes([
            'alt' => $this->getAttribute('alt'),
            'title' => $this->getAttribute('title'),
            'height' => (int) ($iconHeight ?: $iconSize),
            'src' => $src,
            'style' => 'img',
            'width' => (int) $iconSize,
            'sizes' => $sizes,
            'srcset' => $srcset,
        ], ['alt']).' />
                  '.($hasLink ? '</a>' : '').'
                </td>
              </tr>
            </tbody>
          </table>
        </td>
        ';

        $slotContent = trim((string) $data['slot'] ?? '');

        $contentTd = $slotContent !== '' ? '
        <td '.$this->htmlAttributes(['style' => 'tdText']).'>
            '.($hasLink
                ? '<a '.$this->htmlAttributes([
                    'href' => $href,
                    'style' => 'text',
                    'rel' => $this->getAttribute('rel'),
                    'target' => $this->getAttribute('target'),
                ]).'>'
                : '<span '.$this->htmlAttributes(['style' => 'text']).'>'
        ).'
              {{ $slot }}
            '.($hasLink ? '</a>' : '</span>').'
        </td>
        ' : '';

        $row = $iconPosition === 'left'
            ? $iconTd.' '.$contentTd // render left
            : $contentTd.' '.$iconTd; // render right

        return '
      <tr '.$this->htmlAttributes(['class' => $this->getAttribute('css-class')]).'>
        '.$row.'
      </tr>
        ';
    }
}
