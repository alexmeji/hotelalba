$(document).ready( iniciar );

function iniciar( e )
{	
	$("#form-editar").on("submit", editarRegistro);
	$("#tabla-registros").delegate(".btn-editar", "click", verModalEditar);

	llenarTabla();

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
}

function llenarTabla( e ) 
{
	$.ajax({
		type:'GET',
		url:'ws/correlativos',
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

					acciones = "<div class='btn-tollbar' role='toolbar'>" +
									"<div class='btn-group' role='group'>" +
										"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-editar'><i class='fa fa-pencil-square-o'></i> Editar</a> " +
									"</div>" +
								"</div>";


					$("#tabla-registros").dataTable().fnAddData([
						++xIndex,
						value.nombre,
						value.numero,
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

function verModalEditar( e )
{
	var idreg = $(e.target).closest("a").attr("idreg");
	$.ajax({
		type: 		"GET",
		url: 		"ws/correlativos/"+idreg,
		dataType: 	"json",
		data: 		{},
		success: function ( respuesta )
		{
			if (respuesta.resultado)
			{
				$("#modal-editar").modal("show");
				$("#modal-editar #form-editar #nombre").val(respuesta.registros.nombre);
				$("#modal-editar #form-editar #numero").val(respuesta.registros.numero);
				$("#modal-editar #form-editar #idactualizar").val(respuesta.registros.id);
			}
			else
			{
				nGen('warning', 'fa fa-times-circle', 'Espera..!', respuesta.mensaje , 'topRight');		
			}
		},
		error: function ( error )
		{
			nGen('warning', 'fa fa-times-circle', 'Espera..!', error, 'topRight');
		}
	});

	if ( e != null)
		e.preventDefault();
}

function editarRegistro( e )
{
	console.log($(this).serialize());
	var idreg = $("#modal-editar #form-editar #idactualizar").val();
	$.ajax({
		type: 		"PUT",
		url: 		"ws/correlativos/"+idreg,
		dataType: 	"json",
		data: 		$(this).serialize(),
		success: function( respuesta )
		{
			if (respuesta.resultado )
			{
				nGen('success', 'fa fa-check-circle', 'Exito..!', respuesta.mensaje, 'topRight');
				$("#modal-editar").modal("hide");
				setTimeout( function(){ ratPack.refresh(); }, 300 );
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


