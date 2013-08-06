<div id="seopack-edit" class="modal seopack">
	<header class="modal-header">
		<h3>{$aLang.plugin.seopack.edit_parameters}</h3>
		<a href="#" class="close jqmClose"></a>
	</header>
	<div class='seopack_modal_content'>
		<div class="modal-content">
			<div class="block-parameter">
				<strong>{$aLang.plugin.seopack.seopack_create_title}:</strong>
				<label>
					<small>
						<input type="checkbox" id="title_auto" name="title_auto" value="1"
						   class="input-checkbox" onclick="ls.toolbar.seopack.toggleForm('title');" 
						   {if !($oSeopack && $oSeopack->getTitle())}checked{/if}/> {$aLang.plugin.seopack.auto_generate}
					</small>
				</label>
				<textarea rows="3" id="seopack-title-form-text" name="title" class="input-text input-width-full" {if !($oSeopack && $oSeopack->getTitle())}disabled{/if}>{$sHtmlTitle}</textarea>
			</div>
		 
			<div class="block-parameter">
				<strong>{$aLang.plugin.seopack.seopack_create_description}:</strong>
				<label>
					<small>
						<input type="checkbox" id="description_auto" name="description_auto" value="1"
						   class="input-checkbox" onclick="ls.toolbar.seopack.toggleForm('description');"
						   {if !($oSeopack && $oSeopack->getDescription())}checked{/if}/> {$aLang.plugin.seopack.auto_generate}
					</small>
				</label>
				<textarea rows="3" cols="20" id="seopack-description-form-text" name="description" class="input-text input-width-full" {if !($oSeopack && $oSeopack->getDescription())}disabled{/if}>{$sHtmlDescription}</textarea>
			</div>
		 
			<div class="block-parameter">
				<strong>{$aLang.plugin.seopack.seopack_create_keywords}:</strong>
				<label>
					<small>
						<input type="checkbox" id="keywords_auto" name="keywords_auto" value="1"
						   class="input-checkbox" onclick="ls.toolbar.seopack.toggleForm('keywords');"
						   {if !($oSeopack && $oSeopack->getKeywords())}checked{/if}/> {$aLang.plugin.seopack.auto_generate}
					</small>
				</label>
				<textarea rows="3" cols="20" id="seopack-keywords-form-text" name="keywords" class="input-text input-width-full" {if !($oSeopack && $oSeopack->getKeywords())}disabled{/if}>{$sHtmlKeywords}</textarea>
			</div>
			
			<button type="submit"  onclick="return ls.toolbar.seopack.save('{$oCurrentUrl}');" class="button button-primary">{$aLang.user_note_form_save}</button>
			<button type="submit"  onclick="return ls.toolbar.seopack.cancel();" class="button">{$aLang.user_note_form_cancel}</button>
			
		</div>
	</div>
</div>