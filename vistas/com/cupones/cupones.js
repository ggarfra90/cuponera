function cargarDivCupon(u,t) {
   $("#window").empty();
    cargarDiv("#window","vistas/com/cupones/"+u+"?tipo="+t);
}
function listarCupones(){

    acciones.iniciaAjaxTest(COMPONENTES.CUPON, "cuponOpcion");
    ax.setAccion("getCupon");
    ax.consumir();
}
function ComboEspecial(){

    acciones.iniciaAjaxTest(COMPONENTES.CUPON, "cuponOpcion");
    ax.setAccion("getComboEspecial");
    ax.consumir();
}
function cuponOpcion(response) {
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
            case 'getCupon':
                onResponseAjaxpGetDataCupon(response.data);
                break;
                case 'getComboEspecial':
                onResponseAjaxpGetDataCombo(response.data);
                break;
        }
    }
}
function onResponseAjaxpGetDataCupon(data) {
    var cuerpo_total = '';
    var cuerpo = '';
    var cabeza = "";
    var pie = "";
    var cont=0;
    var b=0;
    $.each(data, function (index, item) {
        var r=0;
        var ra=5;
        if(cont%3==0){
            ra=2;
        }
         if(cont>2 || b==0){
           if((cont-1)%3==0 || cont==0){
               r=1;
               
           }
            if (r==1) {
                cabeza='   <div class="row">';
            }
           }
        cuerpo = "  <div class='col-md-4'>" +
                '<a href="#" onclick="cargaDivCupon();limpia();">'+
                '<div class="widget-panel widget-style-1 bg-warning" style="background:'+item.cup_color+'">'+
                '<div class="h2 text-white">'+item.cup_nombre+'</div>'+
                 '<span class="text-white">'+item.cup_msj+'</span>'+
                  item.cup_style +
                "</div>"+
                "</a>"+
                "</div>";
        cont++;
        if (ra==2) {
                pie= '   </div>';
            }
        cuerpo_total = cuerpo_total +cabeza+cuerpo+pie;
    
    });

    
    var html = cuerpo_total;

   // $("#prueba").append(html);
}
function onResponseAjaxpGetDataCombo(data) {
    var cuerpo_total = '';
    var cuerpo = '';
    $.each(data, function (index, item) {
        cuerpo = "<option value='"+item.ceid+"'>"+item.nombre+" "+item.fecha+"</option>";
        cuerpo_total = cuerpo_total+cuerpo;
    });
    var html = cuerpo_total;

    $("#id").append(html);
}
