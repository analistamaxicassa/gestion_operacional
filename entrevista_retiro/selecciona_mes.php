<?php
//error_reporting(0);

//$sentencia = $_POST['sentencia'];

require_once('../conexionesDB/conexion.php');
$link=Conectarse_personal();

$antes = date('Y-m-d', strtotime('-15 day')) ;

//session_start();
//$cedulaent = $_SESSION['cedula'];

/*
	//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}


// consulta en queryx

echo $query = "SELECT emp.emp_codigo CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE
FROM EMPLEADO EMP
WHERE EMP.EMP_ESTADO = 'R' ORDER BY NOMBRE" ;

		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch();

		$cedular=$row['CEDULA'];
		$nombreemp=$row['NOMBRE'];
*/
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<style type='text/css'>
			tr:nth-child(odd) {
			    background-color:#f2f2f2;
			}
			tr:nth-child(even) {
				background-color: #fbfbfb;
			}
		</style>
	  <title>ENTREVISTA DE RETIRO</title>
	  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="../estilos.css">
	  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
	  <script>
	   	function informes(empresa, mes, concepto, anio)
		 	{ //alert(empresa);
				var parametros = {
				"empresa": empresa,
				"mes": mes,
				"concepto": concepto,
				"anio": anio,
				};
				 $.ajax({
	              data: parametros,
								//url: 'http://190.144.42.83:9090/plantillas/entrevista_retiro/listado_informes.php?mes='mes'&concepto='concepto'
				  url: 'listado_informes.php?empresa='+empresa+'&mes='+mes+'&concepto='+concepto+'&anio='+anio+'',
	              type: 'post',
	                 beforeSend: function ()
	                 {
	                      $("#informes").html("Validando, espere por favor...");
	                  },

	                  success: function (response)
	                  {
	                      $("#informes").html(response);
					//document.getElementById('tbl_ppal').style.display="none"
	                  }
				  });
			}
		</script>
		<script>
	    function graficos(sentencia)
			{ alert(sentencia);
				window.open("http://190.144.42.83:9090/plantillas/entrevista_retiro/graficos.php?sentencia=sentencia", "Graficador", "width=700, height=400")
			}
    </script>
		<script>
			function imprSelec(validador){
				var ficha=document.getElementById(validador);
			    var ventimp=window.open(' ','popimpr');
				ventimp.document.write(ficha.innerHTML);
				ventimp.document.close();
				ventimp.print();
				ventimp.close();
			}

		  function graficar(anioinf, empresag, tipo,ident)
			{ //alert (anioinf); alert (empresag);

				if (ident == 1 )
				{
					//window.open('grafico_retirosxmes.php?anioinf='+anioinf+'&tipo='+tipo+'&empresag='+empresag+'', "Graficador", "width=700, 			height=400")
          $.ajax({
            type: "POST",
            url: "grafico_retirosxmes.php",
            data: {anioinf:anioinf, tipo:tipo, empresag:empresag},
            success: function(){
                //alert("Ha sido ejecutada la acción.");
                window.location.assign("grafico_retirosxmes.php")
            }
        });
				}
				if (ident == 2)
				{
					window.open('grafico_retirosxmotivo.php?anioinf='+anioinf+'&tipo='+tipo+'&empresag='+empresag+'', "Graficador", "width=700, 			height=400")

				}
			   if (ident == 3)
				{
					window.open('grafico_factproductividad.php?anioinf='+anioinf+'&tipo='+tipo+'&empresag='+empresag+'', "Graficador", "width=700, 			height=400")

				}
				if (ident == 4)
				{
					window.open('grafico_aspmejorar.php?anioinf='+anioinf+'&tipo='+tipo+'&empresag='+empresag+'', "Graficador", "width=700, 			height=400")

				}
				if (ident == 5)
				{
					window.open('grafico_asppositivos.php?anioinf='+anioinf+'&tipo='+tipo+'&empresag='+empresag+'', "Graficador", "width=700, 			height=400")

				}
				else {}	;
			}
		</script>
		<style>
			.contenedor {
				position: relative;
				width: 1000px;
				height: 4500px;
				color:#036;
			}
			.cabecera {
				display: inline-block;
				text-decoration: none;
				padding: 20px;
				border: 2px solid;
				position: relative;
				color: #036;
				border-top-left-radius: 5px;
				border-top-right-radius: 5px;
				border-top-width:medium;

				transform: translateY(2px);
				z-index: 2;
				border: 3;
			}
			.pestana {
				position: absolute;
				border: 2px solid;
				height: 100%;
				visibility: hidden;
				opacity: 0;
				transition: visibility 1s, opacity 1s;
			}

			.p-activa {
				visibility: visible;
				opacity: 1;
			}
			.c-activa {
				border-bottom-color: white;
			}

			p{
				text-align: justify;
				padding: 10px;
			}
		</style>
		<script>
			function mostrarPestana(n){
				var pestanas = document.getElementsByClassName("pestana");
				var cabecera = document.getElementsByClassName("cabecera");
				for(i = 0; i<pestanas.length; i++){
					if(pestanas[i].className.includes("p-activa")){
						pestanas[i].className = pestanas[i].className.replace("p-activa", "");
						cabecera[i].className = cabecera[i].className.replace("c-activa", "");
						break;
					}
				}
				pestanas[n].className += " p-activa";
				cabecera[n].className += " c-activa";
			}
		</script>
	</head>
<body>

