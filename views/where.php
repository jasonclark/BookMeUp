	<h2 class="result">Local topics for BookMeUp</h2>
	<p id="message" style="display:none"><img src="./meta/img/loading.gif" id="loading" /> Waiting for Godot...</p>
	<p class="terms"> </p>
        <script id="worker" type="text/javascript">
        var msg = document.getElementById("message");
	if (navigator.geolocation) {
                //show loading message
                msg.style.display = 'block';
                navigator.geolocation.getCurrentPosition(addScript);
                console.log('geolocation done');
        } else {
                //error with geolocation
                alert('Error: Your browser doesn\'t support geolocation.');
        }

        function addScript(position) {
                //set latitude and longitude values
                var lat = parseFloat(position.coords.latitude);
                var lon = parseFloat(position.coords.longitude);
                var jsonp = document.createElement('script');
                jsonp.type = 'text/javascript';
                jsonp.async = true;
                jsonp.src = "https://experimental.worldcat.org/mapfast/services?geo=" + lat + "," + lon + ";crs=wgs84&radius=100000&mq=&sortby=distance&max-results=30&callback=showSubjects";
                //document.querySelector('.terms').appendChild(script);
                var script = document.getElementsByTagName('script')[0];
                script.parentNode.insertBefore(jsonp, script);        
	}

        function showSubjects(data) {
                //hide loading message
                msg.style.display = 'none';
                var container = document.getElementById("terms");
                var markup = '<span>';
                //var url = "http://www.worldcat.org/search?q=su:" + term + "&qt=advanced";
                var url = "./index?view=search&q=";
                var i = -1;
                var length = data.Placemark.length;
                while (++i < length) {          
                //for (var i = 0; i < length; i++) {
                        var cleanTerm = data.Placemark[i].name.replace(/ -- /g, " ");
                        markup += '<a title="' + data.Placemark[i].name + '" href="' + url + cleanTerm + '">' + data.Placemark[i].name + '</a>';
                }       
                container.innerHTML = markup + '</span>';
        }               
        </script>
	<a class="bck" href="./index.php?view=search">home</a>

