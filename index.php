<?php
//set value for title of page
$pageTitle = 'BookMeUp';
$subTitle = '@ The Library';
//set default tab and page view
$view = isset($_GET['view']) ? htmlentities($_GET['view']) : 'search';
//set filename for additional stylesheet - default is "none"
$customCSS = 'none';
//create an array with filepaths for multiple page scripts - default is meta/scripts/global.js
//$customScript[0] = './meta/scripts/global.js';
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<!-- force latest IE rendering engine -->
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<meta http-equiv="Cache-control" content="max-age=2592000, public" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title><?php echo $pageTitle.' '.$subTitle; ?></title>
<meta name="description" content="BookMeUp uses the Amazon Product Advertising API to suggest related books to read based on a user's location and/or search query."/>
<meta property="og:title" content="<?php echo $pageTitle.' '.$subTitle; ?>"/>
<meta property="og:description" content="BookMeUp uses the Amazon Product Advertising API to suggest related books to read based on a user's location and/or search query."/>
<meta property="og:image" content="http://www.lib.montana.edu/beta/bookme/meta/img/bookmeup-share-default.png"/>
<meta property="og:url" content="http://www.lib.montana.edu/beta/bookme/"/>
<meta property="og:type" content="website"/>
<meta name="twitter:creator" property="og:site_name" content="@jaclark"/>
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:site" content="http://www.jasonclark.info"/>
<link rel="apple-touch-icon" href="./meta/img/msu-mobile.png"/>
<link rel="manifest" href="manifest.json"/>
<!--<link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
<link href="https://experimental.worldcat.org/" rel="preconnect" crossorigin />-->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:700italic,400,700" rel="stylesheet" />
<link href="./meta/styles/m-app.css" media="screen" rel="stylesheet" />
<?php
if ($customCSS != 'none') {
echo '<link href="'.dirname($_SERVER['PHP_SELF']).'./meta/styles/'.$customCSS.'" media="screen" rel="stylesheet" type="text/css" />'."\n";
}
if ($customScript) {
$counted = count($customScript);
for ($i = 0; $i < $counted; $i++) {
echo '<script type="text/javascript" src="'.$customScript[$i].'"></script>'."\n";
}
}
?>
</head>
<body class="<?php echo $view; ?>">
<div id="doc">
	<div id="hd">
	<h1><?php echo $pageTitle.' '. $subTitle; ?></h1>
	<ul id="nav" role="tablist">
		<li role="tab" aria-controls="main" id="tab1"><a accesskey="1" class="icon-search" href="./index?view=search">Suggest</a></li>
		<li role="tab" aria-controls="main" id="tab2"><a accesskey="2" class="icon-map" href="./index?view=where">Where</a></li>
		<li role="tab" aria-controls="main" id="tab3"><a accesskey="3" class="icon-info-circle" href="./index?view=about">What</a></li>
	</ul><!-- end nav list -->
	</div><!-- end hd div -->
	<div role="tabpanel" id="main">
		<?php include "switch.php"; ?>
	</div><!-- end main div -->
	<div id="ft">
	<p class="info">
		<a accesskey="4" class="site icon-browser" title="full site" href="/index.php">MSU Library</a>
		<a accesskey="5" class="worldcat" title="powered by worldcat.org" href="http://www.worldcat.org/">Worldcat</a>
	</p>
	</div><!-- end ft div -->
</div><!-- end doc div -->
</body>
</html>
