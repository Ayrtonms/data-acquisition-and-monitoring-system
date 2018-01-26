<?php
	include('security.php');

	if(isset($_GET['err'])){
		if($_GET['err'] == 1)
			print '<script>alert("ERROR CONNECTING TO THE DATABASE!");</script>';
		else if($_GET['err'] == 2)
			print '<script>alert("INVALID ACCESS!");</script>';

		print '<script>window.location="cns_usuarios.php";</script>';
	}
	else{
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel='stylesheet' type='text/css'  href='css/del_usuarios.css' />
	</head>
	<body>
		<?php
			if(!isset($_GET['id']))
					header('Location: del_usuarios.php?err=2');
			else{
				if(isset($_GET['del'])){
					$serv = 'localhost';
					$log = 'root';
					$pass = '123';
					$banco = 'sis_amd';

					$db = new mysqli($serv, $log, $pass, $banco);

					if($db->connect_error)
						header('Location: del_usuarios.php?err=1');

					$sql = 'delete from usuarios where id_usuario = ' . $_GET['id'];

					if(!mysqli_query($db, $sql))
						header('Location: del_usuarios.php?err=1');

					$db->close();

					print '<script>alert("Usuário deletado com sucesso!");</script>';
					print '<script>window.location="cns_usuarios.php";</script>';
				}
				else{
					$yes = '<input class="yes" type="button" onclick="window.location=\'del_usuarios.php?id=' . $_GET['id'] . '&del=1\';" value="Yes" />';
					$no = '<input class="no" type="button" onclick="window.location=\'cns_usuarios.php\';" value="No" />';
		?>
		<div class='delete'>
			<center><p class='label'><B>Do you really wish to delete this user?</B></p></center>
			<?php print $yes; ?>
			<?php print $no; ?>
		</div>
		<?php
				}
			}
		?>
	</body>
</html>
<?php
	}
?>
