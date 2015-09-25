var ax = new Ajaxp(URL_EXECUTECONTROLLER, 'POST', 'JSON');
function altura() {
    $("#espacio").height("0px");
    var h2 = 0;
    var h4 = 0;
    h2 = $(window).height();

    h4 = $("#cuerpo").outerHeight();

    var es = "<div id='espacio'></div>";
    $("#window").after(es);
    //h+h1+h3   
    var vacio = h2 - (h4);
    $("#espacio").height(vacio);
}
function agregarSC(e) {
    $(e).after('<div id="spin-combo" class="panel-disabled"  style="height: 35px;margin-left: -15px;opacity: 0.15;"><i class="ion-loading-a" style="color:rgba(58, 41, 41, 0.78);font-size: 25px;left: 50%;top: 18%;position: absolute;"></i></div>');

}
function removeSC() {
    $("#spin-combo").remove();
}
function cargarDiv(div, url)
{
    $('div').remove('.notifyjs-corner');
    $('div').remove('.sweet-overlay');
    $('div').remove('.sweet-alert');
    $("#window").html("");
    $(div).load(url);
}
function limpia() {
    $("#espacio").remove();
}
function regresarC(){
    $('div').remove('.notifyjs-corner');
    cargarDiv("#window","../cuponera/vistas/com/cupones/cuponera.php");
}
function spinnerBuscar()
{
    var c = $('#envb i').attr('class');
    $("#envb").addClass('disabled');
    $("#envb i").removeClass(c);
    $("#envb i").addClass('fa fa-spinner fa-spin');
    
}
function quitaSpinnerBuscar(){
                $("#envb").removeClass('disabled');
                $("#envb i").removeClass('fa-spinner fa-spin');
                $("#envb i").addClass('fa fa-search');
                
}
function quitaSpinnerAgregar(){
                $("#env").removeClass('disabled');
                $("#env i").removeClass('fa-spinner fa-spin');
                $("#env i").addClass('fa fa-plus');
                
}
function spinnerAR(){
     $(".confirm").prop("disabled", "true");
    $(".cancel").prop("disabled", "true");
    $(".confirm").html('<i id="spin"  class="fa fa-spin fa-spinner" ></i> <i style="font-style: normal;font-size:14px;">Procesando...</i>');
    $(".cancel").prop("disabled", "true");
   
}

function spinnerSA(){
                $(".confirm").removeProp("disabled");
                $(".cancel").removeProp("disabled");
                swal("Correcto!", "Operacion exitosa", "success");
}
function spinner()
{
    var c = $('#env i').attr('class');
    $("#env").addClass('disabled');
    $("#env i").removeClass(c);
    $("#env i").addClass('fa fa-spinner fa-spin');
    
}
function quitaSpinner(){
            
                $("#env").removeClass('disabled');
                $("#env i").removeClass('fa fa-spinner fa-spin');
                $("#env i").addClass('fa fa-send-o');
                
}
function numero() {
    $("[type=text]").keydown(function (t) {
        t.shiftKey && t.preventDefault(), 46 == t.keyCode || 8 == t.keyCode || 9 == t.keyCode ||  (t.keyCode < 95 ? (t.keyCode < 48 || t.keyCode > 57) && t.preventDefault() : (t.keyCode < 96 || t.keyCode > 105) && t.preventDefault())
    })
}

$('[data-toggle="tooltip"]').tooltip();
//function cargarDivGetPerfil(id) {
//    $("#window").empty();
//    cargarDiv("#window", "vistas/com/perfil/perfil_form.php?id=" + id + "&" + "tipo=" + 1);
//}
//
//function obtenerPantallaPrincipal(id)
//{
//    acciones.iniciaAjaxTest(COMPONENTES.PERFIL, "successPerfil");
//    ax.setAccion("obtenerPantallaPrincipal");
//    ax.addParamTmp("id_per", id);
//    ax.consumir();
//}

//function successPerfil(response) {
//
//    if (response['status'] === 'ok') {
//        switch (response[PARAM_ACCION_NAME]) {
//            case 'obtenerPantallaPrincipal':
//                cargarDiv("#window", response.data[0].url);
//                break;
//        }
//    }
//}