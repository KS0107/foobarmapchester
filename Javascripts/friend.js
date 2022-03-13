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