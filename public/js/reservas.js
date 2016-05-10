$(document).ready( iniciar );
var selectClientes;
var selectTarifas;
var selectCargos;
var habitaciones;
var tarifas;
var arrayHabitaciones = new Array();
var numeroHabitaciones = new Array();
var idHabitaciones = new Array();
var reservaObservando;
var cargos;
function iniciar( e )
{	
	$(".w-add-reserva").on("click", mostrarViewCrear);
	$(".w-close").on("click", ocultarViewCrear);
	$(".w-close-dc").on("click", ocultarViewDetalle);
	$(".w-add").on("click", mostrarModalHabitaciones);
	$(".w-add-c").on("click", mostrarModalCrearCliente);
	$(".w-add-cargo").on("click", mostrarModalCargo);
	$("#select-cargo").on("change", actualizarCostoCargo);
	$("#form-cargo #precio").on("change", actualizarTotal);
	$("#form-cargo #cantidad").on("change", actualizarTotal);
	$("#form-cargo").on("submit", crearCargo);
	$("#form-crear-reserva").on("submit", crearReserva);
	$("#form-crear-cliente").on("submit", crearCliente);
	$("#form-abonos").on("submit", realizarAbono);
	$("#form-pagar").on("submit", realizarPago);
	$("#tabla-registros").delegate(".btn-anular", "click", anularReserva);
	$("#tabla-registros").delegate(".btn-checkin", "click", hacerCheckIn);
	$("#tabla-registros").delegate(".btn-checkout", "click", hacerCheckOut);
	$("#tabla-registros").delegate(".btn-cuenta", "click", mostrarViewDetalle);
	$("#tabla-habitaciones").delegate(".btn-seleccionar", "click", seleccionarHabitacion);
	$("#tabla-reservaciones").delegate(".btn-eliminar-habitacion", "click", eliminarHabitacion);
	$(".btn-abonar").on("click", mostrarModalAbonos);
	$(".btn-pagar").on("click", mostrarModalPagar);
	$("#tabla-cuenta").delegate(".btn-eliminar-cargo", "click", eliminarCargo);

	$('#select-crear').selectize();
	$('#selects-crear').selectize();

	$("#form-crear-reserva #adultos").val(0);
	$("#form-crear-reserva #ninos").val(0);
	llenarTabla();
	llenarClientes();
	llenarTarifas();
	llenarCargos();
	obtenerCorrelativosRecibo();

	$('.input-date-picker').datepicker({
		format: 'yyyy-mm-dd'
	});

	$('.input-date-picker-fin').datepicker({
		format: 'yyyy-mm-dd'
	});

	$(".input-date-picker-fin").on("change", function()
	{
		var fechaInicio = new Date($(".input-date-picker").val());
		var fechaFin = new Date($(".input-date-picker-fin").val());
		if ( fechaFin <= fechaInicio) 
		{
			nGen('warning', 'fa fa-times-circle', 'Espera..!', 'La fecha de salida es menor', 'topRight');
		}
		else
		{
			var ONE_DAY = 1000 * 60 * 60 * 24;
			var difference_ms = Math.abs(fechaFin - fechaInicio);
			var dias = Math.round(difference_ms/ONE_DAY);
			$("#dias").val(dias);
		}
	});

	$("#select-tarifa-c").on("change", function()
	{	
		var indexTarifa = $("#select-tarifa-c").val();
		var tarifa = tarifas[indexTarifa];
		$.each(arrayHabitaciones,function(index, value) 
		{
			value['precio'] = tarifa.precio;
			value['costo'] = tarifa.precio * parseInt($("#dias").val());
		});

		llenarTablaReserva();
	});

	/****** CONFIGURACION DE LA TABLA ***********/
	$('#tabla-registros').DataTable(
	{
		responsive: true,
		"oLanguage": {
			"sLengthMenu": "Mostrando _MENU_ filas",
		  	"sSearch": "",
				"sProcessing":     "Procesando...",
				"sLengthMenu":     "Mostrar _MENU_ registros",
				"sZeroRecords":    "No se encontraron resultados",
				"sEmptyTable":     "Ningún dato disponible en esta tabla",
				"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
				"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
				"sInfoPostFix":    "",
				"sSearch":         "Buscar:",
				"sUrl":            "",
				"sInfoThousands":  ",",
				"sLoadingRecords": "Cargando...",
				"oPaginate": {
		  			"sFirst":    "Primero",
		  			"sLast":     "Último",
		  			"sNext":     "Siguiente",
		  			"sPrevious": "Anterior"
				}
		}
	});

	$('#tabla-reservaciones').DataTable(
	{
		responsive: true,
		"oLanguage": {
			"sLengthMenu": "Mostrando _MENU_ filas",
		  	"sSearch": "",
				"sProcessing":     "Procesando...",
				"sLengthMenu":     "Mostrar _MENU_ registros",
				"sZeroRecords":    "No se encontraron resultados",
				"sEmptyTable":     "Ningún dato disponible en esta tabla",
				"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
				"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
				"sInfoPostFix":    "",
				"sSearch":         "Buscar:",
				"sUrl":            "",
				"sInfoThousands":  ",",
				"sLoadingRecords": "Cargando...",
				"oPaginate": {
		  			"sFirst":    "Primero",
		  			"sLast":     "Último",
		  			"sNext":     "Siguiente",
		  			"sPrevious": "Anterior"
				}
		}
	});	

	$('#tabla-habitaciones').DataTable(
	{
		responsive: true,
		"oLanguage": {
			"sLengthMenu": "Mostrando _MENU_ filas",
		  	"sSearch": "",
				"sProcessing":     "Procesando...",
				"sLengthMenu":     "Mostrar _MENU_ registros",
				"sZeroRecords":    "No se encontraron resultados",
				"sEmptyTable":     "Ningún dato disponible en esta tabla",
				"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
				"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
				"sInfoPostFix":    "",
				"sSearch":         "Buscar:",
				"sUrl":            "",
				"sInfoThousands":  ",",
				"sLoadingRecords": "Cargando...",
				"oPaginate": {
		  			"sFirst":    "Primero",
		  			"sLast":     "Último",
		  			"sNext":     "Siguiente",
		  			"sPrevious": "Anterior"
				}
		}
	});	

	$('#tabla-cuenta').DataTable(
	{
		responsive: true,
		"oLanguage": {
			"sLengthMenu": "Mostrando _MENU_ filas",
		  	"sSearch": "",
				"sProcessing":     "Procesando...",
				"sLengthMenu":     "Mostrar _MENU_ registros",
				"sZeroRecords":    "No se encontraron resultados",
				"sEmptyTable":     "Ningún dato disponible en esta tabla",
				"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
				"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
				"sInfoPostFix":    "",
				"sSearch":         "Buscar:",
				"sUrl":            "",
				"sInfoThousands":  ",",
				"sLoadingRecords": "Cargando...",
				"oPaginate": {
		  			"sFirst":    "Primero",
		  			"sLast":     "Último",
		  			"sNext":     "Siguiente",
		  			"sPrevious": "Anterior"
				}
		}
	});
}

