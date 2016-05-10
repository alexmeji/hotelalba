$(document).ready( iniciar );

var detalleorden = new Array();
var totalFactura = 0;
var totaliva = 0;
var totalfacturaiva = 0;
var totalProductos = 0;

function iniciar( e )
{	
	$(".w-add").on("click", mostrarIngresoCompra);
	$(".w-close").on("click", esconderIngresoCompra);
	$(".btn-guardar").on("click", guardarVenta);
	$("#tabla-registros").delegate(".btn-editar", "click", mostrarDetalleCompra);
	$("#tabla-registros").delegate(".btn-eliminar", "click", eliminarCompra);
	$(".buscar-sku").on("keyup", buscarSKU);
	$(".modificar-cantidad").on("keyup", actualizarSubTotal);
	$(".eliminar-tabla").on("click", eliminarDeLaTabla);

	llenarTabla();

	$('#select-sucursales-c').selectize();
	$('#select-proveedores-c').selectize();
	
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

	$('#tabla-productos').dataTable(
	{
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
		url:'ws/compras',
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
										"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-eliminar'><i class='fa fa-trash-o'></i> Eliminar</a> " +
									"</div>" +
								"</div>";

					$("#tabla-registros").dataTable().fnAddData([
						++xIndex,
						value.usuario.nombres,
						value.proveedor.nombre,
						value.sucursal.nombre,
						value.created_at,
						'Q.'+numberWithCommas(value.total),
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

function mostrarIngresoCompra( e )
{
	detalleorden = new Array();
	$("#ingreso-mercaderia").removeClass('hide');
	$(".btn-guardar").removeClass('hide');

	var select = $("#select-proveedores-c").selectize();
	var selectize = select[0].selectize; 
	selectize.setValue(0);

	var select2 = $("#select-sucursales-c").selectize();
	var selectize2 = select2[0].selectize; 
	selectize2.setValue(0);

	if ( e != null )
		e.preventDefault();
}

function esconderIngresoCompra( e )
{
	setTimeout(function(){ratPack.refresh();},300);
	if ( e != null )
		e.preventDefault();	
}

function mostrarDetalleCompra( e )
{
	var idreg = $(e.target).closest("a").attr("idreg");
	$.ajax({
		type: 		"GET",
		url: 		"ws/compras/"+idreg,
		dataType: 	"json",
		data: 		{},
		success: function ( respuesta )
		{
			if (respuesta.resultado)
			{
				$("#ingreso-mercaderia").removeClass('hide');
				$(".btn-guardar").addClass('hide');
				
				var select = $("#select-proveedores-c").selectize();
				var selectize = select[0].selectize; 
				selectize.setValue(respuesta.registros.idproveedor);

				var select2 = $("#select-sucursales-c").selectize();
				var selectize2 = select2[0].selectize; 
				selectize2.setValue(respuesta.registros.idsucursal);

				detalleorden = respuesta.registros.detalle;
				
				$.each( detalleorden, function(index, value){
					var acciones;

					/*acciones = "<div class='btn-tollbar' role='toolbar'>" +
									"<div class='btn-group' role='group'>" +
										"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-editar'><i class='fa fa-pencil-square-o'></i> Editar</a> " +
										"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-eliminar'><i class='fa fa-trash-o'></i> Eliminar</a> " +
									"</div>" +
								"</div>";*/
					acciones = "";

					$('#tabla-productos').dataTable().fnClearTable();
					$("#tabla-productos").dataTable().fnAddData([
						value.producto.sku,
						value.producto.nombre,
						value.producto.unidad.nombre,
						value.cantidad,
						'Q.'+numberWithCommas(value.precio),
						'Q.'+numberWithCommas(value.subtotal),
						acciones
					]);
				});

				$("#total-factura").text('Q.'+numberWithCommas(respuesta.registros.total));
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

function eliminarCompra( e )
{
	var idreg = $(e.target).closest('a').attr('idreg');

	swal({
		title: "¿Estas seguro?",
		text:  "Eliminaras la Compra",
		type:  "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmbuttonText: "Si, eliminarla",
		cancelButtonText: "No, cancelar",
		closeOnConfirm: false,
		closeOnCancel: false

	}, function ( isConfirm ) {
		if ( isConfirm )
		{
			$.ajax({
				type:    	"DELETE",
				url:     	"ws/compras/"+idreg,
				dataType: 	"json",
				data: 		{},
				success: function ( respuesta )
				{
					if( respuesta.resultado )
					{
						swal("Listo!", "La compra fue eliminada correctamente", "success");
						setTimeout( function(){ ratPack.refresh(); }, 300 );
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
			swal("Cancelado!", "Ya no se eliminara la Unidad", "error");
		}
	});

	if ( e != null)
		e.preventDefault();
}

function agregarNuevaFila( e )
{
	$("#tabla-productos >tbody").append("<tr><td class='sku'><input type='text' class='buscar-sku' placeholder='SKU' /></td><td class='descripcion'></td><td class='unidad'></td><td class='cantidad'><input type='text' class='modificar-cantidad' placeholder='Cantidad' value='0'/></td><td class='precio'></td><td class='subtotal'></td><td class='acciones'></td></tr>");
    $(".buscar-sku").on("keyup", buscarSKU);
   	$(".modificar-cantidad").on("keyup", actualizarSubTotal);

  	if( e != null)
  		e.preventDefault();
}

function eliminarDeLaTabla( e )
{
    $(e).parent().parent().remove();
	totalProductos--;

	actualizarTotalFactura( null );
	
	if( e != null)
		e.preventDefault();
}

function actualizarTotalFactura( e )
{
	var total = 0;
	var iva = "0." + "12";
	var moneda = "Q"
	$("#tabla-productos > tbody > tr.tiene-sku").each( function(key, item)
	{
		var fila = item;
    	var subtotal = $(fila).find(".subtotal").text();
    	total = total + parseFloat(subtotal);
	});

	totalFactura = total;
	totaliva = parseFloat(iva) * total;
	totalfacturaiva = totalFactura + totaliva;


	$("#total-factura").text(moneda + "." + numberWithCommas(total));
	$("#total-iva").text(moneda + "." + numberWithCommas(totaliva));
	$("#total-factura-iva").text(moneda + "." + numberWithCommas(totalfacturaiva));

	if( e != null)
		e.preventDefault();
}

function actualizarSubTotal( e )
{
	if( e.keyCode === 13)
	{
		var cantidad = parseInt($(this).val());
		var fila = $(this).parent().parent();
		var precio = parseInt($(fila).find(".precio").text());
		
		var subtotal = cantidad * precio;
		$(fila).find(".subtotal").text(subtotal);
		
		actualizarTotalFactura( null );
	}
	
	if( e != null)
		e.preventDefault();
}

function buscarSKU( e )
{
	var sku = $(this).val();
	var fila = $(this).parent().parent();
	var moneda = "Q.";
	
	if( e.keyCode === 13)
	{
		$.ajax(
		{
			type: "GET",
			url: "ws/productos/buscar/sku",
			dataType: "json",
			data: { sku: sku},
			success:function(result)
			{
				if(result.resultado)
				{
					
					$(fila).find(".descripcion").text(result.registros.nombre);
					$(fila).find(".unidad").text(result.registros.unidad.descripcion);
					$(fila).find(".precio").text(result.registros.venta);
					$(fila).find(".subtotal").text("0");
					$(fila).find(".modificar-cantidad").focus();
					$(fila).find(".acciones").append("<span class='trash-equipo' style='cursor:pointer;' onclick='eliminarDeLaTabla(this)'><i style='color: red;' class='fa fa-trash-o'></i></span>");
					$(fila).attr({idreg: result.registros.id});
					$(fila).attr({idtipo: 2});
					$(fila).addClass('tiene-sku');
					agregarNuevaFila( null );
					
				}
				else
				{
					nGen('warning', 'fa fa-check-circle', 'Espera..!', result.mensaje, 'topRight');
				}
			},
			error: function(error)
			{
				nGen('warning', 'fa fa-check-circle', 'Espera..!', error.description, 'topRight');
				console.error(error);
			}
		});
	}
	
	if ( e != null)
		e.preventDefault();
}

function eliminarProducto( e )
{
  	var objeto = (e===jQuery.Event? e.target : e);
  	var idindex= $(objeto).closest('a').attr('idindex');
  	detalleorden.splice(idindex,1);

  	$('#tabla-productos').dataTable().fnClearTable();

  	$.each(detalleorden, function(index, value){
      	$('#tabla-productos').dataTable().fnAddData([
          		value.nombreproducto,
          		value.cantidad,
          		value.precio,
          		value.subtotal,
          		"<span idindex='"+index+"' class='trash-equipo manita' style='cursor:pointer;' onclick='eliminarEquipoTabla(this)'><i style='color: red;' class='fa fa-trash-o'></i></span>"
		]);
  	});
}

function calcularSubtotal( e )
{
	var subtotal = parseInt( $("#cantidad").val() ) * parseFloat( $("#precio").val() );
	$("#subtotal").val( subtotal );
}

function guardarVenta( e )
{
	$("#tabla-productos > tbody > tr.tiene-sku").each( function(key, item)
	{
   		var fila = item;
    	var idproducto = $(fila).attr("idreg");
    	var cantidad = $(fila).find(".cantidad >.modificar-cantidad").val();
    	var precio = $(fila).find(".precio").text();
    	var subtotal = $(fila).find(".subtotal").text();
    
    	var item = new Object();
    	item["idproducto"] = idproducto;
    	item["cantidad"] = cantidad;
    	item["precio"] = precio;
    	item["subtotal"] = subtotal;
    
    	detalleorden.push(item);
	});

	console.log($("#select-proveedores-c").val(), $("#select-sucursales-c").val(), $("#total-factura").text(), "Termino");

	$.ajax(
	{
		type: "POST",
		url: "ws/compras",
		dataType: "json",
		data: { detalleorden: JSON.stringify(detalleorden), idproveedor: $("#select-proveedores-c").val(), idsucursal: $("#select-sucursales-c").val(), total: totalFactura } ,
		success:function(result)
		{
			if(result.resultado)
			{
				setTimeout(function(){ratPack.refresh();},300);
				nGen('success', 'fa fa-check-circle', 'Exito..!', result.mensaje, 'topRight');
			}
			else
			{
				console.log(result.registros);
				nGen('warning', 'fa fa-check-circle', 'Espera..!', result.mensaje, 'topRight');
				console.error(result.mensaje);
			}
		},
		error: function(error)
		{
			nGen('warning', 'fa fa-check-circle', 'Espera..!', error.description, 'topRight');			
			console.error(error);
		}
	});

	if( e != null )
		e.preventDefault();
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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


