let reviews = [];

const seeReviews = (ev) => {
    ev.preventDefault();
    location = document.getElementById("location").value
    document.forms[0].reset();

    reviews = localStorage.getItem('reviews');

    let pre = document.querySelector("#msg pre");
    pre.textContent = "\n" + "hello"//JSON.stringify(reviews, "\t", 2);
}

function addReviewPage() {
    window.location = "reviewPage.html";
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
    localStorage.setItem('label', reviews);
    document.forms[0].reset();

    console.warn("added", { reviews });
}
//document.addEventListener("DOMContentLoaded", () => {
//    document.getElementById("btn").addEventListener("click", addReview);
//})

//document.addEventListener("DOMContentLoaded", () => {
//    document.getElementById("btnR").addEventListener("click", seeReviews);
//    document.getElementById("btnA").addEventListener("click", addReviewPage);
//})

document.getElementById("reviewPageBtn").onclick = dog();

function dog() {
    window.location.replace = "reviewPage.html"
}