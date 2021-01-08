/*
tablaAlumnos.js
Pinta la tabla de Alumnos con la opción de crear nuevos
*/
Ext.require([
    'Ext.plugin.Viewport'
]);
var nLinActual = -1;
Ext.onReady(function(){
	//Define "clase" Alumno
    Ext.define('Materia', {
		extend: 'Ext.data.Model',
		fields: ['id', 'nombremateria', 'creditos']
	});
	
	//Define almacenamiento de Materia proveniente de PHP y usado en la tabla (grid)
	Ext.create('Ext.data.Store', {
		extend: 'Ext.data.Store',
		storeId: 'Materia',
		model: 'Materia',
		autoLoad: true, //se carga al definirse
		autoSync: true,    //para ABC autónomo
		
		proxy: {
			type: 'ajax',
			actionMethods: {
				read: 'GET',
				update: 'POST'
			},
			batchActions: false,
			api: {
				read: 'buscaTodosMateria.php',
				update: 'resABCMateria.php?txtOpe=m',
				destroy: 'resABCMateria.php?txtOpe=b'
			},
			reader: {
				type: 'json',
				rootProperty: 'arrMateria'
			},
			writer: {
				type: 'json'
			},
			listeners: {
				exception: function(proxy, response, operation, eOpts) {
					Ext.Msg.alert(
						'Aviso',
						'Error al llamar al servidor'
					);
				}
			}
		}
	});
	
	//Define tabla que usa almacenamiento proveniente de PHP
	Ext.create('Ext.grid.Panel', {
		renderTo: Ext.get("espacio1"),
		store: Ext.data.StoreManager.lookup('Materia'),
		width: "90%",
		height: "31em",
		title: 'Materias',
		selType: 'rowmodel',
		id: "tblAlum",
		plugins: {
			ptype: 'rowediting',
			clicksToEdit: 2,
			listeners: {
				edit: function(editor, e, eOpts) {
					 alert("Información enviada");
				}
			}
		},
		columns: [
			{
				text: 'Id Materias',
				width: '10%',
				dataIndex: 'idmateria'
			},
			{
				text: 'Nombre de la Materia',
				width: '20%',
				dataIndex: 'nombremateria',
				editor: {
					xtype: 'textfield',
					allowBlank: false
				}
			},
			{
				text: 'Creditos',
				width: '20%',
				dataIndex: 'creditos',
				editor: {
					xtype: 'textfield',
					allowBlank: false
				}
			}
			
		],
		listeners: {
			select: function(selModel, record, index, options){
				nLinActual = index;
			}
		},
		
	});
});
