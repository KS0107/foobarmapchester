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
        users = JSON.parse(this.responseText);
        show = "";
        for(i = 0; i < users.length; i++){
            show += 
            "<div>" + 
                users[i].Username + 
                " " +
                "<button onclick=\"friendRequest(\'" + users[i].Username +"\')\">" +
                    "+" +
                "</button>" +
            "</div>";
        } 
        document.getElementById("showBox").innerHTML = show;
    }
    xmlhttp.open("POST", "../restapi/index.php/user/getUserBy");
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("segment=" + segment);
}

showUsers("");

function friendRequest(username){
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "../restapi/index.php/user/friendRequest");
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("requester=" + getCookie("username") + "&target=" + username);
}

function retrieveRequest(){
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function(){
        res = JSON.parse(this.responseText);
        request = "";
        for(i = 0; i < res.length; i++){
            request += "<div>" + "Date: " +res[i].CreateDate + "<br>" + res[i].Username + " wants to add you!! " + "<button onclick=\"requestYes(\'" + res[i].Username + "\')\">" + "yes" + "</button> " + " <button onclick=\"requestNo(\'" + res[i].Username +"\')\">no</button>" + "</div>";
        }
        document.getElementById("requestsBox").innerHTML = request;
    }
    xmlhttp.open("GET", "../restapi/index.php/user/retrieveRequest");
    xmlhttp.send();
}
setInterval(retrieveRequest, 1000);

function requestYes(friendname){
    //send username with friend name to database linking them in friendship table and delete the request as well
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "../restapi/index.php/user/requestYes");
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("user=" + getCookie("username") + "&friendname=" + friendname);  
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }