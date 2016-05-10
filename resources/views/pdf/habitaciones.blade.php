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
			<span>Usuario: {{ Session::get('nombres') }}</span>
			<span>Tipo Documento: Habitaciones</span>
		</div>
		<div id="main-content">
			@if($tipo == 1)
				<center><h3>Huéspedes en Casa</h3></center>
				<table id="tabla-datos" style="width: 100%;">
					<thead>
						<tr>
							<th width="10%">Habitación</th>
							<th width="46%">Cliente</th>
							<th width="22%">Entrada</th>
							<th width="22%">Salida</th>
						</tr>
					</thead>
					<tbody>
						@foreach($estan as $item)
							<tr>
								<td>{!! $item["habitacion"]["numero"] !!}</td>
								<td>{!! $item["cliente"]["nombres"]." ".$item["cliente"]["apellidos"] !!}</td>
								<td>{!! $item["entrada"] !!}</td>
								<td>{!! $item["salida"] !!}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<center><h3>Llegadas</h3></center>
				<table id="tabla-datos" style="width: 100%;">
					<thead>
						<tr>
							<th width="10%">Habitación</th>
							<th width="46%">Cliente</th>
							<th width="22%">Entrada</th>
							<th width="22%">Salida</th>
						</tr>
					</thead>
					<tbody>
						@foreach($entran as $item)
							<tr>
								<td>{!! $item["habitacion"]["numero"] !!}</td>
								<td>{!! $item["cliente"]["nombres"]." ".$item["cliente"]["apellidos"] !!}</td>
								<td>{!! $item["entrada"] !!}</td>
								<td>{!! $item["salida"] !!}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<center><h3>Salidas</h3></center>
				<table id="tabla-datos" style="width: 100%;">
					<thead>
						<tr>
							<th width="10%">Habitación</th>
							<th width="46%">Cliente</th>
							<th width="22%">Entrada</th>
							<th width="22%">Salida</th>
						</tr>
					</thead>
					<tbody>
						@foreach($salen as $item)
							<tr>
								<td>{!! $item["habitacion"]["numero"] !!}</td>
								<td>{!! $item["cliente"]["nombres"]." ".$item["cliente"]["apellidos"] !!}</td>
								<td>{!! $item["entrada"] !!}</td>
								<td>{!! $item["salida"] !!}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@elseif($tipo == 2)
				<center><h3>Huéspedes en Casa</h3></center>
				<table id="tabla-datos" style="width: 100%;">
					<thead>
						<tr>
							<th width="10%">Habitación</th>
							<th width="46%">Cliente</th>
							<th width="22%">Entrada</th>
							<th width="22%">Salida</th>
						</tr>
					</thead>
					<tbody>
						@foreach($estan as $item)
							<tr>
								<td>{!! $item["habitacion"]["numero"] !!}</td>
								<td>{!! $item["cliente"]["nombres"]." ".$item["cliente"]["apellidos"] !!}</td>
								<td>{!! $item["entrada"] !!}</td>
								<td>{!! $item["salida"] !!}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@elseif($tipo == 3)
				<center><h3>Llegadas</h3></center>
				<table id="tabla-datos" style="width: 100%;">
					<thead>
						<tr>
							<th width="10%">Habitación</th>
							<th width="46%">Cliente</th>
							<th width="22%">Entrada</th>
							<th width="22%">Salida</th>
						</tr>
					</thead>
					<tbody>
						@foreach($entran as $item)
							<tr>
								<td>{!! $item["habitacion"]["numero"] !!}</td>
								<td>{!! $item["cliente"]["nombres"]." ".$item["cliente"]["apellidos"] !!}</td>
								<td>{!! $item["entrada"] !!}</td>
								<td>{!! $item["salida"] !!}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@elseif($tipo == 4)
				<center><h3>Salidas</h3></center>
				<table id="tabla-datos" style="width: 100%;">
					<thead>
						<tr>
							<th width="10%">Habitación</th>
							<th width="46%">Cliente</th>
							<th width="22%">Entrada</th>
							<th width="22%">Salida</th>
						</tr>
					</thead>
					<tbody>
						@foreach($salen as $item)
							<tr>
								<td>{!! $item["habitacion"]["numero"] !!}</td>
								<td>{!! $item["cliente"]["nombres"]." ".$item["cliente"]["apellidos"] !!}</td>
								<td>{!! $item["entrada"] !!}</td>
								<td>{!! $item["salida"] !!}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif
		</div>
	</body>
</html>
