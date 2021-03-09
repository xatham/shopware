Ext.define('Shopware.apps.LiveShoppingItem.model.LiveShoppingItem', {
    extend: 'Shopware.data.Model',

    configure: function() {
        return {
            controller: 'LiveShoppingItem'
        };
    },

    fields: [
        { name : 'id', type: 'int', useNull: true },
        { name : 'active', type: 'boolean' },
        { name : 'startDate', type: 'date' },
        { name : 'endDate', type: 'date', useNull: true},
        { name : 'savingAbsolute', type: 'float', useNull: true},
        { name : 'articleId', type: 'int', useNull: true }
    ]
});
