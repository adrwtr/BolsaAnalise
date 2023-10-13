<?php
namespace Akuma\BolsaAnalise\Service\HtmlReader;

use Akuma\BolsaAnalise\Service\HtmlReader\IHtmlReader;

class DomReader implements IHtmlReader
{
    public function getElementsByTagName(
        string $ds_tag_name,
        string $ds_html_body
    ) : mixed  {
        // Suppress libxml errors
        libxml_use_internal_errors(true);

        $objDOMDocument = new \DOMDocument();

        $objDOMDocument->loadHtml(
            $ds_html_body,
            LIBXML_NOWARNING | LIBXML_NOERROR
        );

        $objElement = $objDOMDocument->getElementsByTagName(
            $ds_tag_name
        );

        return $objElement;
    }
}