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

$config = array();

$config['$root$']['router']['page']['seopack'] = 'PluginSeopack_ActionSeopack';

$config['url']['skip_scheme'] = true;

$config['title']['max_length'] = 60;
$config['description']['max_length'] = 160;
$config['keywords']['max_length'] = 160;

$config['widgets'][] = array(
    'name' => 'toolbar_seopack.tpl',
    'wgroup' => 'toolbar',
    'priority' => '90',
    'plugin'=>'seopack',
);

$cfgLangLoadToJs = Config::Get('lang.load_to_js');

$cfgLangLoadToJs[] = 'plugin.seopack.recomended_title_length';
$cfgLangLoadToJs[] = 'plugin.seopack.recomended_description_length';
$cfgLangLoadToJs[] = 'plugin.seopack.recomended_keywords_length';

Config::Set('lang.load_to_js', $cfgLangLoadToJs);

return $config;

// EOF
