<?php

use Feadbox\Seo\Services\SeoService;

if (!function_exists('seo')) {
    /**
     * Seo helper.
     */
    function seo(): SeoService
    {
        return app(SeoService::class);
    }
}
