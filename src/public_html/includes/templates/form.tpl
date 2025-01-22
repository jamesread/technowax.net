<section>
	<!-- FORM:{$form->getName()} (rendered by template engine) !-->
	<form enctype = "{$form->getEnctype()}" id = "{$form->getName()}" action = "{$form->getAction()}" method = "post">
		<h2>{$form->getTitle()}</h2>

		{include file = "formElements.tpl" elements=$elements}

		{if isset($scripts)}
			{foreach from = $scripts item = "script"}
				<script type = "text/javascript">
				</script>
			{/foreach}
		{/if}
	</form>
</section>
