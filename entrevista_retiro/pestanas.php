

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>plantillaPestaña</title>
		<meta name="description" content="">
		<meta name="author" content="satur">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
	</head>
    <style>
	.contenedor {
			position: relative;
			width: 500px;
			height: 500px;
		}
		.cabecera {
			display: inline-block;
			text-decoration: none;
			padding: 10px;
			border: 2px solid;
			position: relative;
			color: black;
			border-top-left-radius: 5px;
			border-top-right-radius: 5px;
			transform: translateY(2px);
			z-index: 2;
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

	<body>
		<h1>Los satelites galeanos</h1>
<a href="https://youtu.be/mJAgRI_ESRA" target="_blank">
  Tutorial
</a><br /><br />
		<div class="contenedor">
			<a href="#" class="cabecera c-activa" onclick="mostrarPestana(0);">INFORMES MENSUALES</a>
			<div class="pestana p-activa">
				<p>
					Ío es el satélite galileano más cercano a Júpiter. Es el cuarto satélite por su tamaño, tiene la más alta densidad entre todos los satélites y, en proporción, la menor cantidad de agua entre todos los objetos conocidos del sistema solar. Fue descubierto por Galileo Galilei en 1610. Recibe su nombre de Ío, una de las muchas doncellas de las que Zeus se enamoró en la mitología griega, aunque inicialmente el nombre de Júpiter I como primer satélite de Júpiter según su cercanía al planeta.

Con un diamétro de 3600 kilómetros, es la tercera más grande de las lunas de Júpiter. En Ío hay planicies muy extensas y también cadenas montañosas, pero la ausencia de cráteres de impacto sugiere la juventud geológica de su superficie.1 Con más de 400 volcanes activos, es el objeto más activo geológicamente del sistema solar.2 Esta actividad tan elevada se debe al calentamiento por marea, que es la respuesta a la disipación de enormes cantidades de energía proveniente de la fricción provocada en el interior del satélite. Varios volcanes producen nubes de azufre y dióxido de azufre, que se elevan hasta los 500 km. Su superficie también posee más de cien montañas que han sido levantadas por la extrema compresión en la base de la corteza de silicatos del satélite. Algunas de estas montañas son más altas que el Monte Everest.
				</p>
			</div>
			<a href="#" class="cabecera" onclick="mostrarPestana(1);">INFORMES GRAFICOS</a>
			<div class="pestana">
				<p>
					Europa es el sexto satélite natural de Júpiter en orden creciente de distancia y el más pequeño de los cuatro satélites galileanos. Fue descubierto en 1610 por Galileo 1 y nombrado por Europa, la madre del rey Minos de Creta y amante de Zeus. Simon Marius sugirió el nombre tras su descubrimiento, pero este nombre, así como el nombre de los otros satélites galileanos, no fue de uso común hasta mediados del siglo XX. En gran parte de la literatura astronómica temprana aparece mencionado por su designación numeral romana, Júpiter II, o como el segundo satélite de Júpiter. Además de haber sido observado mediante telescopios terrestres, varias sondas espaciales (las primeras a principios de los años 1970) lo han examinado de cerca. Es el sexto satélite más grande del sistema solar.
				</p>
			</div>
			
		</div>
	</body>
</html>

plantillaPestaña.html
Mostrando plantillaPestaña.html.