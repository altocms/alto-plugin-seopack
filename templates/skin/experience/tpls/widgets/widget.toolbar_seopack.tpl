{if $oUserCurrent && $oUserCurrent->isAdministrator()}
	<div class="toolbar-admin toolbar-button">
        <a href="#" onclick="return ls.toolbar.seopack.open();" title="{$aLang.plugin.seopack.manage_seo_page}">
            <span class="fa fa-bar-chart-o"></span>
        </a>
    </div>	
{/if}
