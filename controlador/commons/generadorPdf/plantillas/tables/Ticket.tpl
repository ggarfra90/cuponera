<tr><td class="title" colspan="50" style="width: 100%">0{$contTitle}.- {$titleInfGeneral}</td></tr>
{if in_array('MainHelpDeskShowDescripcion', $configuraciones)}
<tr>
    <td class="label" colspan="8" style="width: 16%">{$lblDescripcion}:</td>
    <td colspan="42" class="information" style="text-align: justify;width: 84%">{$ticket['descripcion']}</td>
</tr>
{/if}
{if in_array('MainHelpDeskShowComponente', $configuraciones) || 
    in_array('MainHelpDeskShowEvento', $configuraciones)}
<tr>
    {if in_array('MainHelpDeskShowComponente', $configuraciones)}
    <td class="label" colspan="8" style="width: 16%">{$lblComponente}:</td>
    <td colspan="17" class="information" style="width: 34%">{$ticket['componente']}</td>
        {if in_array('MainHelpDeskShowEvento', $configuraciones)}
        <td class="label" colspan="8" style="text-align: center;width: 16%">{$lblEvento}:</td>
        <td colspan="17" class="information" style="width: 34%" >{$ticket['evento']}</td>
        {else}
        <td colspan="8" style="width: 16%"></td>
        <td colspan="17"  style="width: 34%"></td>
        {/if}
    {else}
        <td class="label" colspan="8" style="width: 16%">{$lblEvento}:</td>
        <td colspan="17" class="information" style="width: 34%" >{$ticket['evento']}</td>
        <td colspan="8" style="width: 16%"></td>
        <td colspan="17"  style="width: 34%"></td>
    {/if}
</tr>
{/if}
{if in_array('MainHelpDeskShowFechaInicio', $configuraciones) || 
    in_array('MainHelpDeskShowFechaConocimiento', $configuraciones)}
<tr>
    {if in_array('MainHelpDeskShowFechaInicio', $configuraciones)}
    <td class="label"  colspan="8" style="width: 16%">{$lblFechaInicio}:</td>
    <td  class="information"  colspan="10" style="width: 20%">{$ticket['fecha_inicio']}</td>
        {if in_array('MainHelpDeskShowFechaConocimiento', $configuraciones)}
        <td class="label"  colspan="12" style="text-align: center;width: 24%">{$lblFechaConocimiento}:</td>
        <td  class="information"  colspan="10" style="width: 20%">{$ticket['fecha_conocimiento']}</td>
        {else}
        <td colspan="12" style="width: 24%"></td>
        <td colspan="10" style="width: 20%"></td>
        {/if}
    <td  colspan="10"></td>
    {else}
    <td class="label"  colspan="12" style="width: 24%">{$lblFechaConocimiento}:</td>
    <td class="information"  colspan="10" style="width: 20%">{$ticket['fecha_conocimiento']}</td>
    <td colspan="8" style="width: 16%"></td>
    <td colspan="10" style="width: 20%"></td>
    <td colspan="10" style="width: 20%"></td>
    {/if}
</tr>
{/if}
{if in_array('MainHelpDeskShowComentario', $configuraciones)}
<tr>
    <td class="label" colspan="8" style="width: 16%">{$lblComentario}:</td>
    <td colspan="42" class="information" style="width: 84%">{$ticket['comentario']}</td>
</tr>
{/if}
{if in_array('MainHelpDeskShowNaturaleza', $configuraciones)|| 
    in_array('MainHelpDeskShowTipo', $configuraciones) || 
    in_array('MainHelpDeskShowEfectoInicial', $configuraciones)}
