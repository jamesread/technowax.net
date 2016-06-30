<h2>Results</h2>

<table>
	<tbody>
	{foreach from = "$listTeams" item = "itemTeam" key = "index"}
		<tr>
			<th>Team {$index}</th>
		</tr>

		{foreach from = "$itemTeam" item = "itemMember"}
		<tr>
			<td>{$itemMember}</td>
		</tr>
		{/foreach}
	{/foreach}
	</tbody>
</table>
