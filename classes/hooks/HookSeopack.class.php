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

        $oSeopack = $this->PluginSeopack_Seopack_GetSeopackByUrl(trim($_SERVER['REQUEST_URI'], '/'));

        $this->Viewer_Assign('oCurrentUrl', trim($_SERVER['REQUEST_URI'], '/'));

        if ($oSeopack) {
            $this->Viewer_Assign('oSeopack', $oSeopack);
        }

        $sMetaDescriptionTemplate = Plugin::GetTemplateDir(__CLASS__) . 'tpls/meta/description/' . $sAction . '.tpl';
        if ($this->Viewer_TemplateExists($sMetaDescriptionTemplate)) {
            $sMetaDescription = $this->Viewer_Fetch($sMetaDescriptionTemplate);
            if ($oSeopack && $oSeopack->getDescription()) {
                $this->Viewer_Assign('sHtmlDescription', htmlspecialchars($oSeopack->getDescription()));
            } else {
                $this->Viewer_Assign('sHtmlDescription', htmlspecialchars($sMetaDescription));
            }
        }

        $sMetaKeywordsTemplate = Plugin::GetTemplateDir(__CLASS__) . 'tpls/meta/keywords/' . $sAction . '.tpl';
        if ($this->Viewer_TemplateExists($sMetaKeywordsTemplate)) {
            $sMetaKeywords = $this->Viewer_Fetch($sMetaKeywordsTemplate);
            if ($oSeopack && $oSeopack->getKeywords()) {
                $this->Viewer_Assign('sHtmlKeywords', htmlspecialchars($oSeopack->getKeywords()));
            } else {
                $this->Viewer_Assign('sHtmlKeywords', htmlspecialchars($sMetaKeywords));
            }
        }
        if ($oSeopack && $oSeopack->getTitle()) {
            $this->Viewer_Assign('sHtmlTitle', htmlspecialchars($oSeopack->getTitle()));
        }
    }

    /**
     * Footer hook
     *
     * @return void
     */
    public function hook_body_end() {
        return $this->Viewer_Fetch(Plugin::GetTemplateDir(__CLASS__) . 'tpls/modals/modal.seopack_edit.tpl');
    }

    /**
     * Admin menu hook
     *
     * @return void
     */
    public function hook_admin_menu() {
        return $this->Viewer_Fetch(Plugin::GetTemplateDir(__CLASS__) . 'tpls/admin_menu.tpl');
    }

}

// EOF