function mostrarViewCrear( e )
{
	$("#crear-reserva").removeClass('hide');
	if ( e != null )
		e.preventDefault();
}

function ocultarViewCrear( e )
{
	$("#crear-reserva").addClass('hide');
	$("#tabla-reservaciones").dataTable().fnClearTable();
	arrayHabitaciones = new Array();
	numeroHabitaciones = new Array();
	idHabitaciones = new Array();

	var select = $("#select-cliente-c").selectize();
	var selectize = select[0].selectize; 
	selectize.setValue(0);

	$("#form-crear-reserva #entrada").val("");
	$("#form-crear-reserva #salida").val("");
	$("#form-crear-reserva #adultos").val(0);
	$("#form-crear-reserva #ninos").val(0);


	if ( e != null )
		e.preventDefault();
}

function llenarTablaHabitaciones( e ) 
{
		
	$("#tabla-habitaciones").dataTable().fnClearTable();
	$.ajax({
		type:'POST',
		url:'ws/habitacionesdisponibles',
		dataType:'json',
		data:{ habitaciones: JSON.stringify(numeroHabitaciones), entrada: $("#form-crear-reserva #entrada").val(), salida: $("#form-crear-reserva #salida").val() },
		success:function( respuesta )
		{
			if ( respuesta.resultado )
			{
				//nGen('success', 'fa fa-check-circle', 'Exito..!', resultado.mensaje, 'topRight');
				var xIndex = 0;
				habitaciones = respuesta.registros;
				$.each( habitaciones, function(index, value){
					var acciones;

					acciones = "<div class='btn-tollbar' role='toolbar'>" +
									"<div class='btn-group' role='group'>" +
										"<a href='#' idreg='"+value.id+"' indexReg='"+xIndex+"' class='btn btn-default btn-sm btn-seleccionar'><i class='fa fa-check'></i> Seleccionar</a> " +
									"</div>" +
								"</div>";

					var estado;
					if(value.limpieza == 1)
					{
						estado = "<label class='label label-warning'>Limpieza</label>";	
					}
					else
					{
						estado = "<label class='label label-primary'>Disponible</label>";
					}

					$("#tabla-habitaciones").dataTable().fnAddData([
						++xIndex,
						value.numero,
						value.nivel,
						value.torre,
						value.tipohabitacion.nombre,
						estado,
						acciones
					]);
				});

				$.each( respuesta.ocupadas, function(index, value){
					var acciones;

					acciones = "<div class='btn-tollbar' role='toolbar'>" +
									"<div class='btn-group' role='group'>" +
										"<a href='#' idreg='"+value.id+"' indexReg='"+xIndex+"' class='btn btn-default btn-sm btn-seleccionar'><i class='fa fa-check'></i> Seleccionar</a> " +
									"</div>" +
								"</div>";

					var estado;
					if(value.limpieza)
					{
						estado = "<label class='label label-warning'>Limpieza</label>";	
					}
					else
					{
						var estado = "<label class='label label-danger'>Ocupada</label>";
					}

					$("#tabla-habitaciones").dataTable().fnAddData([
						++xIndex,
						value.numero,
						value.nivel,
						value.torre,
						value.tipohabitacion.nombre,
						estado,
						acciones
					]);

					habitaciones.push(value);
				});
			}
			else
			{
				nGen('warning', 'fa fa-times-circle', 'Espera..!', respuesta.mensaje, 'topRight');
			}
		},
		error: function( error )
		{
			console.log(error);
		}
	});

	if ( e != null )
		e.preventDefault();
}

