<h2>{$title|default:"???"}</h2>
<table>
	<thead>
		<tr>
			{foreach from = "$headers" item = "header"}
			<th>{$header}</th>
			{/foreach}
		</tr>
	</thead>

	<tbody>
		{foreach from = "$rows" item = "row"}
		<tr>
			{foreach from = "$row" item = "cell"}
			<td>{$cell}</td>
			{/foreach}
		</tr>
		{/foreach}
	</tbody>
</table>
