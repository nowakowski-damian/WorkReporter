
var dateStartInput = document.getElementById("dateStart");
var dateEndInput = document.getElementById("dateEnd");
var ONE_DAY = 1000 * 60 * 60 * 24;

function validateDates() {
    var dateStart = new Date( dateStartInput.value );
    var dateEnd = new Date( dateEndInput.value );
    var isValid = dateStart<=dateEnd;
    if( isValid ) {
        dateEndInput.setCustomValidity("");
    }
    else {
        dateEndInput.setCustomValidity("Vacation end date cannot be earlier than vacation start date!");
        return false;
    }

    today = new Date();
    today.setHours(0);
    today.setMinutes(0);
    today.setSeconds(0);
    isValid = dateStart >= today;
    if( isValid ) {
        dateEndInput.setCustomValidity("");
    }
    else {
        dateEndInput.setCustomValidity("You cannot submit vacation which has already started!");
        return false;
    }

    isValid = (dateEnd.getTime()-dateStart.getTime()) < 62 * ONE_DAY;
    if( isValid ) {
        dateEndInput.setCustomValidity("");
    }
    else {
        dateEndInput.setCustomValidity("Vacation time is too long!");
        return false;
    }

    return true;
}

dateStartInput.onchange = validateDates;
dateStartInput.onkeyup = validateDates;
dateEndInput.onchange = validateDates;
dateEndInput.onkeyup = validateDates;
