const defaultPlaceholderReviews = [
    {
        "id": "1",
        "location": "Mojo",
        "date": "2022-02-05",
        "rating": "4",
        "review": "Pretty Good"
    },
    {
        "id": "2",
        "location": "Mojo",
        "date": "2022-02-12",
        "rating": "5",
        "review": "Amazing"
    },
    {
        "id": "3",
        "location": "Footage",
        "date": "2022-01-21",
        "rating": "2",
        "review": "Bit Crowded"
    },
    {
        "id": "4",
        "location": "Footage",
        "date": "2022-01-03",
        "rating": "5",
        "review": "Cheap drinks, good music"
    },
    {
        "id": "5",
        "location": "Footage",
        "date": "2022-02-07",
        "rating": "4",
        "review": "Fun pub quiz and good selection of drinks"
    },
    {
        "id": "6",
        "location": "Cargo",
        "date": "2021-12-01",
        "rating": "2",
        "review": "Massive queue, expensive drinks"
    },
    {
        "id": "7",
        "location": "Cargo",
        "date": "2021-11-13",
        "rating": "4",
        "review": "Fast entry, Very cheap drinks for a club"
    },
    {
        "id": "8",
        "location": "Cargo",
        "date": "2021-11-05",
        "rating": "5",
        "review": "Lots of good music choices, good environment and cheap shots"
    },
    {
        "id": "9",
        "location": "Mojo",
        "date": "2022-01-15",
        "rating": "3",
        "review": "Bit pricey but stayed open late"
    },
    {
        "id": "10",
        "location": "Factory",
        "date": "2022-02-05",
        "rating": "4",
        "review": "Alright overall"
    },
    {
        "id": "11",
        "location": "Factory",
        "date": "2021-10-02",
        "rating": "5",
        "review": "Really fun night, vodka was good"
    },
    {
        "id": "12",
        "location": "Gay",
        "date": "2022-01-08",
        "rating": "5",
        "review": "Open late, good songs and fun things to do"
    },
    {
        "id": "15",
        "location": "Turing Tap",
        "date": "2022-02-23",
        "rating": "5",
        "review": "Was there for a soc thing, was a good night"
    },
    {
        "id": "16",
        "location": "Turing Tap",
        "date": "2022-02-21",
        "rating": "4",
        "review": "Nice atmosphere, slightly questionnable music, drinks were not bad"
    },
    {
        "id": "17",
        "location": "The Paramount",
        "date": "2022-02-16",
        "rating": "4",
        "review": "Nice drinks, bit of a long walk though"
    },
    {
        "id": "18",
        "location": "The Paramount",
        "date": "2022-02-16",
        "rating": "2",
        "review": "No martinis"
    },
    {
        "id": "19",
        "location": "The Paramount",
        "date": "2022-02-16",
        "rating": "4",
        "review": "Good beer selection and easy to get to"
    }
];

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

    console.warn("added", { reviews });
}

function loadReviews(){
    let reviews = localStorage.getItem('reviews');
    if(reviews == null){
        fetch('../JSONs/reviews.json')
        .then(response => response.json())
        .then(json => console.log(json + "t"));
        console.log(json + "t")
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
        case "H":
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
        z++;
    } else {
        Imageoffset += 20;
        document.getElementById("reviewBar").style.right = Imageoffset + "vw";
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
