/**
 * Created by damian on 14/09/2017.
 */


function updateProjectSelect(customerId,selectViewId, withBlocked) {
    var httpxml;
    try {
        // Firefox, Opera 8.0+, Safari
        httpxml=new XMLHttpRequest();
    }
    catch (e) {
        // Internet Explorer
        try {
            httpxml=new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e) {
            try {
                httpxml=new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e) {
                alert("Your browser does not support AJAX!");
                return false;
            }
        }
    }
    var url = "ajax/getProjectsForCustomerSelection.php";
    url+="?customerId="+customerId+"&withBlocked="+(withBlocked?1:0);
    httpxml.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById(selectViewId).innerHTML = this.responseText;
        }
    };
    httpxml.open("GET", url, true);
    httpxml.send();
}

function onDownloadCsv() {
    window.location = prepareGetUrl("action/root_download_csv.php");
}

function onDatabaseBackup() {
    window.location = "action/root_download_db_backup.php";
}

function onDatabaseClear() {
    var httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if( this.response==='true' ) {
                if( confirm("ALL DATA WILL BE REMOVED!\nARE YOU SURE YOU WANT TO CLEAR WHOLE DATABASE?") ) {
                    window.location = "action/root_clear_database.php";
                }
            }
            else {
                alert("Please make database backup first!");
            }
        }
    };
    httpRequest.open("GET", "ajax/isBackupDone.php", true);
    httpRequest.send();
}

function onRemoveReport(id) {
    if( confirm("Are you sure you want to remove this report?") ) {
        var httpRequest = new XMLHttpRequest();
        httpRequest.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200 && this.responseText) {
                onFilter(true);
            }
        };
        var url = "action/root_remove_report.php?reportId=" + id;
        httpRequest.open("GET", url, true);
        httpRequest.send();
    }
}

function onFilter(applyButton) {

    if(!applyButton) {
        location.reload();
        return;
    }

    var httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("root_reports_list_container").innerHTML = this.responseText;
        }
    };
    var url = prepareGetUrl("ajax/getFilteredReports.php");
    httpRequest.open("GET", url, true);
    httpRequest.send();
}

function prepareGetUrl(baseUrl) {
    var dateStartOn = document.getElementById("start_date_checkbox").checked;
    var dateEndOn = document.getElementById("end_date_checkbox").checked;
    var customerIdOn = document.getElementById("customer_checkbox").checked;
    var projectIdOn = document.getElementById("project_checkbox").checked;
    var userIdOn = document.getElementById("user_checkbox").checked;

    var dateStart = document.getElementById("start_date_picker").value;
    var dateEnd = document.getElementById("end_date_picker").value;
    var customerId = document.getElementById("customer_select").value;
    var projectId = document.getElementById("project_select").value;
    var userId = document.getElementById("user_select").value;

    var needConcatenation = false;

    if(dateStartOn) {
        baseUrl += "?start=" + dateStart;
        needConcatenation = true;
    }

    if(dateEndOn) {
        if(needConcatenation) {
            baseUrl += "&";
        }
        else {
            baseUrl += "?";
            needConcatenation = true;
        }
        baseUrl += "end=" + dateEnd;
    }

    if(customerIdOn) {
        if(needConcatenation) {
            baseUrl += "&";
        }
        else {
            baseUrl += "?";
            needConcatenation = true;
        }
        baseUrl += "customer=" + customerId;
    }

    if(projectIdOn) {
        if(needConcatenation) {
            baseUrl += "&";
        }
        else {
            baseUrl += "?";
            needConcatenation = true;
        }
        baseUrl += "project=" + projectId;
    }

    if(userIdOn) {
        if(needConcatenation) {
            baseUrl += "&";
        }
        else {
            baseUrl += "?";
        }
        baseUrl += "user="+ userId
    }
    return baseUrl;
}

function onAfirmationFilter(date) {
    var httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("root_affirmation_list_container").innerHTML = this.responseText;
        }
    };
    date = date || document.getElementById("date_picker").value;
    var withBlocked = document.getElementById("locked_users_checkbox").checked;
    var url = "ajax/getFilteredAffirmations.php?date="+date+"&blocked="+withBlocked;
    httpRequest.open("GET", url, true);
    httpRequest.send();
}

function changeAffirmation(date, userId, isAffirmed) {
    var httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            onAfirmationFilter(date);
        }
    };
    var url = "ajax/rootUpdateAffirmation.php?userId="+userId+"&date="+date+"&affirmed="+isAffirmed;
    httpRequest.open("GET", url, true);
    httpRequest.send();
}