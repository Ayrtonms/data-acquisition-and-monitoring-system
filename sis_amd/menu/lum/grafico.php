<html>
	<head>
		<meta charset="UTF-8">
		<link rel='stylesheet' type='text/css'  href='../css/grafico.css' />
		<script type="text/javascript" src="../fusioncharts/fusioncharts/js/fusioncharts.js"></script>
		<script type="text/javascript" src="../fusioncharts/fusioncharts/js/fusioncharts.charts.js"></script>
	</head>

	<?php
		include('busca.php');
		include("../fusioncharts/fusioncharts.php");

		if(!isset($_GET['mod']) || !isset($_GET['qtd']) || !isset($_GET['pag']) || !isset($_GET['eixo'])){
			print '<script>alert("INVALID PARAMETERS!");window.top.location="../index.php";</script>';

		}
		else{
			$mod = $_GET['mod'];
			$dados = '';
			$pag = $_GET['pag'];
			$qtd = $_GET['qtd'];
			$total = 0;

			$onc1 = '';
			$onc2 = '';

			if($mod == 0){
				if(isset($_GET['d1']) && isset($_GET['d2'])){
					$res = grafico1($_GET['d1'], $_GET['d2'], $qtd, $pag);

					if($res[1] == 0){
						echo "Empty chart<br>";
						exit();
					}

					$dados = gen_data1($res[0], $_GET['eixo']);
					$total = $res[1];
				}
				else{
					print '<script>alert("INVALID PARAMETERS!");window.top.location="../index.php";</script>';
				}
			}
			else if($mod == 1){
				if(isset($_GET['d1']) && isset($_GET['d2']) && isset($_GET['agr'])){
					if($_GET['agr'] == 1){
						$dias = listar_dias($_GET['d1'], $_GET['d2']);

						if(count($dias) == 0){
							echo "Empty chart";
							exit();
						}

						$medias = medias_d($dias);
						$res = filtro_medias($dias, $medias, $qtd, $pag);
						$dados = gen_data2($res);
						$total = count($dias);
					}
					else if($_GET['agr'] == 2){
						$meses = listar_meses($_GET['d1'], $_GET['d2']);

						if(count($meses) == 0){
							echo "Empty chart";
							exit();
						}

						$medias = medias_m($meses);
						$res = filtro_medias($meses, $medias, $qtd, $pag);
						$dados = gen_data2($res);
						$total = count($meses);
					}
					else{
						print '<script>alert("INVALID PARAMETERS!");window.top.location="../index.php";</script>';
					}
				}
				else{
					print '<script>alert("INVALID PARAMETERS!");window.top.location="../index.php";</script>';
				}
			}
			else if($mod == 2){
				if(isset($_GET['d1']) && isset($_GET['d2']) && isset($_GET['h1']) && isset($_GET['h2']) && isset($_GET['v1']) && isset($_GET['v2'])){
					$res = grafico2($_GET['d1'], $_GET['d2'], $_GET['h1'], $_GET['h2'], $_GET['v1'], $_GET['v2'], $qtd, $pag);

					if($res[1] == 0){
						echo "Empty chart";
						exit();
					}

					$dados = gen_data1($res[0], $_GET['eixo']);
					$total = $res[1];
				}
				else{
					print '<script>alert("INVALID PARAMETERS!");window.top.location="../index.php";</script>';
				}
			}
			else if($mod == 3){
				if(isset($_GET['d1']) && isset($_GET['d2']) && isset($_GET['h1']) && isset($_GET['h2']) && isset($_GET['v1']) && isset($_GET['v2']) && isset($_GET['agr'])){
					if($_GET['agr'] == 1){
						$dias = listar_dias($_GET['d1'], $_GET['d2']);

						if(count($dias) == 0){
							echo "Empty chart";
							exit();
						}

						$medias = medias_d($dias, $_GET['h1'], $_GET['h2'], $_GET['v1'], $_GET['v2']);
						$res = filtro_medias($dias, $medias, $qtd, $pag);
						$dados = gen_data2($res);
						$total = count($dias);
					}
					else if($_GET['agr'] == 2){
						$meses = listar_meses($_GET['d1'], $_GET['d2']);

						if(count($meses) == 0){
							echo "Empty chart";
							exit();
						}

						$medias = medias_m($meses, $_GET['h1'], $_GET['h2'], $_GET['v1'], $_GET['v2']);
						$res = filtro_medias($meses, $medias, $qtd, $pag);
						$dados = gen_data2($res);
						$total = count($meses);
					}
					else{
						print '<script>alert("INVALID PARAMETERS!");window.top.location="../index.php";</script>';
					}
				}
				else{
					print '<script>alert("INVALID PARAMETERS!");window.top.location="../index.php";</script>';
				}
			}
			else if($mod == 4){
				if(isset($_GET['date']) && isset($_GET['v1']) && isset($_GET['v2'])){
					$horas = listar_horas($_GET['date']);

					if(count($horas) == 0) {
						echo "Empty chart";
						exit();
					}

					$medias = medias_h($_GET['date'], $horas, $_GET['v1'], $_GET['v2']);
					$res = filtro_medias($horas, $medias, $qtd, $pag);
					$dados = gen_data2($res);
					$total = count($horas);
				}
				else{
					print '<script>alert("INVALID PARAMETERS!");window.top.location="../index.php";</script>';
				}
			}
			else{
				print '<script>alert("INVALID PARAMETERS!");window.top.location="../index.php";</script>';
			}

			unset($_GET['pag']);

			if($pag != 0){
				$onc1 = 'onclick=\'window.location="grafico.php?' . http_build_query($_GET) . '&pag=' . ($pag - 1) . '";\'';
			}

			if(($pag + 1) * $_GET['qtd'] < $total){
				$onc2 = 'onclick=\'window.location="grafico.php?' . http_build_query($_GET) . '&pag=' . ($pag + 1) . '";\'';
			}
	?>

	<body>
		<table class='tabela'>
			<tr><td><div id='chart' class='chart'></div></td></tr>
			<tr><td><center>
				<button class='b1' <?php print $onc1; ?>><-</button>
				<button class='b2' <?php print $onc2; ?>>-></button>
			</center></td></tr>
		</table>
	</body>

	<?php
			$chart = new FusionCharts(
				"line", 
				"ex1" , 
				"600", 
				"400", 
				"chart", 
				"json", 
				'{  
				"chart":
				{  
				"caption":"Collected data - Luminosity",
				"setAdaptiveYMin": "1"
				},
				"data":' . $dados . '
			}');

			$chart->render();
		}
	?>
</html>