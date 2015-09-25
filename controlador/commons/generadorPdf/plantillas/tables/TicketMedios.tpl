{if isset($ticket['medios']) && count($ticket['medios']) > 0 && in_array('MainHelpDeskShowTabMedios', $configuraciones)}
                {$contTitle = $contTitle + 1}
            <tr><td class="title" colspan="50" style="width: 100%">0{$contTitle}.- {$titleMedios}</td></tr>
    {foreach key=keyMedios item=itemMedios from=$ticket['medios']}
	<tr class="rowGrid">
            <td rowspan="6" colspan="12" style="padding:1mm;width:24%;text-align: center;vertical-align:top;">
                    <img src="{$itemMedios['imagen']}" style="width: {$itemMedios['ancho']} ;height: {$itemMedios['alto']} ;">
            </td>
	{if isset($itemMedios['comentarios']) && count($itemMedios['comentarios']) > 0}
		{$i = 0}
		{foreach  item=comentario from=$itemMedios['comentarios']}
			{if $i > 0}
				<tr class="rowGrid">
			{/if}
			{if $i > 1}
				<td  colspan="12" style="width:24%"></td>
			{/if}
			<td colspan="3" class="rowGrid" style="padding:0.5mm;width: 6%;vertical-align:top;">
				<img src="{$comentario['imagen']}" style="width: {$comentario['ancho']};height: {$comentario['alto']};vertical-align:top;">
			</td>
                        <td colspan="35" class="rowGrid" style="width: 70%;vertical-align:top;padding-right: 3mm;">
                            <span style="font-weight: bold;color:#0E2D5F;">{$comentario['usuario']}: </span>
                            {$comentario['descripcion']}
                        </td>
                        </tr>

			<tr class="rowGrid">
			{if $i > 1}
                            <td  colspan="12" style="width:24%"></td>
			{/if}
                        <td class="rowGrid" colspan="38" style="width: 76%;text-align: justify;color: #A0A0A0">{$comentario['fecha']}</td>
			</tr>
                        {if count($itemMedios['comentarios'])  > 1 }
                            {if count($itemMedios['comentarios']) - 1 > $i }
				<tr class="rowGrid" style="font-size: 3mm;">
				 {if $i > 1}
					<td  colspan="12" style="width:24%"></td>
				{/if}
					<td class="separatorHeader" colspan="38" style="height: 1;width: 76%"></td>
				</tr>
                            {else}
                                <tr class="rowGrid" style="font-size: 3mm;">
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
		{if count($itemMedios['comentarios']) == 1}
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
            <tr><td class="separator" colspan="50" style="height: 0;width: 100%"></td></tr>
{/if}