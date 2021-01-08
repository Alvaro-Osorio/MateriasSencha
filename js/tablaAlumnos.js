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
    Ext.define('Alumno', {
		extend: 'Ext.data.Model',
		fields: ['id', 'nombre', 'apePat', 'apeMat', 'nnumcontrol', 'ncvecarrera','nsemestre','pwd']
	});
	
	//Define almacenamiento de Alumno proveniente de PHP y usado en la tabla (grid)
	Ext.create('Ext.data.Store', {
		extend: 'Ext.data.Store',
		storeId: 'Alumnos',
		model: 'Alumno',
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
				read: 'buscaTodosAlumno.php',
				update: 'resABCAlumno.php?txtOpe=m',
				destroy: 'resABCAlumno.php?txtOpe=b'
			},
			reader: {
				type: 'json',
				rootProperty: 'arrAlumno'
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
		store: Ext.data.StoreManager.lookup('Alumnos'),
		width: "90%",
		height: "31em",
		title: 'Alumnos',
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
				text: 'Id Alumnos',
				width: '10%',
				dataIndex: 'id'
			},
			{
				text: 'Nombre',
				width: '20%',
				dataIndex: 'nombre',
				editor: {
					xtype: 'textfield',
					allowBlank: false
				}
			},
			{
				text: 'Apellido Paterno',
				width: '20%',
				dataIndex: 'apePat',
				editor: {
					xtype: 'textfield',
					allowBlank: false
				}
			},
			{
				text: 'Apellido Materno',
				width: '20%',
				dataIndex: 'apeMat',
				editor: {
					xtype: 'textfield',
					allowBlank: false
				}
			},
			{
				text: 'NumCtrl',
				width: '10%',
				dataIndex: 'nnumcontrol',
				editor: {
					xtype: 'textfield',
					allowBlank: false
				}
			},
			{
				text: 'Cve Carrera',
				width: '10%',
				dataIndex: 'ncvecarrera',
				editor: {
					xtype: 'numberfield',
					allowBlank: false
				}
			
			},{
				text: 'Semestre',
				width: '10%',
				dataIndex: 'nsemestre',
				editor: {
					xtype: 'numberfield',
					allowBlank: false
				}
			},
			{
				text: 'Contrase&ntilde;a',
				width: '10%',
				dataIndex: 'pwd',
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
		buttons:[
			{
				text: "Crear",
				handler: function(btn){
					var grid = btn.up('grid');
					var store = grid.getStore();
					var nuevo = Ext.create('Alumno',{
						id: store.getCount()+2,
						nombre: "",
						apePat: "",
						apeMat: "",
						nnumcontrol: 1,
						ncvecarrera: 1,
						nsemestre: 1,
						pwd: ""
					});
					store.insert(store.getCount(),nuevo);
				}
			},
			{
				text: "Eliminar",
				handler: function(btn){
					var grid = btn.up('grid');
					var store = grid.getStore();
					var selected = grid.getSelectionModel().getSelection();

					if (selected && selected.length==1) {
						store.remove(selected);
					}
				}
			}
		]
	});
});
