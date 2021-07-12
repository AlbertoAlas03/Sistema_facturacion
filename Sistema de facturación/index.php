<!--Validación de datos en php y en la base de datos-->
<?php

$alert = '';

session_start();
if (!empty($_SESSION['active'])) {
	
	header('location: sistema/');
}else{


if(!empty($_POST)){

	if(empty($_POST['usuario']) || empty($_POST['Clave'])){

		$alert = 'Ingrese su usuario y contraseña';

	}else{


		require_once "conexion.php";
		$user = mysqli_real_escape_string($conection,$_POST['usuario']);
		$pass = md5(mysqli_real_escape_string($conection,$_POST['Clave']));


		$query = mysqli_query($conection,"SELECT * FROM usuario WHERE usuario = '$user' AND Clave = '$pass'");
		$result = mysqli_num_rows($query);

		if ($result > 0) {

			$data = mysqli_fetch_array($query);
			$_SESSION['active'] = true;
			$_SESSION['idUser'] = $data['idusuario'];
			$_SESSION['nombre'] = $data['nombre'];
			$_SESSION['email'] = $data['email'];
			$_SESSION['user'] = $data['usuario'];
			$_SESSION['rol'] = $data['rol'];

			header('location: sistema/');

		
			
		}else{

			$alert = 'El usuario o la contraseña son incorrectos';
			session_destroy();
		}
	}
	
		
	
}

}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sistema de Facturación</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<section id="container">
	
<form action="" method="post">
	
<h3>Iniciar sesión</h3>
<img src="img/blog-wp-login.png" alt="Login">

<input type="text" name="usuario" placeholder="Usuario">
<input type="password" name="Clave" placeholder="Contraseña">
<div class="alert"><?php echo isset($alert)? $alert : '';?></div>
<input type="submit" value="Ingresar">

</form>

</section>

</body>
</html>
<!--Pagina de inicio de sesión--->