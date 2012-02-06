	<h2 class="result">Local topics for BookMeUp</h2>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>
	//$("p.terms").load(function(getLocation)) {
	//$('#tab2').bind('click', function(getLocation) {
	//if ($('body').hasClass('where')) {
	//if ($('.terms').length>0) {

	$('#tab2').on('click', function() {	
	
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(getSubjects);
			} else {
				//onError();
				alert('Error: Your browser doesn\'t support geolocation.');
			}
		
		function getSubjects(position) {
			//set latitude and longitude values
			var lat = parseFloat(position.coords.latitude);
			var lon = parseFloat(position.coords.longitude);
			url = "http://experimental.worldcat.org/mapfast/services?geo=" + lat + "," + lon + ";crs=wgs84&radius=100000&mq=&sortby=distance&max-results=25";
			$.getJSON(url, showSubjects);
		}
	
		function showSubjects(data) {
			$.each(data.Placemark, showSubject);
		}
	
		function showSubject(index, subject) {
			//display results as html
			var term = subject.name.replace(/ -- /g, " ");    
			//var url = "http://www.worldcat.org/search?q=su:" + term + "&qt=advanced";
			var url = "./index.php?view=search&q=" + term;
			
			html = '<a href="' + url + '">' + term + '</a> ';
			$('.terms').append('<span>' + html + '</span>');
		}
	});
	</script>
	<p class="terms"> </p>
	<a class="bck" href="./index.php?view=search">home</a>

