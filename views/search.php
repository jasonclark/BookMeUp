<h2>I'm reading...</h2>
<?php
//set default value for Worldcat API key
$key = isset($_GET['key']) ? trim(strip_tags(urlencode($_GET['key']))) : 'YOUR-WORLDCAT-API-KEY-HERE';
//set default value for query
$q = isset($_GET['q']) ? trim(strip_tags(urlencode($_GET['q']))) : null;
//set default value for latitude
//$lat = isset($_GET['lat']) ? $_GET['lat'] : null;
//set default value for longitude
//$lng = isset($_GET['lng']) ? $_GET['lng'] : null;
//set default value for library collection to search - list available at http://www.oclc.org/contacts/libraries/
//docs here - http://oclc.org/developer/documentation/worldcat-search-api/library-catalog-url
$library = isset($_GET['library']) ? trim(strip_tags($_GET['library'])) : 'YOUR-OCLC-LIBRARY-ID-HERE';

?>

<form id="searchBox" method="get" action="./index?view=search">
<fieldset>
	<label class="hidden" for="q">Search</label>
	<input type="text" maxlength="200" name="q" id="q" tabindex="1" placeholder="keyword, isbn, title..." autofocus />
	<button type="submit" id="btn" class="button">Search</button>
</fieldset>
</form>
<p id="message" style="display:none"><img src="./meta/img/loading.gif" alt="loading" id="loading" /> Time to make the donuts...</p>
<script>
window.onload = function() {
var submit = document.getElementById('btn');
	submit.onclick = function() {
		var msg = document.getElementById("message");
		msg.style.display = 'block';
	}
}
</script>

<?php
if (!is_null($q)): //if form has value, run query and show recommendations

//your AWS Access Key ID, as taken from the AWS Your Account page
$aws_access_key_id = 'YOUR-AMAZON-PRODUCT-ADVERTISING-PUBLIC-API-KEY-HERE';
//your AWS Secret Key corresponding to the above ID, as taken from the AWS Your Account page
$aws_secret_key = 'YOUR-AMAZON-PRODUCT-ADVERTISING-PRIVATE-API-KEY-HERE';
//your Amazon Associate tag, as taken from the Amazon Affiliates page
$aws_associate_tag = 'YOUR-AMAZON-ASSOCIATES-TAG-HERE';
//the region you are interested in
$endpoint = 'webservices.amazon.com';
$uri = '/onca/xml';

$params = array(
        "Service" => "AWSECommerceService",
        "Operation" => "ItemSearch",
        "AWSAccessKeyId" => "$aws_access_key_id",
        "AssociateTag" => "$aws_associate_tag",
        "SearchIndex" => "Books",
        "Keywords" => "$q",
        "ResponseGroup" => "EditorialReview,Images,ItemAttributes,Reviews,Similarities",// we want images, item info, reviews, and similar items
        "Sort" => "relevancerank"
);

//set current timestamp if not set
if (!isset($params["Timestamp"])) {
	$params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
}

//sort the parameters by key
ksort($params);

$pairs = array();

foreach ($params as $key => $value) {
	array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
}

//generate the canonical query
$canonical_query_string = join("&", $pairs);

//generate the string to be signed
$string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;

//generate the signature required by the Product Advertising API
$signature = base64_encode(hash_hmac("sha256", $string_to_sign, $aws_secret_key, true));

//generate the signed URL
$request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);
//echo "Signed URL: \"".$request_url."\"";

$request=simplexml_load_file($request_url) or die ('API response not loading');

