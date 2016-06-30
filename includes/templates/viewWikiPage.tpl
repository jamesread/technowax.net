<h2>{$page.displayTitle}</h2>
{$page.content}

{if $page.canEdit}
<a href = "editWikiPage.php?title={$page.title}">Edit</a>
{/if}
