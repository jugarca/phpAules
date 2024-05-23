<?php
ob_start();
if (isset($params['error'])) { 
	echo $params['error'] ;
}else {?>

<div class="container-fluid">
			<div class="container">
				<div class="row">				
					<div class="col-md-3">
						<p></p>
					</div>
					<div class="col-md-6">
						<h1 class="p-2"><?php echo $params['servicio']['titulo']?></h1>
						<table border="1" cellpadding="10">
							<tr align="center">
								<th>Título</th>
								<td><?php echo $params['servicio']['titulo']; ?></td>
							</tr>
							<tr align="center">
								<th>Descripcion</th>
								<td><?php echo $params['servicio']['descripcion']; ?></td>
							</tr>
							<tr align="center">
								<th>Precio</th>
								<td><?php echo $params['servicio']['precio']; ?></td>
							</tr>
							<tr align="center">
								<th>Tipo</th>
								<td><?php echo $params['servicio']['tipo']; ?></td>
							</tr>
                            <tr align="center">
								<th>Foto</th>
								<td><?php echo $params['servicio']['foto_servicio']; ?></td>
							</tr>
						</table>
					</div>
					<div class="col-md-3">	            									
				</div>
                <div class="row">	
                    <h1>Solicitud del Servicio</h1>
                    <form action="index.php?ctl=solicitoServicio" method="post">
                        <textarea name="mensajeCorreo" id="" cols="30" rows="10"></textarea>
                        <button type="submit" name="solicitarServicio">Solicitar</button>
                    </form>
                </div>
			</div>
	</div>

    
<?php } $contenido = ob_get_clean();
include 'layout.php' ?>