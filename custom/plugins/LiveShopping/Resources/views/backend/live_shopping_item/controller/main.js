Ext.define('Shopware.apps.LiveShoppingItem.controller.Main', {
    extend: 'Enlight.app.Controller',

    init: function() {
        let me = this;
        me.mainWindow = me.getView('list.Window').create({ }).show();
    }
});
