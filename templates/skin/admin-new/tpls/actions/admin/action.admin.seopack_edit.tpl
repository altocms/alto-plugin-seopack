{extends file='_index.tpl'}

{block name="content-bar"}
<div class="col-md-12 mb15">
        <a href="{router page='admin'}seopack/" class="btn btn-primary"><i class="glyphicon glyphicon-chevron-left"></i></a>
    </div>
{/block}

{block name="content-body"}

<div class="col-md-12">
{literal}
	<script type="text/javascript">
		function toggleForm ( parameter ) { 
			if($('#seopack-'+parameter+'-form-text').is(":disabled")){			
				$('#seopack-'+parameter+'-form-text').prop("disabled", false);
				$('#seopack-'+parameter+'-form-text').focus();
			}else{
				$('#seopack-'+parameter+'-form-text').prop("disabled", true);
			}
		};
	</script>
{/literal}
		
{*{include file='inc.modal_load_img.tpl' sToLoad='page_text'}*}

    <div class="panel panel-default">
         
		<div class="panel-heading">
			<h3 class="panel-title">
				{if $sMode=='edit'}
                    {$aLang.plugin.seopack.seopack_edit}: {cfg name="path.root.web"}{$_aRequest.url|strip_tags|escape:'html'}
                {else}
					{$aLang.plugin.seopack.seopack_new}                    
                {/if}
			</h3>
		</div>

        <div class="panel-body">
            <form action="" method="POST" class="form-horizontal uniform" enctype="multipart/form-data">
                {hook run='plugin_seopack_form_add_begin'}
                <input type="hidden" name="security_ls_key" value="{$ALTO_SECURITY_KEY}"/>
                <input type="hidden" name="seopack_id" value="{if $sMode=='edit'}{$_aRequest.seopack_id}{/if}">
					
				<div class="control-group">
					<label for="url" class="col-sm-2 control-label">{$aLang.plugin.seopack.seopack_create_url}</label>

					<div class="col-sm-10 input-group">
						<div class="input-group-addon">{cfg name="path.root.web"}</div>
						<input type="text" id="url" class="form-control" name="url"
								{if $sMode=='edit'}disabled{/if}
                               value="{if $_aRequest.url}{$_aRequest.url|strip_tags|escape:'html'}{/if}" />
							 
					</div>
				</div>
				
				<div class="control-group">
					<label for="seopack-title-form-text" class="col-sm-2 control-label">{$aLang.plugin.seopack.seopack_create_title}</label>

					<div class="col-sm-10">
						<label>
							<small>
								<input type="checkbox" id="title_auto" name="title_auto" value="1"
								   class="input-checkbox" onchange="toggleForm('title');" 
								   {if !($_aRequest.title)}checked{/if}/> {$aLang.plugin.seopack.auto_generate}
							</small>
						</label>						
						<textarea rows="5" id="seopack-title-form-text" name="title" class="form-control" {if !($_aRequest.title)}disabled{/if}>{if ($_aRequest.title)}{$_aRequest.title}{/if}</textarea>
						
					</div>
				</div>
				
				<div class="control-group">
					<label for="seopack-title-form-text" class="col-sm-2 control-label">{$aLang.plugin.seopack.seopack_create_description}</label>

					<div class="col-sm-10">
						<label>
							<small>
								<input type="checkbox" id="description_auto" name="description_auto" value="1"
								   class="input-checkbox" onchange="toggleForm('description');"
								   {if !($_aRequest.description)}checked{/if}/> {$aLang.plugin.seopack.auto_generate}
							</small>
						</label>
						<textarea rows="5" id="seopack-description-form-text" name="description" class="form-control" {if !($_aRequest.description)}disabled{/if}>{if ($_aRequest.description)}{$_aRequest.description}{/if}</textarea>
						
					</div>
				</div>
				
				<div class="control-group">
					<label for="seopack-title-form-text" class="col-sm-2 control-label">{$aLang.plugin.seopack.seopack_create_keywords}</label>

					<div class="col-sm-10">
						<label>
							<small>
								<input type="checkbox" id="keywords_auto" name="keywords_auto" value="1"
								   class="input-checkbox" onchange="toggleForm('keywords');"
								   {if !($_aRequest.keywords)}checked{/if}/> {$aLang.plugin.seopack.auto_generate}
							</small>
						</label>
						<textarea rows="5" id="seopack-keywords-form-text" name="keywords" class="form-control" {if !($_aRequest.keywords)}disabled{/if}>{if ($_aRequest.keywords)}{$_aRequest.keywords}{/if}</textarea>
						
					</div>
				</div>
		
                {hook run='plugin_seopack_form_add_end'}
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"
                            name="submit_seopack_save">{$aLang.plugin.seopack.seopack_create_submit_save}</button>
                </div>

            </form>
        </div>
    </div>

</div>

{/block}