mapboxgl.accessToken = 'pk.eyJ1IjoiZ2VvcmdlZ29vZGV5IiwiYSI6ImNrd3h0NHNjbjAxdDEycG55MXBwaHEzMGYifQ.iu3DK1jhWiFeF7Es8Ysgvw';
const map = new mapboxgl.Map({
    container: 'map', // container ID
    style: 'mapbox://styles/georgegoodey/ckzwvtg49000514p0t2ugjdc7', // style URL
    center: [-2.234618, 53.475721], // starting position [lng, lat]
    zoom: 13.85 // starting zoom
});