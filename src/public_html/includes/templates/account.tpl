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

	<h3>Account</h3>
	<ul>
		<li><a href = "/change-password">Change my password</a></li>
	</ul>

	<h3>My services</h3>

	<p>Manage services tied to your account. Overview and documentation: <a href = "/services">Services</a>.</p>

	<dl>
		<dt><a href = "/dyndns/updates">Dynamic DNS</a></dt>
		<dd>View update history and your personal HTTP update endpoint.</dd>
	</dl>
</section>
