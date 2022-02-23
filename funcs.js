const defaultPlaceholderReviews = [
    {
        "id": "Mojo2022-02-05",
        "location": "Mojo",
        "date": "2022-02-05",
        "rating": "4",
        "review": "Pretty Good"
    },
    {
        "id": "Mojo2022-02-12",
        "location": "Mojo",
        "date": "2022-02-12",
        "rating": "5",
        "review": "Amazing"
    },
    {
        "id": "Footage2022-01-21",
        "location": "Footage",
        "date": "2022-01-21",
        "rating": "2",
        "review": "Bit Crowded"
    },
    {
        "id": "Footage2022-01-03",
        "location": "Footage",
        "date": "2022-01-03",
        "rating": "5",
        "review": "Cheap drinks, good music"
    },
    {
        "id": "Footage2022-02-07",
        "location": "Footage",
        "date": "2022-02-07",
        "rating": "4",
        "review": "Fun pub quiz and good selection of drinks"
    },
    {
        "id": "Cargo2021-12-01",
        "location": "Cargo",
        "date": "2021-12-01",
        "rating": "2",
        "review": "Massive queue, expensive drinks"
    },
    {
        "id": "Cargo2021-11-13",
        "location": "Cargo",
        "date": "2021-11-13",
        "rating": "4",
        "review": "Fast entry, Very cheap drinks for a club"
    },
    {
        "id": "Cargo2021-11-05",
        "location": "Cargo",
        "date": "2021-11-05",
        "rating": "5",
        "review": "Lots of good music choices, good environment and cheap shots"
    },
    {
        "id": "Mojo2022-01-15",
        "location": "Mojo",
        "date": "2022-01-15",
        "rating": "3",
        "review": "Bit pricey but stayed open late"
    },
    {
        "id": "Factory2022-02-05",
        "location": "Factory",
        "date": "2022-02-05",
        "rating": "4",
        "review": "Alright overall"
    },
    {
        "id": "Factory2021-10-02",
        "location": "Factory",
        "date": "2021-10-02",
        "rating": "5",
        "review": "Really fun night, vodka was good"
    },
    {
        "id": "Gay2022-01-08",
        "location": "Gay",
        "date": "2022-01-08",
        "rating": "5",
        "review": "Open late, good songs and fun things to do"
    },
    {
        "id": "Bloom2021-12-13",
        "location": "Bloom",
        "date": "2021-12-13",
        "rating": "5",
        "review": "Easy place to go for a late week night"
    },
    {
        "id": "Bloom2021-12-11",
        "location": "Bloom",
        "date": "2021-12-11",
        "rating": "4",
        "review": "Fun place to go for a late one"
    }
];

const seeReviews = (ev) => {
    const location = document.getElementById("location").value

    console.log(location)
    const reviewsString = localStorage.getItem('reviews');
    const reviewsLocal = JSON.parse(reviewsString);
    console.log(reviewsLocal)
    if(reviewsLocal == null){
        loadReviews();
        const reviewsString = localStorage.getItem('reviews');
        const reviewsLocal = JSON.parse(reviewsString);
    }

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

function loadReviews(){
    let reviews = localStorage.getItem('reviews');
    if(reviews == null){
        reviews = defaultPlaceholderReviews;
        localStorage.setItem('reviews', JSON.stringify(reviews));
    }
}

document.addEventListener("DOMContentLoaded", () => {   //Otherwise the onclick is assigned before the DOM is loaded
    window.onload = loadReviews
    
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
    window.location = "index.html"
}