
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

    $("#delete-friend").click(function(){
        if($(".minusSign").css("display") == "none"){
            clearInterval(loadFriendIntervalID);
            clearInterval(loadGroupChatIntervalID);
            $(".minusSign").css("display", "block");
        }else{
            $(".minusSign").css("display", "none");
            loadFriendIntervalID = setInterval(loadFriend, 1000);
            loadGroupChatIntervalID = setInterval(loadGroupChat, 1000);
        }
        
    });



    // $("#delete").click(function(){
    //         // $.get("https://web.cs.manchester.ac.uk/y02478jh/restapi/index.php/user/delete");
    // }
    
    $("#CustomNamebtn").click(function(){
        customname = $("#CustomNameInput").val();
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.onload = function(){
            alert(JSON.parse(this.responseText));
        }
        xmlhttp.open("POST", "../restapi/index.php/user/updateCustomName");
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("CustomName=" + customname);
        $("#CustomNameInput").val("");
    });

    function loadFriend(){
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
        friends = JSON.parse(this.responseText);
        friendsList = "";
        for(let i = 0; i < friends.length; i++){
            if(friends[i].Status == "online"){
                friendsList +=  "<div  style=\"position: relative;\">" + "<div onclick=remove('friend'" + ",'" + friends[i].UserID +"') class='minusSign' style=\"position: absolute; bottom: 13px; left: 18px; width: 30px; height: 30px; background-image: url(../images/delete.png); background-size: cover; \"></div>" + "<button type=\"button\" style=\"width: 100%; border: solid;\" onclick=\"chatHandler(\'"+ friends[i].Username +"\')\">" + friends[i].Username + "</button>" + "<div style=\"position: absolute; bottom: 12px; right: 0; width: 30px; height: 30px; background-image: url(../images/online.png); background-size: cover; \"></div>" + "</div>";
            }else{
                friendsList +=  "<div  style=\"position: relative;\">"  + "<div class='minusSign' onclick=remove('friend'" + ",'" + friends[i].UserID +"') style=\"position: absolute; bottom: 13px; left: 18px; width: 30px; height: 30px; background-image: url(../images/delete.png); background-size: cover; \"></div>" + "<button type=\"button\" style=\"width: 100%; border: solid;\" onclick=\"chatHandler(\'"+ friends[i].Username +"\')\">" + friends[i].Username + "</button>" + "<div style=\"position: absolute; bottom: 12px; right: 0; width: 30px; height: 30px; background-image: url(../images/offline.png); background-size: cover; \"></div>" + "</div>";
            }
        }
        document.getElementById("friends").innerHTML = friendsList;
        }   
        xhttp.open("GET", "../restapi/index.php/user/getFriend?username=" + getCookie("username"));
        xhttp.send();
    }
    loadFriendIntervalID = setInterval(loadFriend, 1000);

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

function loadGroupChat(){ // query stmt restricts that get groupids only when status is accepted and status is active 
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function(){
        groupChatIDs = JSON.parse(this.responseText);
        groupChatbtns = "";
        for(let i = 0; i <groupChatIDs.length; i++){
            groupChatbtns += "<div style=\"position: relative;\">" + "<div  onclick=remove('"+ groupChatIDs[i].GroupChatID + "') class='minusSign' style=\"position: absolute; bottom: 13px; left: 18px; width: 30px; height: 30px; background-image: url(../images/delete.png); background-size: cover; \"></div>" + "<button type=\"button\" style=\"width: 100%; border: solid;\" onclick=chatHandler('"+ groupChatIDs[i].GroupChatID + "','" + true + "','" + encodeURIComponent(groupChatIDs[i].Place + "-" + groupChatIDs[i].Week + "(" + groupChatIDs[i].Date + ")") + "')>" + groupChatIDs[i].Place + "-" + groupChatIDs[i].Week + "(" + groupChatIDs[i].Date + ")" + "</button>" + "</div>"
        }
        document.getElementById("groupChat").innerHTML = groupChatbtns;
    }
    xhttp.open("GET", "../restapi/index.php/user/getGroupChat");
    xhttp.send();
}
loadGroupChatIntervalID = setInterval(loadGroupChat, 1000);

function remove(type, id){ //delete friend or groupchat
    var exit = confirm("Are you sure?");
    if(exit){
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function(){
            alert("done");
            loadFriend();
            loadGroupChat();
        }
        if(type == "friend"){
         xhttp.open("GET", "../restapi/index.php/user/deleteFriend?id=" + id);
         }else{
            xhttp.open("GET", "../restapi/index.php/user/removeGroupChat?id=" + id);
        }
        xhttp.send();
    }
    
}


function chatHandler(friend, bool=false, text=""){
    if(typeof(intervalID) !== "undefined"){
        clearInterval(intervalID);
    }
    if(bool){
        document.getElementById("friend-name").innerHTML = decodeURIComponent(text);
    }else{
        document.getElementById("friend-name").innerHTML = friend;
    }
    receiver = friend; 
    
    intervalID = setInterval(loadLog, 420, friend);
    
}

