
$(document).ready(function(){
    $("#exit").click(function(){
        var exit = confirm("Are you sure you want to end the session?");
        if(exit == true){
            window.location = 'jQuery.css';
        }
    })

    $("#submitmsg").click(function(){
        var clientmsg = $("#usermsg").val();
        $.post("post.php", {text: clientmsg});
        $("#usermsg").val("");
        return false;
    });

    $("#delete").click(function(){
            $.get("https://web.cs.manchester.ac.uk/y02478jh/restapi/index.php/user/delete");
    });

    function loadLog(){

        $.ajax({
            url: "chatRecords.php",
            cache: false,
            success: function(html){
                $("#chatbox").html(html);

                var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height after the request
                if(newscrollHeight > oldscrollHeight){
                    $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); 
                }
            }
        });
    }

    setInterval(loadLog, 100);
});
