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

class PluginSeopack_HookSeopack extends Hook {

    /**
     * Register hooks
     *
     * @return void
     */
    public function RegisterHook() {
        $this->AddHook('template_admin_menu_content', 'hook_admin_menu');
        if (Router::GetAction() != 'admin') {
            $this->AddHook('template_layout_body_end', 'hook_body_end');
            $this->AddHook('module_viewer_display_before', 'hook_meta');
        }
    }

    /**
     * Meta hook
     *
     * @return void
     */
    public function hook_meta() {

        $sAction = Router::GetAction();

        $sUrl = E::ModuleSeopack()->ClearUrl(R::Url('path'));
        $oSeopack = E::ModuleSeopack()->GetSeopackByUrl($sUrl);

        E::ModuleViewer()->Assign('sCurrentUrl', $sUrl);

        if ($oSeopack) {
            E::ModuleViewer()->Assign('oSeopack', $oSeopack);
        }

        $sMetaDescriptionTemplate = Plugin::GetTemplateDir(__CLASS__) . 'tpls/meta/description/' . $sAction . '.tpl';
        if (E::ModuleViewer()->TemplateExists($sMetaDescriptionTemplate)) {
            $sMetaDescription = E::ModuleViewer()->Fetch($sMetaDescriptionTemplate);
            if ($oSeopack && $oSeopack->getDescription()) {
                E::ModuleViewer()->Assign('sHtmlDescription', htmlspecialchars($oSeopack->getDescription()));
            } else {
                E::ModuleViewer()->Assign('sHtmlDescription', htmlspecialchars($sMetaDescription));
            }
        }

        $sMetaKeywordsTemplate = Plugin::GetTemplateDir(__CLASS__) . 'tpls/meta/keywords/' . $sAction . '.tpl';
        if (E::ModuleViewer()->TemplateExists($sMetaKeywordsTemplate)) {
            $sMetaKeywords = E::ModuleViewer()->Fetch($sMetaKeywordsTemplate);
            if ($oSeopack && $oSeopack->getKeywords()) {
                E::ModuleViewer()->Assign('sHtmlKeywords', htmlspecialchars($oSeopack->getKeywords()));
            } else {
                E::ModuleViewer()->Assign('sHtmlKeywords', htmlspecialchars($sMetaKeywords));
            }
        }
        if ($oSeopack && $oSeopack->getTitle()) {
            E::ModuleViewer()->Assign('sHtmlTitle', htmlspecialchars($oSeopack->getTitle()));
        }
    }

    /**
     * Footer hook
     *
     * @return string
     */
    public function hook_body_end() {

        return E::ModuleViewer()->Fetch(Plugin::GetTemplateDir(__CLASS__) . 'tpls/modals/modal.seopack_edit.tpl');
    }

    /**
     * Admin menu hook
     *
     * @return string
     */
    public function hook_admin_menu() {

        return E::ModuleViewer()->Fetch(Plugin::GetTemplateDir(__CLASS__) . 'tpls/admin_menu.tpl');
    }

}

// EOF