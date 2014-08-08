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

$config['table']['seopack'] = '___db.table.prefix___seopack';

Config::Set('router.page.seopack', 'PluginSeopack_ActionSeopack');

$config['widgets'][] = array(
    'name' => 'toolbar_seopack.tpl',
    'wgroup' => 'toolbar',
    'priority' => '90',
	'params'=>array('plugin'=>'seopack'),
);

return $config;
?>
