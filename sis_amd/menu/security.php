<?php
	session_start();
	if(!isset($_SESSION['logado'])){
		print '<script>alert("ACCESS DENIED!");window.location="http://localhost/sis_amd/";</script>';
	}
?>