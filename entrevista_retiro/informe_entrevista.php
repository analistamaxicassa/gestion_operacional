<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Informe gráfico de entrevistas de retiro.</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../CSS/panel.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather:700i">
  </head>
  <body>
    <div class="container">
      <div class="col-md-12">
				<div class="max-panel panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Maxicassa</h3>
					</div>
					<div class="panel-body">
            <h2><i class="fa fa-bar-chart"> - Informes gráficos</i></h2>
            <form role="form" action="informe_grafico.php" method="post">
              <fieldset>
                <div class="row">
                  <div class="col-md-3 mb-3">
                    <label for="sociedad">Empresa</label>
                    <select class="form-control" name="sociedad" required>
                      <option value="">Seleccione una empresa</option>
                      <option value="10-">Maxicassa</option>
                      <option value="20-">Tu Cassa</option>
                      <option value="40-">Innovapack SAS</option>
                      <option value="50-">Ceramigres</option>
                      <option value="60-">Pegomax</option>
                      <option value="70-">Temporal</option>
                    </select>
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="ciudad">Ciudad</label>
                    <select class="form-control" name="ciudad" required>
                      <option value="">Seleccione una ciudad</option>
                      <option value="BOGOTA">Bogotá</option>
                      <option value="MEDELLIN">Medellín</option>
                      <option value="VILLAVICENCIO">Villavicencio </option>
                      <option value="MALAMBO">Malambo</option>
                      <option value="BARRANCA">Barrancabermeja</option>
                      <option value="NEIVA">Neiva</option>
                      <option value="PEREIRA">Pereira</option>
                      <option value="BARRANQUILLA">Barranquilla</option>
                      <option value="VALLEDUPAR">Valledupar</option>
                      <option value="MAGANGUE">Magangué</option>
                      <option value="IBAGUE">Ibagué</option>
                      <option value="CALI">Cali</option>
                      <option value="CARTAGENA">Cartagena</option>
                      <option value="MANIZALES">Manizales</option>
                      <option value="CUNDINAMARCA">Cundinamarca</option>
                      <option value="TULUA">Tuluá</option>
                      <option value="SOACHA">Soacha</option>
                      <option value="ARMENIA">Armenia</option>
                      <option value="CUCUTA">Cúcuta</option>
                      <option value="SOGAMOSO">Sogamoso</option>
                      <option value="SANTA MARTA">Santa Marta</option>
                      <option value="RIOHACHA">Riohacha</option>
                      <option value="MONTERIA">Montería</option>
                      <option value="BUCARAMANGA">Bucaramanga</option>
                      <option value="TUNJA">Tunja</option>
                    </select>
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="fechaInicial">Inicio</label>
                    <input type="date" class="form-control" name="fechaInicial" required>
                    <small id="fechaInicialHelp" class="form-text text-muted">Ubiqué la fecha inicial en el calendario.</small>
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="fechaFinal">Fin</label>
                    <input type="date" class="form-control" name="fechaFinal" required>
                    <small id="fechaFinalHelp" class="form-text text-muted">Ubiqué la fecha final en el calendario.</small>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-4 mb-3">
                    <label for="cargoEmpleado">Cargo</label>
                    <select multiple class="form-control" name="cargoEmpleado[]">
                      <option value="101">Administrador de sala</option>
                      <option value="118">Auxiliar administrativo</option>
                      <option value="114">Asesor comercial externo</option>
                      <option value="115">Asesor comercial</option>
                      <option value="138">Coordinador de bodega</option>
                      <option value="121">Auxiliar de bodega</option>
                    </select>
                  </div>
                  <div class="col-md-8 mb-3">
                    <label for="tipoGrafica">Filtrar grafica</label>
                    <select class="form-control" name="tipoGrafica" required>
                      <option value="">Seleccione un filtro para su gráfica</option>
                      <option value="1">Retiros por mes</option>
                      <option value="2">Retiros por motivo</option>
                      <option value="3">Aspectos positivos</option>
                      <option value="4">Aspectos a mejorar</option>
                    </select>
                    <small id="fechaFinalHelp" class="form-text text-muted">Ubiqué el tipo de grafica que desea obtener.</small>
                  </div>
                </div>

                <button class="btn btn-primary" type="submit">Graficar</button>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
