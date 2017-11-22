<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <title>.::Vendor. Ares::..</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
                
         <script src="public/js/jquery-1.10.2.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="public/js/funciones.js"></script>
        <style>	
	    /* responsive text queries */
		 @media screen and (max-width: 992px) {
			p,.btn,input,div,span,h4 {
			 font-size: 95%;
			}
			h1 {
			 font-size: 24px;  
			}
			h2 {
			 font-size: 22px;  
			}
			h3 {
			 font-size: 18px;  
			}
		 }
		 
		 @media screen and (max-width: 768px) {
			p,.btn,input,div,span,h4 {
			 font-size: 90%;
			}
			h1 {
			 font-size: 20px;  
			}
			h2 {
			 font-size: 18px;  
			}
			h3 {
			 font-size: 16px;  
			}
		 }
	</style>
    </head>
    <body>

              <div class="panel-body">
                
               
                
                <p>
                <a href="agregar.php" class="btn btn-success"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar</a>
                </p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Ruta</th>
                            <th>Fecha inicio ruta</th>
                            <th>Fecha final ruta</th>
                            <th>Estado</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                            <tr>
                                <td><?php echo $dato->ruta?></td>
                                <td><?php echo $dato->fini?></td>
                                <td><?php echo $dato->ffin?></td>
                                <td><?php echo $dato->estado?></td>
                                <td><?php echo $dato->observaciones?></td>
                                <td><a href="../rutero_programado/index.php?id_ruta=<?php echo $dato->id_ruta?>&ruta=<?php echo $dato->ruta?>">Generar ruta</a></td>
                                <td><a href="../rutero_programado/gestion_ruta.php?id_ruta=<?php echo $dato->id_ruta?>&ruta=<?php echo $dato->ruta?>">Gestionar ruta</a></td>
                                <td>
                                <td>
                                    <a href="editar.php?id=<?php echo $dato->id_ruta?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                    <a href="javascript:void(0);" onclick="eliminar('eliminar.php?id=<?php echo $dato->id_ruta?>');"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                </td>
                            </tr>
                           
                    </tbody>
                </table>
                
              </div>
            </div>
        </div>

    </body>
    </html>

