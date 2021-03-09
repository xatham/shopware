Ext.define('Shopware.apps.LiveShoppingItem', {
    extend: 'Enlight.app.SubApplication',

    name:'Shopware.apps.LiveShoppingItem',

    loadPath: '{url action=load}',
    bulkLoad: true,

    controllers: [ 'Main' ],

    views: [
        'list.Window',
        'list.LiveShoppingItem'
    ],

    models: [ 'LiveShoppingItem' ],
    stores: [ 'LiveShoppingItem' ],

    launch: function() {
        return this.getController('Main').mainWindow;
    }
});
