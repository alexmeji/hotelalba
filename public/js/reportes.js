$(document).ready( iniciar );


function iniciar( e ) 
{

	$(".btn-cierrecajadia").on("click", verCirreCajaDia);
	$(".btn-reportehabitaciones").on("click", verReportHabitaciones);
	$(".btn-reporte-encasa").on("click", verReporteEnCasa);
	$(".btn-reporte-llegadas").on("click", verReporteLlegadas);
	$(".btn-reporte-salidas").on("click", verReporteSalidas);

	$('.input-date-picker').datepicker({
		format: 'yyyy-mm-dd',
		orientation: "bottom auto"
	});

	$('.input-date-picker-fin').datepicker({
		format: 'yyyy-mm-dd',
		orientation: "bottom auto"
	});
}

function verCirreCajaDia( e )
{

	var inicio = $("#inicio-cd").val();
	var fin = $("#fin-cd").val();
	window.open("ws/usuarios/caja/vercierre/pdf?inicio="+inicio+"&fin="+fin, "_blank");

	if (e != null)
	{
		e.preventDefault();
		e.stopPropagation();
	}
}

function verReportHabitaciones( e )
{
	var inicio = $("#inicio-rh").val();
	var fin = $("#inicio-rh").val();
	window.open("ws/habitaciones/reporte/pdf?inicio="+inicio+"&fin="+fin+"&tipo=1", "_blank");

	if (e != null)
	{
		e.preventDefault();
		e.stopPropagation();
	}	
}

function verReporteEnCasa( e )
{
	var inicio = $("#inicio-rh").val();
	var fin = $("#inicio-rh").val();
	window.open("ws/habitaciones/reporte/pdf?inicio="+inicio+"&fin="+fin+"&tipo=2", "_blank");

	if (e != null)
	{
		e.preventDefault();
		e.stopPropagation();
	}	
}

function verReporteLlegadas( e )
{
	var inicio = $("#inicio-rh").val();
	var fin = $("#inicio-rh").val();
	window.open("ws/habitaciones/reporte/pdf?inicio="+inicio+"&fin="+fin+"&tipo=3", "_blank");

	if (e != null)
	{
		e.preventDefault();
		e.stopPropagation();
	}	
}

function verReporteSalidas( e )
{
	var inicio = $("#inicio-rh").val();
	var fin = $("#inicio-rh").val();
	window.open("ws/habitaciones/reporte/pdf?inicio="+inicio+"&fin="+fin+"&tipo=4", "_blank");

	if (e != null)
	{
		e.preventDefault();
		e.stopPropagation();
	}	
}