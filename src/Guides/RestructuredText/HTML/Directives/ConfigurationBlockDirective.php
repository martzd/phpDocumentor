<?php

declare(strict_types=1);

/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link https://phpdoc.org
 * @author Ryan Weaver <ryan@symfonycasts.com> on the original DocBuilder.
 * @author Mike van Riel <me@mikevanriel.com> for adapting this to phpDocumentor.
 */

namespace phpDocumentor\Guides\RestructuredText\HTML\Directives;

use phpDocumentor\Guides\RestructuredText\Directives\SubDirective;
use phpDocumentor\Guides\RestructuredText\Nodes\CodeNode;
use phpDocumentor\Guides\RestructuredText\Nodes\DocumentNode;
use phpDocumentor\Guides\RestructuredText\Nodes\Node;
use phpDocumentor\Guides\RestructuredText\Parser;
use Webmozart\Assert\Assert;
use function strtoupper;

class ConfigurationBlockDirective extends SubDirective
{
    public function getName() : string
    {
        return 'configuration-block';
    }

    public function processSub(Parser $parser, ?Node $document, string $variable, string $data, array $options) : ?Node
    {
        Assert::isInstanceOf($document, DocumentNode::class);

        $blocks = [];
        foreach ($document->getNodes() as $node) {
            if (!$node instanceof CodeNode) {
                continue;
            }

            $language = $node->getLanguage() ?? 'Unknown';

            $blocks[] = [
                'language' => $this->formatLanguageTab($language),
                'code' => $node->render(),
            ];
        }

        $wrapperDiv = $parser->renderTemplate(
            'directives/configuration-block.html.twig',
            [
                'blocks' => $blocks,
            ]
        );

        return $parser->getNodeFactory()->createWrapperNode(null, $wrapperDiv, '</div>');
    }

    /**
     * A hack to print exactly what we want in the tab of a configuration block.
     */
    private function formatLanguageTab(string $language) : string
    {
        switch ($language) {
            case 'php-annotations':
                return 'Annotations';
            case 'xml':
            case 'yaml':
            case 'php':
                return strtoupper($language);
            default:
                return $language;
        }
    }
}