function seleccionarHabitacion( e )
{
	var indexHabitacion = $(e.target).closest("a").attr("indexReg");
	var indexTarifa = $("#select-tarifa-c").val();
	var habitacion = habitaciones[indexHabitacion];
	var tarifa = tarifas[indexTarifa];
	habitacion['precio'] = tarifa.precio;
	habitacion['costo'] = tarifa.precio * parseInt($("#dias").val());
	arrayHabitaciones.push(habitacion);
	numeroHabitaciones.push(habitacion.numero);
	idHabitaciones.push(habitacion.id);
	llenarTablaReserva();
	$("#modal-habitaciones").modal("hide");
	if ( e != null )
	{
		e.preventDefault();
		e.stopPropagation();
	}
}

function llenarTablaReserva( e )
{
	$("#tabla-reservaciones").dataTable().fnClearTable();

	var xIndex = 0;
	var total = 0;
	$.each(arrayHabitaciones, function(index, value) {
		var acciones;

		acciones = "<div class='btn-tollbar' role='toolbar'>" +
						"<div class='btn-group' role='group'>" +
							"<a href='#' idreg='"+value.id+"' indexReg='"+xIndex+"' class='btn btn-default btn-sm btn-eliminar-habitacion'><i class='fa fa-trash-o'></i> Eliminar</a> " +
						"</div>" +
					"</div>";
		total+=value.costo;
		$("#tabla-reservaciones").dataTable().fnAddData([
			++xIndex,
			value.numero,
			value.torre,
			value.nivel,
			value.tipohabitacion.nombre,
			value.precio,
			value.costo,
			acciones
		]);
	});

	$("#total").text(total);

	if ( e != null )
		e.preventDefault();
}

function eliminarHabitacion( e )
{
	var indexRow = $(e.target).closest("a").attr("indexReg");
	var row = $(e.target).closest("tr");

	numeroHabitaciones.splice(indexRow, 1);
	arrayHabitaciones.splice(indexRow, 1);
	$("#tabla-reservaciones").dataTable().fnDeleteRow(row);
	llenarTablaReserva();

	if ( e != null )
		e.preventDefault();
}

function llenarTabla( e ) 
{
	$.ajax({
		type:'GET',
		url:'ws/reservas',
		dataType:'json',
		data:{},
		success:function( respuesta )
		{
			if ( respuesta.resultado )
			{
				//nGen('success', 'fa fa-check-circle', 'Exito..!', resultado.mensaje, 'topRight');
				$("#tabla-registros").dataTable().fnClearTable();

				var xIndex = 0;
				$.each( respuesta.registros, function(index, value){
					var acciones;


					if (value.checkin == "0000-00-00 00:00:00")
					{
						acciones = "<div class='btn-tollbar' role='toolbar'>" +
									"<div class='btn-group' role='group'>" +
										"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-anular'><i class='fa fa-thumbs-down'></i> Anular</a> " +
										"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-cuenta'><i class='fa fa-calculator'></i> Cuenta</a> " +
										"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-checkin'><i class='fa fa-check-square-o'></i> Check In</a> " +
									"</div>" +
								"</div>";
					}
					else
					{
						acciones = "<div class='btn-tollbar' role='toolbar'>" +
									"<div class='btn-group' role='group'>" +
										"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-cuenta'><i class='fa fa-calculator'></i> Cuenta</a> " +
										"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-checkout'><i class='fa fa-toggle-up'></i> Check Out</a> " +
									"</div>" +
								"</div>";
					}

					var sexo = (value.sexo == 1 ? "<label class='label label-primary'>Masculino</label>" : "<label class='label label-danger'>Femenino</label>");

					$("#tabla-registros").dataTable().fnAddData([
						++xIndex,
						value.usuario.nombres,
						value.cliente.nombres + ' ' + value.cliente.apellidos,
						value.habitacion.numero,
						value.entrada,
						value.salida,
						acciones
					]);
				});
			}
			else
			{
				nGen('warning', 'fa fa-times-circle', 'Espera..!', respuesta.mensaje, 'topRight');
			}
		},
		error: function( error )
		{
			console.log(error);
		}
	});
	

	if ( e != null )
		e.preventDefault();
}

