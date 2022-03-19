document.addEventListener("DOMContentLoaded", () => {   //Otherwise the onclick is assigned before the DOM is loaded
    window.onload = loadReviewLocations;
});

function loadReviewLocations(){
    console.warning("Loading Review Drop Down")
    let reviewDropDown = document.getElementById("locations")
    if(reviewDropDown != null){
        var locations = getLocations();
        locations.forEach(element => {
            var option = document.createElement("option");
            option.text = element.Name;
            reviewDropDown.add(option);
        });
    }
}

var slidOut = true;
var Imageoffset = 0;
function slideInOut() {
    if (slidOut) {
        Imageoffset -= 20;
        document.getElementById("reviewBar").style.right = Imageoffset + "vw";
        document.getElementById("slider").value = "Show Reviews";
        slidOut = false;
    } else {
        Imageoffset += 20;
        document.getElementById("reviewBar").style.right = Imageoffset + "vw";
        document.getElementById("slider").value = "Collapse Reviews";
        slidOut = true;
    }
}