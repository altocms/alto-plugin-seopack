<?php

/* ---------------------------------------------------------------------------
 * @Plugin Name: SEO
 * @Plugin URI:
 * @Description: Optimization site for search engines
 * @Author: web-studio stfalcon.com
 * @Author URI: http://stfalcon.com
 * @LiveStreet Version: 0.4.2
 * @License: GNU GPL v3, http://www.gnu.org/licenses/agpl.txt
 * ----------------------------------------------------------------------------
 */

/**
 * Deny direct access to this file
 */
if (!class_exists('Plugin')) {
    die('Hacking attemp!');
}

class PluginSeopack extends Plugin {
	
	protected $aInherits = array(
        'action' => array(
            'ActionAdmin'
        ),
    );
	
	public $aDelegates = array(
        'template' => array(
            'toolbar_seopack.tpl' => '_toolbar_seopack.tpl'
        ),
    );
    /**
     * Plugin Activation
     *
     * @return boolean
     */
    public function Activate() {
		if (!$this->isTableExists('prefix_seopack')) {
			$this->ExportSQL(dirname(__FILE__) . '/dump.sql');
		}
		return true; 
    }

    /**
     * Plugin Initialization
     *
     * @return void
     */
    public function Init() {
		$this->Viewer_AppendScript(Plugin::GetTemplateWebPath(__CLASS__).'js/seopack.js');
        $this->Viewer_AppendStyle(Plugin::GetTemplateWebPath(__CLASS__).'css/seopack.css');
    }

}