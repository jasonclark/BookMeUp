<?php
//set value for title of page
$pageTitle = 'BookMeUp';
$subTitle = '@ The Library';
//set default tab and page view
$view = isset($_GET['view']) ? $_GET['view'] : 'search';
//set filename for additional stylesheet - default is "none"
$customCSS = 'none';
//create an array with filepaths for multiple page scripts - default is meta/scripts/global.js
$customScript[0] = './meta/scripts/global.js';
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Cache-Control" content="max-age=200" />
<meta name="description" content="<?php echo $pageTitle.' '.$subTitle; ?>" />
<meta id="viewport" name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<title><?php echo $pageTitle.' '.$subTitle; ?></title>
<link rel="apple-touch-icon" href="./meta/img/msu-mobile.png" />
<link href="./meta/styles/m.css" media="screen" rel="stylesheet" type="text/css" />
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
<script type="text/javascript">
/*if (navigator.geolocation) {
	//navigator.geolocation.getCurrentPosition(getPosition, onError);
	navigator.geolocation.getCurrentPosition(getPosition);
	// also monitor position as it changes
	navigator.geolocation.watchPosition(getPosition);
} else {
	//onError();
	alert('Error: Your browser doesn\'t support geolocation.');
}

function getPosition(position) {
	//set latitude and longitude values
	var lat = position.coords.latitude;
	var lng = position.coords.longitude;
	//print latitude and longitude values into search form input hidden fields
	document.getElementById("lat").value = lat;
	document.getElementById("lng").value = lng;
}*/
</script>
</head>
<body class="<?php echo $view; ?>">
<div id="doc">
	<div id="hd">
	<h1><?php echo $pageTitle.' '. $subTitle; ?></h1>
    <ul id="nav">
        <li id="tab1"><a accesskey="1" href="./index.php?view=search">Suggest</a></li>
        <li id="tab2"><a accesskey="2" href="./index.php?view=where">Where?</a></li>
        <li id="tab3"><a accesskey="3" href="./index.php?view=about">What?</a></li>
    </ul><!-- end nav list -->
    </div><!-- end hd div -->
	<div id="main">
    	<?php include "switch.php"; ?>
    	</div><!-- end main div -->
	<div id="ft">
    <p class="info">
        <a accesskey="4" class="site" title="full site" href="http://twitter.com/jaclark">@jaclark</a>
        <a accesskey="5" class="worldcat" title="powered by worldcat.org" href="http://www.worldcat.org/">Worldcat</a>
	</p> 
	</div><!-- end ft div -->
</div><!-- end doc div -->
</body>
</html>
