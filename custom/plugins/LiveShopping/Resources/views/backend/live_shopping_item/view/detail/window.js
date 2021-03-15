Ext.define('Shopware.apps.LiveShoppingItem.view.detail.Window', {
    extend: 'Shopware.window.Detail',
    alias: 'widget.product-detail-window',
    title : '{s name=title}Product details{/s}',
    height: 420,
    width: 900,

    initComponent: function () {
        var me = this;
        me.callParent(arguments);

        /*me.saveButton = Ext.create('Ext.button.Button', {
            cls: 'primary',
            name: 'save-article-button',
            text: '{s name="start_update"}Speicher den Rotz{/s}',
            handler: function() {
                let form = me.formPanel.getForm();
                me.fireEvent('startUpdate', form);
                me.onSave();
            }
        });
*/
        me.saveButton.handler = function () {
            let form = me.formPanel.getForm();
            me.fireEvent('startUpdate', form);

            let value = form.findField('article').lastValue;
            me.record.raw.article.number = value;

            me.onSave();
        };
    },


});