function dateformatting(date, opt){
    var daysNames = ['Sun', 'Mon', "Tue", 'Wed', 'Thu', 'Fri', 'Sat'];
    var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jum', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
    //************************//
    year = date.getFullYear();               //
    // as 0-11 0=>Jan                        //
    month = monthNames[date.getMonth()];     //  
    day = date.getDate();
    weekday = date.getDay();                    //   break the date down 
    dayName = daysNames[weekday];                //
    // hours:minutes:seconds                 //  
    hours = date.getHours();                 //
    minutes = date.getMinutes();             //
    if(minutes<10){minutes = "0" + minutes;}
    seconds = date.getSeconds();             //
    //************************//
    switch(opt){
        case 1:  
            return dayName + " " + hours + ":" + minutes;
            break;
        case 2:
            return month + " " + day + " " +hours + ":" + minutes;
            break;
        case 3:
            return hours + ":" + minutes;
    }
}

const c = new Date();

function compareDates(date1, date2="", interval){
    if(date2){
        var miliseconds = date1.getTime() - date2.getTime();
        days = miliseconds / (1000 * 60 * 60 * 24);
        if(days >= interval){
            return true;
        }else{
            return false;
        }
    }else{
        var days =   Math.floor(c.getTime() / (1000 * 60 * 60 * 24)) - Math.floor(date1.getTime() / (1000 * 60 * 60 * 24));
        if(days >= interval){
            return true;
        }else{
            return false;
        }
    }
}

function loadLog(friend){
    var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20;
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
    let text = JSON.parse(this.responseText);
    let message="";
    let time = "";
    for(let i = 0; i < text[1].length; i++){
        if(i > 0){
            date = new Date(text[1][i].CreateDate.replace(" ", "T") + "Z");
            lastDate = new Date(text[1][i - 1].CreateDate.replace(" ", "T") + "Z");
            if(compareDates(date, '', 6)){
                if(compareDates(date, lastDate, 5/(24 * 60))){ // if the last message sent equal or greater than five minutes ago
                    time = dateformatting(date, 2);
                    message += "<div style=\"text-align: center;\">"   + time + "</div>";
                }
            }else if(compareDates(date, '', 2)){
                if(compareDates(date, lastDate, 5/(24 * 60))){ // if the last message sent equal or greater than five minutes ago
                    time = dateformatting(date, 1);
                    message += "<div style=\"text-align: center;\">"   + time + "</div>";
                }
            }else if(compareDates(date, '', 1)){
                if(compareDates(date, lastDate, 5/(24 * 60))){ // if the last message sent equal or greater than five minutes ago
                    time = "yesterday " + dateformatting(date, 3);
                    message += "<div style=\"text-align: center;\">"   + time + "</div>";
                }
            }else{
                if(compareDates(date, lastDate, 5/(24 * 60))){ // if the last message sent equal or greater than five minutes ago
                    time = "today " + dateformatting(date, 3);
                    message += "<div style=\"text-align: center;\">"   + time + "</div>";
                }
            }
        }else{
            date = new Date(text[1][i].CreateDate.replace(" ", "T") + "Z");
            if(compareDates(date, '', 7)){
                time = dateformatting(date, 2);
                message += "<div style=\"text-align: center;\">"   + time + "</div>";
            }else if(compareDates(date, '', 2)){
                time = dateformatting(date, 1);
                message += "<div style=\"text-align: center;\">"   + time + "</div>";
            }else if(compareDates(date, '', 1)){
                time = "yesterday " + dateformatting(date, 3);
                message += "<div style=\"text-align: center;\">"   + time + "</div>";
            }else{
                time = "today " + dateformatting(date, 3);
                message += "<div style=\"text-align: center;\">"   + time + "</div>";
            }
        }
        
        if(text[1][i].UserID == text[0].Sender){
            if(text[0].CustomName === null){
                message += "<div style=\"text-align: right; overflow-wrap: break-word;  margin-top: 6px;\">" + "<div style=\" display: inline-block; border: solid white; border-radius: 6px; padding: 5px 5px 5px 5px;\">" + text[1][i].MessageBody   + "</div>" + "> " + "<div style=\" display: inline-block; font-size: 15px;\">" + text[0].Username + "</div></div>";
            }else{
             message += "<div style=\"text-align: right; overflow-wrap: break-word; margin-top: 6px; \">"  + "<div style=\" display: inline-block; border: solid white; border-radius: 6px; padding: 5px 5px 5px 5px;\">" + text[1][i].MessageBody  + "</div>"  + "> " + "<div style=\" display: inline-block; font-size: 15px; \">" + text[0].CustomName + "</div></div>";
            }
        }else{
            if(text[1][i].CustomName === null){
                message += "<div style=\"text-align: left; overflow-wrap: break-word; margin-top: 6px;\">" + "<div style=\" display: inline-block; \">" + text[1][i].Username   + "</div>"+ " <" + "<div style=\" display: inline-block; font-size: 15px; border: solid white; border-radius: 6px; padding: 5px 5px 5px 5px;\">" + text[0].MessageBody + "</div></div>";
            }else{
                message += "<div style=\"text-align: left; overflow-wrap: break-word; margin-top: 6px;\">" + "<div style=\" display: inline-block;\">" + text[1][i].CustomName   + "</div>"+ " <" + "<div style=\" display: inline-block; font-size: 15px; border: solid white; border-radius: 6px; padding: 5px 5px 5px 5px;\">" + text[0].MessageBody + "</div></div>";
            }
        }      
    }
    document.getElementById("chatbox").innerHTML = message;
    }
    if(/^\d+$/.test(friend)){
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