<tr>
    {if in_array('MainHelpDeskShowNaturaleza', $configuraciones)}
    <td class="label"  colspan="8" style="width: 16%">{$lblNaturaleza}:</td>
    <td  class="information"  colspan="10" style="width: 20%">{$ticket['naturaleza']}</td>
        {if in_array('MainHelpDeskShowTipo', $configuraciones)}
        <td class="label"  colspan="5" style="text-align: center;width: 10%">{$lbTipo}:</td>
        <td  class="information"  colspan="7" style="width: 14%">{$ticket['tipo']}</td>
            {if in_array('MainHelpDeskShowEfectoInicial', $configuraciones)}
            <td class="label"  colspan="7" style="text-align: center;width: 14%">{$lblEfectoInicial}:</td>
            <td  class="information"  colspan="13" style="width: 26%">{$ticket['efecto_inicial']}</td>
            {else}
            <td colspan="7" style="width: 14%"></td>
            <td colspan="13" style="width: 26%"></td>
            {/if}
        {else}
            {if in_array('MainHelpDeskShowEfectoInicial', $configuraciones)}
            <td class="label"  colspan="7" style="text-align: center;width: 14%">{$lblEfectoInicial}:</td>
            <td  class="information"  colspan="13" style="width: 26%">{$ticket['efecto_inicial']}</td>
            {else}
            <td colspan="7" style="width: 14%"></td>
            <td colspan="13" style="width: 26%"></td>
            {/if}
        {/if}
    {else}
        {if in_array('MainHelpDeskShowTipo', $configuraciones)}
        <td class="label"  colspan="8" style="width: 16%">{$lbTipo}:</td>
        <td  class="information"  colspan="15" style="width: 20%">{$ticket['tipo']}</td>
            {if in_array('MainHelpDeskShowEfectoInicial', $configuraciones)}
            <td class="label"  colspan="8" style="text-align: center;width: 14%">{$lblEfectoInicial}:</td>
            <td class="information"  colspan="15" style="width: 26%">{$ticket['efecto_inicial']}</td>
            <td colspan="4" style="width: 8%"></td>
            {else}
            <td colspan="27" style="width: 54%"></td>
            {/if}
        {else}
            <td class="label"  colspan="8" style="width: 16%">{$lblEfectoInicial}:</td>
            <td  class="information"  colspan="20" style="width: 40%">{$ticket['efecto_inicial']}</td>
            <td colspan="22" style="width: 44%"></td>
        {/if}
    {/if}
</tr>
{/if}
{if in_array('MainHelpDeskShowCatalogacion', $configuraciones) || 
    in_array('MainHelpDeskShowCriticidad', $configuraciones)}
<tr>
    {if in_array('MainHelpDeskShowCatalogacion', $configuraciones)}
    <td class="label"  colspan="8" style="width: 16%">{$lblCatalogacion}:</td>
    <td  class="information"  colspan="22" style="width: 44%">{$ticket['catalogo']}</td>
        {if in_array('MainHelpDeskShowCriticidad', $configuraciones)}
        <td class="label"  colspan="7" style="text-align: center;width: 14%">{$lblCriticidad}:</td>
        <td  class="information"  colspan="13" style="width: 26%">{$ticket['criticidad']}</td>
        {else}
        <td colspan="20" style="width: 40%;"></td>
        {/if}
    {else}
    <td class="label"  colspan="8" style="text-align: center;width: 16%">{$lblCriticidad}:</td>
    <td  class="information"  colspan="22" style="width: 40%">{$ticket['criticidad']}</td>
    <td colspan="20" style="width: 40%;"></td>
    {/if}
</tr>
{/if}
{if in_array('MainHelpDeskShowPropietario', $configuraciones) || 
    in_array('MainHelpDeskShowResponsable', $configuraciones)}
<tr>
    {if in_array('MainHelpDeskShowPropietario', $configuraciones)}
    <td class="label"  colspan="8" style="width: 16%">{$lblPropietario}:</td>
    <td  class="information"  colspan="17" style="width: 34%">{$ticket['propietario']}</td>
        {if in_array('MainHelpDeskShowResponsable', $configuraciones)}
        <td class="label"  colspan="8" style="text-align: center;width: 16%">{$lblResponsable}:</td>
        <td  class="information"  colspan="17" style="width: 34%">{$ticket['responsable']}</td>
        {else}
        <td colspan="25" style="width: 50%"></td>    
        {/if}
    {else}
    <td class="label"  colspan="8" style="width: 16%">{$lblResponsable}:</td>
    <td  class="information"  colspan="17" style="width: 34%">{$ticket['responsable']}</td>
    <td colspan="25" style="width: 50%"></td> 
    {/if}
