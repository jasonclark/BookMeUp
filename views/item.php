<?php
//set default value for query
$id = isset($_GET['id']) ? $_GET['id'] : null;

$worldcatKey = 'B3F6fY0fdaYyWFaU2a5a25QD28BsxH6H8wZnViTESKxZZBR7Fg71nC0V6IeXa78EKAYsGzhMAyYyEihv';

$base = 'http://www.worldcat.org/webservices/catalog/content/isbn/'.$id.'?&recordSchema=info%3Asrw%2Fschema%2F1%2Fdc';
$base .= '&wskey='. $worldcatKey;

//build request and send to Worldcat Search API
$request = simplexml_load_file($base);

//prepare dublin core namespace for parsing
$dc = $request->children('http://purl.org/dc/elements/1.1/');

$title = $dc->title;

if (strlen($title) > 0 ): //item available
	
	$title = $dc->title;
	$author = $dc->creator;
	$date = $dc->date;
	$format = $dc->format;

	$oclc = $request->children('http://purl.org/oclc/terms/');
	$lccnNumber = trim($oclc->recordIdentifier[0]);
	$oclcNumber = trim($oclc->recordIdentifier[1]);

	$remoteImageUrl = 'http://covers.openlibrary.org/b/isbn/'.$id.'-S.jpg';
	list($width, $height) = getimagesize($remoteImageUrl); 
	//echo $width;
	if ($width > 30){
		//thumbnail available
		$thumbnail = $remoteImageUrl;
	}else{
		//set default thumbnail
		$thumbnail = './meta/img/thumbnail-default.gif';
	}	
?>

<h2>Worldcat Item</h2>
<ul class="item">
<li>
<img src="<?php echo $thumbnail; ?>" />
<span class="meta"><strong><?php echo $title; ?></strong>
by <?php echo $author; ?> (<?php echo $date; ?>)<br />
<?php echo $format; ?><br />
<!--<a class="expand" href="http://www.worldcat.org/search?q=bn%3A<?php //echo $id; ?>&qt=advanced">Worldcat</a>-->
<a class="expand" href="http://www.worldcat.org/oclc/<?php echo $oclcNumber; ?>">Worldcat</a>
<a class="expand" href="http://lccn.loc.gov/<?php echo $lccnNumber; ?>">Library of Congress</a>
</li>
</ul>

<?php
else: //if item is not available
?>

<h2 class="result">Book with the <strong><?php echo $id; ?></strong> number/id is not available.</h2>
<p><a class="bck" href="./index.php?view=search">Try a new search</a>.</p>

<?php
//end submit isset if statement on line 35
endif;
?>