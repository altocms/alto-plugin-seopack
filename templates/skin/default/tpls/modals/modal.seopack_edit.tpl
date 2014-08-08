<div class="modal fade in" id="modal-seopack_edit">
    <div class="modal-dialog">
        <div class="modal-content">

            <header class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{$aLang.plugin.seopack.edit_parameters}</h4>
            </header>

            <div class="modal-body">
				<div class="form-group">
					<label for="seopack-title-form-text">{$aLang.plugin.seopack.seopack_create_title}:
						<small>
							<input type="checkbox" id="title_auto" name="title_auto" value="1"
							   class="input-seopack" onchange="ls.toolbar.seopack.toggleForm('title');" 
							   {if !($oSeopack && $oSeopack->getTitle())}checked{/if}/> {$aLang.plugin.seopack.auto_generate}
						</small>
					</label>
					<textarea rows="3" id="seopack-title-form-text" name="title" class="form-control input-text input-width-full" {if !($oSeopack && $oSeopack->getTitle())}disabled{/if}>{$sHtmlTitle}</textarea>
				</div>
			 
				<div class="form-group">
					<label>{$aLang.plugin.seopack.seopack_create_description}:
						<small>
							<input type="checkbox" id="description_auto" name="description_auto" value="1"
							   class="input-seopack" onchange="ls.toolbar.seopack.toggleForm('description');"
							   {if !($oSeopack && $oSeopack->getDescription())}checked{/if}/> {$aLang.plugin.seopack.auto_generate}
						</small>
					</label>
					<textarea rows="3" cols="20" id="seopack-description-form-text" name="description" class="form-control input-text input-width-full" {if !($oSeopack && $oSeopack->getDescription())}disabled{/if}>{$sHtmlDescription}</textarea>
				</div>
			 
				<div class="form-group">
					<label>{$aLang.plugin.seopack.seopack_create_keywords}:
						<small>
							<input type="checkbox" id="keywords_auto" name="keywords_auto" value="1"
							   class="input-seopack" onchange="ls.toolbar.seopack.toggleForm('keywords');"
							   {if !($oSeopack && $oSeopack->getKeywords())}checked{/if}/> {$aLang.plugin.seopack.auto_generate}
						</small>
					</label>
					<textarea rows="3" cols="20" id="seopack-keywords-form-text" name="keywords" class="form-control input-text input-width-full" {if !($oSeopack && $oSeopack->getKeywords())}disabled{/if}>{$sHtmlKeywords}</textarea>
				</div>
				
				<button type="submit"  onclick="return ls.toolbar.seopack.save('{$oCurrentUrl}');" class="btn btn-primary">{$aLang.user_note_form_save}</button>
				<button type="submit"  onclick="return ls.toolbar.seopack.cancel();" class="btn">{$aLang.user_note_form_cancel}</button>
				
		
            </div>

        </div>
    </div>
</div>