function hacerCheckIn( e )
{
	var idreg = $(e.target).closest('a').attr('idreg');

	swal({
		title: "¿Estas seguro?",
		text:  "Realizaras el Check In a la Reservación",
		type:  "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmbuttonText: "Si, hacer Check In",
		cancelButtonText: "No, cancelar",
		closeOnConfirm: false,
		closeOnCancel: false

	}, function ( isConfirm ) {
		if ( isConfirm )
		{
			$.ajax({
				type:    	"GET",
				url:     	"ws/reservas/checkin/"+idreg,
				dataType: 	"json",
				data: 		{},
				success: function ( respuesta )
				{
					if( respuesta.resultado )
					{
						swal("Listo!", "Se realizo Check In", "success");
						setTimeout( function(){ ratPack.refresh(); }, 300 );
					}
					else
					{
						console.log(respuesta);
						swal("Cancelado!", "Ocurrio un error al intentar hacer Check In", "error");
					}
				}, 
				error: function ( error )
				{
					console.log(error);
					swal("Cancelado!", "Ocurrio un error al intentar hacer Check In", "error");
				}
			});
		}
		else
		{
			swal("Cancelado!", "Ya no se hico Check In", "error");
		}
	});

	if ( e != null)
		e.preventDefault();
}

function hacerCheckOut( e )
{
	var idreg = $(e.target).closest('a').attr('idreg');

	swal({
		title: "¿Estas seguro?",
		text:  "Realizaras el Check Out a la Reservación",
		type:  "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmbuttonText: "Si, hacer Check Out",
		cancelButtonText: "No, cancelar",
		closeOnConfirm: false,
		closeOnCancel: false

	}, function ( isConfirm ) {
		if ( isConfirm )
		{
			$.ajax({
				type:    	"GET",
				url:     	"ws/reservas/checkout/"+idreg,
				dataType: 	"json",
				data: 		{},
				success: function ( respuesta )
				{
					if( respuesta.resultado )
					{
						swal("Listo!", "Se realizo Check Out", "success");
						setTimeout( function(){ ratPack.refresh(); }, 300 );
					}
					else
					{
						console.log(respuesta);
						swal("Cancelado!", "Ocurrio un error al intentar hacer Check Out", "error");
					}
				}, 
				error: function ( error )
				{
					console.log(error);
					swal("Cancelado!", "Ocurrio un error al intentar hacer Check Out", "error");
				}
			});
		}
		else
		{
			swal("Cancelado!", "Ya no se hico Check Out", "error");
		}
	});

	if ( e != null)
		e.preventDefault();
}

function llenarClientes( e ) 
{
	$.ajax({
		type:'GET',
		url:'ws/clienteselect',
		dataType:'json',
		data:{},
		success:function( respuesta )
		{
			if ( respuesta.resultado )
			{
				var clientes = respuesta.registros;
				selectClientes = $('#select-cliente-c').selectize({
					delimiter: ',',
        			persist: false,
        			create: true,
        			options: clientes,
        			searchField: ['nombres'],
        			labelField: "nombres",
        			valueField: "id"
        			
				});
			}
			else
			{
				selectClientes = $('#select-cliente-c').selectize();
				nGen('warning', 'fa fa-times-circle', 'Espera..!', respuesta.mensaje, 'topRight');
			}
		},
		error: function( error )
		{
			console.log(error);
		}
	});

	if ( e != null )
		e.preventDefault();
}

function llenarTarifas( e ) 
{
	$.ajax({
		type:'GET',
		url:'ws/tarifas',
		dataType:'json',
		data:{},
		success:function( respuesta )
		{
			if ( respuesta.resultado )
			{
				tarifas = respuesta.registros;
				selectTarifas = $('#select-tarifa-c').selectize({
					delimiter: ',',
        			persist: false,
        			create: true,
        			options: tarifas,
        			searchField: ['nombre'],
        			labelField: "nombre",
        			valueField: "id"
        			
				});
			}
			else
			{
				selectTarifas = $('#select-tarifa-c').selectize();
				nGen('warning', 'fa fa-times-circle', 'Espera..!', respuesta.mensaje, 'topRight');
			}
		},
		error: function( error )
		{
			console.log(error);
		}
	});

	if ( e != null )
		e.preventDefault();
}

