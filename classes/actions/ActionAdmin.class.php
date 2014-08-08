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

        $this->_setTitle($this->Lang_Get('plugin.seopack.seopack_title'));

        $nPage = $this->_getPageNum();

        $aSeopack = $this->PluginSeopack_Seopack_GetSeopackItemsByFilter(
            array(
                '#page' => 1,
                '#limit' => array(($nPage - 1) * Config::Get('admin.items_per_page'),
                                  Config::Get('admin.items_per_page'))
            )
        );

        $aPaging = $this->Viewer_MakePaging(
            $aSeopack['count'], $nPage, Config::Get('admin.items_per_page'), 4,
            Router::GetPath('admin') . 'seopack/'
        );

        $this->Viewer_Assign('aSeopack', $aSeopack['collection']);
        $this->Viewer_Assign('aPaging', $aPaging);

        $this->SetTemplateAction('seopack_list');
    }

    protected function EventSeopackEdit() {

        $this->sMainMenuItem = 'content';

        $this->_setTitle($this->Lang_Get('plugin.seopack.seopack_title'));

        if (isPost('submit_seopack_save')) {
            $this->SubmitSaveSeopack();
        }

        $this->Viewer_Assign('sMode', str_replace('seopack', '', Router::GetActionEvent()));

        if (Router::GetActionEvent() == 'seopackedit') {
            if ($oSeopack = $this->PluginSeopack_Seopack_GetSeopackBySeopackId($this->GetParam(0))) {

                if (!isPost('submit_seopack_save')) {
                    $_REQUEST['url'] = $oSeopack->getUrl();
                    $_REQUEST['title'] = $oSeopack->getTitle();
                    $_REQUEST['description'] = $oSeopack->getDescription();
                    $_REQUEST['keywords'] = $oSeopack->getKeywords();
                    $_REQUEST['seopack_id'] = $oSeopack->getSeopackId();
                }

            } else {
                $this->Message_AddError(
                    $this->Lang_Get('plugin.seopack.seopack_edit_notfound'), $this->Lang_Get('error')
                );
                $this->SetParam(0, null);
            }
        }

        $this->SetTemplateAction('seopack_edit');
    }

    protected function GetUri($url) {

        $this->sMainMenuItem = 'content';

        $url = str_replace(Config::Get('path.root.web'), '', $url);
        $pos = strpos($url, '#');
        if ($pos = strpos($url, '#')) {
            $url = substr($url, 0, $pos);
        }
        return trim(strip_tags($url), "/");
    }

    protected function SubmitSaveSeopack() {

        $this->sMainMenuItem = 'content';

        if (!$this->CheckSeopackFields()) {
            return false;
        }

        if (!getRequest('seopack_id')) {
            if (!$oSeopack = $this->PluginSeopack_Seopack_GetSeopackByUrl($this->GetUri(getRequest('url')))) {
                $oSeopack = Engine::GetEntity('PluginSeopack_ModuleSeopack_EntitySeopack');
                $oSeopack->setUrl($this->GetUri(getRequest('url')));
            }
        } elseif (!$oSeopack = $this->PluginSeopack_Seopack_GetSeopackBySeopackId(getRequest('seopack_id'))) {
            $oSeopack = Engine::GetEntity('PluginSeopack_ModuleSeopack_EntitySeopack');
            $oSeopack->setUrl($this->GetUri(getRequest('url')));
        }

        $oSeopack->setTitle(getRequest('title_auto') ? null : strip_tags(getRequest('title')));
        $oSeopack->setDescription(getRequest('description_auto') ? null : strip_tags(getRequest('description')));
        $oSeopack->setKeywords(getRequest('keywords_auto') ? null : strip_tags(getRequest('keywords')));

        if ($oSeopack->Save()) {
            $this->Message_AddNotice($this->Lang_Get('plugin.seopack.seopack_edit_submit_save_ok'));
            Router::Location('admin/seopack/');
        } else {
            $this->Message_AddError($this->Lang_Get('system_error'));
        }
    }

    protected function EventSeopackDelete() {

        $this->sMainMenuItem = 'content';

        $this->Security_ValidateSendForm();

        if ($oSeopack = $this->PluginSeopack_Seopack_GetSeopackBySeopackId($this->GetParam(0))) {
            $oSeopack->Delete();
            $this->Message_AddNotice($this->Lang_Get('plugin.seopack.seopack_admin_action_delete_ok') . null, true);
            Router::Location('admin/seopack/');
        } else {
            $this->Message_AddError(
                $this->Lang_Get('plugin.seopack.seopack_admin_action_delete_error'), $this->Lang_Get('error')
            );
        }

        $this->SetTemplateAction('seopack_list');
    }

    protected function CheckSeopackFields() {

        $this->Security_ValidateSendForm();

        $bOk = true;

        if (isPost('title') && !func_check(getRequest('title', '', 'post'), 'text', 0, 1000)) {
            $this->Message_AddError(
                $this->Lang_Get('plugin.seopack.seopack_create_title_error'), $this->Lang_Get('error')
            );
            $bOk = false;
        }
        if (isPost('description') && !func_check(getRequest('description', '', 'post'), 'text', 0, 1000)) {
            $this->Message_AddError(
                $this->Lang_Get('plugin.seopack.seopack_create_description_error'), $this->Lang_Get('error')
            );
            $bOk = false;
        }
        if (isPost('keywords') && !func_check(getRequest('keywords', '', 'post'), 'text', 0, 1000)) {
            $this->Message_AddError(
                $this->Lang_Get('plugin.seopack.seopack_create_keywords_error'), $this->Lang_Get('error')
            );
            $bOk = false;
        }
        if (isPost('url') && !func_check(getRequest('url', null, 'post'), 'text', 0, 255)) {
            $this->Message_AddError(
                $this->Lang_Get('plugin.seopack.seopack_create_url_error'), $this->Lang_Get('error')
            );
            $bOk = false;
        }

        return $bOk;
    }
}

// EOF