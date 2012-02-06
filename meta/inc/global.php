<?php
//sitewide functions and utilities, holds global functions that can be included on all kinds of pages

//function validates the user's search term(s) to make sure that they contain only valid characters. A list of valid characters is given in the validChar string below.
function validation($q)
{
  $localQ = strtolower($q);


  $validChar = "abcdefghijklmnopqrstuvwxyz\"',.?&:;-()/\ 1234567890&amp;";

  $length = strlen($localQ);
  for($i = 0; $i < $length; $i++)
  {
	 if(!strstr($validChar, $localQ[$i]))
	 {
		echo "<h2><strong>Your search contains invalid characters</strong></h2>\n";
		echo "<hr />\n";
		echo "<h3>The search string \"$localQ\" contains an invalid character(s)!!<br /><br /> 
			  Please use your browser's <strong>BACK</strong> button and fix the error. Then resubmit your request.</h3>\n";

		return false;
	 } 
  }

  return true;
}//end validation()

//function displays a message box to the user if their search resulted in no matching item/records. When the user clicks the OK button they are taken back to the main search page.
function noMatches()
{
  echo "<h2><strong>There are no resulting matches</strong></h2>\n";
  echo "<hr />\n"; 
  echo "<h3>There are no items in the database that match your search value(s).<br /><br /> 
		Please try again!!!</h3>\n";
}//end noMatches()

//function converts rfc 822 date into unix timestamp
function dateConvert($rssDate)
{
$rawdate=strtotime($rssDate);
if ($rawdate == -1) {
		$convertedDate = 'conversion failed';
    } else {
		$convertedDate = date('Y-m-d h:i:s',$rawdate);
		return $convertedDate;
    }
}
//end dateConvert

//function converts timestamp into rfc 822 date
function dateConvertTimestamp($timestamp)
{
$rawdate=strtotime($timestamp);
if ($rawdate == -1) {
		$convertedDate = 'conversion failed';
    } else {
		$convertedDate = date('D, d M Y h:i:s T',$rawdate);
		return $convertedDate;
    }
}
//end dateConvertTimestamp

//this function matches and highlights words used in the search query
function highlightWords($string, $words) {
	foreach ($words as $word) {
		$string = str_ireplace($word, '<span class="highlight">'.$word.'</span>', $string);
	}
	//return the highlighted string
	return $string;
}//end highlightWords()

?>
