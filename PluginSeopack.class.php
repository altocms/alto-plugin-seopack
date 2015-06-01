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

class PluginSeopack extends Plugin {

    public $aDelegates
        = array(
            'template' => array(
                'toolbar_seopack.tpl' => '_toolbar_seopack.tpl'
            ),
        );

    protected $aInherits
        = array(
            'action' => array(
                'ActionAdmin',
            ),
            'module' => array(
                'ModuleSeopack',
            ),
        );

    /**
     * Plugin Activation
     *
     * @return boolean
     */
    public function Activate() {

        if (!$this->isTableExists('prefix_seopack')) {
            $this->ExportSQL(dirname(__FILE__) . '/install/db/dump.sql');
        }
        return true;
    }

    /**
     * Plugin Initialization
     *
     * @return void
     */
    public function Init() {

        E::ModuleViewer()->AppendScript(Plugin::GetTemplateDir(__CLASS__) . 'assets/js/seopack.js');
        E::ModuleViewer()->AppendStyle(Plugin::GetTemplateDir(__CLASS__) . 'assets/css/seopack.css');
    }

}

// EOF