
$(document).ready(function(){
    $("#exit").click(function(){
        var exit = confirm("Are you sure you want to end the session?");
        if(exit == true){
            window.location = '../webpages/home.html';
        }
    })

    $("#send").click(function(){
        var clientmsg = $("#usermsg").val();
        $.post("../restapi/index.php/user/msgIn", {text: clientmsg, receiver: receiver, sender: getCookie("username")});
        $("#usermsg").val("");
        return false;
    });

    $("#delete").click(function(){
            $.get("https://web.cs.manchester.ac.uk/y02478jh/restapi/index.php/user/delete");
    });

    $("#f1").click(function(){
        $("#f1").html("yes");
    });


    

    function loadFriend(){
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
        friends = JSON.parse(this.responseText);
        friendsList = "";
        for(let i = 0; i < friends.length; i++){
            friendsList +=  "<button type=\"button\" style=\"width: 100%; border: solid;\" onclick=\"chatHandler(\'"+ friends[i].Username +"\')\">" + friends[i].Username + "</button>";
        }
        document.getElementById("friends").innerHTML = friendsList;
        }   
        xhttp.open("GET", "https://web.cs.manchester.ac.uk/y02478jh/restapi/index.php/user/getFriend?username=" + getCookie("username"));
        xhttp.send();
    }
    setInterval(loadFriend, 1000);

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
});

function chatHandler(friend){
    if(typeof(intervalID) !== "undefined"){
        clearInterval(intervalID);
    }
    receiver = friend;
    intervalID = setInterval(loadLog, 500, friend);
}

function loadLog(friend){
    var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20;
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
    let text = JSON.parse(this.responseText);
    let message="";
    alert(text[1].MessageBody);
    for(let i = 1; i < text.length; i++){
        if(text[i].UserID == text[0].Sender){
            message += "<div style=\"text-align: right;\">" + text[i].CreateDate + "<br>" + text[i].MessageBody + "</div>";
        }else{
            message += "<div style=\"text-align: left;\">" + text[i].CreateDate + "<br>" + text[i].MessageBody + "</div>";
        }      
    }
    alert(message);
    document.getElementById("#chatbox").innerHTML = message;
    }   
    xhttp.open("GET", "https://web.cs.manchester.ac.uk/y02478jh/restapi/index.php/user/getMessage?receiver=" + friend);
    xhttp.send();

    var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height after the request
    if(newscrollHeight > oldscrollHeight){
        $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); 
    }
}