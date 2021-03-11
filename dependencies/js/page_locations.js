var modify_location_id;
var modify_location_name;
var modify_location_zipcode;
var modify_location_adress;
var modify_location_description;
var clicked_object_start;

function modify_location(clicked_object) {
    clicked_object_start = clicked_object;
    clicked_object.setAttribute('onclick', '');
    var modify_value = clicked_object.innerHTML;

    clicked_object.innerHTML = "<input id='gay' onfocusout='modify_location_totext(this);' type='text' style='width: 85%' value='" + modify_value + "' autofocus>";
    clicked_object.children[0].focus();
}

function modify_location_totext(child_obj) {
    var tempvalue = child_obj.value; // Saves modified value in temporary var.
    child_obj.parentElement.setAttribute('onclick', 'modify_location(this)');
    child_obj.parentElement.innerHTML = tempvalue; // Destroys child_obj

    modify_location_id = clicked_object_start.parentElement.children[0].innerHTML;
    modify_location_name = clicked_object_start.parentElement.children[1].innerHTML;
    modify_location_zipcode = clicked_object_start.parentElement.children[2].innerHTML;
    modify_location_adress = clicked_object_start.parentElement.children[3].innerHTML;
    modify_location_description = clicked_object_start.parentElement.children[4].innerHTML;

    var modify_location_data = [
        modify_location_id,
        modify_location_name,
        modify_location_zipcode,
        modify_location_adress,
        modify_location_description
    ];
    console.log(modify_location_data);


    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            // window.location.reload();
        }
    };
    xhttp.open("POST", "dependencies/php/management_modifylocations.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("modify_data=" + JSON.stringify(modify_location_data));
    // console.log(child_obj);

}

function deletelocation(id){

    var confirm_delete = confirm("Deleting a location will also remove ALL products that are on this location to it, including ones that are also assigned to other locations. Are you sure?");
    if (confirm_delete == true) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                window.location.reload();
            }
        };
        xhttp.open("POST", "dependencies/php/management_deletelocation.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("delete_id=" + id);
    } else {
        console.log('cancelled delete');
    }

}