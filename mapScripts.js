mapboxgl.accessToken = 'pk.eyJ1IjoiZ2VvcmdlZ29vZGV5IiwiYSI6ImNrd3h0NHNjbjAxdDEycG55MXBwaHEzMGYifQ.iu3DK1jhWiFeF7Es8Ysgvw';
const geojson = {
    'type': 'FeatureCollection',
    'features': [
    {
    'type': 'Feature',
    'properties': {
    'message': 'Factory',
    'iconSize': [60, 60]
    },
    'geometry': {
    'type': 'Point',
    'coordinates': [-2.23733, 53.47404]
    }
    },
    {
    'type': 'Feature',
    'properties': {
    'message': 'Turing',
    'iconSize': [50, 50]
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
    }
    ]
    };
const map = new mapboxgl.Map({
    container: 'map', // container ID
    style: 'mapbox://styles/georgegoodey/ckzwvtg49000514p0t2ugjdc7', // style URL
    center: [-2.234618, 53.475721], // starting position [lng, lat]
    zoom: 13.85 // starting zoom
});
for (const marker of geojson.features) {
    // Create a DOM element for each marker.
    const el = document.createElement('div');
    const width = marker.properties.iconSize[0];
    const height = marker.properties.iconSize[1];
    el.className = 'marker';
    el.style.backgroundImage = `url(https://mms.businesswire.com/media/20210921005137/en/513573/4/Square_Logo.jpg)`;
    el.style.width = `${width}px`;
    el.style.height = `${height}px`;
    el.style.backgroundSize = '100%';
     
    el.addEventListener('click', () => {
    window.alert(marker.properties.message);
    });
     
    // Add markers to the map.
    new mapboxgl.Marker(el)
    .setLngLat(marker.geometry.coordinates)
    .addTo(map);
}