document.addEventListener("DOMContentLoaded", () => {   //Otherwise the onclick is assigned before the DOM is loaded

    const editTimetableButton = document.getElementById("btnET");
    if(editTimetableButton != null){
        editTimetableButton.onclick = editTimetable;
    }else{
        console.log("edit timetable function not found");
    }
    const saveTimetableButton = document.getElementById("btnST");
    if(saveTimetableButton != null){
        saveTimetableButton.onclick = saveTimetable;
    }else{
        console.log("save timetable function not found");
    }
});

$(document).ready(function(){
    getTimetable();
});

function getCookie(cookieName){
    return document.cookie.split('; ')
    .find(row => row.startsWith(cookieName))
    .split('=')[1];
}

function getTimetable(){
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function(){
                console.log(this.responseText);
                text = JSON.parse(this.responseText);
                loadTimetable(text);
                console.log(text);
            }  
    xhttp.open("GET", "../restapi/index.php/user/getTimetable?username="+getCookie("username"));
    xhttp.send();
}

let timeSlots = ["10am-2pm", "2pm-6pm", "6pm-11pm", "11pm-10am"];
let daysOfWeek = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
function loadTimetable(timetable){
    var timetableObj = document.getElementById("timetable");
    for (let i = 0; i < 4; i++) {
        element = timetable[i];
        var newRow = timetableObj.insertRow();
        newRow.id = timeSlots[i];
        var newCell = newRow.insertCell();
        newCell.textContent = timeSlots[i];
        for (let j = 0; j < 7; j++) {
            var newCell = newRow.insertCell();
            if(element[daysOfWeek[j]] != null){
                cellTextOut = ""
                cellText = element[daysOfWeek[j]];
                cellTextSplit = cellText.split("|");
                cellTextLocation = cellTextSplit[0];
                cellTextOut += cellTextLocation;
                cellTextGroupChat = JSON.parse(cellTextSplit[1]);
                cellTextFriend1 = JSON.parse(cellTextSplit[2]);
                cellTextFriend2 = JSON.parse(cellTextSplit[3]);
                if(cellTextGroupChat != null){
                    cellTextOut += "\n with";
                    cellTextOut += "\n" + cellTextGroupChat;
                }else if(cellTextFriend1 != null || cellTextFriend2 != null){
                    cellTextOut += "\n with";
                    if(cellTextFriend1 != null){
                        cellTextOut += "\n" + cellTextFriend1;
                    }else if(cellTextFriend2 != null){
                        cellTextOut += "\n" + cellTextFriend2;
                    }else{
                        cellTextOut += "\n" + cellTextFriend1 + " and " + cellTextFriend2;
                    }
                }
                newCell.textContent = cellTextOut;
                newCell.style.backgroundColor = "rgba(31, 31, 31, 0.6)";
            }else{
                newCell.textContent = "Free";
                newCell.style.backgroundColor = "rgba(117, 117, 117, 0.6)";
            }newCell.onclick = function(){
                flipCell(this, element[daysOfWeek[j]]);
            }
        }
    }
}

function saveTimetable(){
    editing = false;
    var timetable = [{"Mon": null,"Tue": null,"Wed": null,"Thu": null,"Fri": null,"Sat": null,"Sun": null},
    {"Mon": null,"Tue": null,"Wed": "Cargo","Thu": null,"Fri": null,"Sat": null,"Sun": null},
    {"Mon": null,"Tue": null,"Wed": "Cargo","Thu": null,"Fri": null,"Sat": null,"Sun": null},
    {"Mon": null,"Tue": null,"Wed": "Cargo","Thu": null,"Fri": null,"Sat": null,"Sun": null}];
    var timetableObj = document.getElementById("timetable");
    for (let i = 0; i < 4; i++) {
        element = timetable[i];
        var timetableRow = document.getElementById(timeSlots[i]);
        for (let j = 0; j < 7; j++) {
            if(timetableRow.childNodes[j+1].textContent != "Free"){
                timetableContent = timetableRow.childNodes[j+1].textContent.split("\n")[0];
                timetable[i][daysOfWeek[j]] = timetableContent;
            }else{
                timetable[i][daysOfWeek[j]] = null;
            }
        }
    }
    console.log(timetable);
    postTimetable(timetable);
}

function postTimetable(Timetable){
    // const xhttp = new XMLHttpRequest();
    // xhttp.onload = function(){
    //     console.log(this.responseText);
    // }  
    $.post("../restapi/index.php/user/updateTimetable", {timetable: Timetable, username: getCookie("username")});
    // xhttp.open("POST", "../restapi/index.php/user/updateTimetable?username="+getCookie("username"));
    // xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // xhttp.send("Timetable=" + timetable);
}

var editing = false;
function flipCell(cell, status){
    if(editing){
        if(status != null){
            cell.textContent = "Free";
            cell.style.backgroundColor = "rgba(117, 117, 117, 0.6)";
            cell.onclick = function(){
                flipCell(cell, null);
            }
        }else{
            cell.textContent = "Other";
            cell.style.backgroundColor = "rgba(31, 31, 31, 0.6)";
            cell.onclick = function(){
                flipCell(cell, "Other");
            }
        }
    }
}

function editTimetable(){
    const editTimetableButton = document.getElementById("btnET");
    if(editing){
        editing = false;
        editTimetableButton.style.backgroundColor = "rgb(0, 0, 0)";
    }else{
        editing = true;
        editTimetableButton.style.backgroundColor = "rgb(28, 28, 28)";
    }
}