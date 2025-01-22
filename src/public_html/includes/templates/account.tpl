<section>
	<h2>Your Account</h2>

	<p><strong>Username: </strong> {$user.username}</p>
	<p><strong>ID: </strong> {$user.id}</p>

	<h3>Permissions</h3>

	{if empty($permissions)}
		You don't have any special permissions.
	{else}
		<ul>
		{foreach from = $permissions item = perm}
			<li>{$perm.key}</li>
		{/foreach}
		</ul>

	{/if}

	<h3>Options</h3>
	<ul>
		<li><a href = "changePassword.php">Change my password</a></li>
	</ul>

	<h3>Services</h3>

	<dl>
		<dt><a href = "listDynamicDnsUpdates.php">dyndns</a></dt>
		<dd>Records a dynamic DNS address.</dd>

	</dl>
</section>
