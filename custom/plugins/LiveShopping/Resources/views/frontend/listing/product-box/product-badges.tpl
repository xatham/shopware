{* SwagPluginSystem/Views/frontend/listing/product-box/product-badges.tpl *}
{extends file="parent:frontend/listing/product-box/product-badges.tpl"}

{block name="frontend_listing_box_article_new"}
    {$smarty.block.parent}

    {if $sArticle.attributes.swag_plugin_system}
        {$swagSeoAttribute = $sArticle.attributes.swag_plugin_system}

        {include file="frontend/live_shopping/listing-badge.tpl" seoCategory=$swagSeoAttribute->get('category')}
    {/if}
{/block}
