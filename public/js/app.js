Ext.require(['Ext.data.*', 'Ext.grid.*']);

Ext.define('User', {
    extend: 'Ext.data.Model',
    fields: [{
        name: 'id',
        type: 'int',
        useNull: true
    }, 'name', 'grade', 'cities']
});

Ext.define('Grade', {
    extend: 'Ext.data.Model',
    fields: [{
        name: 'id',
        type: 'int',
        useNull: true
    }, 'title']
});

Ext.onReady(function() {

    var user_store = Ext.create('Ext.data.Store', {
        autoLoad: true,
        autoSync: true,
        model: 'User',
        proxy: {
            type: 'rest',
            url: '/api/user',
            reader: {
                type: 'json',
                rootProperty: 'data'
            },
            writer: {
                type: 'json'
            }
        },
        listeners: {
            write: function(store, operation) {
                var record = operation.getRecords()[0];
                Ext.MessageBox.alert('Result', Ext.String.format("Updated user #{0}", record.getId()));
            }
        }
    });

    var grade_store = Ext.create('Ext.data.Store', {
        autoLoad: true,
        autoSync: true,
        model: 'Grade',
        proxy: {
            type: 'rest',
            url: '/api/grade',
            reader: {
                type: 'json',
                rootProperty: 'data'
            },
            writer: {
                type: 'json'
            }
        }
    });

    var rowEditing = Ext.create('Ext.grid.plugin.RowEditing');

    var grid = Ext.create('Ext.grid.Panel', {
        renderTo: document.body,
        plugins: [rowEditing],
        width: 680,
        height: 400,
        frame: true,
        title: 'Users',
        store: user_store,
        style: 'margin:0 auto;margin-top:100px;',
        columns: [{
            text: 'Id',
            width: 50,
            sortable: true,
            dataIndex: 'id',
            renderer: function(v, meta, rec) {
                return rec.phantom ? '' : v;
            }
        }, {
            text: 'Name',
            width: 180,
            sortable: true,
            dataIndex: 'name',
            field: {
                xtype: 'textfield',
                editable: false
            }
        }, {
            header: 'Grade',
            flex: 1,
            sortable: true,
            dataIndex: 'grade',
            field: {
                xtype: 'combobox',
                store: grade_store,
                displayField: 'title',
                valueField: 'title',
                editable: false,
                queryMode: 'local',
                forceSelection: true,
                triggerAction: 'all',
                allowBlank: false
            }
        }, {
            text: 'Cities',
            width: 300,
            sortable: false,
            dataIndex: 'cities',
            field: {
                xtype: 'textfield',
                editable: false,
                allowBlank: true
            }
        }],
        dockedItems: [{
            xtype: 'toolbar',
            items: [{
                text: 'Refresh user list',
                handler: function() {
                    user_store.reload();
                }
            }]
        }]
    });
});