{block name="frontend_live_shopping_detail_link"}
    <a href="{url controller=cat sCategory=$seoCategory->getId() sPage=1}"
       rel="nofollow"
       class="action--link">

        {block name="frontend_live_shopping_detail_link_icon"}
            123213
            <i class="icon--comment"></i>
        {/block}

        {block name="frontend_live_shopping_detail_link_text"}
            {$seoCategory->getName()}
        {/block}
    </a>
{/block}
