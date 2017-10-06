/**
 * Created by damian on 16/09/2017.
 */
var password1 = document.getElementById("password1");
var password2 = document.getElementById("password2");

function validatePasswordsEquality(isEditMode) {
    var checkLength = !isEditMode || (isEditMode && password1.value.length!=0);

    if( checkLength && password1.value.length<3 ) {
        password1.setCustomValidity("Password is too short! (min. 3 characters) ");
    }
    else if( checkLength && password2.value.length<3 ) {
        password2.setCustomValidity("Password is too short! (min. 3 characters) ");
    }
    else if(password1.value != password2.value) {
        password2.setCustomValidity("Passwords are not identical!");
    }
    else {
        password1.setCustomValidity("");
        password2.setCustomValidity("");
        return true;
    }
    return false;
}

password1.onchange = validatePasswordsEquality;
password1.onkeyup = validatePasswordsEquality;
password2.onchange = validatePasswordsEquality;
password2.onkeyup = validatePasswordsEquality;
