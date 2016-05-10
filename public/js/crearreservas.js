$(document).ready( iniciar );
var selectClientes;
var selectTarifas;
var habitaciones;
var tarifas;
var arrayHabitaciones = new Array();
var numeroHabitaciones = new Array();
var idHabitaciones = new Array();
var reservaObservando;
function iniciar( e )
{	
	$(".w-add").on("click", mostrarModalHabitaciones);
	$(".w-add-c").on("click", mostrarModalCrearCliente);
	$("#form-crear-reserva").on("submit", crearReserva);
	$("#form-crear-cliente").on("submit", crearCliente);
	$("#tabla-habitaciones").delegate(".btn-seleccionar", "click", seleccionarHabitacion);
	$("#tabla-reservaciones").delegate(".btn-eliminar-habitacion", "click", eliminarHabitacion);

	$('#select-crear').selectize();
	$('#selects-crear').selectize();

	$("#form-crear-reserva #adultos").val(0);
	$("#form-crear-reserva #ninos").val(0);
	llenarClientes();
	llenarTarifas();

	$('.input-date-picker').datepicker({
		format: 'yyyy-mm-dd',
		orientation: "bottom auto"
	});

	$('.input-date-picker-fin').datepicker({
		format: 'yyyy-mm-dd',
		orientation: "bottom auto"
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
	var tarifa = $.grep(tarifas, function(e){ return e.id == indexTarifa; });
	habitacion['precio'] = tarifa[0].precio;
	habitacion['costo'] = tarifa[0].precio * parseInt($("#dias").val());
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
        			create: false,
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
				console.log(tarifas);
				selectTarifas = $('#select-tarifa-c').selectize({
					delimiter: ',',
        			persist: false,
        			create: false,
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
				selectClientes[0].selectize.destroy()
				/*selectClientes[0].selectize.addOption({value:respuesta.registros.id, text:respuesta.registros.nombres + ' ' + respuesta.registros.apellidos}); //option can be created manually or loaded using Ajax
				selectClientes[0].selectize.addItem(respuesta.registros.id);*/
				llenarClientes();

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


