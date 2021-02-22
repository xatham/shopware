{* SwagPluginSystem/Views/frontend/detail/actions.tpl *}
{extends file="parent:frontend/detail/actions.tpl"}

{block name='frontend_detail_actions_voucher'}
    {$smarty.block.parent}
    {if $sArticle.attributes.swag_plugin_system}
        {$swagSeoAttribute = $sArticle.attributes.swag_plugin_system}
        { $swagSeoAttribute->get('category')|var_dump }
        {include file="frontend/live_shopping/detail-link.tpl" seoCategory=$swagSeoAttribute->get('category')}
    {/if}
{/block}
