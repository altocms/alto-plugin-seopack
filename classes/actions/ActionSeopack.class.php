<?php
/*---------------------------------------------------------------------------
 * @Project: Alto CMS
 * @Project URI: http://altocms.com
 * @Description: Advanced Community Engine
 * @Copyright: Alto CMS Team
 * @License: GNU GPL v2 & MIT
 *----------------------------------------------------------------------------
 */


class PluginSeopack_ActionSeopack extends ActionPlugin {
    public function Init() { 
		$this->Viewer_SetResponseAjax('json');
		
		if ($this->User_IsAuthorization()) {
            $this->oUserCurrent = $this->User_GetUserCurrent();
        }
        if (!$this->oUserCurrent || !$this->oUserCurrent->isAdministrator()) {
            return Router::Location('error/404/');
        }
		
    }

    /**
     * Регистрация евентов
     */
    protected function RegisterEvent() { 
		$this->AddEvent('ajax-set', 'EventAjaxSet');
    }

	protected function EventAjaxSet() {
	
		if (!isPost('url')) {
            return false;
        }
		
		if (!$this->CheckSeopackFields()) {
            return false;
        } 	
		if( !$oSeopack = $this->PluginSeopack_Seopack_GetSeopackByUrl( strip_tags(getRequest('url')) ) ){
			$oSeopack = Engine::GetEntity('PluginSeopack_ModuleSeopack_EntitySeopack');
			$oSeopack->setUrl(trim(strip_tags(getRequest('url')),"/"));
		}
		
		if (getRequest('title_auto') && getRequest('description_auto') && getRequest('keywords_auto')){
			$oSeopack->Delete();
			$this->Message_AddNotice($this->Lang_Get('plugin.seopack.seopack_edit_submit_save_ok'));
			return;
		}
		
		$oSeopack->setTitle(getRequest('title_auto') ? null : strip_tags(getRequest('title')));
		$oSeopack->setDescription(getRequest('description_auto') ? null : strip_tags(getRequest('description')));
		$oSeopack->setKeywords(getRequest('keywords_auto') ? null : strip_tags(getRequest('keywords')));
		
		if( $oSeopack->Save()){			
			if($oSeopack->getTitle())$this->Viewer_AssignAjax('title', $oSeopack->getTitle());
			$this->Message_AddNotice($this->Lang_Get('plugin.seopack.seopack_edit_submit_save_ok'));
		}
		
		return;
	}
	protected function CheckSeopackFields() {

        $this->Security_ValidateSendForm();

        $bOk = true;

        if (isPost('title') && !func_check(getRequest('title', null, 'post'), 'text', 0, 1000)) {
            $this->Message_AddError($this->Lang_Get('plugin.seopack.title_error'), $this->Lang_Get('error'));
            $bOk = false;
        }		
		if (isPost('description') && !func_check(getRequest('description', null, 'post'), 'text', 0, 1000)) {
            $this->Message_AddError($this->Lang_Get('plugin.seopack.description_error'), $this->Lang_Get('error'));
            $bOk = false;
        }
		if (isPost('keywords') && !func_check(getRequest('keywords', null, 'post'), 'text', 0, 1000)) {
            $this->Message_AddError($this->Lang_Get('plugin.seopack.keywords_error'), $this->Lang_Get('error'));
            $bOk = false;
        }
        if (!func_check(getRequest('url', null, 'post'), 'text', 0, 255)) {
            $this->Message_AddError($this->Lang_Get('plugin.seopack.url_error'), $this->Lang_Get('error'));
            $bOk = false;
        }

        return $bOk;
    }
}