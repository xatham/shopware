{block name="widgets_emotion_components_live_shopping"}
    <style>
        .liveshopping__details {
            display: flex;
        }
        .liveshopping__picture{
            max-height: 150px;
            width: 100px;
        }
    </style>
    {if $Data.product == null}
        Live shopping abgelaufen
    {/if}
    <div class="liveshopping__container">
        <div class="liveshopping__details">
            <div class="liveshopping__picture">
                <img src="{$Data.product.image.source}" alt="article">
            </div>
            <div class="col-8">
                <div class="liveshopping__name">
                    {$Data.product.articleName}
                </div>
                <div class="liveshopping__price">
                    {$Data.product.price}
                </div>
            </div>
        </div>
        <div class="liveshopping__addtocart">
            <button
                    class="liveshopping--button buybox--button block btn is--primary is--icon-right is--center is--large"
                    aria-label="{s namespace="frontend/listing/box_article" name="ListingBuyActionAddText"}{/s}">
                {s namespace="frontend/listing/box_article" name="ListingBuyActionAdd"}{/s}
                <i class="icon--basket"></i>
                <i class="icon--arrow-right"></i>
            </button>
        </div>
    </div>
{/block}
