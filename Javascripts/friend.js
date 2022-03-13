$(document).ready(function(){
    $("#friendsbtn").click(function(){
        $("#requestsBox").css("display", "none");
        $("#friendsBox").css("display", "block");
    });

    $("#requestsbtn").click(function(){
        $("#friendsBox").css("display", "none");
        $("#requestsBox").css("display", "block");
    });

    
});

function showUsers(segment){
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
        let users = JSON.parse(this.responseText);
        show = "";
        for(i = 0; i < users.length; i++){
            show += "<div>" + users[i].Username + "</div>";
        } 
        document.getElementById("showBox").innerHTML = show;
    }
    xmlhttp.open("POST", "../restapi/index.php/user/getUserBy");
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("segment" + segment);
}