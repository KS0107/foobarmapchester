
$(document).ready(function(){
    $("#exit").click(function(){
        var exit = confirm("Are you sure you want to end the session?");
        if(exit == true){
            window.location = '../webpages/home.html';
        }
    })

    $("#send").click(function(){
        var clientmsg = $("#input").val();
        $.post("../restapi/index.php/user/msgIn", {text: clientmsg, receiver: receiver, sender: getCookie("username")});
        $("#input").val("");
        return false;
    });

    $("#delete").click(function(){
            // $.get("https://web.cs.manchester.ac.uk/y02478jh/restapi/index.php/user/delete");
    });

    

    function loadFriend(){
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
        friends = JSON.parse(this.responseText);
        friendsList = "";
        for(let i = 0; i < friends.length; i++){
            if(friends[i].Status == "online"){
                friendsList +=  "<div style=\"position: relative;\"><button type=\"button\" style=\"width: 100%; border: solid;\" onclick=\"chatHandler(\'"+ friends[i].Username +"\')\">" + friends[i].Username + "</button>" + "<div style=\"position: absolute; bottom: 12px; right: 0; width: 30px; height: 30px; background-image: url(../images/online.png); background-size: cover; \"></div>" + "</div>";
            }else{
                friendsList +=  "<div style=\"position: relative;\"><button type=\"button\" style=\"width: 100%; border: solid;\" onclick=\"chatHandler(\'"+ friends[i].Username +"\')\">" + friends[i].Username + "</button>" + "<div style=\"position: absolute; bottom: 12px; right: 0; width: 30px; height: 30px; background-image: url(../images/offline.png); background-size: cover; \"></div>" + "</div>";
            }
        }
        document.getElementById("friends").innerHTML = friendsList;
        }   
        xhttp.open("GET", "../restapi/index.php/user/getFriend?username=" + getCookie("username"));
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

function loadGroupChat(){
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function(){
        groupChatIDs = JSON.parse(this.responseText);
        groupChatbtns = "";
        for(let i = 0; i <groupChatIDs.length; i++){
            groupChatbtns += "<div style=\"position: relative;\"><button type=\"button\" style=\"width: 100%; border: solid;\" onclick=chatHandler('"+ groupChatIDs[i].GroupChatID +"')>" + groupChatIDs[i].GroupChatID + "</button>" + "</div>"
        }
        document.getElementById("groupChat").innerHTML = groupChatbtns;
    }
    xhttp.open("GET", "../restapi/index.php/user/getGroupChat");
    xhttp.send();
}
setInterval(loadGroupChat, 1000);

function chatHandler(friend){
    if(typeof(intervalID) !== "undefined"){
        clearInterval(intervalID);
    }
    receiver = friend; 
    document.getElementById("friend-name").innerHTML = friend;
    intervalID = setInterval(loadLog, 420, friend);
    
}


function loadLog(friend){
    var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20;
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
    let text = JSON.parse(this.responseText);
    let message="";
    for(let i = 0; i < text[1].length; i++){
        if(text[1][i].UserID == text[0].Sender){
            message += "<div style=\"text-align: right;\">" + text[1][i].CreateDate + "<br>" + text[1][i].MessageBody + "</div>";
        }else{
            message += "<div style=\"text-align: left;\">" + text[1][i].CreateDate + "<br>" + text[1][i].MessageBody + "</div>";
        }      
    }
    document.getElementById("chatbox").innerHTML = message;
    }
    if(preg_match("/^\d+$/", friend)){
        xhttp.open("GET", "../restapi/index.php/user/getMessageForGroupChat?receiver=" + friend);
        xhttp.send();
    }else{
        xhttp.open("GET", "../restapi/index.php/user/getMessage?receiver=" + friend);
        xhttp.send();
    }

    var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height after the request
    if(newscrollHeight > oldscrollHeight){
        $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); 
    }
}

