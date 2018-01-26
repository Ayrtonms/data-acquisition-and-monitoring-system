<?php
	include('../security.php');
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel='stylesheet' type='text/css'  href='../css/filtro_mensal.css' />
	</head>
	<body>

		<?php
			if(isset($_POST['ano']) && isset($_POST['mes']) && isset($_POST['qtd']) && isset($_POST['eixo']) && isset($_POST['agr'])){
				$ano = $_POST['ano'];
				$mes = $_POST['mes'];
				$qtd = $_POST['qtd'];
				$eixo = $_POST['eixo'];
				$agr = $_POST['agr'];

				$err = 0;

				if($ano > date('Y')){
					print '<script>alert("INVALID YEAR!");</script>';
					$err++;
				}

				if(empty($qtd) || $qtd == 0){
					print '<script>alert("INVALID AMOUNT!");</script>';
					$err++;
				}

				if($qtd > 100){
					print '<script>alert("AMOUNT SPECIFIED IS TOO HIGH!");</script>';
					$err++;
				}

				if($agr != 0 && $eixo != 0){
					print '<script>alert("GROUP CHARTS REQUIRE DATE ON X AXIS!!");</script>';
					$err++;
				}

				if($err){
					print '<script>window.location="filtro_mensal.php";</script>';
				}

				$data1 = $ano . $mes . '01';
				$data2 = $ano . $mes . '31';

				if($agr == 0){
					$loc = 'Location: grafico.php?mod=0';
				}
				else{
					$loc = 'Location: grafico.php?mod=1&agr=' . $agr;
				}

				$loc .= '&d1=' . $data1 . '&d2=' . $data2 . '&qtd=' . $qtd . '&pag=0' . '&eixo=' . $eixo;

				if (!$err) header($loc);
			}
			else{
		?>

		<div class='filtro'>
			<center><B><p class='label'>Temperature: Basic monthly filter</B></p></center>
			<form target='_self' method='post'>
				<p class='ano_l'>Year:</p>
				<input class='ano_f' type='text' name='ano' onkeyup="this.value=this.value.replace(/[^\d]+/,'')" maxlength='4' />
				<p class='mes_l'>Month:</p>
				<select class='mes_f' name='mes'>
					<option value='01'>January</option>
					<option value='02'>February</option>
					<option value='03'>March</option>
					<option value='04'>April</option>
					<option value='05'>May</option>
					<option value='06'>June</option>
					<option value='07'>July</option>
					<option value='08'>August</option>
					<option value='09'>Semtember</option>
					<option value='10'>October</option>
					<option value='11'>November</option>
					<option value='12'>December</option>
				</select>
				<p class='qtd_l'>Amount of readings:</p>
				<input class='qtd_f' type='text' name='qtd' onkeyup="this.value=this.value.replace(/[^\d]+/,'')" maxlength='3' />
				<p class='eixo_l'>X axis:</p>
				<select class='eixo_f' name='eixo'>
					<option value='0'>Date</option>
					<option value='1'>Time</option>
				</select>
				<p class='agr_l'>Group by:</p>
				<select class='agr_f' name='agr'>
					<option value='0'>No grouping</option>
					<option value='1'>Days</option>
					<option value='2'>Months</option>
				</select>
				<input class='ok' type='submit'	value='OK' />
			</form>
		</div>

		<?php
			}
		?>

	</body>
</html>
