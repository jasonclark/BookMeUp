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

  let url = "https://en.wikipedia.org/w/api.php";

  const params = {
    action: "query",
    list: "geosearch",
    gscoord: coordinates,
    gsradius: "10000",
    gslimit: "25",
    format: "json"
  };

  url = `${url}?origin=*`;
  Object.keys(params).forEach(key => {
    url += `&${key}=${params[key]}`;
  });
  //console.log(url);

  fetch(url)
    .then(response => response.json())
    .then(({query}) => {
      //hide loading message
      msg.style.display = 'none';
      const container = document.getElementById("terms");
      let markup = '<span>';
      const url = "http://www.worldcat.org/search?q=su:";
      //const url = "./index.html?&q=";
      const pages = query.geosearch;
      for (const page in pages) {
        //console.log(`Title: ${pages[page].title}`);
        markup += `<a title="${pages[page].title}" href="${url}${pages[page].title}">${pages[page].title}</a>`;
      }
      container.innerHTML = `${markup}</span> `;
    })
    .catch(error => {
      console.log(error);
    });
}
</script>
	<a class="bck" href="./index.php?view=search">home</a>

