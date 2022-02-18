const reviews = [{"id":"Mojo2022-02-05", "location":"Mojo", "date":"2022-02-05", "rating": "4", "review": "Pretty Good"}]

const seeReviews = (ev) => {
    //location = document.getElementById("location").value
    //document.forms[0].reset();

    console.log("Worked")
    const reviewsString = localStorage.getItem('reviews');
    const reviewsLocal = JSON.parse(reviewsString);

    let pre = document.querySelector("#msg pre");
    pre.textContent = "\n" + JSON.stringify(reviewsLocal, "\t", 2);
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
    reviews.push(review);
    localStorage.setItem('reviews', JSON.stringify(reviews));
    document.forms[0].reset();

    console.warn("added", { reviews });
}

document.addEventListener("DOMContentLoaded", () => {   //Otherwise the onclick is assigned before the DOM is loaded
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