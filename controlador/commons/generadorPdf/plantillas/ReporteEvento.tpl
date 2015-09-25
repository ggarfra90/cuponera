{if !isset($maxDivision)}{$maxDivision = 50}{/if}

<style type="text/css">
<!--
    table.page_header { width: 100%; padding-bottom: 5mm; padding-top: 5mm; border: none}
    table.page_footer { width: 100%;  border: none;  border-top: solid 0.1mm #000000; padding: 5mm}
    
    td.title { font-weight: bold;font-size: 2.5mm;color: #000000;background-color: #DFECFE;width: 100%;height: 2.5mm;padding: 0.5mm;}
    td.label{ font-size: 2.5mm;vertical-align:top;}
    td.information { font-size: 2.5mm;color: #000000;text-align: left; height: 2.5mm;border: solid 0.1mm #D5D4D4;vertical-align:top;}
    td.separator { height: 0;border-top: solid 0.4mm #666566;}
   
    td.division { border: none;}
    td.titleGrilla { font-weight: bold;font-size: 2.5mm;color: #000000;width: 100%;height: 2.5mm;padding: 0.5mm;}
    td.separatorHeader { height: 0;border-top: solid 0.2mm #000000;} 
    td.separatorCell { height: 0;border-top: dotted 0.2mm #666566;}
    tr.headerGrid { font-weight: bold;border: #000000;font-size: 2.5mm;vertical-align:top;}
    tr.rowGrid { border-bottom: dotted 0.3mm #666566;font-size: 2.5mm;vertical-align:top;}
    
    img.centradaMedios {
	width:400px;
	height:300px;
	line-height:300px;
	margin:0px auto;
	text-align:center;
    }
    
    img.centradaPersona {
	width:400px;
	height:300px;
	line-height:300px;
	margin:0px auto;
	text-align:center;
    }
    
-->
</style>
{foreach key=keyTicket item=ticket from=$tickets}
<page backtop="21mm" backbottom="20mm" {if $keyTicket == 0} backleft="5mm" backright="5mm" pagegroup="new"{else} backleft="3mm" backright="7mm" pagegroup="old" {/if}>
    <page_header>
        <table class="page_header">
            <tr>
                <td style="width: 50%; text-align: left;padding-left: 5mm">
                    <img src="{$urlbase}{$logoEmpresa}" style="height: 9mm;">
                </td>
                <td style="width: 50%; text-align: right;padding-right: 5mm">
                    <table style="width: 100%; text-align: right;float: right;font-size: 2.7mm;font-weight: bold">
                        <tr>
                            <td style="width: 100%;text-align: right;">
                                {$lblEspacioTrabajo}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100%;text-align: right;">
                                {$lblEvento} : {$ticket['ticket_id']}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="width: 100%;height: 0mm; border-bottom: solid 0.1mm #000000"></td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table class="page_footer">
            <tr><td style="width: 100%; height: 2.5mm; text-align: left;font-size: 2.5mm">{$fecha}</td></tr>
            <tr>
                <td style="width: 100%; text-align: center;font-size: 2.5mm">
                    {$lblPagina} [[page_cu]]/[[page_nb]]
                </td>
            </tr>
        </table>
    </page_footer>
        <table style="width: 200mm;float: " cellspacing="1mm" cellpadding="0" >
            {$contTitle = 1}
            {include file="tables/Ticket.tpl"}
            {include file="tables/Tabla5W2H.tpl"}
            {include file="tables/TicketMedios.tpl"}
            {if isset($ticket['causasprobables']) && count($ticket['causasprobables']) > 0 && in_array('MainHelpDeskShowTabCausas', $configuraciones)}
                {$contTitle = $contTitle + 1}
            <tr><td class="title" colspan="50" style="width: 100%">0{$contTitle}.- {$titleCausasProbabales}</td></tr>
            <tr class="headerGrid">
                <td colspan="2" style="width: 4%;text-align: center;">#</td>
                <td colspan="10" style="width: 20%">{$lblFecha}</td>
                <td  colspan="8" style="width: 16%" >{$lblNaturaleza}</td>
                <td colspan="18"  style="width: 36%" >{$lblDescripcion}</td>
                <td colspan="12"  style="width: 24%" >{$lblResponsable}</td>
            </tr>
            <tr><td class="separatorHeader" colspan="50" style="height: 0;width: 100%"></td></tr>
            {$i = 1}
            {foreach key=keyCauPro item=itemCauPro from=$ticket['causasprobables']}
            <tr class="rowGrid">
                <td colspan="2" style="width: 4%;text-align: center;">{$i}</td>
                <td colspan="10" style="width: 20%">{$itemCauPro['fecha_creacion']}</td>
                <td  colspan="8" style="width: 16%" >{$itemCauPro['naturaleza']}</td>
                <td colspan="18"  style="width: 36%" >{$itemCauPro['descripcion']}</td>
                <td colspan="12"  style="width: 24%" >{$itemCauPro['responsable']}</td>
            </tr>
            <tr><td class="separatorCell" colspan="50" style="height: 0;width: 100%"></td></tr>
            {if isset($itemCauPro['porques']) && count($itemCauPro['porques']) > 0}
            <tr class="headerGrid">
                <td colspan="2" style="width: 4%;text-align: center;"></td>
                <td colspan="2" style="width: 4%">#</td>
                <td  colspan="46" style="width: 92%" >{$lblPorque}</td>
            </tr>
            <tr><td colspan="2" style="width: 4%;"></td><td class="separatorHeader" colspan="48" style="height: 0;width: 96%"></td></tr>
            {$j = 1}
            {foreach  item=porque from=$itemCauPro['porques']}
            <tr class="rowGrid">
                <td colspan="2" style="width: 4%;text-align: center;"></td>
                <td colspan="2" style="width: 4%">{$i}.{$j}</td>
                <td  colspan="46" style="width: 92%" >{$porque['porque']}</td>
            </tr>
            {if count($itemCauPro['porques']) > $j}
                <tr><td colspan="2" style="width: 4%;"></td><td class="separatorCell" colspan="48" style="height: 0;width: 96%"></td></tr>
            {else}
                <tr><td class="separatorCell" colspan="50" style="height: 0;width: 100%"></td></tr>
            {/if}
            {$j = $j + 1}
            {/foreach}
            {/if}
            {$i = $i + 1}
            {/foreach}
            <tr><td class="separator" colspan="50" style="height: 0;width: 100%"></td></tr>
            {/if}
            {if isset($ticket['causasraices']) && count($ticket['causasraices']) > 0}
                {$contTitle = $contTitle + 1}
            <tr><td class="title" colspan="50" style="width: 100%">0{$contTitle}.- {$titleCausasRaices}</td></tr>
            <tr class="headerGrid">
                <td colspan="2" style="width: 4%;text-align: center;">#</td>
                <td colspan="10" style="width: 20%">{$lblFecha}</td>
                <td  colspan="10" style="width: 20%" >{$lblNaturaleza}</td>
                <td colspan="9"  style="width: 18%" >{$lblEstado}</td>
                <td colspan="8"  style="width: 16%" >{$lblDescripcion}</td>
                <td colspan="11"  style="width: 22%" >{$lblResponsable}</td>
            </tr>
            <tr><td class="separatorHeader" colspan="50" style="height: 0;width: 100%"></td></tr>
            {$i = 1}
            {foreach key=keyCauRaiz item=itemCauRaiz from=$ticket['causasraices']}
            <tr class="rowGrid">
                <td colspan="2" style="width: 4%;text-align: center;">{$i}</td>
                <td colspan="10" style="width: 20%">{$itemCauRaiz['fecha_creacion']}</td>
                <td  colspan="10" style="width: 20%" >{$itemCauRaiz['naturaleza']}</td>
                <td colspan="9"  style="width: 18%" >{$itemCauRaiz['estado']}</td>
                <td colspan="8"  style="width: 16%" >{$itemCauRaiz['descripcion']}</td>
                <td colspan="11"  style="width: 22%" >{$itemCauRaiz['responsable']}</td>
            </tr>
            <tr><td class="separatorCell" colspan="50" style="height: 0;width: 100%"></td></tr>
            {if isset($itemCauRaiz['porques']) && count($itemCauRaiz['porques']) > 0}
            <tr class="headerGrid">
                <td colspan="2" style="width: 4%;text-align: center;"></td>
                <td colspan="2" style="width: 4%">#</td>
                <td  colspan="5" style="width: 10%" >{$lblEsRaiz}</td>
                <td  colspan="41" style="width: 82%" >{$lblPorque}</td>
            </tr>
            <tr><td colspan="2" style="width: 4%;"></td><td class="separatorHeader" colspan="48" style="height: 0;width: 96%"></td></tr>
            {$j = 1}
            {foreach  item=porque from=$itemCauRaiz['porques']}
            <tr class="rowGrid">
                <td colspan="2" style="width: 4%;text-align: center;"></td>
                <td colspan="2" style="width: 4%">{$i}.{$j}</td>
                <td colspan="5" style="width: 10%" >{$porque['esraiz']}</td>
                <td colspan="41" style="width: 82%" >{$porque['porque']}</td>
            </tr>
            {if count($porque['porques']) > $j}
                <tr><td colspan="2" style="width: 4%;"></td><td class="separatorCell" colspan="48" style="height: 0;width: 96%"></td></tr>
            {else}
                <tr><td class="separatorCell" colspan="50" style="height: 0;width: 100%"></td></tr>
            {/if}
            {$j = $j + 1}
            {/foreach}
            {/if}
            {$i = $i + 1}
            {/foreach}
            <tr><td class="separator" colspan="50" style="height: 0;width: 100%"></td></tr>
            {/if}
            {if isset($ticket['validacioncausas']) && count($ticket['validacioncausas']) > 0 && in_array('MainHelpDeskShowTabCausas', $configuraciones)}
                {$contTitle = $contTitle + 1}
            <tr><td class="title" colspan="50" style="width: 100%">0{$contTitle}.- {$titleValidacionCausas}</td></tr>
            <tr class="headerGrid">
                <td colspan="2" style="width: 4%;text-align: center;">#</td>
                <td colspan="10" style="width: 20%">{$lblFecha}</td>
                <td  colspan="16" style="width: 32%" >{$lblCausaRaiz}</td>
                <td colspan="10"  style="width: 20%" >{$lblEstado}</td>
                <td colspan="12"  style="width: 24%" >{$lblResponsable}</td>
            </tr>
            <tr><td class="separatorHeader" colspan="50" style="height: 0;width: 100%"></td></tr>
            {$i = 1}
            {foreach key=keyValCau item=itemValCau from=$ticket['validacioncausas']}
            <tr class="rowGrid">
                <td colspan="2" style="width: 4%;text-align: center;">{$i}</td> 
                <td colspan="10" style="width: 20%">{$itemValCau['fecha_creacion']}</td>
                <td  colspan="16" style="width: 32%" >{$itemValCau['descripcion']}</td>
                <td colspan="10"  style="width: 20%" >{$itemValCau['estado']}</td>
                <td colspan="12"  style="width: 24%" >{$itemValCau['responsable']}</td>
            </tr>
            <tr><td class="separatorCell" colspan="50" style="height: 0;width: 100%"></td></tr>
            {$i = $i + 1}
            {/foreach}
            <tr><td class="separator" colspan="50" style="height: 0;width: 100%"></td></tr>
            {/if}
            {if isset($ticket['tareas']) && count($ticket['tareas']) > 0}
                {$contTitle = $contTitle + 1}
            <tr><td class="title" colspan="50" style="width: 100%">0{$contTitle}.- {$titleTareas}</td></tr>
            
            <tr class="headerGrid">
                <td colspan="2" style="width: 4%;text-align: center;">#</td>
                <td colspan="15" style="width: 30%">ID</td>
                <td  colspan="33" style="width: 66%" >Criticidad</td>
            </tr>
            <tr><td class="separatorHeader" colspan="50" style="height: 0;width: 100%"></td></tr>
            {$contTareas = 1}
            {foreach key=keyTarea item=tarea from=$ticket['tareas']}
            {$k = 1}
            <tr><td class="separatorCell" colspan="50" style="height: 0;width: 100%"></td></tr>
            <tr class="headerGrid">
                <td colspan="2" style="width: 4%;text-align: center;">{$contTareas}</td>
                <td colspan="15" style="width: 30%">{$tarea['id']}</td>
                <td  colspan="33" style="width: 66%" >{$tarea['criticidad']}</td>
            </tr>
            <tr><td class="separatorCell" colspan="50" style="height: 0;width: 100%"></td></tr>
            <tr><td colspan="50" style="width: 100%;height: 1mm;"></td></tr>
            <tr class="rowGrid">
                <td colspan="1" style="width: 2%;font-weight: bold;"></td>
                <td colspan="49" style="width: 98%;font-weight: bold;">{$contTareas}.{$k}.- GENERAL</td>
            </tr>
            <tr class="rowGrid">
                <td colspan="1" style="width: 2%;"></td>
                <td colspan="8" style="width: 16%;font-weight: bold;">Accion ¿Qué?</td>
                <td  colspan="41" style="width: 82%" >{$tarea['que']}</td>
            </tr>
            <tr class="rowGrid">
                <td colspan="1" style="width: 2%;"></td>
                <td colspan="8" style="width: 16%;font-weight: bold;">¿Cómo?</td>
                <td  colspan="41" style="width: 82%" >{$tarea['como']}</td>
            </tr>
            <tr class="rowGrid">
                <td colspan="1" style="width: 2%;"></td>
                <td colspan="8" style="width: 16%;font-weight: bold;">¿Dondé?</td>
                <td  colspan="41" style="width: 82%" >{$tarea['donde']}</td>
            </tr>
            <tr class="rowGrid">
                <td colspan="1" style="width: 2%;"></td>
                <td colspan="8" style="width: 16%;font-weight: bold;">¿Por Qué?</td>
                <td  colspan="41" style="width: 82%" >{$tarea['porque']}</td>
            </tr>
            <tr class="rowGrid">
                <td colspan="1" style="width: 2%;"></td>
                <td colspan="8" style="width: 16%;font-weight: bold;">¿Cuanto?</td>
                <td  colspan="41" style="width: 82%" >{$tarea['cuanto']}</td>
            </tr>
            <tr><td colspan="50" style="width: 100%;height: 1mm;"></td></tr>
            {if isset($tarea['planificaciones']) && count($tarea['planificaciones']) > 0}
                {$k = $k + 1}
            <tr class="rowGrid">
                <td colspan="1" style="width: 2%;font-weight: bold;"></td>
                <td colspan="49" style="width: 98%;font-weight: bold;">{$contTareas}.{$k}.- PLANIFICACION</td>
            </tr>
            {$j = 1}
            <tr><td class="separatorCell" colspan="50" style="height: 0;width: 100%"></td></tr>
            <tr class="headerGrid">
                <td colspan="1" style="width: 2%;"></td>
                <td colspan="2" style="width: 4%;">#</td>
                <td colspan="8" style="width: 16%" >{$lblFecha}</td>
                <td colspan="8" style="width: 16%">{$lblInicioPlanificado}</td>
                <td colspan="7" style="width: 14%" >{$lblDuracion}</td>
                <td colspan="8"  style="width: 16%" >{$finPlanificado}</td>
                <td colspan="8"  style="width: 16%" >{$lblComentario}</td>
                <td colspan="8"  style="width: 16%" >{$lblResponsable}</td>
            </tr>
            <tr><td class="separatorCell" colspan="50" style="height: 0;width: 100%"></td></tr>
            {foreach key=keyPlanificacion item=planificacion from=$tarea['planificaciones']}
            <tr class="rowGrid">
               <td colspan="1" style="width: 2%;"></td>
                <td colspan="2" style="width: 4%;">{$j}</td>
                <td colspan="8" style="width: 16%" >{$planificacion['fecha']}</td>
                <td colspan="8" style="width: 16%">{$planificacion['inicio']}</td>
                <td colspan="7" style="width: 14%" >{$planificacion['duracion']}</td>
                <td colspan="8"  style="width: 16%" >{$planificacion['fin']}</td>
                <td colspan="8"  style="width: 16%" >{$planificacion['comentario']}</td>
                <td colspan="8"  style="width: 16%" >{$planificacion['responsable']}</td>
            </tr>
                {$j = $j + 1}
            {/foreach}
            <tr><td colspan="50" style="width: 100%;height: 1mm;"></td></tr>
            {/if}
            {if isset($tarea['avances']) && count($tarea['avances']) > 0}
                {$k = $k + 1}
            <tr class="rowGrid">
                <td colspan="1" style="width: 2%;font-weight: bold;"></td>
                <td colspan="49" style="width: 98%;font-weight: bold;">{$contTareas}.{$k}.- AVANCES</td>
            </tr>
            {$j = 1}
            <tr><td class="separatorCell" colspan="50" style="height: 0;width: 100%"></td></tr>
            <tr class="headerGrid">
                <td colspan="1" style="width: 2%;"></td>
                <td colspan="2" style="width: 4%;">#</td>
                <td colspan="8" style="width: 16%" >{$lblFecha}</td>
                <td colspan="24"  style="width: 48%" >{$lblComentario}</td>
                <td colspan="5" style="width: 10%" >{$lblAvance}</td>
                <td colspan="10"  style="width: 20%" >{$lblResponsable}</td>
            </tr>
            <tr><td class="separatorCell" colspan="50" style="height: 0;width: 100%"></td></tr>
            {foreach key=keyAvance item=avance from=$tarea['avances']}
            <tr class="rowGrid">
               <td colspan="1" style="width: 2%;"></td>
                <td colspan="2" style="width: 4%;">{$j}</td>
                <td colspan="8" style="width: 16%" >{$avance['fecha']}</td>
                <td colspan="24"  style="width: 48%" >{$avance['comentario']}</td>
                <td colspan="5" style="width: 10%" >{$avance['avance']}</td>
                <td colspan="10"  style="width: 20%" >{$avance['responsable']}</td>
            </tr>
                {$j = $j + 1}
            {/foreach}
            <tr><td colspan="50" style="width: 100%;height: 1mm;"></td></tr>
            {/if}
            {if isset($tarea['sucesos']) && count($tarea['sucesos']) > 0}
                {$k = $k + 1}
            <tr class="rowGrid">
                <td colspan="1" style="width: 2%;font-weight: bold;"></td>
                <td colspan="49" style="width: 98%;font-weight: bold;">{$contTareas}.{$k}.- {$titleSucesos}</td>
            </tr>
            {$j = 1}
            <tr><td class="separatorCell" colspan="50" style="height: 0;width: 100%"></td></tr>
            <tr class="headerGrid">
                <td colspan="1" style="width: 2%;"></td>
                <td colspan="2" style="width: 4%;">#</td>
                <td colspan="14" style="width: 28%" >{$lblFecha}</td>
                <td colspan="5" style="width: 10%" >{$lblSuceso}</td>
                <td colspan="18"  style="width: 36%" >{$lblComentario}</td>
                <td colspan="10"  style="width: 20%" >{$lblResponsable}</td>
            </tr>
            <tr><td class="separatorCell" colspan="50" style="height: 0;width: 100%"></td></tr>
            {foreach key=keySuceso item=suceso from=$tarea['sucesos']}
            <tr class="rowGrid">
                <td colspan="1" style="width: 2%;"></td>
                <td colspan="2" style="width: 4%;">{$j}</td>
                <td colspan="14" style="width: 28%" >{$suceso['fecha']}</td>
                <td colspan="5" style="width: 10%" >{$suceso['suceso']}</td>
                <td colspan="18"  style="width: 36%" >{$suceso['comentario']}</td>
                <td colspan="10"  style="width: 20%" >{$suceso['responsable']}</td>
            </tr>
                {$j = $j + 1}
            {/foreach}
            <tr><td colspan="50" style="width: 100%;height: 1mm;"></td></tr>
            {/if}
            {if isset($tarea['recursos']) && count($tarea['recursos']) > 0}
                {$k = $k + 1}
            <tr class="rowGrid">
                <td colspan="1" style="width: 2%;font-weight: bold;"></td>
                <td colspan="49" style="width: 98%;font-weight: bold;">{$contTareas}.{$k}.- RECURSOS</td>
            </tr>
            {$j = 1}
            <tr><td class="separatorCell" colspan="50" style="height: 0;width: 100%"></td></tr>
            <tr class="headerGrid">
                <td colspan="1" style="width: 2%;"></td>
                <td colspan="2" style="width: 4%;">#</td>
                <td colspan="47" style="width: 94%" >{$lblRecurso}</td>
            </tr>
            <tr><td class="separatorCell" colspan="50" style="height: 0;width: 100%"></td></tr>
            {foreach key=keyRecurso item=recurso from=$tarea['recursos']}
            <tr class="rowGrid" style="font-size: 2.5mm;">
                <td colspan="1" style="width: 2%;"></td>
                <td colspan="2" style="width: 4%;">{$j}</td>
                <td colspan="47" style="width: 94%" >{$recurso['recurso']}</td>
            </tr>
                {$j = $j + 1}
            {/foreach}
            <tr><td colspan="50" style="width: 100%;height: 1mm;"></td></tr>
            {/if}
            {if isset($tarea['medios']) && count($tarea['medios']) > 0}
                {$k = $k + 1}
            <tr class="rowGrid">
                <td colspan="1" style="width: 2%;font-weight: bold;"></td>
                <td colspan="49" style="width: 98%;font-weight: bold;">{$contTareas}.{$k}.- {$titleMedios}</td>
            </tr>
            <tr><td class="separatorCell" colspan="50" style="height: 0;width: 100%"></td></tr>
    {foreach key=keyMedios item=itemTarMedios from=$tarea['medios']}
            <tr class="rowGrid">
            <td rowspan="6" colspan="12" style="padding:1mm;width:24%;text-align: center;vertical-align:top;">
                    <img src="{$itemTarMedios['imagen']}" style="width:{$itemTarMedios['ancho']};height: {$itemTarMedios['alto']}">
            </td>
	{if isset($itemTarMedios['comentarios']) && count($itemTarMedios['comentarios']) > 0}
		{$i = 0}
		{foreach  item=comentarioTar from=$itemTarMedios['comentarios']}
			{if $i > 0}
				<tr class="rowGrid">
			{/if}
			{if $i > 1}
				<td  colspan="12" style="width:24%"></td>
			{/if}
			<td colspan="3" class="rowGrid" style="padding:0.5mm;width: 6%;vertical-align:top;">
				<img src="{$comentarioTar['imagen']}" style="width: {$comentarioTar['ancho']};height: {$comentarioTar['alto']};vertical-align:top;">
			</td>
			<td colspan="35" class="rowGrid" style="width: 70%;vertical-align:top;padding-right: 3mm;">
                            <span style="font-weight: bold;color:#0E2D5F;">{$comentarioTar['usuario']}: </span>
                            {$comentarioTar['descripcion']}</td>
                        </tr>

			<tr class="rowGrid">
			{if $i > 1}
				<td  colspan="12" style="width:24%"></td>
			{/if}
			<td class="rowGrid" colspan="38" style="width: 76%;text-align: justify;color: #A0A0A0">{$comentarioTar['fecha']}</td>
			</tr>
                        {if count($itemTarMedios['comentarios'])  > 1 }
                            {if count($itemTarMedios['comentarios']) - 1 > $i}
                                    <tr class="rowGrid">
                                     {if $i > 1}
                                            <td  colspan="12"></td>
                                    {/if}
                                            <td class="separatorHeader" colspan="38" style="height: 1;width: 76%"></td>
                                    </tr>
                            {else}
                                    <tr class="rowGrid">
                                     {if $i > 1}
                                            <td  colspan="12" style="width:24%"></td>
                                    {/if}
                                            <td colspan="38" style="height: 0;width: 76%"></td>
                                    </tr>
                                    <tr><td class="separatorHeader" colspan="50" style="height: 1;width: 100%"></td></tr>
                            {/if}
                        {/if}
			{$i = $i + 1}
		{/foreach}
		{if count($itemTarMedios['comentarios']) == 1}
			{for $foo=1 to 4}
                            <tr><td colspan="38" style="width:76%;"></td></tr>
			{/for}
                <tr><td class="separatorHeader" colspan="50" style="height: 1;width: 100%"></td></tr>
		{/if}
	{else}
		{for $foo=1 to 5}
		<td colspan="38" style="width:76%;"></td></tr><tr>
		{/for}
		<td colspan="38" style="width:76%;"></td></tr>
        <tr><td class="separatorHeader" colspan="50" style="height: 1;width: 100%"></td></tr>
	{/if}
    {/foreach}
            <tr><td colspan="50" style="width: 100%;height: 1mm;"></td></tr>
            {/if}
            {if isset($tarea['verificaciones']) && count($tarea['verificaciones']) > 0}
                {$k = $k + 1}
            <tr class="rowGrid">
                <td colspan="1" style="width: 2%;font-weight: bold;"></td>
                <td colspan="49" style="width: 98%;font-weight: bold;">{$contTareas}.{$k}.- {$titleVerificaciones}</td>
            </tr>
            {$j = 1}
            <tr><td class="separatorCell" colspan="50" style="height: 0;width: 100%"></td></tr>
            <tr class="headerGrid">
                <td colspan="1" style="width: 2%;"></td>
                <td colspan="2" style="width: 4%;">#</td>
                <td colspan="10" style="width: 20%">{$lblFecha}</td>
                <td  colspan="11" style="width: 22%" >{$lblTipo}</td>
                <td colspan="6"  style="width: 12%" >{$lblPuntajeEstado}</td>
                <td colspan="10"  style="width: 20%" >{$lblComentario}</td>
                <td colspan="10"  style="width: 20%" >{$lblResponsable}</td>
            </tr>
            <tr><td class="separatorCell" colspan="50" style="height: 0;width: 100%"></td></tr>
            {foreach key=keyVerificacion item=verificacion from=$tarea['verificaciones']}
            <tr class="rowGrid">
                <td colspan="1" style="width: 2%;"></td>
                <td colspan="2" style="width: 4%;">#</td>
                <td colspan="10" style="width: 20%">{$verificacion['fecha_creacion']}</td>
                <td  colspan="11" style="width: 22%">{$verificacion['tipo']}</td>
                <td colspan="6"  style="width: 12%" >{$verificacion['puntaje']}</td>
                <td colspan="10"  style="width: 20%" >{$verificacion['comentario']}</td>
                <td colspan="10"  style="width: 20%" >{$verificacion['responsable']}</td>
            </tr>
                {$j = $j + 1}
            {/foreach}
            <tr><td colspan="50" style="width: 100%;height: 1mm;"></td></tr>
            {/if}
            {$contTareas = $contTareas + 1}
            {/foreach}
            <tr><td class="separator" colspan="50" style="height: 0;width: 100%"></td></tr>
            {/if}
            {if isset($ticket['sucesos']) && count($ticket['sucesos']) > 0}
                {$contTitle = $contTitle + 1}
            <tr><td class="title" colspan="50" style="width: 100%">0{$contTitle}.- {$titleSucesos}</td></tr>
             <tr class="headerGrid">
                <td colspan="2" style="width: 4%;text-align: center;">#</td>
                <td colspan="10" style="width: 20%">{$lblFecha}</td>
                <td  colspan="8" style="width: 16%" >{$lblSuceso}</td>
                <td colspan="8"  style="width: 16%" >{$lblEfecto}</td>
                <td colspan="10"  style="width: 20%" >{$lblComentario}</td>
                <td colspan="12"  style="width: 24%" >{$lblResponsable}</td>
            </tr>
            <tr><td class="separatorHeader" colspan="50" style="height: 0;width: 100%"></td></tr>
            {$i = 1}
            {foreach key=keyTckSucesos item=itemTckSucesos from=$ticket['sucesos']}
            <tr class="rowGrid">
                <td colspan="2" style="width: 4%;text-align: center;">{$i}</td> 
                <td colspan="10" style="width: 20%">{$itemTckSucesos['fecha_creacion']}</td>
                <td  colspan="8" style="width: 16%" >{$itemTckSucesos['suceso']}</td>
                <td colspan="8"  style="width: 16%" >{$itemTckSucesos['efecto']}</td>
                <td colspan="10"  style="width: 20%" >{$itemTckSucesos['comentario']}</td>
                <td colspan="12"  style="width: 24%" >{$itemTckSucesos['responsable']}</td>
            </tr>
            <tr><td class="separatorCell" colspan="50" style="height: 0;width: 100%"></td></tr>
            {$i = $i + 1}
            {/foreach}
            <tr><td class="separator" colspan="50" style="height: 0;width: 100%"></td></tr>
            {/if}
            {if isset($ticket['verificaciones']) && count($ticket['verificaciones']) > 0}
                {$contTitle = $contTitle + 1}
            <tr><td class="title" colspan="50" style="width: 100%">0{$contTitle}.- {$titleVerificaciones}</td></tr>
            <tr class="headerGrid">
                <td colspan="2" style="width: 4%;text-align: center;">#</td>
                <td colspan="10" style="width: 20%">{$lblFecha}</td>
                <td  colspan="12" style="width: 24%" >{$lblTipo}</td>
                <td colspan="6"  style="width: 12%" >{$lblPuntajeEstado}</td>
                <td colspan="10"  style="width: 20%" >{$lblComentario}</td>
                <td colspan="10"  style="width: 20%" >{$lblResponsable}</td>
            </tr>
            <tr><td class="separatorHeader" colspan="50" style="height: 0;width: 100%"></td></tr>
            {$i = 1}
            {foreach key=keyTckVerificaciones item=itemTckVerificaciones from=$ticket['verificaciones']}
            <tr class="rowGrid">
                <td colspan="2" style="width: 4%;text-align: center;">{$i}</td> 
                 <td colspan="10" style="width: 20%">{$itemTckVerificaciones['fecha_creacion']}</td>
                <td  colspan="12" style="width: 24%" >{$itemTckVerificaciones['tipo']}</td>
                <td colspan="6"  style="width: 12%" >{$itemTckVerificaciones['puntaje']}</td>
                <td colspan="10"  style="width: 20%" >{$itemTckVerificaciones['comentario']}</td>
                <td colspan="10"  style="width: 20%" >{$itemTckVerificaciones['responsable']}</td>
            </tr>
            <tr><td class="separatorCell" colspan="50" style="height: 0;width: 100%"></td></tr>
            {$i = $i + 1}
            {/foreach}
            <tr><td class="separator" colspan="50" style="height: 0;width: 100%"></td></tr>
            {/if}
            <tr>
            {for $foo=1 to $maxDivision}
                <td class="division" style="width:{100/$maxDivision}%"></td>
            {/for}
           </tr>
        </table>  
</page>
{/foreach}

            
