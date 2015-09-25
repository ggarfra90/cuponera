<?php
session_start();

include_once __DIR__ . '/../cuponera/util/Util.php';
include_once __DIR__ . '/controlador/core/ControladorParametros.php';
include_once __DIR__ . '/modelo/cuponera/Usuario.php';
include_once __DIR__ . '/modelo/cuponera/PerfilUsuario.php';
include_once __DIR__ . '/controlador/cuponera/AlmacenIndexControlador.php';
include_once __DIR__ . '/controlador/cuponera/UsuarioControlador.php';
include_once __DIR__ . '/modeloNegocio/cuponera/PerfilNegocio.php';
//include_once __DIR__ . '/vistas/com/template/partHeadBase.php';
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = utf8_decode(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
    $password = utf8_encode(filter_var($_POST["password"], FILTER_SANITIZE_STRING));

    $usu = new UsuarioControlador();

    $responsew = $usu->validateLoginWP($username, $password);
    if ($responsew[0]['vout_exito_wp'] == '0') {
        $response = $usu->validateLogin($username, $password);
        if ($response[0]['vout_exito_dato'] == '0') {
            header("location:login.php?error=notfound");
            exit;
        }
        if ($response[0]['vout_exito_clave'] != '0') {
            if ($response[0]['vout_exito_inac'] == '0') {
                header("location:login.php?error=esi");
                exit;
            }
            if ($response[0]['vout_exito_elimi'] == '0') {
                header("location:login.php?error=ese");
                exit;
            }
            header("location:index.php");
            exit;
        } else {
            header("location:login.php?error=si");
            exit;
        }
    }
    if ($responsew[0]['vout_exito_cup'] == '0') {
        header("location:login.php?error=cw");
        exit;
    }
    if ($responsew[0]['vout_exito_inac'] == '0') {
        header("location:login.php?error=esi");
        exit;
    }
    if ($responsew[0]['vout_exito_elimi'] == '0') {
        header("location:login.php?error=ese");
        exit;
    }
    if ($responsew[0]['vout_exito'] == '1') {
        header("location:index.php");
        exit;
    }
    if ($responsew[0]['vout_exito_dato'] == '0') {
        header("location:login.php?error=notfoundS");
        exit;
    }
} else {
    ?>

    <html lang="en">

        <!-- Mirrored from coderthemes.com/velonic/admin/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 14 May 2015 23:17:26 GMT -->
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="description" content="">
            <meta name="author" content="">

            <link rel="shortcut icon" href="admin/img/favicon_1.ico">

            <title>Netafim - RRHH</title>

            <!-- Google-Fonts -->
            <!-- Bootstrap core CSS -->
            <link href="vistas/libs/imagina/css/bootstrap.min.css" rel="stylesheet">
            <!--<link href="admin/css/bootstrap.min.css" rel="stylesheet">-->
            <link href="vistas/libs/imagina/css/bootstrap-reset.css" rel="stylesheet">

            <!--Animation css-->
            <link href="vistas/libs/imagina/css/animate.css" rel="stylesheet">

            <!--Icon-fonts css-->
            <link href="vistas/libs/imagina/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
            <link href="vistas/libs/imagina/assets/ionicon/css/ionicons.min.css" rel="stylesheet" />

            <!--Morris Chart CSS -->
            <!--<link rel="stylesheet" href="admin/assets/morris/morris.css">-->


            <!-- Custom styles for this template -->
            <link href="vistas/libs/imagina/css/style.css" rel="stylesheet">
            <link href="vistas/libs/imagina/css/helper.css" rel="stylesheet">
            <link href="vistas/libs/imagina/css/style-responsive.css" rel="stylesheet" />
            <style>
                .panel.panel-color .panel-heading {
                    padding: 10px 30px;
                }
/*                        @font-face {
            font-family: "Ubuntu";
            src: url("Ubuntu-Title-webfont.eot") format("eot"),
                 url("Ubuntu-Title-webfont.woff") format("woff"),
                 url("Ubuntu-Title-webfont.ttf") format("truetype"),
                 url("Ubuntu-Title-webfont.svg#UbuntuTitle") format("svg");
}*/
  html, body {
        height: 100%;
        width: 100%;
        padding: 0;
        margin: 0;
    }
 
    #full-screen-background-image {
        z-index: -999;
        width: 100%;
        height: auto;
        position: fixed;
        top: 0;
        left: 0;
    }

            </style>
        </head>

        <body>
                <img class="img-responsive" alt="full screen background image" src="images/web_bglogin.png" id="full-screen-background-image" /> 

            <div class="wrapper-page animated fadeInDown ">
                <div class="panel panel-color " style="background-color:#00457c;border-radius: 10px;opacity: 0.95;"  >
                    <div class="panel-heading" > 
                        <h3><strong class="text-white m-r-5">INICIA SESIÓN</strong></h3>
                    </div> 
                    <form class="form-horizontal m-t-40" action="login.php" method="POST">
                        <p class="text-justify text-white p-b-10 " style="margin-top: -15px;">Bienvenido, ingrese sus credenciales para acceder a la red corporativa.</p>

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="username" placeholder="Usuario" value="">
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="password" placeholder="Contrase&ntilde;a" value="">
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <div class="col-xs-12">
                                <input class="btn btn-purple w-md" type="submit" value="Ingresar" style="background-color:#dc911b;border-radius: 0px;" ></input>
                            </div>
                        </div>
                    </form>

    <?php
    if (isset($_GET['error'])) {
        echo("<br />\n");
        if ($_GET['error'] == "si") {

            echo("<font color='red'>Error: Usuario y/o contrase&ntilde;a erronea.Por favor verificar sus datos de ingreso.</font>\n");
        } elseif ($_GET['error'] == "notfound") {
            echo("<font color='red'>Error: Usuario y/o contrase&ntilde;a no registrados, no tiene permisos para ingresar.</font>\n");
        } elseif ($_GET['error'] == "cw") {
            echo("<font color='red'>Error: Contrase&ntilde;a incorrecta</font>\n");
        } elseif ($_GET['error'] == "esi") {
            echo("<font color='red'>Error: su cuenta esta inactiva, no tiene permisos para ingresar.</font>\n");
        } elseif ($_GET['error'] == "ese") {
            echo("<font color='red'>Error: su cuenta fue eliminada, no tiene permisos para ingresar.</font>\n");
        } elseif ($_GET['error'] == "notfoundS") {
            echo("<font color='red'>Error: Usuario no registrado no tiene permisos para ingresar</font>\n");
        }
    }
    ?>
                </div>
            </div>

                    <?php
                    include_once __DIR__ . '/vistas/com/template/partBodyMainContentEnds.php';
                    ?>
            <script src="<?php echo Configuraciones::url_base(); ?>vistas/index.js"></script>

        </body>
    </html>

            <?php
        }
        ?>
