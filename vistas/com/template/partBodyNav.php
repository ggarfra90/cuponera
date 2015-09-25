<?php
//session_start();
$id_perfil = $_SESSION['perfil_id'];
include_once __DIR__ . '/../../../controlador/cuponera/PerfilControlador.php';
include_once __DIR__ . '/../../../controlador/cuponera/UsuarioControlador.php';
?>
<!--    <input type="hidden" name="txtid" id="txtid" value='<?php echo $id_perfil; ?>'>-->

<script>

function oculta(){$("ul").removeAttr("style")}function active(j,k){$("ul li").removeClass("active"),$("ul #l" + k).addClass("active"),$("ul li ul li").removeClass("active"),$("ul li ul #m" + j).addClass("active")}
</script>
<nav id="nav" class="navigation">
                <ul class="list-unstyled" >
                    <li id="l1" class="has-submenu"><a href="#" ><i class="ion-ios7-pricetags-outline"></i><span class="nav-label">Cuponera</span></a>
                        <ul  class="list-unstyled">
                            <li id="m1"><a href="#"  onclick='cargarDiv("#window", "vistas/com/cupones/cuponera.php");
                                    active(1, 1);
                                    '><i style="font-size: 20px;" class="ion-compose"></i>Registro</a></li>
                            <li  id="m2"><a href="#" class="" onclick='cargarDiv("#window", "vistas/com/bloqueo/bloqueo_listar.php");
                                    active(2, 1);'><i style="font-size: 20px;" class="fa fa-unlock-alt"></i>Bloqueo</a></li>

                        </ul>
                    </li>
                    <li id="l2" class="has-submenu"><a href="#"><i style="font-size: 22px;" class="ion-ios7-checkmark-outline"></i><span class="nav-label">Aprobaci&oacute;n cuponera</span></a>
                        <ul class="list-unstyled">
                   
                            <li id="m3"><a href="#"  class="" onclick='cargarDiv("#window", "vistas/com/cupones/aprobaciones/aprobacion_cupones.php");
                                    active(3, 2);'><i style="font-size: 20px;" class="ion-ios7-pricetags-outline"></i>Cuponera</a></li>    
                     
                            <li id="m4"><a href="#"  class="" onclick='cargarDiv("#window", "vistas/com/cupones/aprobaciones/aprobacion_cupon_especial.php");
                                    active(4, 2);'><i  style="font-size: 20px;" class="ion-ios7-star-outline"></i>Cupones especiales</a></li>
   
                            <li id="m5"><a href="#"  class="" onclick='cargarDiv("#window", "vistas/com/cupones/aprobaciones/visto_bueno_cupones.php");
                                    active(5, 2);'><i style="font-size: 20px;" class="fa fa-gavel"></i>Visto bueno</a></li>
        
                        </ul>
                    </li>
                    <li id="l3" class="has-submenu"><a href="#"><i class="ion-clipboard"></i><span class="nav-label">Reportes cuponera</span></a>
                        <ul class="list-unstyled">
          
                            <li id="m6"><a href="#" onclick="cargarDiv('#window', 'vistas/com/cupones/reportes/cupones_listar.php');
                                    active(6, 3);"><i style="font-size: 20px;" class="ion-ios7-pricetags-outline"></i>Cupones</a></li>
                            <li id="m7"><a href="#" onclick="cargarDiv('#window', 'vistas/com/cupones/reportes/reporte_cupon_especial.php');
                                    active(7, 3);"><i style="font-size: 20px;" class="ion-ios7-star-outline"></i>Cupones especiales</a></li>
                            <li id="m8"><a href="#" onclick="cargarDiv('#window', 'vistas/com/cupones/reportes/reporte_dias_ocupados.php');
                                    active(8, 3);"><i style="font-size: 20px;" class="fa fa-minus-circle"></i>D&iacute;as ocupados</a></li>
                        
                            <li id="m9"><a href="#"  class="" onclick='cargarDiv("#window", "vistas/com/cupones/reportes/reporte_estado_tramite.php");
                                    active(9, 3);'><i style="font-size: 20px;" class="fa fa-dashboard"></i>Estados de tr&aacute;mites</a></li>

                            <li id="m10"><a href="#" onclick="cargarDiv('#window', 'vistas/com/cupones/reportes/reporte_cupon_especial_uso.php');
                                    active(10, 3);"><i style="font-size: 20px;" class="ion-battery-half"></i>Utilizaci&oacute;n</a></li>

                        </ul>
                    </li>
                   
                    <li id="l8" class="has-submenu"><a href="#"><i class="ion-settings"></i><span class="nav-label">Mantenimientos</span></a>
                        <ul class="list-unstyled">
  
                         <li id="m32"><a href="#" onclick="cargarDiv('#window','vistas/com/dia_puente/dia_puente_listar.php');
                                    active(32, 8);"><i style="font-size: 20px;" class="fa fa-road"></i>D&iacute;as puente</a></li>
                            <li id="m33"><a href="#" onclick="cargarDiv('#window', 'vistas/com/feriados_anio/feriados_anio_listar.php');
                                    active(33, 8);"><i style="font-size: 20px;" class="ion-calendar"></i>D&iacute;as feriados</a></li>
                            <li  id="m34"><a href="#" class="" onclick='cargarDiv("#window", "vistas/com/especiales/especiales_listar.php");
                                    active(34, 8);'><i style="font-size: 20px;" class="ion-ios7-star-outline"></i>Cupones especiales</a></li>
<li id="m38"><a href="#" onclick="cargarDiv('#window', 'vistas/com/usuario/usuario_listar.php');         
                                    active(38, 8);"><i style="font-size: 20px;" class="ion-person-stalker"></i>Usuarios</a></li>

                            <!--                            <li id="m36"><a href="#" onclick="cargarDiv('#window', 'mant_adelantos.php');
                                    active(36, 8);"><i style="font-size: 20px;" class="ion-android-mixer"></i>Adelanto vacaciones</a></li>
 
                            <li id="m37"><a href="#" onclick="cargarDiv('#window', 'mant_suc_rrhh.php');
                                    active(37, 8);"><i style="font-size: 20px;" class="fa fa-hospital-o"></i>Sucursales</a></li>
       
         
                            
                                                                  <li id="m35"><a href="#" onclick="cargarDiv('#window', 'lista_feriados.php');active(35, 8);"><i style="font-size: 20px;" class="fa fa-calendar"></i>Feriados y dias puente</a></li>

                                      <li id="m39"><a href="#" onclick="cargarDiv('#window', 'MOD_base.php');
                                    active(39, 8);"><i style="font-size: 20px;" class="fa fa-folder-open-o"></i>Utilitario</a></li>
        -->
                        </ul>
                    </li>
                    
                </ul>
            </nav>


