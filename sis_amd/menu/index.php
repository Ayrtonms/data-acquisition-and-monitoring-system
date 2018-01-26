<?php
	include('security.php');
?>

<html>
	<head>
		<meta charset="UTF-8">
		<title>Monitoring System</title>
		<link rel="stylesheet" type="text/css"  href="css/style.css" />
	</head>

	<script>
		function usuarios(){
			document.getElementById('frame').setAttribute('src', 'cns_usuarios.php');
		}

		function t_mensal(){
			document.getElementById('frame').setAttribute('src', 'temp/filtro_mensal.php');
		}

		function t_data(){
			document.getElementById('frame').setAttribute('src', 'temp/filtro_data.php');
		}

		function t_perso(){
			document.getElementById('frame').setAttribute('src', 'temp/filtro_perso.php');
		}

		function t_hora(){
			document.getElementById('frame').setAttribute('src', 'temp/filtro_horario.php');
		}

		function l_mensal(){
			document.getElementById('frame').setAttribute('src', 'lum/filtro_mensal.php');
		}

		function l_data(){
			document.getElementById('frame').setAttribute('src', 'lum/filtro_data.php');
		}

		function l_perso(){
			document.getElementById('frame').setAttribute('src', 'lum/filtro_perso.php');
		}

		function l_hora(){
			document.getElementById('frame').setAttribute('src', 'lum/filtro_horario.php');
		}
	</script>

	<body>
		<nav>
			<ul class="menu">
				<li><a href="#">Temperature</a>
					<ul>
						<li onclick='t_mensal();'><a href="#">Basic monthly filter</a></li>
						<li onclick='t_data();'><a href="#">Basic date filter</a></li>
						<li onclick='t_hora();'><a href="#">Hourly averages</a></li>
						<li onclick='t_perso();'><a href="#">Custom filter</a></li>
					</ul>
				</li>
				<li><a href="#">Luminosity</a>
					<ul>
						<li onclick='l_mensal();'><a href="#">Basic monthly filter</a></li>
						<li onclick='l_data();'><a href="#">Basic date filter</a></li>
						<li onclick='l_hora();'><a href="#">Hourly averages</a></li>
						<li onclick='l_perso();'><a href="#">Custom filter</a></li>
					</ul>
				</li>
				<li onclick='usuarios();'><a href="#">Users</a></li>
				<li><a href="index.php?exit=1">Exit</a></li>

			</ul>
		</nav>

		<iframe id='frame' class='frame'></iframe>
	</body>
</html>

<?php
	if(isset($_GET['exit'])){
		session_destroy();
		header('Location: ../index.php');
	}
?>
