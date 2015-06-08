<?php
//set default value for query
$id = isset($_GET['id']) ? htmlentities(strip_tags($_GET['id'])) : null;

$worldcatKey = 'YOUR-WORLDCAT-API-KEY-HERE';

$base = 'http://www.worldcat.org/webservices/catalog/content/isbn/'.$id.'?recordSchema=info%3Asrw%2Fschema%2F1%2Fdc&wskey='.$worldcatKey;

// print out Worldcat API response for troubleshooting
//echo $base;

//build request and send to Worldcat Search API
$request = simplexml_load_file($base);

//prepare dublin core namespace for parsing
$dc = $request->children('http://purl.org/dc/elements/1.1/');

$title = $dc->title;

if (strlen($title) > 0 ): //item available

	$title = $dc->title;
	$author = $dc->creator;
	$date = $dc->date;
	$publisher = $dc->publisher;
	$format = $dc->format;
	$isbn = trim($dc->identifier[0]);

	$oclc = $request->children('http://purl.org/oclc/terms/');

	//simple logic check for oclc and lccn values
	if (strlen($oclc->recordIdentifier[1]) > 2) {
		$oclcNumber = '/oclc/'.trim($oclc->recordIdentifier[1]);
	} elseif (empty($oclc->recordIdentifier[1])) {
		$oclcNumber = '/isbn/'.trim($dc->identifier[0]);
	} else {
		$oclcNumber = '/search?q=bn%3A'.$id.'&qt=advanced';
	}

	$lccnNumber = (strlen($oclc->recordIdentifier[0]) > 2) ? trim($oclc->recordIdentifier[0]) : $id;

	$remoteImageUrl = 'http://covers.openlibrary.org/b/isbn/'.$isbn.'-S.jpg';
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
<?php echo $publisher; ?><br />
<!--<a class="expand" href="http://www.worldcat.org/search?q=bn%3A<?php //echo $id; ?>&qt=advanced">Worldcat</a>-->
<a class="expand" href="http://www.worldcat.org<?php echo $oclcNumber; ?>">Worldcat</a>
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
