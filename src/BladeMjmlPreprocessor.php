<?php

namespace colq2\BladeMjml;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;

class BladeMjmlPreprocessor
{
    /**
     * Mapping of column-like elements to their container elements
     */
    protected array $columnContainerMap = [
        'mj-column' => ['mj-section', 'mj-group', 'mj-hero'],
        'mj-navbar-link' => ['mj-navbar'],
        'mj-carousel-image' => ['mj-carousel'],
        'mj-accordion-element' => ['mj-accordion'],
        'mj-social-element' => ['mj-social'],
    ];

    protected array $mjmlTags = [
        'mjml',
        'mj-head',
        'mj-title',
        'mj-attributes',
        'mj-style',
        'mj-font',
        'mj-breakpoint',
        'mj-raw',
        'mj-include',
        'mj-body',
        'mj-section',
        'mj-group',
        'mj-column',
        'mj-text',
        'mj-image',
        'mj-divider',
        'mj-button',
        'mj-hero',
        'mj-spacer',
        'mj-wrapper',
        'mj-image',
        'mj-social',
        'mj-social-element',
        'mj-table',
    ];

    /**
     * Whether to process x- prefixed tags
     */
    protected bool $processPrefixedTags = false;

    /**
     * The attribute name to add for sibling count
     */
    protected string $siblingCountAttribute = 'non-raw-siblings';

    /**
     * Create a new preprocessor instance
     */
    public function __construct(array $config = [])
    {
        if (isset($config['column_container_map'])) {
            $this->columnContainerMap = $config['column_container_map'];
        }

        if (isset($config['process_prefixed_tags'])) {
            $this->processPrefixedTags = $config['process_prefixed_tags'];
        }

        if (isset($config['sibling_count_attribute'])) {
            $this->siblingCountAttribute = $config['sibling_count_attribute'];
        }
    }

    /**
     * Process the MJML string and add sibling counts
     */
    public function process(string $mjml): string
    {
        $dom = $this->createDomDocument($mjml);

        foreach ($this->columnContainerMap as $columnTag => $containerTags) {
            $this->processColumnType($dom, $columnTag, $containerTags);
        }

        return $this->extractHtmlFromDom($dom);
    }

    /**
     * Process a specific type of column element
     */
    protected function processColumnType(DOMDocument $dom, string $columnTag, array $containerTags): void
    {
        // Process both regular and x- prefixed tags if enabled
        $columnTags = [$columnTag];
        if ($this->processPrefixedTags) {
            $columnTags[] = 'x-'.$columnTag;
        }

        foreach ($columnTags as $currentColumnTag) {
            foreach ($containerTags as $containerTag) {
                $currentContainerTag = $containerTag;
                if ($this->processPrefixedTags && strpos($currentColumnTag, 'x-') === 0) {
                    $currentContainerTag = 'x-'.$containerTag;
                }

                $this->addSiblingCountsToColumns($dom, $currentColumnTag, $currentContainerTag);
            }
        }
    }

    /**
     * Add sibling count to columns within a specific container type
     */
    protected function addSiblingCountsToColumns(DOMDocument $dom, string $columnTag, string $containerTag): void
    {
        $xpath = new DOMXPath($dom);
        $containers = $xpath->query("//{$containerTag}");

        foreach ($containers as $container) {
            $directColumns = $this->getDirectChildrenByTagName($container, $columnTag);
            $siblingCount = count($directColumns);

            foreach ($directColumns as $column) {
                if ($column instanceof DOMElement) {
                    $column->setAttribute($this->siblingCountAttribute, (string) $siblingCount);
                }
            }
        }
    }

    /**
     * Get direct children of a node by tag name (not nested)
     */
    protected function getDirectChildrenByTagName(DOMNode $parent, string $tagName): array
    {
        $children = [];

        foreach ($parent->childNodes as $child) {
            if ($child->nodeType === XML_ELEMENT_NODE && $child->nodeName === $tagName) {
                $children[] = $child;
            }
        }

        return $children;
    }

    /**
     * Create a DOM document from HTML string
     */
    protected function createDomDocument(string $html): DOMDocument
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);

        // Wrap in a root element to handle fragments
        $wrappedHtml = '<?xml encoding="UTF-8"><mjml-root>'.$html.'</mjml-root>';
        $dom->loadHTML($wrappedHtml, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        return $dom;
    }

    /**
     * Extract HTML from DOM document without the wrapper
     */
    protected function extractHtmlFromDom(DOMDocument $dom): string
    {
        $result = '';
        $root = $dom->documentElement;

        if ($root && $root->nodeName === 'mjml-root') {
            foreach ($root->childNodes as $child) {
                $result .= $dom->saveHTML($child);
            }
        } else {
            $result = $dom->saveHTML();
        }

        return $result;
    }

    /**
     * Convert MJML tags to Blade component tags (x- prefix)
     */
    public function convertToBladeComponents(string $mjml): string
    {
        // Replace <mj-attributes> tags with <x-mj-attributes> but keep inner content unchanged
        $pattern = '/(<mj-attributes\b[^>]*>)(.*?)(<\/mj-attributes>)/is';
        $mjml = preg_replace_callback($pattern, function ($matches) {
            // Replace only the tag names, not the content
            $openTag = preg_replace('/<mj-attributes\b/', '<x-mj-attributes', $matches[1]);
            $closeTag = str_replace('</mj-attributes>', '</x-mj-attributes>', $matches[3]);

            return $openTag.$matches[2].$closeTag;
        }, $mjml);

        // Now replace all other MJML tags outside of <mj-attributes> blocks
        $pattern = '/(<x-mj-attributes\b[^>]*>.*?<\/x-mj-attributes>)/is';
        $parts = preg_split($pattern, $mjml, -1, PREG_SPLIT_DELIM_CAPTURE);

        foreach ($parts as $i => $part) {
            // Only convert parts that are NOT <x-mj-attributes> blocks
            if (! preg_match($pattern, $part)) {
                foreach ($this->mjmlTags as $tag) {
                    if ($tag === 'mj-attributes') {
                        continue; // Already handled
                    }
                    $part = str_replace("<{$tag}", "<x-{$tag}", $part);
                    $part = str_replace("</{$tag}", "</x-{$tag}", $part);
                }
                $parts[$i] = $part;
            }
        }

        return implode('', $parts);
    }

    /**
     * Process MJML with both tag conversion and sibling count
     */
    public function preprocess(string $mjml): string
    {
        // First convert to x- components
        $mjml = $this->convertToBladeComponents($mjml);

        // Enable processing of x- prefixed tags
        $this->processPrefixedTags = true;

        // Then add sibling counts
        return $this->process($mjml);
    }

    /**
     * Set custom column-container mapping
     */
    public function setColumnContainerMap(array $map): self
    {
        $this->columnContainerMap = $map;

        return $this;
    }

    /**
     * Add a new column-container mapping
     */
    public function addColumnContainerMapping(string $columnTag, array $containerTags): self
    {
        $this->columnContainerMap[$columnTag] = $containerTags;

        return $this;
    }

    /**
     * Set the attribute name for sibling count
     */
    public function setSiblingCountAttribute(string $attribute): self
    {
        $this->siblingCountAttribute = $attribute;

        return $this;
    }

    /**
     * Enable or disable processing of x- prefixed tags
     */
    public function setProcessPrefixedTags(bool $process): self
    {
        $this->processPrefixedTags = $process;

        return $this;
    }
}
