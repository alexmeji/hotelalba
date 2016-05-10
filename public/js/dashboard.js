$(document).ready( iniciar );

var numeroHabitaciones = new Array();

function iniciar( e )
{
	 $('#calendar').fullCalendar({
        lang: 'es',
        select: function(start, end, jsEvent, view) {
        	var allDay = !start.hasTime() && !end.hasTime();
        	var fInicio = moment(start).format('YYYY-MM-DD');
        	var fFin = moment(end - 1).format('YYYY-MM-DD');
        	verHabitacionesDisponibles(fInicio, fFin);
        },
        selectable: true,
        selectHelper: true,
        eventRender: function (event, element) {
            element.popover({
                title: event.title,
                html: true,
                placement: 'top',
                content: '<div>Habitacion: ' + event.description + '</div>' +
                    	 '<div>Entrada: ' + moment(event.start).format('MM/DD/YYYY hh:mm') + '</div>' +
                    	 '<div>Salida: ' + moment(event.end).format('MM/DD/YYYY hh:mm') + '</div>'
            });

            element.find('div.fc-title').html(element.find('div.fc-title').text());
            $('body').on('click', function (e) {
                if (!element.is(e.target) && element.has(e.target).length === 0 && $('.popover').has(e.target).length === 0)
                    element.popover('hide');
            });

            element.find('.fc-time').text(event.numhabitacion);
        },
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

	 llenarCalendario();
}

function verHabitacionesDisponibles( start, end, e )
{
	$("#tabla-habitaciones").dataTable().fnClearTable();
	$.ajax({
		type:'POST',
		url:'ws/habitacionesdisponibles',
		dataType:'json',
		data:{ habitaciones: JSON.stringify(numeroHabitaciones), entrada: start, salida: end },
		success:function( respuesta )
		{
			if ( respuesta.resultado )
			{
				//nGen('success', 'fa fa-check-circle', 'Exito..!', resultado.mensaje, 'topRight');
				var xIndex = 0;
				habitaciones = respuesta.registros;
				$.each( habitaciones, function(index, value){
					var acciones = "";

					/*acciones = "<div class='btn-tollbar' role='toolbar'>" +
									"<div class='btn-group' role='group'>" +
										"<a href='#' idreg='"+value.id+"' indexReg='"+xIndex+"' class='btn btn-default btn-sm btn-seleccionar'><i class='fa fa-check'></i> Seleccionar</a> " +
									"</div>" +
								"</div>";*/

					var estado;
					if(value.limpieza)
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
					var acciones = "" ;

					/*acciones = "<div class='btn-tollbar' role='toolbar'>" +
									"<div class='btn-group' role='group'>" +
										"<a href='#' idreg='"+value.id+"' indexReg='"+xIndex+"' class='btn btn-default btn-sm btn-seleccionar'><i class='fa fa-check'></i> Seleccionar</a> " +
									"</div>" +
								"</div>";*/

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

	$("#modal-habitaciones").modal('show');
	
	if ( e != null )
		e.preventDefault();
}

function llenarCalendario( e )
{
	$.ajax({
		type:'GET',
		url:'ws/reservas/calentario/todas',
		dataType:'json',
		data:{},
		success:function( respuesta )
		{
			if ( respuesta.resultado )
			{
				$.each(respuesta.registros, function(index, value) {

					if(value.anulada == 1)
					{
						var newEvent = {title: value.cliente.nombres + ' ' + value.cliente.apellidos , start: new Date(value.entrada), end: new Date(value.salida), numhabitacion: value.habitacion.numero, description: 'Num: ' + value.habitacion.numero + ' - ( ' + value.habitacion.tipohabitacion.nombre + ' )', color: '#d84315'};
						$("#calendar").fullCalendar('renderEvent', newEvent, true);
					}
					else if (value.checkout != "0000-00-00 00:00:00")
					{
						var newEvent = {title: value.cliente.nombres + ' ' + value.cliente.apellidos , start: new Date(value.entrada), end: new Date(value.salida), numhabitacion: value.habitacion.numero, description: 'Num: ' + value.habitacion.numero + ' - ( ' + value.habitacion.tipohabitacion.nombre + ' )', color: '#8bc34a'};
						$("#calendar").fullCalendar('renderEvent', newEvent, true);
					}
					else if (value.checkin != "0000-00-00 00:00:00")
					{
						var newEvent = {title: value.cliente.nombres + ' ' + value.cliente.apellidos , start: new Date(value.entrada), end: new Date(value.salida), numhabitacion: value.habitacion.numero, description: 'Num: ' + value.habitacion.numero + ' - ( ' + value.habitacion.tipohabitacion.nombre + ' )', color: '#4fc3f7'};
						$("#calendar").fullCalendar('renderEvent', newEvent, true);
					}
					else
					{
						var newEvent = {title: value.cliente.nombres + ' ' + value.cliente.apellidos , start: new Date(value.entrada), end: new Date(value.salida), numhabitacion: value.habitacion.numero, description: 'Num: ' + value.habitacion.numero + ' - ( ' + value.habitacion.tipohabitacion.nombre + ' )', color: '#455a64'};
						$("#calendar").fullCalendar('renderEvent', newEvent, true);
					}
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
