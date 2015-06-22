	<h2 class="result">Local topics for BookMeUp</h2>
	<p id="message" style="display:none"><img src="./meta/img/loading.gif" id="loading" /> Waiting for Godot...</p>
	<p class="terms"> </p>
  <script type="text/javascript">
	if (navigator.geolocation) {
		//show loading message
		var msg = document.getElementById("message");
		msg.style.display = 'block';
		navigator.geolocation.getCurrentPosition(getSubjects);
		console.log('geolocation done');
	} else {
		//onError();
		alert('Error: Your browser doesn\'t support geolocation.');
	}

	function getSubjects(position) {
		//set latitude and longitude values
		var lat = parseFloat(position.coords.latitude);
		var lon = parseFloat(position.coords.longitude);
		var url = "http://experimental.worldcat.org/mapfast/services?geo=" + lat + "," + lon + ";crs=wgs84&radius=100000&mq=&sortby=distance&max-results=30&callback=?";
		$.getJSON(url, showSubjects);

		/*$.ajax({
      type: 'GET',
      url: url,
      contentType: 'application/json',
      dataType: 'jsonp',
      crossDomain: true,
      xhrFields: { withCredentials: true }
    }).done(showSubjects);*/

	}

	function showSubjects(data) {
    $.each(data.Placemark, showSubject);
		//hide loading message
		var msg = document.getElementById("message");
		msg.style.display = 'none';
	}

	function showSubject(index, subject) {
		//display results as html
		var term = subject.name.replace(/ -- /g, " ");
		//var url = "http://www.worldcat.org/search?q=su:" + term + "&qt=advanced";
		var url = "./index?view=search&q=" + term;

		html = '<a href="' + url + '">' + term + '</a> ';
		$('.terms').append('<span>' + html + '</span>');
	}
	</script>
  <script async src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<a class="bck" href="./index.php?view=search">home</a>

