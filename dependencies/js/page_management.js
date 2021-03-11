function deleteall() {
    deletelist = [];
    for (i = 0; i < document.getElementsByClassName('checkbox_product').length; i++) { // Loop trough every product in list
        if (document.getElementsByClassName('checkbox_product')[i].checked) { // If row is checked...
            deletelist.push(document.getElementsByClassName('checkbox_product')[i].id); // ...add to deletelist array
        }
    }


    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            window.location.reload();
        }
    };
    xhttp.open("POST", "dependencies/php/management_deleteproducts.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=delete_selected&deletelist=" + JSON.stringify(deletelist));

}

var modify_id;
var modify_name;
var modify_brand;
var modify_type;
var modify_buyprice;
var modify_sellprice;
var modify_stock;
var clicked_object_start;

function modify(clicked_object) {
    clicked_object_start = clicked_object;
    clicked_object.setAttribute('onclick', '');
    var modify_value = clicked_object.innerHTML;

    clicked_object.innerHTML = "<input id='gay' onfocusout='modify_totext(this);' type='text' style='width: 85%' value='" + modify_value + "' autofocus>";
    clicked_object.children[0].focus();
}

function modify_totext(child_obj) {
    var tempvalue = child_obj.value;
    child_obj.parentElement.setAttribute('onclick', 'modify(this)');
    child_obj.parentElement.innerHTML = tempvalue;

    modify_id = clicked_object_start.parentElement.children[1].innerHTML;
    modify_name = clicked_object_start.parentElement.children[2].innerHTML;
    modify_brand = clicked_object_start.parentElement.children[3].innerHTML;
    modify_type = clicked_object_start.parentElement.children[4].innerHTML;
    modify_buyprice = clicked_object_start.parentElement.children[5].innerHTML;
    modify_sellprice = clicked_object_start.parentElement.children[6].innerHTML;
    modify_stock = clicked_object_start.parentElement.children[7].innerHTML;
    modify_minstock = clicked_object_start.parentElement.children[8].innerHTML;

    var modify_data = [
        modify_id,
        modify_name,
        modify_brand,
        modify_type,
        modify_buyprice,
        modify_sellprice,
        modify_stock,
        modify_minstock
    ]


    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            // window.location.reload();
        }
    };
    xhttp.open("POST", "dependencies/php/management_modifyproducts.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("modify_data=" + JSON.stringify(modify_data));
    // console.log(child_obj);

}

function getproducts_list(location_selector) {
    var getlocation = location_selector.value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var returnedProducts = JSON.parse(this.responseText);
            console.log(returnedProducts);
            document.getElementById('products_select_list').innerHTML = "";
            returnedProducts.forEach(function setReturnedProducts(item, index) {
                document.getElementById('products_select_list').innerHTML += "<option id=\"" + item + "\">" + item + "</option>";
            });
            // window.location.reload();
        }
    };
    xhttp.open("POST", "dependencies/php/management_getproductlist.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("getlocation=" + getlocation);
}

var returnedProducts;

function getproducts_ID_list(location_selector_from) {
    var getlocation = location_selector_from.value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var returnedProducts_raw = JSON.parse(this.responseText);
            returnedProducts = Object.entries(returnedProducts_raw);
            console.log(returnedProducts);

            document.getElementById('products_select_list_from').innerHTML = "";
            for (let i = 0; i < returnedProducts.length; i++) {
                console.log(returnedProducts[i]);
                document.getElementById('products_select_list_from').innerHTML += "<option name=\"" + returnedProducts[i][1] + "\">" + returnedProducts[i][0] + "</option>";
                getProductID(document.getElementById('products_select_list_from').value);
            }
        }
    };
    xhttp.open("POST", "dependencies/php/management_getproductIDlist.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("getlocation=" + getlocation);
}

function getProductID(name) {
    for (let i = 0; i < returnedProducts.length; i++) {
        if(returnedProducts[i][0] == name){
            document.getElementById('add_from_id').value = returnedProducts[i][1];
            console.log(returnedProducts[i][1]);
        }
    }
}