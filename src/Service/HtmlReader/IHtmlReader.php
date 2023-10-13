<?php
namespace Akuma\BolsaAnalise\Service\HtmlReader;

interface IHtmlReader
{
    public function getElementsByTagName(
        string $ds_tag_name,
        string $ds_html_body
    ): mixed;
}