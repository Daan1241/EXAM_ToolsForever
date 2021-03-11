const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

if (urlParams.get('alert') == "already_exists") {
    document.getElementById('alert').innerHTML = "This username has already been taken. Please use a different one.";

} else if (urlParams.get('alert') == "check_email") {
    document.getElementById('alert').innerHTML = "<font color='green'>Account created! Please check your E-mail to enable your account.</font>";

} else if (urlParams.get('alert') == "account_activated") {
    document.getElementById('alert').innerHTML = "<font color='green'>Account activated! To set it up, please log in.</font>";

} else if (urlParams.get('alert') == "login_fail") {
    document.getElementById('alert').innerHTML = "Login failed, please check credentials again.";

} else if (urlParams.get('alert') == "no_info") {
    document.getElementById('alert').innerHTML = "Please fill in all login credentials.";

} else if (urlParams.get('alert') == "not_all_info") {
    document.getElementById('alert').innerHTML = "Please fill in all login credentials.";

} else if (urlParams.get('alert') == "not_activated") {
    document.getElementById('alert').innerHTML = "Please check your E-mail to activate your account.";

} else if (urlParams.get('alert') == "error_critical") {
    document.getElementById('alert').innerHTML = "A critical error occurred while creating your account. Please try again later.";

} else if (urlParams.get('alert') == "already_logged_out") {
    document.getElementById('alert').innerHTML = "Hmm, this is awkward. It seems like you were already logged out.";

} else if (urlParams.get('alert') == "logout_success") {
    document.getElementById('alert').innerHTML = "<font color='green'>You've been successfully logged out.</font>";

} else if (urlParams.get('alert') == "no_access") {
    document.getElementById('Login_title').innerHTML = "Please log in to view this content:";

} else if (urlParams.get('alert') == "password_changed") {
    document.getElementById('Login_title').innerHTML = "<font color='green'>Password successfully changed! Please log in with your new password.</font>";

}


function checkPassword() {
    if (document.getElementById('CA_password_repeat').value != document.getElementById('CA_password').value) {
        document.getElementById('alert').innerHTML = "Password and repeated password do not match, please check again";
    } else {
        document.getElementById('alert').innerHTML = "";
    }
}