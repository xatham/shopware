Ext.define('Shopware.apps.LiveShoppingItem.store.LiveShoppingItem', {
    extend:'Shopware.store.Listing',

    configure: function() {
        return {
            controller: 'LiveShoppingItem'
        };
    },
    model: 'Shopware.apps.LiveShoppingItem.model.LiveShoppingItem'
});
