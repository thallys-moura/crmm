<?php

namespace Webkul\Email\Helpers;

use Stichoza\GoogleTranslate\GoogleTranslate;

class MailTranslation
{
    protected $translator;

    /**
     * Construtor para inicializar o GoogleTranslate.
     *
     * @param string $targetLanguage O idioma de destino para a tradução (padrão: 'es').
     */
    public function __construct(string $targetLanguage = 'es')
    {
        $this->translator = new GoogleTranslate();
        $this->translator->setTarget($targetLanguage);
    }

    /**
     * Traduz dinamicamente o conteúdo de HTML preservando tags.
     *
     * @param string $htmlContent O conteúdo HTML a ser traduzido.
     * @return string O conteúdo HTML traduzido.
     */
    public function translateHtmlContent(string $htmlContent): string
    {
        // Carrega o conteúdo HTML em um DOMDocument
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true); // Suprime erros de HTML inválido
        $dom->loadHTML($htmlContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        // Traduz os nós de texto
        $this->translateTextNodes($dom);

        // Retorna o HTML traduzido
        return $dom->saveHTML();
    }

    /**
     * Traduz recursivamente os nós de texto em um DOMNode.
     *
     * @param \DOMNode $node O nó DOM a ser traduzido.
     */
    protected function translateTextNodes($node)
    {
        foreach ($node->childNodes as $child) {
            // Verifica se o nó é um nó de texto comum e que não é nulo ou de um tipo especial como namespace
            if ($child->nodeType === XML_TEXT_NODE && !empty(trim($child->nodeValue))) {
                // Traduz apenas o texto, preservando espaços em branco
                $child->nodeValue = $this->translator->translate($child->nodeValue);
            } elseif ($child->hasChildNodes()) {
                // Chama recursivamente para elementos filhos
                $this->translateTextNodes($child);
            }
        }
    }
}
