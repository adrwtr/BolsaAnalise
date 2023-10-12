<?php
namespace Akuma\BolsaAnalise\Service\Http;

interface IHttpClient
{
    public function readBodyFromUrl(string $ds_url): string;
}