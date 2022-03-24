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
    xhttp.open("GET", "../restapi/index.php/user/getTimetable?UserID=9");
    xhttp.send();
}

function loadTimetable(timetable){
    console.log(timetable);
    var timetableObj = document.getElementById("timetable");
    timetable.forEach(element => {
        var newRow = timetableObj.insertRow();
        newRow.id = "timePlaceHolder";
        var newCell = newRow.insertCell();
        newCell.textContent = element[0];
        for (let i = 0; i < 7; i++) {
            var newCell = newRow.insertCell();
            if(element[1][i] == 1){
                newCell.textContent = "Busy";
                newCell.style.backgroundColor = "rgba(31, 31, 31, 0.6)";
            }else{
                newCell.textContent = "Free";
                newCell.style.backgroundColor = "rgba(117, 117, 117, 0.6)";
            }newCell.onclick = function(){
                flipCell(this, element[1][i]);
            }
        }
    });
}

function saveTimetable(){
    editing = false;
    var timetable = [["10am-2pm", "1110011"], ["2pm-6pm", "1101100"], ["6pm-11pm", "0110011"], ["11pm-10am", "1001011"]];
    var timetableObj = document.getElementById("timetable");
    timetable.forEach(element => {
        endStringifiedData = "";
        var timetableRow = document.getElementById(element[0]);
        for (let i = 1; i < 8; i++) {
            if(timetableRow.childNodes[i].textContent == "Busy"){
                endStringifiedData += "1";
            }else{
                endStringifiedData += "0";
            }
        }
        element[1] = endStringifiedData;
        document.cookie = element[0].replace("-", "")+"="+element[1];
    });
}

var editing = false;
function flipCell(cell, status){
    if(editing){
        if(status == 0){
            cell.textContent = "Busy";
            cell.style.backgroundColor = "rgba(31, 31, 31, 0.6)";
            cell.onclick = function(){
                flipCell(cell, 1);
            }
        }else{
            cell.textContent = "Free";
            cell.style.backgroundColor = "rgba(117, 117, 117, 0.6)";
            cell.onclick = function(){
                flipCell(cell, 0);
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