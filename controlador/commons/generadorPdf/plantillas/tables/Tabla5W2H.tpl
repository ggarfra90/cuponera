{if isset($ticket['preguntas5w2h']) && count($ticket['preguntas5w2h']) > 0 && in_array('MainHelpDeskShow5W2H', $configuraciones)}
{$contTitle = $contTitle + 1}
    <tr><td class="title" colspan="50" style="width: 100%">0{$contTitle}.- {$title5w2h}</td></tr>
    <tr class="headerGrid">
        <td colspan="2" style="width: 4%;text-align: center;">#</td>
        <td colspan="10" style="width: 20%">{$lblTipo}</td>
        <td  colspan="7" style="width: 14%" >{$lblClase}</td>
        <td colspan="31"  style="width: 62%" >{$lblDescripcion}</td>
    </tr>
    <tr><td class="separatorHeader" colspan="50" style="height: 0;width: 100%"></td></tr>
{$i = 1}
{foreach key=key5w2h item=item5w2h from=$ticket['preguntas5w2h']}
    <tr class="rowGrid">
        <td colspan="2" style="width: 4%;text-align: center;">{$i}</td>
        <td colspan="10" style="width: 20%">{$item5w2h['tipo']}</td>
        <td  colspan="7" style="width: 14%" >{$item5w2h['clase']}</td>
        <td colspan="31"  style="width: 62%" >{$item5w2h['descripcion']}</td>
    </tr>
    <tr><td class="separatorCell" colspan="50" style="height: 0;width: 100%"></td></tr>
    {$i = $i + 1}
{/foreach}
    <tr><td class="separator" colspan="50" style="height: 0;width: 100%"></td></tr>
{/if}