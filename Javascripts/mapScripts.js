mapboxgl.accessToken = 'pk.eyJ1Ijoia3MwMTA3IiwiYSI6ImNrd3hpa2djNzBlYjYydnExYXJ3bXVqNW8ifQ.4eD36Q7KuGJIPegaAn37NQ';

document.addEventListener("DOMContentLoaded", () => {   //Otherwise the onclick is assigned before the DOM is loaded
    const lightandDarkButton = document.getElementById("lightD");
    if(lightandDarkButton != null){
        lightandDarkButton.onclick = LightFunction;
    }else{
        console.log("light function not found");
    }
    const slideButton = document.getElementById("slider");
    if(slideButton != null){
        slideButton.onclick = slideInOut;
    }else{
        console.log("slide function not found");
    }
});

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

markers = getMarkers();
let markersOnScreen = [];

function loadMarkers() {
    for (const marker of markers.features) {
        // Create a DOM element for each marker.
        const el = document.createElement('div');
        const width = marker.properties.iconSize[0];
        const height = marker.properties.iconSize[1];
        el.className = 'marker';
        el.id = "mapmarker"+marker.properties.message;
        el.style.width = `${height}px`;
        el.style.height = `${height}px`;
        el.style.backgroundSize = '100%';
        
        console.log(map.style.z);

        el.addEventListener('click', () => {
            //window.alert(marker.properties.message);
            let locationName = document.getElementById("locationName");
            locationName.textContent = marker.properties.message;
            getLocation(locationName.textContent);
        });
        
        markersOnScreen.push(el);
        // Add markers to the map.
        new mapboxgl.Marker(el)
        .setLngLat(marker.geometry.coordinates)
        .addTo(map);
    }
}

function updateMarkers(){
    console.log(map.style.z);
    markersOnScreen.forEach(element=>{
        element.style.width = "200px";
    })
}

loadMarkers()

map.on('render', () => {
    updateMarkers()
});

function displayReviews(reviews){
    var location = document.getElementById("locationName").textContent;

    let reviewTextBlockOut = ""
    let totalRating = 0;
    for (let i = 0; i < reviews.length; i++) {
        totalRating += parseInt(reviews[i].rating);
    }
    finalRating = totalRating / reviews.length
    finalRating = Math.round(finalRating * 100)/100
    reviewTextBlockOut += "Rating of: " + finalRating + "\n\n\n";
    for (let i = 0; i < reviews.length; i++) {
        reviewTextBlockOut += ("Reviewed On: " + reviews[i].date + "\n");
        reviewTextBlockOut += ("Given A Score Of: " + reviews[i].rating + " Out Of 5" + "\n");
        reviewActualText = reviews[i].review
        for (let i = 0; i < Math.floor(reviewActualText.length / 30); i++) {
            reviewLineByLine = reviewActualText.split("\n");
            console.log(reviewLineByLine)
            foundSpace = false;
            decrement = 0;
            // while(!foundSpace){
            //     if(reviewLineByLine[i][30-decrement] == " "){
            //         console.log(reviewLineByLine[i][30-decrement])
            //         reviewLineByLine[i] = reviewLineByLine[i].slice(0, 30-decrement) + "\n" + reviewLineByLine[i].slice(30-decrement);
            //         foundSpace = true;
            //     }else{
            //         decrement ++;
            //     }
            // }
            console.log(reviewLineByLine)
            reviewTextTemp = ""
            reviewLineByLine.forEach(element => {
                reviewTextTemp += element + "\n"
            });
            reviewActualText = reviewTextTemp;
        }
        reviewTextBlockOut += ("Review: " + reviewActualText + "\n\n");
    }
    let pre = document.querySelector("#msg pre");
    pre.textContent = reviewTextBlockOut;
}

function getLocation(MarkerLocation){
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function(){
        text = JSON.parse(this.responseText);
        displayReviews(text);
    }
    xhttp.open("POST","../restapi/index.php/user/showReviews");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("LocationName=" + MarkerLocation);
}

let i = 1;
function LightFunction() {
    if (i % 2 != 0) {
        document.body.style.backgroundColor = "lightgrey";
        document.getElementById("reviewBar").style.backgroundColor = "lightgrey";
        document.body.style.color = "black";
        document.getElementById("lightD").innerText = "Dark Mode"
        changeMapStyle();
        i++;
    } else {
        document.body.style.backgroundColor = "rgb(7, 7, 7)";
        document.getElementById("reviewBar").style.backgroundColor = "rgb(7, 7, 7)";
        document.body.style.color = "white";
        document.getElementById("lightD").innerText = "Light Mode"
        changeMapStyle();
        i++;
    }
}

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