</tr>
{/if}
{if in_array('MainHelpDeskShowAccionesInmediatas', $configuraciones)}
<tr>
    <td class="label"  colspan="8" style="width: 16%">{$lblAcccionesInmediatas}:</td>
    <td  class="information"  colspan="42" style="width: 84%">{$ticket['acciones_inmediatas']}</td>
</tr>
{/if}
{if in_array('MainHelpDeskShowSolucionProbable', $configuraciones) || 
    in_array('MainHelpDeskShowSolucionProbableComentario', $configuraciones)}
<tr>
    {if in_array('MainHelpDeskShowSolucionProbable', $configuraciones)}
    <td class="label"  colspan="8" style="width: 16%">{$lblSolucionProbable}:</td>
    <td  class="information"  colspan="17" style="width: 34%">{$ticket['solucionprobable']}</td>
        {if in_array('MainHelpDeskShowSolucionProbableComentario', $configuraciones)}
        <td class="label"  colspan="8" style="text-align: center;width: 16%" >{$lblComentario}:</td>
        <td  class="information"  colspan="17"  style="width: 34%" >{$ticket['solucionprobable_comentario']}</td>
        {else}
        <td colspan="25" style="width: 50%"></td>
        {/if}
    {else}
    <td class="label"  colspan="8" style="width: 16%" >{$lblComentario}:</td>
    <td  class="information"  colspan="17"  style="width: 34%" >{$ticket['solucionprobable_comentario']}</td>
    <td colspan="25" style="width: 50%"></td>
    {/if}
</tr>
{/if}
{if in_array('MainHelpDeskShowCausaProbable', $configuraciones) || 
    in_array('MainHelpDeskShowCausaProbableComentario', $configuraciones)}
<tr>
    {if in_array('MainHelpDeskShowCausaProbable', $configuraciones)}
    <td class="label"  colspan="8" style="width: 16%">{$lblCausaProbable}:</td>
    <td  class="information"  colspan="17" style="width: 34%">{$ticket['causaprobable']}</td>
        {if in_array('MainHelpDeskShowCausaProbableComentario', $configuraciones)}
        <td class="label"  colspan="8" style="text-align: center;width: 16%" >{$lblComentario}:</td>
        <td  class="information"  colspan="17"  style="width: 34%" >{$ticket['causaprobable_comentario']}</td>
        {else}
        <td colspan="25" style="width: 50%"></td>
        {/if}
    {else}
    <td class="label"  colspan="8" style="width: 16%" >{$lblComentario}:</td>
    <td  class="information"  colspan="17"  style="width: 34%" >{$ticket['causaprobable_comentario']}</td>
    <td colspan="25" style="width: 50%"></td>
    {/if}
</tr>
{/if}
{if in_array('MainHelpDeskShowFechaAnalisis', $configuraciones) || 
    in_array('MainHelpDeskShowAnalisisPropuesto', $configuraciones)}
<tr>
    {if in_array('MainHelpDeskShowFechaAnalisis', $configuraciones)}
    <td class="label"  colspan="8" style="width: 16%">{$lblFechaAnalisis}:</td>
    <td  class="information"  colspan="17" style="width: 34%">{$ticket['fecha_analisis']}</td>
        {if in_array('MainHelpDeskShowAnalisisPropuesto', $configuraciones)}
        <td class="label"  colspan="8" style="text-align: center;width: 16%" >{$lblAnalisisPropuesto}:</td>
        <td  class="information"  colspan="17"  style="width: 34%" >{$ticket['analisispropuesto']}</td>
        {else}
        <td colspan="25" style="width: 50%"></td>    
        {/if}
    {else}
    <td class="label"  colspan="8" style="width: 16%" >{$lblAnalisisPropuesto}:</td>
    <td  class="information"  colspan="17"  style="width: 34%" >{$ticket['analisispropuesto']}</td>
    <td colspan="25" style="width: 50%"></td>
    {/if}
</tr>
{/if}
<tr><td class="separator" colspan="50" style="height: 0;width: 100%"></td></tr>