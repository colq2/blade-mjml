<?php

use colq2\BladeMjml\Tests\TestCase;
use Illuminate\Testing\TestView;
use Symfony\Component\Process\Exception\ProcessFailedException;

uses(TestCase::class, \Illuminate\Foundation\Testing\Concerns\InteractsWithViews::class)->in(__DIR__);

function blade(string $template, array $data = []): TestView
{
    return test()->blade($template, $data);
}

expect()->extend('toEqualHtml', function (string $expectedHtml) {
    $actual = normalizeHtmlToDom($this->value);
    $expected = normalizeHtmlToDom($expectedHtml);

    $parsedActual = $actual->saveHTML();
    $parsedExpected = $expected->saveHTML();

    $domAreEqual = areDomsEqual($actual, $expected);

    if (! $domAreEqual) {
        throw new \PHPUnit\Framework\ExpectationFailedException(
            "HTML documents do not match.\n\n".
            "Actual:\n".$parsedActual."\n\n".
            "Expected:\n".$parsedExpected
        );
    }

    \Illuminate\Testing\Assert::assertTrue($domAreEqual);

    return $this;
});

expect()->extend('toEqualMjmlHtml', function (string $mjmlTemplate, array $options = []) {
    $mjmlHtml = convertMjml($mjmlTemplate, $options);

    return $this->toEqualHtml($mjmlHtml);
});

/**
 * Convert HTML string to normalized DOM for comparison
 */
function normalizeHtmlToDom(string $html): DOMDocument
{
    $doc = new DOMDocument('1.0', 'UTF-8');
    libxml_use_internal_errors(true);

    // Load the HTML
    $doc->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();

    // Normalize whitespace in text nodes
    normalizeWhitespace($doc);

    return $doc;
}

/**
 * Normalize whitespace in all text nodes
 */
function normalizeWhitespace(DOMNode $node): void
{
    if ($node->nodeType === XML_TEXT_NODE) {
        // Collapse multiple whitespaces into single space
        $node->nodeValue = preg_replace('/\s+/', ' ', $node->nodeValue);

        // If it's only whitespace, check if we should keep it
        if (trim($node->nodeValue) === '') {
            // Remove whitespace-only text nodes between block elements
            $parent = $node->parentNode;
            if ($parent && ! isInlineElement($parent)) {
                $node->nodeValue = '';
            }
        }
    }

    // Recursively process child nodes
    foreach ($node->childNodes as $child) {
        normalizeWhitespace($child);
    }
}

/**
 * Check if an element is inline (where whitespace matters)
 */
function isInlineElement(DOMNode $node): bool
{
    if ($node->nodeType !== XML_ELEMENT_NODE) {
        return false;
    }

    $inlineElements = ['span', 'a', 'em', 'strong', 'b', 'i', 'u', 'code', 'small'];

    return in_array(strtolower($node->nodeName), $inlineElements);
}

/**
 * Compare two DOM documents for equality
 */
function areDomsEqual(DOMDocument $doc1, DOMDocument $doc2): bool
{
    return areNodesEqual($doc1, $doc2);
}

/**
 * Recursively compare two DOM nodes
 */
function areNodesEqual(DOMNode $node1, DOMNode $node2): bool
{
    // Compare node types
    if ($node1->nodeType !== $node2->nodeType) {
        return false;
    }

    // Compare node names
    if ($node1->nodeName !== $node2->nodeName) {
        return false;
    }

    // Compare text content
    if ($node1->nodeType === XML_TEXT_NODE) {
        $text1 = trim($node1->nodeValue);
        $text2 = trim($node2->nodeValue);

        // Empty text nodes are considered equal
        if ($text1 === '' && $text2 === '') {
            return true;
        }

        return $text1 === $text2;
    }

    // Compare attributes
    if ($node1->nodeType === XML_ELEMENT_NODE) {
        if (! areAttributesEqual($node1, $node2)) {
            return false;
        }
    }

    // Compare children
    $children1 = getSignificantChildren($node1);
    $children2 = getSignificantChildren($node2);

    if (count($children1) !== count($children2)) {
        dump('Node children count mismatch: '.count($children1).' vs '.count($children2).' for node '.$node1->nodeName);

        return false;
    }

    for ($i = 0; $i < count($children1); $i++) {
        if (! areNodesEqual($children1[$i], $children2[$i])) {
            dump('Node mismatch at index '.$i.' for node '.$node1->nodeName);

            return false;
        }
    }

    return true;
}

/**
 * Get non-empty child nodes
 */
function getSignificantChildren(DOMNode $node): array
{
    $children = [];

    foreach ($node->childNodes as $child) {
        // Skip empty text nodes
        if ($child->nodeType === XML_TEXT_NODE && trim($child->nodeValue) === '') {
            continue;
        }

        // Skip comment nodes
        if ($child->nodeType === XML_COMMENT_NODE) {
            continue;
        }

        $children[] = $child;
    }

    return $children;
}

/**
 * Compare attributes of two elements
 */
function areAttributesEqual(DOMNode $elem1, DOMNode $elem2): bool
{
    if (! $elem1->hasAttributes() && ! $elem2->hasAttributes()) {
        return true;
    }

    if ($elem1->hasAttributes() !== $elem2->hasAttributes()) {
        return false;
    }

    $attrs1 = [];
    $attrs2 = [];

    foreach ($elem1->attributes as $attr) {
        $attrs1[$attr->nodeName] = $attr->nodeValue;
    }

    foreach ($elem2->attributes as $attr) {
        $attrs2[$attr->nodeName] = $attr->nodeValue;
    }

    // Sort for consistent comparison
    ksort($attrs1);
    ksort($attrs2);

    return $attrs1 === $attrs2;
}

function convertMjml(string $mjmlTemplate, array $options = []): string
{
    // Default options similar to spatie/mjml-php
    $defaultOptions = [
        'keepComments' => true,
        'ignoreIncludes' => false,
        'beautify' => false,
        'minify' => false,
        'validationLevel' => 'soft',
        'filePath' => '.',
    ];

    $mergedOptions = array_merge($defaultOptions, $options);

    // Prepare arguments like spatie/mjml-php
    $arguments = [
        $mjmlTemplate,
        $mergedOptions,
    ];

    // Create command with base64-encoded arguments
    $command = [
        'node',
        './bin/mjml.mjs', // You'd need to create this wrapper script
        base64_encode(json_encode($arguments)),
    ];

    // Create the process
    $workingDirectory = __DIR__.'/../';

    $process = new Symfony\Component\Process\Process($command, $workingDirectory);
    $process->setTimeout(30);

    // Run the process
    $process->run();

    // Check if successful
    if (! $process->isSuccessful()) {
        throw new ProcessFailedException($process);
    }

    // Parse output - get last line and decode from base64
    $output = $process->getOutput();
    $lines = explode("\n", trim($output));
    $lastLine = end($lines);

    $result = json_decode(base64_decode($lastLine), true);

    return $result['html'];
}
