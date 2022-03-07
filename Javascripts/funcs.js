function seeReviews(){
    var location = document.getElementById("locationName").textContent;

    var reviewsString = localStorage.getItem('reviews');
    var reviewsLocal = JSON.parse(reviewsString);
    if(reviewsLocal == null){
        loadReviews();
        reviewsString = localStorage.getItem('reviews');
        reviewsLocal = JSON.parse(reviewsString);
    }

    var filteredReviews = []
    for (let i = 0; i < reviewsLocal.length; i++) {
        if(reviewsLocal[i].location == location){
            filteredReviews.push(reviewsLocal[i])
        }
    }

    let reviewTextBlockOut = ""
    let totalRating = 0;
    for (let i = 0; i < filteredReviews.length; i++) {
        totalRating += parseInt(filteredReviews[i].rating);
    }
    finalRating = totalRating / filteredReviews.length
    finalRating = Math.round(finalRating * 100)/100
    reviewTextBlockOut += "Rating of: " + finalRating + "\n\n\n";
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
    //Ollie code goes here
    localStorage.setItem('reviews', JSON.stringify(reviews));
    document.forms[0].reset();
}

function loadReviews(){
    let reviews = localStorage.getItem('reviews');
    console.log(reviews)
    if(reviews == null){
        let reviews = getReviews();
        localStorage.setItem('reviews', JSON.stringify(reviews));
    }
}

function loadText(){
    let reviewBox = document.getElementById("review")
    if(reviewBox != null){
        reviewBox.value = "";
    }
}

document.addEventListener("DOMContentLoaded", () => {   //Otherwise the onclick is assigned before the DOM is loaded
    window.onload = loadReviews
    window.onload = loadText

    const timetablePageButton = document.getElementById("btnTP");
    if(timetablePageButton != null){
        timetablePageButton.addEventListener('click', function(){
            goToPage("T");
        });
    }else{
        console.log("timetable link button not found");
    }
    const loginPageButton = document.getElementById("btnLP");
    if(loginPageButton != null){
        loginPageButton.addEventListener('click', function(){
            goToPage("L");
        });
    }else{
        console.log("login link button not found");
    }
    const reviewPageButton = document.getElementById("btnRP");
    if(reviewPageButton != null){
        reviewPageButton.addEventListener('click', function(){
            goToPage("R");
        });
    }else{
        console.log("review link button not found");
    }
    const homePageButton = document.getElementById("btnHP");
    if(homePageButton != null){
        homePageButton.addEventListener('click', function(){
            goToPage("H");
        });
    }else{
        console.log("home link button not found");
    }
    const mapPageButton = document.getElementById("btnMP");
    if(mapPageButton != null){
        mapPageButton.addEventListener('click', function(){
            goToPage("M");
        });
    }else{
        console.log("map link button not found");
    }
    const signoutPageButton = document.getElementById("btnSP");
    if(signoutPageButton != null){
        signoutPageButton.addEventListener('click', function(){
            goToPage("S");
        });
    }else{
        console.log("map link button not found");
    }
    const indexPageButton = document.getElementById("btnIP");
    if(indexPageButton != null){
        indexPageButton.addEventListener('click', function(){
            goToPage("I");
        });
    }else{
        console.log("home link button not found");
    }
    const addReviewButton = document.getElementById("btnAR");
    if(addReviewButton != null){
        addReviewButton.onclick = addReview;
    }else{
        console.log("add review button not found");
    }
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
})

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
        document.body.style.backgroundColor = "rgb(31, 31, 31)";
        document.getElementById("reviewBar").style.backgroundColor = "rgb(31, 31, 31)";
        document.body.style.color = "white";
        document.getElementById("lightD").innerText = "Light Mode"
        changeMapStyle();
        i++;
    }
}

function goToPage(page){
    var path =  window.location.pathname;
    var pathSections = path.split("/");
    pathSections.shift();
    if(pathSections[pathSections.length-1] == "index.html"){
        console.log("on index");
    }
    switch(page){
        case "T":
            pathSections.pop();
            if(pathSections[pathSections.length-1] == "manchester"){
                pathSections.push("webpages");
            }
            pathSections.push("timetable.php");
            break;
        case "L":
            pathSections.pop();
            if(pathSections[pathSections.length-1] == "manchester"){
                pathSections.push("webpages");
            }
            pathSections.push("loginPage.php");
            break;
        case "R":
            pathSections.pop();
            if(pathSections[pathSections.length-1] == "manchester"){
                pathSections.push("webpages");
            }
            pathSections.push("reviewPage.html");
            break;
        case "M":
            pathSections.pop();
            if(pathSections[pathSections.length-1] == "manchester"){
                pathSections.push("webpages");
            }
            pathSections.push("map.html");
            break;
        case "S":
            pathSections.pop();
            if(pathSections[pathSections.length-1] == "manchester"){
                pathSections.push("webpages");
            }
            pathSections.push("logout.php");
            break;
        case "H":
            pathSections.pop();
            if(pathSections[pathSections.length-1] == "manchester"){
                pathSections.push("webpages");
            }
            pathSections.push("home.html");
            break;
        case "I":
            pathSections.pop();
            if(pathSections[pathSections.length-1] == "webpages"){
                pathSections.pop();
            }
            pathSections.push("index.html");
            break;
        default:
            console.log("Case didnt work");
    }
    newLink = reconstructLink(pathSections);
    window.location = newLink;
}

function reconstructLink(sections){
    outLink = ""
    sections.forEach(element => {
        outLink += ("/" + element);
    });
    return outLink
}

let z = 1;
let Imageoffset = 0;
function slideInOut() {
    if (z % 2 != 0) {
        Imageoffset -= 20;
        document.getElementById("reviewBar").style.right = Imageoffset + "vw";
        document.getElementById("slider").value = "Show Reviews";
        z++;
    } else {
        Imageoffset += 20;
        document.getElementById("reviewBar").style.right = Imageoffset + "vw";
        document.getElementById("slider").value = "Collapse Reviews";
        z++;
    }
}
window.addEventListener('scroll', function() {myFunction()});
function myFunction() {
    var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
    var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    var scrolled = (winScroll / height) * 100;
    document.getElementById("myBar").style.width = scrolled + "%";
}
