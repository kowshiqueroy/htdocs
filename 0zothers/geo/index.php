<!DOCTYPE html>
<html>
<body>
<h1>HTML Geolocation</h1>
<p>Click the button to get your coordinates.</p>



<p id="demo"></p>

<script>
const x = document.getElementById("demo");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.watchPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}
    
function showPosition(position) {
    var requestOptions = {
  method: 'GET',
};




    x.innerHTML="" + position.coords.latitude + 
    " " + position.coords.longitude + " "+
    "<a href ='https://api.geoapify.com/v1/geocode/reverse?lat="+position.coords.latitude +
    "&lon="+position.coords.longitude +"&apiKey=fea23cadb4db4002bc154d386852aa39'>click </a>"
}

getLocation();
</script>

</body>
</html>