<section>
	<h2>Users</h2>

	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>Group</th>
			</tr>
		</thead>

		<tbody>
		{foreach from = $listUsers item = itemUser} 
			<tr>
				<td><a href = "viewUser.php?id={$itemUser.id}">{$itemUser.id}</a></td>
				<td>{$itemUser.username}</td>
				<td>{$itemUser.groupName}</td>
			</tr>
		{/foreach}
		</tbody>
	</table>
</section>
