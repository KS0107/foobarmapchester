//All Link Buttons Used On Pages
var btns = ["btnTP", "btnLP", "btnCP", "btnRP", "btnHP", "btnMP", "btnSP", "btnIP"];

//Button Link Assignments
document.addEventListener("DOMContentLoaded", () => {   //Otherwise the onclick is assigned before the DOM is loaded
    btns.forEach(element => {
        const timetablePageButton = document.getElementById(element);
        if(timetablePageButton != null){
            timetablePageButton.addEventListener('click', function(){
                goToPage(element);
            });
        };
    });
})

function goToPage(page){
    var path =  window.location.pathname;
    var pathSections = path.split("/");
    pathSections.shift();
    if(pathSections[pathSections.length-1] == "index.html"){
        console.log("on index");
    }
    switch(page){
        case "btnTP":
            pathSections.pop();
            if(pathSections[pathSections.length-1] == "manchester"){
                pathSections.push("webpages");
            }
            pathSections.push("timetable.php");
            break;
        case "btnLP":
            pathSections.pop();
            if(pathSections[pathSections.length-1] == "manchester"){
                pathSections.push("webpages");
            }
            pathSections.push("loginPage.php");
            break;
        case "btnCP":
            pathSections.pop();
            if(pathSections[pathSections.length-1] == "manchester"){
                pathSections.push("webpages");
            }
            pathSections.push("chatFunc.php");
            break;
        case "btnRP":
            pathSections.pop();
            if(pathSections[pathSections.length-1] == "manchester"){
                pathSections.push("webpages");
            }
            pathSections.push("reviewPage.php");
            break;
        case "btnMP":
            pathSections.pop();
            if(pathSections[pathSections.length-1] == "manchester"){
                pathSections.push("webpages");
            }
            pathSections.push("map.php");
            break;
        case "btnSP":
            pathSections.pop();
            if(pathSections[pathSections.length-1] == "manchester"){
                pathSections.push("webpages");
            }
            pathSections.push("logout.php");
            break;
        case "btnHP":
            pathSections.pop();
            if(pathSections[pathSections.length-1] == "manchester"){
                pathSections.push("webpages");
            }
            pathSections.push("home.html");
            break;
        case "btnIP":
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
    // made by Jiaying: set a global variable for invoke logout function when close the broswer but not when redireting
    redirect = true;
    window.location = newLink;
}
// When close the page, it invoks logout function.
window.onbeforeunload = function(){
    if(typeof(redirect) == 'undefined'){
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "../webpages/logoutMedium.php");
        xmlhttp.send(); 
        return "are you sure to leave";
    }
}

function reconstructLink(sections){
    outLink = "";
    sections.forEach(element => {
        outLink += ("/" + element);
    });
    return outLink;
}


window.addEventListener('scroll', function() {myFunction()});
function myFunction() {
    var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
    var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    var scrolled = (winScroll / height) * 100;
    try {
        document.getElementById("myBar").style.width = scrolled + "%";
    } catch (error) {
        console.log("Cant find myBar element");
    }
}