function llenarCargos( e ) 
{
	$.ajax({
		type:'GET',
		url:'ws/cargos',
		dataType:'json',
		data:{},
		success:function( respuesta )
		{
			if ( respuesta.resultado )
			{
				cargos = respuesta.registros;
				selectCargos = $('#select-cargo').selectize({
					delimiter: ',',
        			persist: false,
        			create: true,
        			options: cargos,
        			searchField: ['nombre'],
        			labelField: "nombre",
        			valueField: "id"
        			
				});
			}
			else
			{
				selectCargos = $('#select-cargo').selectize();
				nGen('warning', 'fa fa-times-circle', 'Espera..!', respuesta.mensaje, 'topRight');
			}
		},
		error: function( error )
		{
			console.log(error);
		}
	});

	if ( e != null )
		e.preventDefault();
}

function mostrarModalCrearCliente( e )
{
	$("#modal-crear").modal('show');

	if ( e != null )
		e.preventDefault();
}

function mostrarModalHabitaciones( e )
{
	if ($("#form-crear-reserva #entrada").val() != "" && $("#form-crear-reserva #salida").val() != "")
	{
		$("#modal-habitaciones").modal('show');
		llenarTablaHabitaciones();
	}
	else
	{
		nGen('warning', 'fa fa-times-circle', 'Espera..!', 'Selecciona una fecha de Inicio y Fin', 'topRight');
	}

	if ( e != null )
		e.preventDefault();
}

function crearCliente( e )
{
	$.ajax({
		type: 		"POST",
		url: 		"ws/clientes",
		dataType: 	"json",
		data: 		$(this).serialize(),
		success: function( respuesta )
		{
			if (respuesta.resultado )
			{
				nGen('success', 'fa fa-check-circle', 'Exito..!', respuesta.mensaje, 'topRight');
				$("#modal-crear").modal("hide");
				selectClientes[0].selectize.addOption({value:respuesta.registros.id, text:respuesta.registros.nombres + ' ' + respuesta.registros.apellidos}); //option can be created manually or loaded using Ajax
				selectClientes[0].selectize.addItem(respuesta.registros.id);
			}
			else
			{
				nGen('warning', 'fa fa-times-circle', 'Espera..!', respuesta.mensaje , 'topRight');		
			}
		},
		error: function( error )
		{
			nGen('warning', 'fa fa-times-circle', 'Espera..!', error, 'topRight');
		}
	});

	if ( e != null )
		e.preventDefault();
		e.stopPropagation();
}

function crearReserva( e )
{

	if (arrayHabitaciones.length == 0) 
	{
		nGen('warning', 'fa fa-times-circle', 'Espera..!', 'Debes seleccionar una habitación como minimo', 'topRight');
	}
	else
	{
		var idcliente = $("#select-cliente-c").val();
		var idtarifa = $("#select-tarifa-c").val();
		var entrada = $("#form-crear-reserva #entrada").val() + " 15:00:00";
		var salida = $("#form-crear-reserva #salida").val() + " 13:00:00";
		var adultos = $("#form-crear-reserva #adultos").val();
		var ninos = $("#form-crear-reserva #ninos").val();
		var habitacionesSend = JSON.stringify(idHabitaciones);
		var dias = $("#dias").val();
		$.ajax({
			type: 		"POST",
			url: 		"ws/reservas",
			dataType: 	"json",
			data: 		{idcliente: idcliente, idtarifa: idtarifa, dias: dias, entrada: entrada, salida: salida, adultos: adultos, ninos: ninos, habitaciones: habitacionesSend},
			success: function( respuesta )
			{
				if (respuesta.resultado )
				{
					nGen('success', 'fa fa-check-circle', 'Exito..!', respuesta.mensaje, 'topRight');
					setTimeout( function(){ ratPack.refresh(); }, 300 );
				}
				else
				{
					console.log(respuesta);
					nGen('warning', 'fa fa-times-circle', 'Espera..!', respuesta.mensaje , 'topRight');		
				}
			},
			error: function( error )
			{
				console.log(error);
				nGen('warning', 'fa fa-times-circle', 'Espera..!', error, 'topRight');
			}
		});
	}


	if ( e != null )
		e.preventDefault();
		e.stopPropagation();
}