if($request->Items->TotalResults > 0) {

//we have at least one response
//set Amazon xml values as specifc variables to be printed out below
$image = $request->Items->Item->SmallImage->URL;
if (empty($image)) { $image = './meta/img/thumbnail-default.gif'; }
$title = $request->Items->Item->ItemAttributes->Title;
//set creator using conditional check for value in two different XML nodes
$creator = 
        (!empty($request->Items->Item->ItemAttributes->Author)) ? $request->Items->Item->ItemAttributes->Author :
        ((empty($request->Items->Item->ItemAttributes->Author) ? $request->Items->Item->ItemAttributes->Director :
        '* Publisher Not Available'));
//simple logic check for author and director values
//$author = $request->Items->Item->ItemAttributes->Author;
/*if (strlen($author) > 2) {
        $creator = $author;
} elseif (empty($author)) {
        $creator = $request->Items->Item->ItemAttributes->Director;
} else {
        $creator = '* Creator Not Available';
}*/
//set publisher using conditional check for value in two different XML nodes
$publisher = 
        (!empty($request->Items->Item->ItemAttributes->Publisher)) ? $request->Items->Item->ItemAttributes->Publisher : 
        ((empty($request->Items->Item->ItemAttributes->Publisher) ? $request->Items->Item->ItemAttributes->Label : 
        '* Publisher Not Available'));
//simple logic check for publisher and label values
/*$brand = $request->Items->Item->ItemAttributes->Publisher;
if (strlen($brand) > 2) {
        $publisher = $brand;
} elseif (empty($brand)) {
        $publisher = $request->Items->Item->ItemAttributes->Label;
} else {
        $publisher = '* Publisher Not Available';
}*/
$asin = $request->Items->Item->ASIN;
$pages = $request->Items->Item->ItemAttributes->NumberOfPages;
$date = $request->Items->Item->ItemAttributes->ReleaseDate;
$uri = $request->Items->Item->DetailPageURL;
//$editorialReview = $request->Items->Item->EditorialReviews->EditorialReview->Content;
//$customerReviews = $request->Items->Item->CustomerReviews->IFrameURL;

//print out Amazon xml values as html
echo '<h3>Hmmm... If you are reading...</h3>'."\n";
echo '<ul class="item" >'."\n";
	echo '<li>'."\n";
		echo '<img src="'.$image.'" />'."\n";
		echo '<span class="meta"><strong>'.$title.'</strong>'."\n";
		echo 'by '.$creator.'<br />'.$pages.' pages, '.$date.'<br />'.$publisher.'<br /><a class="expand" href="'.$uri.'">Get full details</a></span>'."\n";
		//echo '<p><a class="expand" href="'.html_entity_decode($customerReviews).'">Customer Reviews</a></p>'."\n";
		//echo '<p><strong>Editorial review:</strong> '.html_entity_decode($editorialReview).'</p>'."\n";
	echo '</li>'."\n";
echo '</ul>'."\n";
echo '<h3>You should check out...</h3>'."\n";
echo '<ul class="match">'."\n";
if ($request->Items->Item->SimilarProducts->SimilarProduct == null) {
	echo '<li>We couldn\'t find related books. Try a more specific query.</li>'."\n";
} else {
        foreach ($request->Items->Item->SimilarProducts->SimilarProduct as $related) {
		$remoteImageUrl = 'http://covers.openlibrary.org/b/isbn/'.$related->ASIN.'-S.jpg';
		list($width, $height) = getimagesize($remoteImageUrl);
		//echo $width;
		if ($width > 30){
			//thumbnail available
			$thumbnail = $remoteImageUrl;
		} else {
			//set default thumbnail
			$thumbnail = './meta/img/thumbnail-default.gif';
		}
	echo '<li>'."\n";
		echo '<img src="'.$thumbnail.'" />'."\n";
		echo '<span class="meta"><strong>'.html_entity_decode($related->Title).'</strong>'."\n";
		echo '<br /><a class="expand" href="./index?view=item&id='.$related->ASIN.'">Check Worldcat</a></span>'."\n";
	echo '</li>'."\n";
	}
}
echo '</ul>'."\n";
echo '<p><a class="bck" href="./index.php?view=search">new search</a></p>'."\n";
}
else {
//no search results
echo '<h2 class="result">No results for your query <strong>"'.$q.'"</strong></h2>'."\n";
echo '<p><a class="bck" href="./">Try a new search</a>.</p>'."\n";
}

//end submit isset if statement on line 35
endif;
?>
