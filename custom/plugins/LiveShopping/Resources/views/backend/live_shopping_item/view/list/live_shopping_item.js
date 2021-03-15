Ext.define('Shopware.apps.LiveShoppingItem.view.list.LiveShoppingItem', {
        extend: 'Shopware.grid.Panel',
        alias: 'widget.product-listing-grid',
        region: 'center',
        configure: function () {
            return {
                detailWindow: 'Shopware.apps.LiveShoppingItem.view.detail.Window',
            }
        },
    }
);