function anularReserva( e )
{
	var idreg = $(e.target).closest('a').attr('idreg');

	swal({
		title: "¿Estas seguro?",
		text:  "Anularas la Reservación",
		type:  "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmbuttonText: "Si, Anularla",
		cancelButtonText: "No, cancelar",
		closeOnConfirm: false,
		closeOnCancel: false

	}, function ( isConfirm ) {
		if ( isConfirm )
		{
			$.ajax({
				type:    	"GET",
				url:     	"ws/reservas/anular/"+idreg,
				dataType: 	"json",
				data: 		{},
				success: function ( respuesta )
				{
					if( respuesta.resultado )
					{
						swal("Listo!", "El Reservación fue anulada", "success");
						setTimeout( function(){ ratPack.refresh(); }, 300 );
					}
					else
					{
						swal("Cancelado!", "Ocurrio un error al intentar anular", "error");
					}
				}, 
				error: function ( error )
				{
					swal("Cancelado!", "Ocurrio un error al intentar anular", "error");
				}
			});
		}
		else
		{
			swal("Cancelado!", "Ya no se Anulo la Reservación", "error");
		}
	});

	if ( e != null)
		e.preventDefault();
}

function mostrarViewDetalle( e )
{
	$("#detallecuenta").removeClass('hide');
	var idreg = $(e.target).closest('a').attr('idreg');
	$("#tabla-cuenta").dataTable().fnClearTable();
	reservaObservando = idreg;
	$.ajax({
		type:    	"GET",
		url:     	"ws/reservas/cuenta/ver/"+idreg,
		dataType: 	"json",
		data: 		{},
		success: function ( respuesta )
		{
			if( respuesta.resultado )
			{
				var detallecuenta = respuesta.registros;
				var xIndex = 0;
				var total = 0.0;
				$.each( detallecuenta, function(index, value){

					total += value.debe; 
					$("#form-abonos #idcuenta").val(value.idcuenta);
					$("#form-pagar #idcuenta").val(value.idcuenta);
					$("#form-cargo #idcuenta").val(value.idcuenta);


					if($("#idtipousuario").val() == 1)
					{
						var acciones = "";

							
						if (value.debe == value.costo) 
						{
							acciones = "<div class='btn-tollbar' role='toolbar'>" +
									"<div class='btn-group' role='group'>" +
										"<a href='#' idreg='"+value.id+"' indexReg='"+xIndex+"' class='btn btn-default btn-sm btn-eliminar-cargo'><i class='fa fa-trash-o'></i> Eliminar</a> " +
									"</div>" +
								"</div>";
						}
						

						var estado;
						if(value.pagado == 0)
						{
							if ( parseFloat(value.debe) < parseFloat(value.costo) ) 
							{
								estado = "<label class='label label-warning'>Abonado</label>";
									
							}
							else
							{
								estado = "<label class='label label-danger'>Sin Pagar</label>";
							}		
						}
						else
						{
							acciones = "";
							estado = "<label class='label label-primary'>Pagado</label>";	
						}

						$("#tabla-cuenta").dataTable().fnAddData([
							++xIndex,
							value.cargo,
							value.descripcion,
							value.costo,
							value.debe,
							estado,
							acciones
						]);
					}
					else
					{
						var estado;
						if(value.pagado == 0)
						{
							if ( parseFloat(value.debe) < parseFloat(value.costo) ) 
							{
								estado = "<label class='label label-warning'>Abonado</label>";
									
							}
							else
							{
								estado = "<label class='label label-danger'>Sin Pagar</label>";
							}		
						}
						else
						{
							estado = "<label class='label label-primary'>Pagado</label>";	
						}

						$("#tabla-cuenta").dataTable().fnAddData([
							++xIndex,
							value.cargo,
							value.descripcion,
							value.costo,
							value.debe,
							estado
						]);
					}


				});

				$(".total-detalle").text("Q." + total);
			}
			else
			{
				nGen('warning', 'fa fa-times-circle', 'Espera..!', respuesta.mensaje, 'topRight');
			}
		}, 
		error: function ( error )
		{
			console.log(error);
			nGen('warning', 'fa fa-times-circle', 'Espera..!', error, 'topRight');
		}
	});

	if ( e != null )
		e.preventDefault();
}

