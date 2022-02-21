//import 'mapbox-gl/dist/mapbox-gl.css';

const seeReviews = (ev) => {
    const location = document.getElementById("location").value

    console.log(location)
    const reviewsString = localStorage.getItem('reviews');
    const reviewsLocal = JSON.parse(reviewsString);
    console.log(reviewsLocal)

    const filteredReviews = []
    for (let i = 0; i < reviewsLocal.length; i++) {
        if(reviewsLocal[i].location == location){
            filteredReviews.push(reviewsLocal[i])
        }
    }
    console.log(filteredReviews)

    let reviewTextBlockOut = ""
    for (let i = 0; i < filteredReviews.length; i++) {
        reviewTextBlockOut += ("Reviewed On: " + filteredReviews[i].date + "\n");
        reviewTextBlockOut += ("Given A Score Of: " + filteredReviews[i].rating + " Out Of 5" + "\n");
        reviewTextBlockOut += ("Review: " + filteredReviews[i].review + "\n\n");
    }
    let pre = document.querySelector("#msg pre");
    pre.textContent = reviewTextBlockOut;
}

const addReview = (ev) => {
    ev.preventDefault();
    let review = {
        id: (document.getElementById("location").value + document.getElementById("date").value),
        location: document.getElementById("location").value,
        date: document.getElementById("date").value,
        rating: document.getElementById("rating").value,
        review: document.getElementById("review").value
    }
    const reviewsString = localStorage.getItem('reviews');
    const reviews = JSON.parse(reviewsString);
    reviews.push(review);
    localStorage.setItem('reviews', JSON.stringify(reviews));
    document.forms[0].reset();

    console.warn("added", { reviews });
}

function loadPage(){
    let reviews = localStorage.getItem('reviews');
    if(reviews = null){
        reviews = [{"id":"Mojo2022-02-05", "location":"Mojo", "date":"2022-02-05", "rating": "4", "review": "Pretty Good"}]
        localStorage.setItem('reviews', JSON.stringify(reviews));
    }
}

document.addEventListener("DOMContentLoaded", () => {   //Otherwise the onclick is assigned before the DOM is loaded
    window.onload = loadPage
    
    const reviewPageButton = document.getElementById("btnRP");
    if(reviewPageButton != null){
        reviewPageButton.onclick = goToReviews;
    }else{
        console.log("review link button not found");
    }
    const mapPageButton = document.getElementById("btnMP");
    if(mapPageButton != null){
        mapPageButton.onclick = goToMap;
    }else{
        console.log("map link button not found");
    }
    const seeReviewsButton = document.getElementById("btnSR");
    if(seeReviewsButton != null){
        seeReviewsButton.onclick = seeReviews;
    }else{
        console.log("see reviews button not found");
    }
    const addReviewButton = document.getElementById("btnAR");
    if(addReviewButton != null){
        addReviewButton.onclick = addReview;
    }else{
        console.log("add review button not found");
    }
})

function goToReviews() {
    console.log("pressed")
    window.location = "reviewPage.html"
}

function goToMap() {
    window.location = "mapPlaceholder.html"
}

//mapboxgl.accessToken = 'pk.eyJ1IjoiZ2VvcmdlZ29vZGV5IiwiYSI6ImNrd3h0NHNjbjAxdDEycG55MXBwaHEzMGYifQ.iu3DK1jhWiFeF7Es8Ysgvw';
//const map = new mapboxgl.Map({
    //container: 'map', // container ID
    //style: 'mapbox://styles/georgegoodey/ckzwvtg49000514p0t2ugjdc7', // style URL
    //center: [-74.5, 40], // starting position [lng, lat]
    //zoom: 9 // starting zoom
//});