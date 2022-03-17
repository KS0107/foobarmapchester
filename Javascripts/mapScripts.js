mapboxgl.accessToken = 'pk.eyJ1Ijoia3MwMTA3IiwiYSI6ImNrd3hpa2djNzBlYjYydnExYXJ3bXVqNW8ifQ.4eD36Q7KuGJIPegaAn37NQ';

const bounds = [
    [-2.279723291346777, 53.43227454888223], // Southwest coordinates
    [-2.181081425869853, 53.50590158784653] // Northeast coordinates
];

var map = new mapboxgl.Map({
    container: 'map', // container ID
    style: 'mapbox://styles/ks0107/ckzznmnzk001e14o50943ru4p', // style URL
    center: [-2.234618, 53.475721], // starting position [lng, lat]
    zoom: 13.85, // starting zoom
    maxBounds: bounds
});

var blackStyle = true

function changeMapStyle(){
    if(blackStyle){
        console.log("is now white")
        map.setStyle("mapbox://styles/georgegoodey/ckzznt1rc013614rweroxr40f");//mapbox://styles/georgegoodey/ckzznt1rc013614rweroxr40f
        blackStyle = false;
    }else{
        map.setStyle('mapbox://styles/ks0107/ckzznmnzk001e14o50943ru4p');
        blackStyle = true;
    }
}

for (const marker of getMarkers().features) {
    // Create a DOM element for each marker.
    const el = document.createElement('div');
    const width = marker.properties.iconSize[0];
    const height = marker.properties.iconSize[1];
    el.className = 'marker';
    el.id = "mapmarker";
    el.style.width = `${width}px`;
    el.style.height = `${height}px`;
    el.style.backgroundSize = '100%';
     
    el.addEventListener('click', () => {
        //window.alert(marker.properties.message);
        let locationName = document.getElementById("locationName");
        locationName.textContent = marker.properties.message;
        getLocation(locationName.textContent);
    });
     
    // Add markers to the map.
    new mapboxgl.Marker(el)
    .setLngLat(marker.geometry.coordinates)
    .addTo(map);
}