function cargarTablaDetalle( idReservacion )
{
	$("#tabla-cuenta").dataTable().fnClearTable();
	$.ajax({
		type:    	"GET",
		url:     	"ws/reservas/cuenta/ver/"+idReservacion,
		dataType: 	"json",
		data: 		{},
		success: function ( respuesta )
		{
			if( respuesta.resultado )
			{
				var detallecuenta = respuesta.registros;
				var xIndex = 0;
				var total = 0.0;
				$.each( detallecuenta, function(index, value){
					total += value.debe;

					$("#form-abonos #idcuenta").val(value.idcuenta);
					$("#form-pagar #idcuenta").val(value.idcuenta);

					if($("#idtipousuario").val() == 1)
					{
						var acciones = "";

							
						if (value.debe == value.costo) 
						{
							acciones = "<div class='btn-tollbar' role='toolbar'>" +
									"<div class='btn-group' role='group'>" +
										"<a href='#' idreg='"+value.id+"' indexReg='"+xIndex+"' class='btn btn-default btn-sm btn-eliminar-cargo'><i class='fa fa-trash-o'></i> Eliminar</a> " +
									"</div>" +
								"</div>";
						}

						var estado;
						if(value.pagado == 0)
						{
							if ( parseFloat(value.debe) < parseFloat(value.costo) )
							{
								estado = "<label class='label label-warning'>Abonado</label>";
							}
							else
							{
								estado = "<label class='label label-danger'>Sin Pagar</label>";
							}
							
						}
						else
						{
							acciones = "";
							estado = "<label class='label label-primary'>Pagado</label>";	
						}

						$("#tabla-cuenta").dataTable().fnAddData([
							++xIndex,
							value.cargo,
							value.descripcion,
							value.costo,
							value.debe,
							estado,
							acciones
						]);
					}
					else
					{
						var estado;
						if(value.pagado == 0)
						{
							if ( parseFloat(value.debe) < parseFloat(value.costo) ) 
							{
								estado = "<label class='label label-warning'>Abonado</label>";
									
							}
							else
							{
								estado = "<label class='label label-danger'>Sin Pagar</label>";
							}
						}
						else
						{
							estado = "<label class='label label-primary'>Pagado</label>";	
						}

						$("#tabla-cuenta").dataTable().fnAddData([
							++xIndex,
							value.cargo,
							value.descripcion,
							value.costo,
							value.debe,
							estado
						]);
					}
				});

				if (total == 0) 
				{
					
				}

				$(".total-detalle").text("Q." + total);
			}
			else
			{
				console.log(respuesta);
				nGen('warning', 'fa fa-times-circle', 'Espera..!', respuesta.mensaje, 'topRight');
			}
		}, 
		error: function ( error )
		{
			console.log(error);
			nGen('warning', 'fa fa-times-circle', 'Espera..!', error, 'topRight');
		}
	});
}

function ocultarViewDetalle( e )
{
	$("#detallecuenta").addClass('hide');

	if ( e != null )
		e.preventDefault();
}

function mostrarModalAbonos( e )
{
	$("#modal-abonos").modal('show');

	obtenerCorrelativosRecibo();

	if ( e != null )
		e.preventDefault();
}

function obtenerCorrelativosRecibo( )
{
	$.ajax({
		type:    	"GET",
		url:     	"ws/correlativos",
		dataType: 	"json",
		data: 		{},
		success: function ( respuesta )
		{
			$("#modal-pagar #recibo").val("Factura: " + respuesta.registros[0].numero);
			$("#modal-abonos #recibo").val("Recibo: " + respuesta.registros[1].numero);
		}, 
		error: function ( error )
		{
		}
	});
}

function realizarAbono( e )
{
	if ($("#form-abonos #efectivo").val() == "0" && $("#form-abonos #cheque").val() == "0" && $("#form-abonos #numcheque").val() == "-" && $("#form-abonos #tcredito").val() == "0" && $("#form-abonos #tdebito").val() == "0")
	{
		nGen('warning', 'fa fa-times-circle', 'Espera..!', 'Debes indicar un metodo de pago y su cantidad', 'topRight');
	}
	else
	{
		$.ajax({
			type:    	"GET",
			url:     	"ws/reservas/cuenta/abonar",
			dataType: 	"json",
			data: 		$(this).serialize(),
			success: function ( respuesta )
			{
				if( respuesta.resultado )
				{
					$("#modal-abonos").modal('hide');
					nGen('success', 'fa fa-times-circle', 'Espera..!', respuesta.mensaje, 'topRight');
					cargarTablaDetalle( reservaObservando );
					obtenerCorrelativosRecibo();
				}
				else
				{
					nGen('warning', 'fa fa-times-circle', 'Espera..!', respuesta.mensaje, 'topRight');
				}
			}, 
			error: function ( error )
			{
				nGen('warning', 'fa fa-times-circle', 'Espera..!', error, 'topRight');
			}
		});
	}

	if ( e != null )
		e.preventDefault();
		e.stopPropagation();
}

function mostrarModalPagar( e )
{
	$("#modal-pagar").modal('show');

	obtenerCorrelativosRecibo();

	if ( e != null )
		e.preventDefault();
}

