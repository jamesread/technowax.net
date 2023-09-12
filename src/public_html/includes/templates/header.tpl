<!DOCTYPE html>
   
<html>

<head>
	<link rel = "shortcut icon" href = "resources/images/technowaxSmall.png" />
	<title>technowax.net &bull; {$pageTitle|default:'A collection of utilities.'}</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel = "stylesheet" type = "text/css" href = "resources/stylesheets/main.css" />
	<script src = "resources/js/main.js" type = "text/javascript"></script>
</head>

<body>

</body>
	<header>
		<p class = "headerLogo">
			<a href = "index.php"><img id = "headerLogo" src = "resources/images/technowax.png" alt = "technowax.net" title = "technowax.net" /></a>
		</p>

		<button id = "sidebarToggle" onclick = "javascript:sidebarToggle()">&laquo; Close</button>
	</header>

	<nav>
		<ul id = "navigationMain">
		{foreach from = $listLinks item = "itemLink"}
			<li><a href = "{$itemLink.url}">{$itemLink.title}</a></li>
		{/foreach}
		</ul>

		<ul id = "navigationAccount">
		{foreach from = $listLinksAccount item = "itemLink"}
			<li><a href = "{$itemLink.url}">{$itemLink.title}</a></li>
		{/foreach}
		</ul>
	</nav>

	<main>

