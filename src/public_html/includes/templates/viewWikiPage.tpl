<section>
	<h2>{$page.displayTitle}</h2>
	{$page.content}

	{if $page.canEdit}
	<a href = "/wiki/{$page.title}/edit">Edit</a>
	{/if}
</section>
