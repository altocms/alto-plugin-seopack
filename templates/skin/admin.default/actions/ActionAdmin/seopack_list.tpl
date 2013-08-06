{extends file='_index.tpl'}

{block name="content-bar"}
    <div class="btn-group">
        <a href="{router page='admin'}seopackadd/" class="btn btn-primary"><i class="icon-plus-sign"></i></a>
    </div>
{/block}

{block name="content-body"}

<div class="span12">

    <div class="b-wbox">
        <div class="b-wbox-content nopadding">

            <table class="table table-striped table-condensed pages-list">
                <thead>
                <tr>
                    <th class="span1">ID</th>
                    <th>{$aLang.plugin.seopack.seopack_admin_url}</th>
                    <th>{$aLang.plugin.seopack.seopack_admin_title}</th>
                    <th>{$aLang.plugin.seopack.seopack_admin_description}</th>
                    <th>{$aLang.plugin.seopack.seopack_admin_keywords}</th>
                    <th class="span2"></th>
                </tr>
                </thead>

                <tbody>
					{foreach $aSeopack as $oSeopack}
                    <tr>
                        <td>
                            {$oSeopack->getId()}
                        </td>
						<td>
                            <a href="{cfg name="path.root.web"}{$oSeopack->getUrl()|strip_tags|escape:'html'}" target="_blank">{cfg name="path.root.web"}{$oSeopack->getUrl()|strip_tags|escape:'html'}</a>
                        </td>
						<td>
                            {if $oSeopack->getTitle()===null}-{else}{$oSeopack->getTitle()|strip_tags|escape:'html'}{/if}
                        </td>
						<td>
                            {if $oSeopack->getDescription()===null}-{else}{$oSeopack->getDescription()|strip_tags|escape:'html'}{/if}
                        </td>
						<td>
                            {if $oSeopack->getKeywords()===null}-{else}{$oSeopack->getKeywords()|strip_tags|escape:'html'}{/if}
                        </td>
						<td class="center">
                            <a href="{router page='admin'}seopackedit/{$oSeopack->getId()}/"
                               title="{$aLang.plugin.seopack.seopack_admin_action_edit}" class="tip-top i-block">
                                <i class="icon-edit"></i>
                            </a>
                            <a href="#" title="{$aLang.plugin.seopack.seopack_admin_action_delete}" class="tip-top i-block"
                                  onclick="return admin.confirmDelete('{$oSeopack->getId()}', '{cfg name="path.root.web"}{$oSeopack->getUrl()|strip_tags|escape:'html'}'); return false;">
                                <i class="icon-remove"></i>
                            </a>
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    </div>

    {include file="inc.paging.tpl"}

</div>

<script>
    var admin = admin || { };

    admin.confirmDelete = function(id, title) {
        admin.confirm({
            header: '{$aLang.plugin.seopack.seopack_admin_action_delete}',
            content: '{$aLang.plugin.seopack.seopack_admin_action_delete_message} "' + title + '"<br/>{$aLang.plugin.seopack.seopack_admin_action_delete_confirm}',
            onConfirm: function() {
                document.location = "{router page='admin'}seopackdelete/" + id + "/?security_ls_key={$ALTO_SECURITY_KEY}";
            }
        })
    }
</script>

{/block}