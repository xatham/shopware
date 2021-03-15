Ext.define('Shopware.apps.LiveShoppingItem.model.LiveShoppingItem', {
    extend: 'Shopware.data.Model',

    configure: function () {
        return {
            controller: 'LiveShoppingItem',
            detail: 'Shopware.apps.LiveShoppingItem.view.detail.LiveShoppingItem',
        };
    },

    fields: [
        { name: 'id', type: 'int'},
        { name: 'active', type: 'boolean'},
        { name: 'startDate', type: 'date'},
        { name: 'endDate', type: 'date'},
        { name: 'savingAbsolute', type: 'float'},
        { name: 'article', type: 'string', convert: function (value, record) {
                if (record && record.raw && record.raw.article) {
                    return record.raw.article.number;
                }

                return value.number;
            }
        },
    ],

/*    associations: [
        {
            field: 'article',
            relation: 'OneToOne',
            type: 'hasOne',
            model: 'Shopware.apps.Base.model.Variant',
            name: 'getArticle',
            associationKey: 'article',
        }
    ],*/
});
