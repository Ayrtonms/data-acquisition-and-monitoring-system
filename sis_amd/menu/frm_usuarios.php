<?php
	include('security.php');

	if(isset($_GET['err'])){
		if($_GET['err'] == 1)
			print '<script>alert("ERROR CONNECTING TO THE DATABASE!");</script>';
		else if($_GET['err'] == 2)
			print '<script>alert("INVALID VALUES SENT!");</script>';
		else if($_GET['err'] == 3)
			print '<script>alert("THE FIELDS CANNOT BE EMPTY!");</script>';
		else if($_GET['err'] == 4)
			print '<script>alert("THE PASSWORDS DO NOT MATCH!");</script>';

		print '<script>window.location="cns_usuarios.php";</script>';
	}
	else{
		if(isset($_POST['nome']) && isset($_POST['login']) && isset($_POST['senha']) && isset($_POST['confirmar'])){
			if(empty($_POST['nome']) || empty($_POST['login']) || empty($_POST['senha']) || empty($_POST['confirmar'])){
				header('Location: frm_usuarios.php?err=3');
			}

			if($_POST['senha'] != $_POST['confirmar']){
				header('Location: frm_usuarios.php?err=4');
			}

			$senha = $_POST['senha'];

			$serv = 'localhost';
			$log = 'root';
			$pass = '123';
			$banco = 'sis_amd';

			$db = new mysqli($serv, $log, $pass, $banco);
			$sql = '';
			$mod = '';

			if($db->connect_error)
				header('Location: frm_usuarios.php?err=1');

			if(isset($_POST['id'])){
				$sql = 'update usuarios set nome = \'' . $_POST['nome'] . '\', login = \'' . $_POST['login'] . '\', senha = \'' . $senha . '\' where id_usuario = ' . $_POST['id'];
				$mod = 'UPDATED';
			}
			else{
				$sql = 'insert into usuarios (nome, login, senha) values (\'' . $_POST['nome'] . '\', \'' . $_POST['login'] . '\', \'' . $senha . '\')';
				$mod = 'INSERTED';
			}

			if(!mysqli_query($db, $sql))
				header('Location: frm_usuarios.php?err=1');

			$db->close();

			print '<script>alert("USER ' . $mod . ' SUCCESSFULLY!");</script>';
			print '<script>window.location="cns_usuarios.php";</script>';
		}
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel='stylesheet' type='text/css'  href='css/frm_usuarios.css' />
	</head>
	<body>
		<?php
			$nome = '';
			$login = '';
			$id = '';
			$sub = '';
			$del = '';

			if(isset($_GET['id'])){
				$serv = 'localhost';
				$log = 'root';
				$pass = '123';
				$banco = 'sis_amd';

				$db = new mysqli($serv, $log, $pass, $banco);

				if($db->connect_error)
					header('Location: frm_usuarios.php?err=1');

				$sql = $db->prepare('select nome, login from usuarios where id_usuario = ?');
				$sql->bind_param('i', $_GET['id']);
				$sql->execute();
				$sql->bind_result($nome, $login);

				if(!$sql->fetch())
					header('Location: frm_usuarios.php?err=2');

				$sql->free_result();
				$db->close();

				$id = '<input type="hidden" name="id" value="' . $_GET['id'] . '" />';
				$sub = 'Update';
				$del = '<input class="del" type="button" onclick="window.location=\'del_usuarios.php?id=' . $_GET['id'] . '\';" value="Delete" />';
			}
			else $sub = 'Insert';
		?>
		<div class='form'>
			<center><p class='label'><B>User</B></p></center>
			<form target='_self' method='POST'>
				<?php print $id; ?>
				<p class='nome_l'>Name: </p>
				<?php print '<input class="nome_f" type="text" name="nome" value="' . $nome . '" />'; ?><br>
				<p class='login_l'>Username: </p>
				<?php print '<input class="login_f" class="login" type="text" name="login" value="' . $login . '" />'; ?><br>
				<p class='senha_l'>Password: </p><input class='senha_f' type='password' name='senha' /><br>
				<p class='conf_l'>Confirm: </p><input class='conf_f' type='password' name='confirmar' /><br>
				<?php print '<input class="sub" type="submit" value=' . $sub . ' />'; ?>
				<?php print $del; ?>
				<input class='back' type='button' onclick='window.location="cns_usuarios.php";' value='Back' />
			</form>	
		</div>
	</body>
</html>
<?php
	}
?>
