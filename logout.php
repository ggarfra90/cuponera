<?php
session_start();
include_once __DIR__.'/modelo/cuponera/Usuario.php';
?>
<html>
<head>
	<meta http-equiv="Refresh" content="1;url=index.php">
	<style type="text/css">
		body{font-size: 10pt; font-family: arial,helvetica}
	</style>
</head>
<?php
//include 'datos_abrir_bd.php';
//sinclude_once __DIR__.'/../scm/util/Util.php';
include_once __DIR__ . '/../cuponera/util/Util.php';
//include_once __DIR__.'/modelo/cuponera/Usuario.php';
date_default_timezone_set("America/Lima");
ob_start();

?>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<div align="center">
<!--	<img src="images/gracias_por_tu_visita.jpg" align = middle><br>-->
	<p>Cerrando sesi&oacute;n <img src="images/waitbar18-0.gif"></p>
</div>
<?php
//session_start();
$id_usuario = $_SESSION['id_usuario'];
 $time = time();
 $fecha_fin =  date("y-m-d H:i:s", $time);
// Usuario::create()->updateFechaCookie($id_usuario,$fecha_fin);
session_destroy();
Util::borrarCookie();
//include 'datos_cerrar_bd.php';
?>

</html>