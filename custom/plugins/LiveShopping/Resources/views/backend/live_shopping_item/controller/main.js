Ext.define('Shopware.apps.LiveShoppingItem.controller.Main', {
    extend: 'Enlight.app.Controller',

    init: function() {
        let me = this;
        me.mainWindow = me.getView('list.Window').create({ }).show();

        me.control({
            'product-detail-window': {
                startUpdate: me.onShowPluginUpdateDetails,
            }
        });

    },

    onShowPluginUpdateDetails: function(form) {
        let value = form.findField('article').lastValue;
        console.log(value);
        return true;
    },
});

