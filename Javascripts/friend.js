

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

function requestNo(friendname){
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "../restapi/index.php/user/requestNo");
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

  function loadPlaces(){
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
    
    places = JSON.parse(this.responseText);
    placesList = "";
    for(let i = 0; i < places.length; i++){
        placesList += "<option value=\'" + places[i].Name + "\'>" + places[i].Name + "</option>";
    }
    document.getElementById("place1").innerHTML =  placesList;
    document.getElementById("place2").innerHTML =  placesList;
    }   
    xhttp.open("GET", "../restapi/index.php/user/getPlaces");
    xhttp.send();
}
loadPlaces();

// Private and Public requests
function retrieveEventRequest(){
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        response = JSON.parse(this.responseText);
        privateRequests = "";
        publicRequests = "";
        for(let i = 0; i < response[1].length; i++){
            if(response[1][i].Type == "private"){
                if(response[0] == response[1][i].requesterID){
                    privateRequests += 
                    "<div>" +
                        "<table>" +
                            "<tr>" +
                                "<th>" + "Date" + "</th>" +
                                "<th>" + "Place" + "</th>" +
                                "<th>" + "To Friend" + "</th>"+
                                "<th>" + "Status" + "</th>"+
                            "</tr>" +
                            "<tr>" +
                                "<td>" + response[1][i].Date + "</td>" +
                                "<td>" + response[1][i].Place + "</td>" +
                                "<td>" + response[1][i].Username + "</td>"+
                                "<td>" + response[1][i].Status + "</td>"+
                            "</tr>" +
                        "</table>" +
                    "</div>";
                }else{ // user is recipient
                    privateRequests += 
                    "<div>" +
                        "<table>" +
                            "<tr>" +
                                "<th>" + "Date" + "</th>" +
                                "<th>" + "Place" + "</th>" +
                                "<th>" + "From Friend" + "</th>" +
                                "<th>" + "Status" + "</th>"+
                                "<th>" + "Response" + "</th>"+
                            "</tr>" +
                            "<tr>" +
                                "<td>" + response[1][i].Date + "</td>" +
                                "<td>" + response[1][i].Place + "</td>" +
                                "<td>" + response[1][i].Username + "</td>" +
                                "<td>" + response[1][i].Status + "</td>"+
                                "<td>" + 
                                    "<div id=" + response[1][i].RequestmsgID + ">" +
                                        "<div>" + "<button onclick=\'eventYes(" + response[1][i].RequestmsgID+ ")\'>Accept</button>" + "</div>" +
                                        "<div>" + "<button onclick=\'eventNo(" + response[1][i].RequestmsgID+ ")\'>Decline</button>" + "</div>" +
                                    "</div>" +
                                "</td>"+
                            "</tr>" +
                        "</table>" +
                    "</div>";
                }
            }else{ //public case
                if(response[0] != response[1][i].requesterID){
                    publicRequests +=
                    "<div>" +
                        "<table>" +
                            "<tr>" +
                                "<th>" + "Date" + "</th>" +
                                "<th>" + "Place" + "</th>" +
                                "<th>" + "Host" + "</th>" +
                                "<th>" + "Group Chat" + "</th>"+
                            "</tr>" +
                            "<tr>" +
                                "<td>" + response[1][i].Date + "</td>" +
                                "<td>" + response[1][i].Place + "</td>" +
                                "<td>" + response[1][i].Username + "</td>" +
                                "<td>" + 
                                    "<div id=" + response[1][i].RequestmsgID + ">" +
                                        "<div>" + "<button onclick=\'eventJoin(" + response[1][i].RequestmsgID+ ")\'>Join</button>" + "</div>" +
                                        "<div>" + "<button onclick=\'eventNo(" + response[1][i].RequestmsgID+ ")\'>Decline</button>" + "</div>" +
                                    "</div>" +
                                "</td>"+
                            "</tr>" +
                        "</table>" +
                    "</div>";
                }
            }
        }
        document.getElementById("privateRequest").innerHTML = privateRequests;
        document.getElementById("PublicRequest").innerHTML = publicRequests;
    }   
    xhttp.open("GET", "../restapi/index.php/user/getEventRequest");
    xhttp.send();
}

retrieveEventRequest();


$(document).ready(function(){
    $("#friendsbtn").click(function(){
        $("#publicbox").css("display", "none");
        $("#requestsBox").css("display", "none");
        $("#privatebox").css("display", "none");
        $("#friendsBox").css("display", "block");
    });

    $("#requestsbtn").click(function(){
        $("#publicbox").css("display", "none");
        $("#friendsBox").css("display", "none");
        $("#privatebox").css("display", "none");
        $("#requestsBox").css("display", "block");
    });

    $("#privatebtn").click(function(){
        $("#friendsBox").css("display", "none");
        $("#requestsBox").css("display", "none");
        $("#publicbox").css("display", "none");
        $("#privatebox").css("display", "block");
    });

    $("#publicbtn").click(function(){
        $("#friendsBox").css("display", "none");
        $("#requestsBox").css("display", "none");
        $("#privatebox").css("display", "none");
        $("#publicbox").css("display", "block");
    });


});