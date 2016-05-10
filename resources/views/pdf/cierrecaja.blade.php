<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>PDF Costa Verde</title>
	</head>
	<style type="text/css">
		body{
			width: 100%;
			height: 100%;
			margin: 0;
		}

		#main-content{
			width: 100%;
			height: auto;
			margin-top: 150px;
		}

		.logo{
			width: 250px;
			height: 100px;
			display: inline-block;
			left: 0;
			position: absolute;
		}


		.datos-empresa{
			width: 250px;
			height: 120px;
			display: inline-block;
			right: 0;
			position: absolute;
		}

		.titulo-empresa{
			font-size: 22px;
		}

		span{
			display: block;
		}

		#tabla-datos > thead > tr > th {
			border-bottom: 1px solid black;
		}

		#tabla-datos > tbody > tr > td {
			text-align: center;
		}

		#tabla-datos > tbody > tr > td:first-child {
			text-align: left;
		}

		#tabla-datos > tbody > tr:last-child > td {
			border-bottom: 1px solid black;
		}

		#tabla-datos > tfoot > tr > td {
			text-align: center;
		}

		#tabla-datos > tfoot > tr:last-child > td {
			border-top: 1px solid black;
			border-bottom: 1px solid black;
		}

	</style>
	<body>
		<div class="logo">
			<h1>Hotel Alba</h1>
		</div>
		<div class="datos-empresa">
			<center>
				<span class="titulo-empresa"> Hotel Costa Verde </span>
			</center>
			<span>Mazatenango, Suchitequez</span>
			<span>Fecha: {{ date('d M Y') }}</span>
			<span>Hora: {{ date('H:i:s') }}</span>
			<span>Usuario: Alex Mejicanos</span>
			<span>Tipo Documento: Corte Caja</span>
		</div>
		<div id="main-content">
			<table id="tabla-datos" style="width: 100%;">
				<thead>
					<tr>
						<th width="35%">Descripcion</th>
						<th width="10%">Efectivo</th>
						<th width="10%">Credito</th>
						<th width="10%">Debito</th>
						<th width="10%">Cheque</th>
						<th width="10%">Nota</th>
					</tr>
				</thead>
				<tbody>
					@foreach($pagos as $item)
						<tr>
							<td>{!! $item["detalle_cuenta"]["descripcion"] !!}</td>
							<td>Q.{!! $item["efectivo"] !!}</td>
							<td>Q.{!! $item["tcredito"] !!}</td>
							<td>Q.{!! $item["tdebito"] !!}</td>
							<td>Q.{!! $item["cheque"] !!}</td>
							<td>Q.{!! $item["notacredito"] !!}</td>
						</tr>
					@endforeach

					@foreach($abonos as $item)
						<tr>
							<td>Recibo {!! $item["id"] !!}</td>
							<td>Q.{!! $item["efectivo"] !!}</td>
							<td>Q.{!! $item["tcredito"] !!}</td>
							<td>Q.{!! $item["tdebito"] !!}</td>
							<td>Q.{!! $item["cheque"] !!}</td>
							<td>Q.{!! $item["notacredito"] !!}</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td></td>
						<td>Q.{!! $resumen["efectivo"] !!}</td>
						<td>Q.{!! $resumen["tcredito"] !!}</td>
						<td>Q.{!! $resumen["tdebito"] !!}</td>
						<td>Q.{!! $resumen["cheque"] !!}</td>
						<td>Q.{!! $resumen["nota"] !!}</td>
					</tr>
					<tr>
						<td></td>
						<td>Q.{!! floatval($resumen["efectivo"]) !!}</td>
						<td>Q.{!! floatval($resumen["efectivo"]) + floatval($resumen["tcredito"]) !!}</td>
						<td>Q.{!! floatval($resumen["efectivo"]) + floatval($resumen["tcredito"]) + floatval($resumen["tdebito"]) !!}</td>
						<td>Q.{!! floatval($resumen["efectivo"]) + floatval($resumen["tcredito"]) + floatval($resumen["tdebito"]) + floatval($resumen["cheque"]) !!}</td>
						<td>Q.{!! floatval($resumen["efectivo"]) + floatval($resumen["tcredito"]) + floatval($resumen["tdebito"]) + floatval($resumen["cheque"]) + floatval($resumen["nota"]) !!}</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</body>
</html>
