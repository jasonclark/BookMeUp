	<h2 class="result">Local topics for BookMeUp</h2>
	<p id="message" style="display:none"><img src="./meta/img/loading.gif" id="loading" /> Waiting for Godot...</p>
	<p id="terms" class="terms"> </p>
<script id="worker" type="text/javascript">
const msg = document.getElementById("message");
if (navigator.geolocation) {
  //show loading message
  msg.style.display = 'block';
  navigator.geolocation.getCurrentPosition(showTerms);
  console.log('geolocation done');
} else {
  //error with geolocation
  alert('Error: Your browser doesn\'t support geolocation.');
}

function showTerms({coords}) {
  const lat = parseFloat(coords.latitude);
  const lon = parseFloat(coords.longitude);
  const coordinates = `${lat}|${lon}`;
  //console.log(coordinates);

  let api_url = 'https://en.wikipedia.org/w/api.php';

  const params = {
    action: "query",
    list: "geosearch",
    gscoord: coordinates,
    gsradius: "10000",
    gslimit: "25",
    format: "json"
  };

  api_url = `${api_url}?origin=*`;
  Object.keys(params).forEach(key => {
    api_url += `&${key}=${params[key]}`;
  });
  //console.log(url);

  fetch(api_url)
    .then(response => response.json())
    .then(({query}) => {
      //hide loading message
      msg.style.display = 'none';
      const container = document.getElementById("terms");
      let markup = '';
      const search_url = 'http://www.worldcat.org/search?q=su:';
      //const search_url = './index.html?&q=';
      const pages = query.geosearch;
      for (const page in pages) {
        //console.log(`Title: ${pages[page].title}`);
	markup += `<span><a title="${pages[page].title}" href="${search_url}${pages[page].title}">${pages[page].title}</a></span>`;
      }
      //container.appendChild(`${markup}`);
      container.innerHTML = `${markup}`;
    })
    .catch(error => {
      console.log(error);
    });
}
</script>
	<a class="bck" href="./index.php?view=search">home</a>

