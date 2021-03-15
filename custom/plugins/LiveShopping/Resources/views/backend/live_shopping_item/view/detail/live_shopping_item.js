Ext.define('Shopware.apps.LiveShoppingItem.view.detail.LiveShoppingItem', {
    extend: 'Shopware.model.Container',
    padding: 20,

    configure: function() {
        return {
            controller: 'LiveShoppingItem',
            associations: [ 'article' ],
        };
    },
});
