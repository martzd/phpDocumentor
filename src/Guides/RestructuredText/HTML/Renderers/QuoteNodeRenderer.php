<?php

declare(strict_types=1);

namespace phpDocumentor\Guides\RestructuredText\HTML\Renderers;

use phpDocumentor\Guides\RestructuredText\Nodes\QuoteNode;
use phpDocumentor\Guides\RestructuredText\Renderers\NodeRenderer;
use phpDocumentor\Guides\RestructuredText\TemplateRenderer;

class QuoteNodeRenderer implements NodeRenderer
{
    /** @var QuoteNode */
    private $quoteNode;

    /** @var TemplateRenderer */
    private $templateRenderer;

    public function __construct(QuoteNode $quoteNode, TemplateRenderer $templateRenderer)
    {
        $this->quoteNode        = $quoteNode;
        $this->templateRenderer = $templateRenderer;
    }

    public function render() : string
    {
        return $this->templateRenderer->render('quote.html.twig', [
            'quoteNode' => $this->quoteNode,
        ]);
    }
}