function realizarPago( e )
{
	if ($("#form-pagar #efectivo").val() == "0" && $("#form-pagar #cheque").val() == "0" && $("#form-pagar #numcheque").val() == "-" && $("#form-pagar #tcredito").val() == "0" && $("#form-pagar #tdebito").val() == "0")
	{
		nGen('warning', 'fa fa-times-circle', 'Espera..!', 'Debes indicar un metodo de pago y su cantidad', 'topRight');
	}
	else
	{
		$.ajax({
			type:    	"GET",
			url:     	"ws/reservas/cuenta/pagar",
			dataType: 	"json",
			data: 		$(this).serialize(),
			success: function ( respuesta )
			{
				if( respuesta.resultado )
				{
					$("#modal-pagar").modal('hide');
					nGen('success', 'fa fa-times-circle', 'Espera..!', respuesta.mensaje, 'topRight');
					cargarTablaDetalle( reservaObservando );
					obtenerCorrelativosRecibo();
				}
				else
				{
					nGen('warning', 'fa fa-times-circle', 'Espera..!', respuesta.mensaje, 'topRight');
				}
			}, 
			error: function ( error )
			{
				nGen('warning', 'fa fa-times-circle', 'Espera..!', error, 'topRight');
			}
		});
	}

	if ( e != null )
		e.preventDefault();
		e.stopPropagation();
}

function eliminarCargo( e )
{
	var idreg = $(e.target).closest('a').attr('idreg');

	swal({
		title: "¿Estas seguro?",
		text:  "Eliminaras el Cargo de la Cuenta",
		type:  "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmbuttonText: "Si, Eliminar",
		cancelButtonText: "No, cancelar",
		closeOnConfirm: false,
		closeOnCancel: false

	}, function ( isConfirm ) {
		if ( isConfirm )
		{
			$.ajax({
				type:    	"DELETE",
				url:     	"ws/reservas/cargos/eliminar/"+idreg,
				dataType: 	"json",
				data: 		{},
				success: function ( respuesta )
				{
					if( respuesta.resultado )
					{
						swal("Listo!", "El cargo fue eliminado", "success");
						cargarTablaDetalle( reservaObservando );
					}
					else
					{
						swal("Cancelado!", "Ocurrio un error al intentar eliminar", "error");
					}
				}, 
				error: function ( error )
				{
					swal("Cancelado!", "Ocurrio un error al intentar eliminar", "error");
				}
			});
		}
		else
		{
			swal("Cancelado!", "Ya no se Elimino el Cargo", "error");
		}
	});

	if ( e != null)
		e.preventDefault();
}

function mostrarModalCargo( e )
{
	$("#modal-agregar-cargo").modal('show');

	if ( e != null )
		e.preventDefault();
}

function actualizarCostoCargo( e )
{
	var indexCargo = $(this).val();
	var cargo = $.grep(cargos, function(e){ return e.id == indexCargo; });
	$("#form-cargo #precio").val(cargo[0].costo);
	actualizarTotal();
}


function actualizarTotal()
{
	var precio = $("#form-cargo #precio").val();
	var cantidad = 	$("#form-cargo #cantidad").val();
	var total = precio * cantidad;
	$("#form-cargo #total").val(total);
}

function crearCargo( e )
{

	$.ajax({
		type:    	"POST",
		url:     	"ws/reservas/cuenta/cargo",
		dataType: 	"json",
		data: 		$(this).serialize(),
		success: function ( respuesta )
		{
			if( respuesta.resultado )
			{
				$("#modal-agregar-cargo").modal('hide');
				nGen('success', 'fa fa-times-circle', 'Espera..!', respuesta.mensaje, 'topRight');
				cargarTablaDetalle( reservaObservando );
			}
			else
			{
				nGen('warning', 'fa fa-times-circle', 'Espera..!', respuesta.mensaje, 'topRight');
			}
		}, 
		error: function ( error )
		{
			nGen('warning', 'fa fa-times-circle', 'Espera..!', error, 'topRight');
		}
	});

	if ( e != null )
		e.preventDefault();
		e.stopPropagation();
}

function nGen(type, icono, titulo, text, layout)
{
	var n = noty({
		text: "<div class='activity-item'> <i class='"+icono+"' + 'text-alert'></i> <div class='activity'> <span>"+titulo+"</span> <span> "+text+" </span> </div> </div> ",
		type: type,
		timeout: 3000,
		dismissQueue: true,
        layout: layout,
        closeWith: ['click'],
        theme: 'MatMixNoty',
        maxVisible: 10,
		animation: {
            open: 'noty_animated bounceInRight',
            close: 'noty_animated bounceOutRight',
            easing: 'swing',
            speed: 500
        }
	});
}

var ThisLoad;
$(".w-reload").click( function(){
	ThisLoad = $(this);
	$(this).parents(".widget-head")
		.next(".widget-container").mask("Cargando..");
	setTimeout(UnMask, 1500);
});

function UnMask() {
	ThisLoad.parents(".widget-head")
		.next(".widget-container").unmask();
}


