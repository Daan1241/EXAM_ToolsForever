function admin_search() {

    var search_type = document.getElementById("admin_search_user_privilege").value;
    var search_query = document.getElementById("admin_search_user_name").value;
    console.log("Searching for "+search_query+" as "+search_type);


}

function admin_modify(clicked_object){
    clicked_object_start = clicked_object;
    clicked_object.setAttribute('onclick', '');
    var modify_value = clicked_object.innerHTML;

    clicked_object.innerHTML = "<input id='gay' onfocusout='modify_admin_totext(this);' type='text' value='" + modify_value + "' autofocus>";
    clicked_object.children[0].focus();


}

function modify_admin_totext(child_obj) {
    var tempvalue = child_obj.value; // Saves modified value in temporary var.
    child_obj.parentElement.setAttribute('onclick', 'admin_modify(this)');
    child_obj.parentElement.innerHTML = tempvalue; // Destroys child_obj

    modify_admin_id = clicked_object_start.parentElement.children[0].innerHTML;
    modify_admin_name = clicked_object_start.parentElement.children[1].innerHTML;
    modify_admin_email = clicked_object_start.parentElement.children[2].innerHTML;
    modify_admin_privileges = clicked_object_start.parentElement.children[5].children[0].value;


    var modify_admin_data = [
        modify_admin_id,
        modify_admin_name,
        modify_admin_email,
        modify_admin_privileges
    ];
    console.log(modify_admin_data)


    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log("received:\n");
            console.log(this.responseText);
            // window.location.reload();
        }
    };
    xhttp.open("POST", "dependencies/php/admin_modifyuser.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("modify_data=" + JSON.stringify(modify_admin_data));
    // console.log(child_obj);

}


function resetpassword(UUID){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            // window.location.reload();
        }
    };
    xhttp.open("POST", "dependencies/php/admin_resetpassword.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("userID=" + UUID);
}



