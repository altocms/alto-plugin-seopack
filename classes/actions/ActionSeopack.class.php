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


class PluginSeopack_ActionSeopack extends ActionPlugin {

    public function Init() {

        E::ModuleViewer()->SetResponseAjax('json');

        if (!E::IsAdmin()) {
            Router::Location('error/404/');
        }

        $this->oUserCurrent = E::User();
    }

    /**
     * Регистрация евентов
     */
    protected function RegisterEvent() {

        $this->AddEvent('ajax-set', 'EventAjaxSet');
    }

    protected function EventAjaxSet() {

        if (!F::isPost('url')) {
            return false;
        }

        if (!$this->CheckSeopackFields()) {
            return false;
        }
        $sUrl = E::ModuleSeopack()->ClearUrl(F::GetRequest('url'));

        if (!$oSeopack = E::ModuleSeopack()->GetSeopackByUrl($sUrl)) {
            $oSeopack = Engine::GetEntity('PluginSeopack_ModuleSeopack_EntitySeopack');
            $oSeopack->setUrl($sUrl);
        }

        if (F::GetRequest('title_auto') && F::GetRequest('description_auto') && F::GetRequest('keywords_auto')) {
            $oSeopack->Delete();
            E::ModuleMessage()->AddNotice(E::ModuleLang()->Get('plugin.seopack.seopack_edit_submit_save_ok'));
            return;
        }

        $oSeopack->setTitle(F::GetRequest('title_auto') ? null : strip_tags(F::GetRequest('title')));
        $oSeopack->setDescription(F::GetRequest('description_auto') ? null : strip_tags(F::GetRequest('description')));
        $oSeopack->setKeywords(F::GetRequest('keywords_auto') ? null : strip_tags(F::GetRequest('keywords')));

        if ($oSeopack->Save()) {
            if ($oSeopack->getTitle()) {
                E::ModuleViewer()->AssignAjax('title', $oSeopack->getTitle());
            }
            E::ModuleMessage()->AddNotice(E::ModuleLang()->Get('plugin.seopack.seopack_edit_submit_save_ok'));
        }

        return;
    }

    /**
     * @return bool
     */
    protected function CheckSeopackFields() {

        E::ModuleSecurity()->ValidateSendForm();

        $bOk = true;

        if (F::isPost('title') && !F::CheckVal(F::GetRequest('title', null, 'post'), 'text', 0, 1000)) {
            E::ModuleMessage()->AddError(E::ModuleLang()->Get('plugin.seopack.title_error'), E::ModuleLang()->Get('error'));
            $bOk = false;
        }
        if (F::isPost('description') && !F::CheckVal(F::GetRequest('description', null, 'post'), 'text', 0, 1000)) {
            E::ModuleMessage()->AddError(E::ModuleLang()->Get('plugin.seopack.description_error'), E::ModuleLang()->Get('error'));
            $bOk = false;
        }
        if (F::isPost('keywords') && !F::CheckVal(F::GetRequest('keywords', null, 'post'), 'text', 0, 1000)) {
            E::ModuleMessage()->AddError(E::ModuleLang()->Get('plugin.seopack.keywords_error'), E::ModuleLang()->Get('error'));
            $bOk = false;
        }
        if (!F::CheckVal(F::GetRequest('url', null, 'post'), 'text', 0, 255)) {
            E::ModuleMessage()->AddError(E::ModuleLang()->Get('plugin.seopack.url_error'), E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        return $bOk;
    }
}

// EOF