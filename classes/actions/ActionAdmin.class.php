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

class PluginSeopack_ActionAdmin extends PluginSeopack_Inherits_ActionAdmin {

    /**
     * Регистрация евентов
     */
    protected function RegisterEvent() {
        parent::RegisterEvent();
        $this->AddEvent('seopack', 'EventSeopack');
        $this->AddEvent('seopackadd', 'EventSeopackEdit');
        $this->AddEvent('seopackedit', 'EventSeopackEdit');
        $this->AddEvent('seopackdelete', 'EventSeopackDelete');
    }

    protected function EventSeopack() {

        $this->sMainMenuItem = 'content';

        $this->_setTitle(E::ModuleLang()->Get('plugin.seopack.seopack_title'));

        $nPage = $this->_getPageNum();

        $aSeopack = E::ModuleSeopack()->GetSeopackItemsByFilter(
            array(
                '#page' => 1,
                '#limit' => array(($nPage - 1) * Config::Get('admin.items_per_page'),
                                  Config::Get('admin.items_per_page'))
            )
        );

        $aPaging = E::ModuleViewer()->MakePaging(
            $aSeopack['count'], $nPage, Config::Get('admin.items_per_page'), 4,
            Router::GetPath('admin') . 'seopack/'
        );

        E::ModuleViewer()->Assign('aSeopack', $aSeopack['collection']);
        E::ModuleViewer()->Assign('aPaging', $aPaging);

        $this->SetTemplateAction('seopack_list');
    }

    protected function EventSeopackEdit() {

        $this->sMainMenuItem = 'content';

        $this->_setTitle(E::ModuleLang()->Get('plugin.seopack.seopack_title'));

        if (F::isPost('submit_seopack_save')) {
            $this->SubmitSaveSeopack();
        }

        E::ModuleViewer()->Assign('sMode', str_replace('seopack', '', Router::GetActionEvent()));

        if (Router::GetActionEvent() == 'seopackedit') {
            if ($oSeopack = E::ModuleSeopack()->GetSeopackBySeopackId($this->GetParam(0))) {

                if (!F::isPost('submit_seopack_save')) {
                    $_REQUEST['url'] = $oSeopack->getUrl();
                    $_REQUEST['title'] = $oSeopack->getTitle();
                    $_REQUEST['description'] = $oSeopack->getDescription();
                    $_REQUEST['keywords'] = $oSeopack->getKeywords();
                    $_REQUEST['seopack_id'] = $oSeopack->getSeopackId();
                }

            } else {
                E::ModuleMessage()->AddError(
                    E::ModuleLang()->Get('plugin.seopack.seopack_edit_notfound'), E::ModuleLang()->Get('error')
                );
                $this->SetParam(0, null);
            }
        }

        $this->SetTemplateAction('seopack_edit');
    }

    protected function SubmitSaveSeopack() {

        $this->sMainMenuItem = 'content';

        if (!$this->CheckSeopackFields()) {
            return false;
        }

        $sUrl = E::ModuleSeopack()->ClearUrl(F::GetRequest('url'));
        if (!F::GetRequest('seopack_id')) {
            if (!$oSeopack = E::ModuleSeopack()->GetSeopackByUrl($this->GetUri($sUrl))) {
                $oSeopack = Engine::GetEntity('PluginSeopack_ModuleSeopack_EntitySeopack');
                $oSeopack->setUrl($this->GetUri($sUrl));
            }
        } elseif (!$oSeopack = E::ModuleSeopack()->GetSeopackBySeopackId(F::GetRequest('seopack_id'))) {
            $oSeopack = Engine::GetEntity('PluginSeopack_ModuleSeopack_EntitySeopack');
            $oSeopack->setUrl($this->GetUri($sUrl));
        }

        $oSeopack->setTitle(F::GetRequest('title_auto') ? null : strip_tags(F::GetRequest('title')));
        $oSeopack->setDescription(F::GetRequest('description_auto') ? null : strip_tags(F::GetRequest('description')));
        $oSeopack->setKeywords(F::GetRequest('keywords_auto') ? null : strip_tags(F::GetRequest('keywords')));

        if ($oSeopack->Save()) {
            E::ModuleMessage()->AddNotice(E::ModuleLang()->Get('plugin.seopack.seopack_edit_submit_save_ok'));
            Router::Location('admin/seopack/');
        } else {
            E::ModuleMessage()->AddError(E::ModuleLang()->Get('system_error'));
        }
    }

    protected function EventSeopackDelete() {

        $this->sMainMenuItem = 'content';

        E::ModuleSecurity()->ValidateSendForm();

        if ($oSeopack = E::ModuleSeopack()->GetSeopackBySeopackId($this->GetParam(0))) {
            $oSeopack->Delete();
            E::ModuleMessage()->AddNotice(E::ModuleLang()->Get('plugin.seopack.seopack_admin_action_delete_ok') . null, true);
            Router::Location('admin/seopack/');
        } else {
            E::ModuleMessage()->AddError(
                E::ModuleLang()->Get('plugin.seopack.seopack_admin_action_delete_error'), E::ModuleLang()->Get('error')
            );
        }

        $this->SetTemplateAction('seopack_list');
    }

    protected function CheckSeopackFields() {

        E::ModuleSecurity()->ValidateSendForm();

        $bOk = true;

        if (F::isPost('title') && !F::CheckVal(F::GetRequest('title', '', 'post'), 'text', 0, 1000)) {
            E::ModuleMessage()->AddError(
                E::ModuleLang()->Get('plugin.seopack.seopack_create_title_error'), E::ModuleLang()->Get('error')
            );
            $bOk = false;
        }
        if (F::isPost('description') && !F::CheckVal(F::GetRequest('description', '', 'post'), 'text', 0, 1000)) {
            E::ModuleMessage()->AddError(
                E::ModuleLang()->Get('plugin.seopack.seopack_create_description_error'), E::ModuleLang()->Get('error')
            );
            $bOk = false;
        }
        if (F::isPost('keywords') && !F::CheckVal(F::GetRequest('keywords', '', 'post'), 'text', 0, 1000)) {
            E::ModuleMessage()->AddError(
                E::ModuleLang()->Get('plugin.seopack.seopack_create_keywords_error'), E::ModuleLang()->Get('error')
            );
            $bOk = false;
        }
        if (F::isPost('url') && !F::CheckVal(F::GetRequest('url', null, 'post'), 'text', 0, 255)) {
            E::ModuleMessage()->AddError(
                E::ModuleLang()->Get('plugin.seopack.seopack_create_url_error'), E::ModuleLang()->Get('error')
            );
            $bOk = false;
        }

        return $bOk;
    }
}

// EOF