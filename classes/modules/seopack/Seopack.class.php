<?php
/* ---------------------------------------------------------------------------
 * @Project: Alto CMS
 * @Plugin Name: SEOpack
 * @Description: Optimization site for search engines
 * @Author: Klaus
 * @Author URI: http://stfalcon.com
 * @License: GNU GPL v2 & MIT
 *----------------------------------------------------------------------------
 * Based on
 *   Plugin SEO for LiveStreet CMS
 *   Author: Web studio stfalcon.com
 *   Site: http://stfalcon.com
 *----------------------------------------------------------------------------
 */

class PluginSeopack_ModuleSeopack extends ModuleORM {

    public function Init() {

        parent::Init();
    }

    public function ClearUrl($sUrl) {

        $sUrl = trim(filter_var($sUrl, FILTER_SANITIZE_URL), '/');

        if (C::Get('plugin.seopack.url.skip_scheme')) {
            if (preg_match('/^https?:(.*)$/i', $sUrl, $aMatches)) {
                $sUrl = $aMatches[1];
            }
        }
        return $sUrl;
    }
}

// EOF