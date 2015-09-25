<?php
include_once __DIR__.'/../template/TemplateIncludes.php';
?>
<html>
  <head>
    <script src="<?php echo $url_libs_imagina;?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo Configuraciones::url_base();?>vistas/com/visado/firma.js"></script>
  </head>
  <body>
    <div style="border:2px solid #ccc;width:200px; height: 100px;" id="canvasDiv"></div>	
  </body>
</html>