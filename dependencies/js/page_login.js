const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

function checkPassword() {
    if (document.getElementById('CA_password_repeat').value != document.getElementById('CA_password').value) {
        document.getElementById('CA_password_mismatch').innerHTML = "<font color=\"red\">Password and repeated password do not match, please check again</font>";
    } else {
        document.getElementById('CA_password_mismatch').innerHTML = "";
    }
}