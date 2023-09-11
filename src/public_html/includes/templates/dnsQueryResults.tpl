<h2>DNS Query Results</h2>
<p>You will probably only care about the A records. For a full list of types, check out the <a href = "viewWikiPage.php?title=dnsRecords">dns records</a> page.</p>
<table>
	<thead>
		<tr>
			<th>Host</th>
			<th>DNS Record Type</th>
			<th>IP</th>
			<th>Target</th>
		</tr>
	</thead>

	<tbody>
		{foreach from = $rows item = "row"}
		<tr>
			<td>{$row.host}</td>
			<td>{$row.type}</td>
			<td>{if isset($row.ip)}{$row.ip}{else}<span class = "subtle">N/A</span>{/if}</td>
			<td>{if isset($row.target)}{$row.target}{else}<span class = "subtle">N/A</span>{/if}</td>
		</tr>
		{/foreach}
	</tbody>
</table>
