<!DOCTYPE html>
<html>

<head>

<title>
Peta Pelabuhan Dunia
</title>


<link 
rel="stylesheet"
href="https://unpkg.com/leaflet/dist/leaflet.css"
/>


<style>

#map {

height: 600px;
width:100%;

}

</style>


</head>


<body>


<h2>
🗺️ Peta Pelabuhan Dunia
</h2>


<div id="map"></div>



<script src="
https://unpkg.com/leaflet/dist/leaflet.js">
</script>



<script>


// posisi awal dunia

var map = L.map('map')
.setView([10,0],2);



L.tileLayer(
'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
{

maxZoom:18,

attribution:
'© OpenStreetMap'

}

).addTo(map);



// data dari Laravel

var ports = @json($ports);



ports.forEach(function(port){


    var marker = L.marker(
    [
        port.latitude,
        port.longitude
    ]
    )
    .addTo(map);



    marker.bindPopup(`


        <div>


        <h3>
        ⚓ ${port.port_name}
        </h3>


        <b>Negara:</b>
        ${port.country_name}
        <br>


        <b>Kota:</b>
        ${port.city}
        <br>


        <b>Kode:</b>
        ${port.port_code}


        <br><br>


        <a href="/ports/${port.id}">
        Detail Pelabuhan
        </a>


        </div>


    `);


});


</script>


</body>

</html>