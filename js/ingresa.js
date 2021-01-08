/*
ingresa.js
Presenta formulario ExtJS para login, realiza envío parcial,
espera JSON como {"success":true, "sNom":nombre_usu_o_error, "sTipo":tipo_o_-1}
*/
Ext.require([
    'Ext.plugin.Viewport'
]);
Ext.onReady(function(){
    Ext.create('Ext.form.Panel', {
		title: 'Ingresar al Sistema',
		renderTo: Ext.get("espacio1"),
		bodyPadding: 5,
		width: "40em",
		url: "login.php",
		standardSubmit: false, //para request parcial
		defaultType: 'textfield',
		items: [{
				fieldLabel: 'Clave',
				name: 'txtCve',
				regex: /^[0-9]+$/,
				invalidText: 'Sólo números'
			},
			{
				fieldLabel: 'Contrase&ntilde;a',
				name: 'txtPwd',
				allowBlank: false
			}],
		buttons: [{
			text: 'Enviar',
			handler: function() {
				var frm = this.up('form').getForm();
				if (frm.isValid()) {
					// Envío "normal", viaja de forma parcial por la configuración inicial
					frm.submit({
						success: function(form, action) {
							Ext.get("espacio1").setHtml(
							"<h3>Inicio</h3><h4>Bienvenido "+action.result.sNom
							+"</h4><h4>Eres tipo "+action.result.sTipo+"</h4>");
							if (action.result.sTipo=="Administrador"){
								Ext.get("ligaAlumnos").set({href:"tabAlumnos.php"});
								Ext.get("ligaAlumnos").setHtml("Ver Alumnos");
							}
							else
							{
							Ext.get("ligaMaterias").set({href:"tabMaterias.php"});
								Ext.get("ligaMaterias").setHtml("Ver Materias");	
							}
							Ext.get("ligaSalir").set(
							{href: 'logout.php'});
							Ext.get("ligaSalir").setHtml("Salir");
						},
						failure: function(form, action) {
							Ext.Msg.alert('Error', action.result ? action.result.sNom : 'Sin respuesta');
						}
					});
				}
			}
		}]
	});
});
