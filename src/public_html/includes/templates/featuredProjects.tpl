<section>
	<h2>Featured projects</h2>

	<p>Open source projects curated from <a href = "https://jread.com/projects" class = "external">jread.com/projects</a> — practical software for self-hosters and homelab operators.</p>

	{if $featuredProjects|@count eq 0}
		<p>No featured projects have been imported yet.</p>
	{else}
		{foreach from = $featuredProjects item = project}
		<article class = "featured-project">
			<h3>
				{if $project.homepage_url}
					<a href = "{$project.homepage_url}" class = "external">{$project.name}</a>
				{else}
					{$project.name}
				{/if}
			</h3>

			{if $project.description}
				<p>{$project.description}</p>
			{/if}

			<ul>
				{if $project.github_url}
					<li><a href = "{$project.github_url}" class = "external">GitHub</a></li>
				{/if}
				{if $project.docs_url}
					<li><a href = "{$project.docs_url}" class = "external">Documentation</a></li>
				{/if}
				{if $project.homepage_url}
					<li><a href = "{$project.homepage_url}" class = "external">Project page</a></li>
				{/if}
			</ul>
		</article>
		{/foreach}
	{/if}
</section>
