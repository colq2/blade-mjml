<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use Illuminate\Contracts\View\View;

class MjHeadAttributes extends MjmlHeadComponent
{
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
    ) {
        parent::__construct($bladeMjmlContext);
    }

    public function getComponentName(): string
    {
        return 'mj-attributes';
    }

    public function allowedAttributes(): array
    {
        return [];
    }

    public function renderMjml(array $data): View|string
    {
        // parse the inner HTML of the mj-attributes tag
        $content = (string) $data['slot'];

        // parse the content to dom and extract attributes
        // only the children nodes, ignore more nested tags
        $dom = new \DOMDocument;
        // Suppress warnings from invalid HTML
        @$dom->loadHTML('<div>'.$content.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new \DOMXPath($dom);
        $nodes = $xpath->query('//div/*'); // Get all child elements of the div
        $attributes = [];

        /** @var \DOMElement $node */
        foreach ($nodes as $node) {
            if ($node->nodeName === 'mj-class') {
                // Handle mj-class tag separately
                $mjClass = $node->getAttribute('name');

                if ($mjClass) {

                    // add attributes to the global context
                    foreach ($node->attributes as $attr) {
                        if ($attr->name === 'name') {
                            // Add the class to the global context
                            continue;
                        }

                        $attributes[$attr->name] = $attr->value;

                        $this->bladeMjmlContext->addDefaultClasses(
                            $mjClass,
                            [
                                $attr->name => $attr->value,
                            ]
                        );
                    }
                }

                continue;
            }

            // Extract attributes from each node
            foreach ($node->attributes as $attr) {
                $attributes[$attr->name] = $attr->value;

                $this->bladeMjmlContext->addDefaultAttributes(
                    $node->nodeName,
                    [
                        $attr->name => $attr->value,
                    ]
                );
            }
        }

        return '';
    }
}
