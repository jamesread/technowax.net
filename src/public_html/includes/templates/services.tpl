<section>
	<h2>Community</h2>

	<p>
		Most of the technowax community is on
		{if $discordInviteUrl}
			<a href = "{$discordInviteUrl}" class = "external">Discord</a>
		{else}
			Discord
		{/if}
		right now. This website is for self-hosting utilities, documentation, and account services — not forums or chat.
	</p>
</section>

<section>
	<h2>Services for self-hosters</h2>

	<p>Practical tools for people who run their own software and infrastructure. No account required for lookups; account required for personal services.</p>

	<p>See also <a href = "/projects">featured open source projects</a> curated for this community.</p>

	<dl>
		<dt><a href = "/tools/dns-lookup">DNS lookup</a></dt>
		<dd>Query A, AAAA, MX, CNAME, and other records for a hostname. Useful when debugging mail, reverse proxies, and split-horizon DNS.</dd>

		<dt><a href = "/markdown">Document repos</a></dt>
		<dd>Markdown files served from this site — intended for homelab notes, stack documentation, and config references you want to share or browse in one place.</dd>

		<dt><a href = "/dyndns/updates">Dynamic DNS</a></dt>
		<dd>
			{if $isLoggedIn}
				Record your current public IPv4 address from routers, scripts, or ddclient-compatible clients.
			{else}
				<a href = "/login">Log in</a> or <a href = "/register">register</a> to receive a personal update endpoint and view your update history.
			{/if}
		</dd>
	</dl>
</section>

<section>
	<h2>Running your own stack</h2>

	<p>This instance is a development deployment. Production content will focus on open source software, self-hosting, and modern infrastructure without hype or vendor funnels.</p>

	<p>If you are evaluating the site: join Discord for discussion, create an account here for dynamic DNS, and watch the document repos for published guides.</p>
</section>
