	<h2 class="result">Local topics for BookMeUp</h2>
	<p id="message" style="display:none"><img src="./meta/img/loading.gif" id="loading" /> Waiting for Godot...</p>
	<p class="terms"> </p>
        <script id="worker" type="text/javascript">
if (navigator.geolocation) {
        //show loading message
        var msg = document.getElementById("message");
        msg.style.display = 'block';
        navigator.geolocation.getCurrentPosition(setScript);
        console.log('geolocation done');
} else {
        //onError();
        alert('Error: Your browser doesn\'t support geolocation.');
}

function setScript(position) {
        //set latitude and longitude values
        var lat = parseFloat(position.coords.latitude);
        var lon = parseFloat(position.coords.longitude);
        var script = document.createElement('script');
        script.src = "https://experimental.worldcat.org/mapfast/services?geo=" + lat + "," + lon + ";crs=wgs84&radius=100000&mq=&sortby=distance&max-results=30&callback=showSubjects";
        document.querySelector('.terms').appendChild(script);
        //document.getElementsByTagName('body')[0].appendChild(script);
}

function showSubjects(data) {
        //hide loading message
        var msg = document.getElementById("message");
        msg.style.display = 'none';
        var container = document.getElementById("terms");
        var markup = '<span>';
        //var url = "http://www.worldcat.org/search?q=su:" + term + "&qt=advanced";
        var url = "./index?view=search&q=";
        for (var i = 0; i < data.Placemark.length; i++) {
                var cleanTerm = data.Placemark[i].name.replace(/ -- /g, " ");
                markup += '<a title="' + data.Placemark[i].name + '" href="' + url + cleanTerm + '">' + data.Placemark[i].name + '</a>';
        }
        container.innerHTML = markup + '</span>';
}
        </script>
	<a class="bck" href="./index.php?view=search">home</a>

