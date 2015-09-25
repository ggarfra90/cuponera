<?php
    include_once __DIR__.'/../../../util/Configuraciones.php';
    include_once __DIR__.'/../../com/util/Seguridad.php';
?>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>SCM Netafim</title>
        
        <link rel="stylesheet" type="text/css" href="<?php echo Configuraciones::url_base(); ?>vistas/libs/jeasyui/themes/bootstrap/easyui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Configuraciones::url_base(); ?>vistas/libs/jeasyui/themes/icon.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Configuraciones::url_base(); ?>vistas/css/estilos.css">

        <script type="text/javascript" src="<?php echo Configuraciones::url_base(); ?>vistas/libs/jeasyui/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo Configuraciones::url_base(); ?>vistas/libs/jeasyui/jquery.easyui.min.js"></script>
        <script type="text/javascript" src="<?php echo Configuraciones::url_base(); ?>vistas/libs/jeasyui/locale/easyui-lang-es.js"></script>
        <script type="text/javascript" src="<?php echo Configuraciones::url_base(); ?>vistas/libs/noty/jquery.noty.js"></script>
        <script type="text/javascript" src="<?php echo Configuraciones::url_base(); ?>vistas/libs/noty/layouts/top.js"></script>
        <script type="text/javascript" src="<?php echo Configuraciones::url_base(); ?>vistas/libs/noty/layouts/topRight.js"></script>
        <script type="text/javascript" src="<?php echo Configuraciones::url_base(); ?>vistas/libs/noty/themes/default.js"></script>
        
                <script type="text/javascript">var URL_BASE = "<?php echo Configuraciones::url_base();?>";</script><script type="text/javascript" src="<?php echo Configuraciones::url_base(); ?>vistas/VistaConfiguraciones.js"></script>
        <script type="text/javascript" src="<?php echo Configuraciones::url_base(); ?>vistas/com/util/Global.js"></script>
        <script type="text/javascript" src="<?php echo Configuraciones::url_base(); ?>vistas/com/util/Enums.js"></script>
        <script type="text/javascript" src="<?php echo Configuraciones::url_base(); ?>vistas/com/util/Include.js"></script>
        <script type="text/javascript" src="<?php echo Configuraciones::url_base(); ?>vistas/com/util/EventManager.js"></script>
        <script type="text/javascript" src="<?php echo Configuraciones::url_base(); ?>vistas/com/util/Utils.js"></script>
        <script type="text/javascript" src="<?php echo Configuraciones::url_base(); ?>vistas/com/util/String.js"></script>
        <script type="text/javascript" src="<?php echo Configuraciones::url_base(); ?>vistas/com/util/validatorResponse/ValidatorResponse.js"></script>
        <script type="text/javascript" src="<?php echo Configuraciones::url_base(); ?>vistas/com/util/Ajaxp.js"></script>
        <script type="text/javascript" src="<?php echo Configuraciones::url_base(); ?>vistas/com/util/Mensajes.js"></script>
        <script type="text/javascript" src="<?php echo Configuraciones::url_base(); ?>vistas/com/util/DataGridPaginationClient.js"></script>
        
        <script type="text/javascript" src="<?php echo Configuraciones::url_base(); ?>vistas/com/ComponentCodes.js"></script>
        <script type="text/javascript" src="<?php echo Configuraciones::url_base(); ?>vistas/conf/ini/conf.js"></script>
        <style type="text/css">
            #fm{
                margin:0;
                padding:10px 30px;
            }
            .ftitle{
                font-size:14px;
                font-weight:bold;
                padding:5px 0;
                margin-bottom:10px;
                border-bottom:1px solid #ccc;
            }
            .fitem{
                margin-bottom:5px;
            }
            .fitem label{
                display:inline-block;
                width:80px;
            }
            .fitem input{
                width:160px;
            }
        </style>
    </head>
    <body>
        
    </body>
</html>