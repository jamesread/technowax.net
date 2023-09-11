<h2>DynDns</h2>

<p>This is a list of DynDNS updates. IPV4 only.</p>

<p>You can update this list by having your DynDns client make a HTTP query with the following syntax; </p>

<p><tt>http://www.technowax.net/dyndns.php?update&amp;user=<strong>{$userId}</strong>&amp;ident=<strong>yourString</strong></tt></p>

<p>The query string parameters are documented like this:
	<dl>
		<dt>user</dt>
		<dd>Your user ID, so that dyn dns updates go to your "account"</dd>

		<dt>ident</dt>
		<dd>An optional string that identifys the update in some way. Example: "homeRouter", or "workRouter".</dd>
	</dl>
</p>

<h3>List of updates</h3>
{if $listDdUpdates|@count eq 0}
	<p>No updates have ever been received.</p>
{else}
	<table>
		<thead>
			<tr>
				<th>Ident</th>
				<th>IP Address</th>
				<th>Timestamp<th>
			</tr>
		</thead>

		<tbody>
			{foreach from = "$listDdUpdates" item = "itemUpdate"}
			<tr>
				<td>{if empty($itemUpdate.ident)}<span class = "subtle">N/A</span>{else}{$itemUpdate.ident}{/if}</td>
				<td>{$itemUpdate.ipAddress}</td>
				<td>{$itemUpdate.timestamp}</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
{/if}
