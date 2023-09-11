<div>
	<div style = "display: inline-block">
	{include file = "form.tpl"}
	</div>

	{if $enableOpenId}
	<div style = "display: inline-block; border-left: 1px solid black;">
		<a href = "?openId=google"><img src = "resources/images/openid-google.png" width = "300" /></a><br />
		<a href = "?openId=facebook"><img src = "resources/images/openid-facebook.png" width = "300" /></a>
	</div>
	{/if}
</div>
