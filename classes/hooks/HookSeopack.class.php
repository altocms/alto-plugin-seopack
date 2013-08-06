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

class PluginSeopack_HookSeopack extends Hook {

    /**
     * Register hooks
     *
     * @return void
     */
    public function RegisterHook() {
        $this->AddHook('module_viewer_display_before', 'hook_meta');
		$this->AddHook('template_admin_menu_content', 'hook_admin_menu');
		$this->AddHook('template_body_begin', 'hook_body_begin');
		$this->AddHook('template_body_end', 'hook_body_end');
    }

    /**
     * Meta hook
     *
     * @return void
     */
    public function hook_meta() {
	
        $sAction = Router::GetAction();
        
		$oSeopack = $this->PluginSeopack_Seopack_GetSeopackByUrl( trim($_SERVER['REQUEST_URI'],"/") );
		
		$this->Viewer_Assign("oCurrentUrl", trim($_SERVER['REQUEST_URI'],"/") );
		
		if($oSeopack){
			$this->Viewer_Assign("oSeopack", $oSeopack);
		}
		
        $sMetaDescriptionTemplate = Plugin::GetTemplatePath(__CLASS__) . 'meta/description/' . $sAction . '.tpl';
        if ($this->Viewer_TemplateExists($sMetaDescriptionTemplate)) {
            $sMetaDescription = $this->Viewer_Fetch($sMetaDescriptionTemplate);
			if($oSeopack && $oSeopack->getDescription()){
				$this->Viewer_Assign("sHtmlDescription", htmlspecialchars($oSeopack->getDescription()));
			}else{
				$this->Viewer_Assign("sHtmlDescription", htmlspecialchars($sMetaDescription));
			}
        }

        $sMetaKeywordsTemplate = Plugin::GetTemplatePath(__CLASS__) . 'meta/keywords/' . $sAction . '.tpl';
        if ($this->Viewer_TemplateExists($sMetaKeywordsTemplate)) {
            $sMetaKeywords = $this->Viewer_Fetch($sMetaKeywordsTemplate);
			if($oSeopack && $oSeopack->getKeywords()){
				$this->Viewer_Assign("sHtmlKeywords", htmlspecialchars($oSeopack->getKeywords()));
			}else{
				$this->Viewer_Assign("sHtmlKeywords", htmlspecialchars($sMetaKeywords));
			}
        }
		if($oSeopack && $oSeopack->getTitle()){			
			$this->Viewer_Assign("sHtmlTitle", htmlspecialchars($oSeopack->getTitle())); 
		}
    }

    /**
     * Footer hook
     *
     * @return void
     */
    public function hook_body_end() {
        return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__) . 'modal_form.tpl');
    }
	
	/**
     * Admin menu hook
     *
     * @return void
     */
	public function hook_admin_menu() { 
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__) . 'admin_menu.tpl');
    }
	
	/**
     * For toolbar hook
     *
     * @return void
     */
	public function hook_body_begin() {
        return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__) . 'body_begin.tpl');
    }
}