<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
   
<html>

<head>
	<link rel = "shortcut icon" href = "resources/images/technowaxSmall.png" />
	<title>technowax.net &bull; {$pageTitle|default:"A community for people interested in all forms of modern technology."}</title>

	<link rel = "stylesheet" type = "text/css" href = "resources/stylesheets/main.css" />
</head>

<body>

</body>
	<div id = "header">
		<p class = "headerLogo">
			<img class = "headerLogo" src = "resources/images/technowax.png" alt = "technowax.net" title = "technowax.net" /><br />
		</p>

		<p class = "headerSlogan">
			A community for all forms of modern technology.
		</p>

		<ul id = "navigation">
		{foreach from = $listLinks item = "itemLink"}
			<li><a href = "{$itemLink.url}">{$itemLink.title}</a></li>
		{/foreach}
		</ul>
	</div>

	<div id = "content">

