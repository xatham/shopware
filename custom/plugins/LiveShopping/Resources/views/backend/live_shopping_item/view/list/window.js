Ext.define('Shopware.apps.LiveShoppingItem.view.list.Window', {
    extend: 'Shopware.window.Listing',
    alias: 'widget.product-list-window',
    height: 450,
    title : '{s name=window_title}Live shopping items{/s}',

    configure: function() {
        return {
            listingGrid: 'Shopware.apps.LiveShoppingItem.view.list.LiveShoppingItem',
            listingStore: 'Shopware.apps.LiveShoppingItem.store.LiveShoppingItem'
        };
    }
});
