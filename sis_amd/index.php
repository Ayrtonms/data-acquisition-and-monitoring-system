<html>
	<head>
		<meta charset="UTF-8">
		<title>Login - Monitoring System</title>
		<link rel="stylesheet" type="text/css"  href="style.css" />
	</head>
	<body>
		<div class="login">
			<form target="_self" method="POST">
				<center><B>Monitoring System</B></center>
				<p class='login_l'>Username:</p>
				<input class='login_f' type="text" name="login" />
				<p class='senha_l'>Password:</p>
				<input class='senha_f' type="password" name="senha" />
				<center><input class="botao" type="submit" value="OK" /></center>
			</form>
		</div>
	</body>
</html>

<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	if(isset($_POST['login']) && isset($_POST['senha'])){
		$senha = $_POST['senha'];
		$a = true;

		$serv = 'localhost';
		$log = 'root';
		$pass = '123';
		$banco = 'sis_amd';

		$db = new mysqli($serv, $log, $pass, $banco);
		if($db->connect_error){
			header('Location: index.php?err=1');
		}

		$sql = $db->prepare('select id_usuario from usuarios where login = ? and senha = ?');
		$sql->bind_param('ss', $_POST['login'], $senha);
		$sql->execute();

		$sql->bind_result($usu);
		if(!$sql->fetch()){
			$a = false;
		}

		$sql->free_result();
		$db->close();

		if($a){
			session_start();
			$_SESSION['logado'] = true;
			header('Location: menu/index.php');
		}
		else{
			print '<script>alert("ACCESS DENIED!");</script>';
		}
	}

	if(isset($_GET['err'])){
		print '<script>alert("ERROR CONNECTING TO THE DATABASE!");</script>';
	}
?>