<br> <br> <br> <br><br> <br> <br>
<div class="contenedor">

  <a href="#" class="cabecera c-activa" onclick="mostrarPestana(0);">INFORMES MENSUALES</a>
  <div class="pestana p-activa">

  <table class="tablas">

    <tr>
      <td width="545">Seleccione  </td>
      <td width="443">

        <table width="391" border="0">
          <tr>
	        <td width="115">Empresa</td>
            <td width="115">Mes</td>
            <td width="112">Tipo</td>
            <td width="150">Año</td>
          </tr>
        </table>


        <label>
          <select name="empresa" id="empresa">
            <option value="">Seleccione</option>
             <option value="MAXICASSA">Maxicasa</option>
            <option value="TU CASSA">Tu cassa</option>
            <option value="PEGOMAX">Pegomax</option>
            <option value="INNOVAPACK SAS">Innova</option>
          </select>
        </label>
        <select name="mes" id="mes" >

    <option value="">seleccione... </option>
    <option value="01  ENERO">ENERO</option>
    <option value="02  FEBRERO">FEBRERO</option>
    <option value="03  MARZO">MARZO</option>
    <option value="04  ABRIL">ABRIL</option>
    <option value="05  MAYO">MAYO</option>
    <option value="06  JUNIO">JUNIO</option>
    <option value="07  JULIO">JULIO</option>
    <option value="08  AGOSTO">AGOSTO</option>
    <option value="09  SEPTIEMBRE">SEPTIEMBRE</option>
    <option value="10 OCTUBRE">OCTUBRE</option>
    <option value="11 NOVIEMBRE">NOVIEMBRE</option>
    <option value="12 DICIEMBRE">DICIEMBRE</option>
   <!-- <option value="EFM">1er TRIMESTRE</option>
    <option value="AMJ">2er TRIMESTRE</option>
    <option value="JAS">3er TRIMESTRE</option>
    <option value="OND">4er TRIMESTRE</option>
    <option value="1SEMESTRE">PRIMER SEMESTRE</option>
    <option value="2SEMESTRE">SEGUNDO SEMESTRE</option>-->
  </select>
          <label for="concepto"></label>
          <select name="concepto" size="1" id="concepto">
            <option value="">seleccione... </option>
            <option value="renuncia">renuncias</option>
            <option value="todos">todos</option>
          </select>
          <label for="anioinf"></label>
          <select name="anio" id="anio">
            <option value="">Seleccione..</option>
            <option value="2016">2016</option>
            <option value="2017">2017</option>
          </select>
          <input type="submit" name="generar" id="generar" value="Generar"
        onClick="informes($('#empresa').val(),$('#mes').val(),$('#concepto').val(),$('#anio').val()); return false;">
       </td>

    </tr>

</table>

<div id="informes" ></div>

</div>
	<a href="#" class="cabecera" onclick="mostrarPestana(1);">INFORMES GRÁFICOS</a>
	<div class="pestana">
	  <div class="contenedor">
	  	<h4 align="center">Seleccion de informe</h4>
			<table class="tablas" align="center" width="353" border="0">
				<tr>
		      <td width="107" rowspan="6">Año
		      <select name="anioinf" size="1" id="anioinf" graficador", "width=700, height=400")" >
		        <option value="">Seleccione..</option>
		        <option value="2017">2017</option>
		        <option value="2016">2016</option>
		      </select>
					</td>
					<td width="107" rowspan="6">Empresa
		        <select name="empresag" size="1" id="empresag" graficador", "width=700, height=400")" >
			        <option value="">Seleccione..</option>
							<option value="MAXICASSA">Maxicassa</option>
							<option value="TU CASSA">Tu cassa</option>
							<option value="PEGOMAX">Pegomax</option>
							<option value="INNOVAPACK SAS">Innova</option>
		      	</select>
					</td>
			    <td width="107" rowspan="6"><label for="tipo"></label>
			      Frecuencia
			      <select name="tipo" size="1" id="tipo">
			        <option>seleccione..</option>
			        <option value="between 0 AND 4">1er TRIMESTRE</option>
			        <option value="between 4 AND 7">2er TRIMESTRE</option>
			        <option value="between 7 AND 10">3er TRIMESTRE</option>
			        <option value="between 9 AND 13">4er TRIMESTRE</option>
			        <option value="<7">PRIMER SEMESTRE</option>
			        <option value=">6">SEGUNDO SEMESTRE</option>
			        <option value="<>222">ANUAL</option>
			        <option value="MES">MENSUAL</option>
			      </select>
			   	</td>
			    <td align="center">&nbsp;</td>
		    </tr>
			  <tr>
			    <td width="117" align="center"><label for="anio2">
			      <input type="submit" name="generarinf1" id="generarinf1" value="Inf de Retiros" onClick="graficar($('#anioinf').val(), $('#empresag').val(), $('#tipo').val(), 1)">
			    </label></td>
			  </tr>
			  <tr>
			    <td align="center"><input type="submit" name="generarinf2" id="generarinf2" value="Inf de Retiros x Motivo" onClick="graficar($('#anioinf').val(),$('#empresag').val(), $('#tipo').val(),2)"></td>
			  </tr>
			  <tr>
			    <td align="center"><input type="submit" name="generarinf3" id="generarinf3" value="Inf de factores de productividad" onClick="graficar($('#anioinf').val(),$('#empresag').val(), $('#tipo').val(),3)"></td>
			  </tr>
			  <tr>
			    <td align="center"><input type="submit" name="generarinf4" id="generarinf4" value="Inf de aspectos a mejorar" onClick="graficar($('#anioinf').val(),$('#empresag').val(), $('#tipo').val(),4)"></td>
			  </tr>
			  <tr>
			    <td align="center"><input type="submit" name="generarinf5" id="generarinf5" value="Inf de aspectos positivos" onClick="graficar($('#anioinf').val(), $('#empresag').val(), $('#tipo').val(),5)"></td>
			  </tr>
			</table>
		</div>
	</div>

   <input type="button" name="imprimir" id="prn" value="imprimir" onClick="imprSelec('validador');" >
 </div>
