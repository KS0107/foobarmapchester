mapboxgl.accessToken = 'pk.eyJ1Ijoia3MwMTA3IiwiYSI6ImNrd3hpa2djNzBlYjYydnExYXJ3bXVqNW8ifQ.4eD36Q7KuGJIPegaAn37NQ';
const geojson = {
    'type': 'FeatureCollection',
    'features': [
        {
            'type': 'Feature',
            'properties': {
                'message': 'Factory',
                'iconSize': [40, 40]
            },
            'geometry': {
                'type': 'Point',
                'coordinates': [-2.23733, 53.47404]
            }
        },
        {
            'type': 'Feature',
            'properties': {
                'message': 'Turing Tap',
                'iconSize': [40, 40]
            },
            'geometry': {
                'type': 'Point',
                'coordinates': [-2.22935, 53.46252]
            }
        },
        {
            'type': 'Feature',
            'properties': {
                'message': 'Footage',
                'iconSize': [40, 40]
            },
            'geometry': {
                'type': 'Point',
                'coordinates': [-2.23687, 53.47016]
            }
        },
        {
            'type': 'Feature',
            'properties': {
                'message': 'Mojo',
                'iconSize': [40, 40]
            },
            'geometry': {
                'type': 'Point',
                'coordinates': [-2.249815066033617, 53.481263991254615]
            }
        },
        {
            'type': 'Feature',
            'properties': {
                'message': 'Gay',
                'iconSize': [40, 40]
            },
            'geometry': {
                'type': 'Point',
                'coordinates': [-2.2379910112825154, 53.47647216906738]
            }
        },
        {
            'type': 'Feature',
            'properties': {
                'message': 'Cargo',
                'iconSize': [40, 40]
            },
            'geometry': {
                'type': 'Point',
                'coordinates': [-2.2412459798138444, 53.48478796773415]
            }
        },
        {
            'type': 'Feature',
            'properties': {
                'message': 'The Paramount',
                'iconSize': [40, 40]
            },
            'geometry': {
                'type': 'Point',
                'coordinates': [-2.242571365193075, 53.47653556884342]
            }
        }
    ]
};

var map = new mapboxgl.Map({
    container: 'map', // container ID
    style: 'mapbox://styles/ks0107/ckzznmnzk001e14o50943ru4p', // style URL
    center: [-2.234618, 53.475721], // starting position [lng, lat]
    zoom: 13.85 // starting zoom
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

for (const marker of geojson.features) {
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
        seeReviews();
    });
     
    // Add markers to the map.
    new mapboxgl.Marker(el)
    .setLngLat(marker.geometry.coordinates)
    .addTo(map);
}