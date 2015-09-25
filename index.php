<?php
include_once __DIR__ . '/vistas/com/template/TemplateIncludes.php';
?>
<!DOCTYPE html>
<html lang="es">
    <?php
    include_once __DIR__ . '/vistas/com/template/partHeadTemplate.php';
    ?>

    <head>
        <title>Imagina Technologies [Template de Arquitectura]</title>
    </head>

    <body id="cuerpo" onload="altura()">

        <?php
        include_once __DIR__ . '/vistas/com/template/partBodyLeft.php';
        ?>
        <section class="content">
            <?php
            include_once __DIR__ . '/vistas/com/template/partBodyHeader.php';
            ?>
            <?php
            include_once __DIR__ . '/vistas/com/template/partBodyMainContentEnds.php';
            ?>
            <div id="window" class="wraper container-fluid">
                     
            </div>
            <?php
            include_once __DIR__ . '/vistas/com/template/partFooter.php';
            ?>
        </section>
         
        <script src="<?php echo Configuraciones::url_base(); ?>vistas/index.js"></script>
    </body>
</html>

