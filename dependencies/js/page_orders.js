const urlString = window.location.search;
const urlParameters = new URLSearchParams(urlString);

if(urlParameters.get('message') == "order_complete"){
document.getElementById('message').innerHTML = "Your order has been placed";
}



function getlocations_ID_list(product_selector_from) {
    var getproduct = product_selector_from.value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // console.log(JSON.parse(this.responseText));
            var returnedLocations_raw = JSON.parse(this.responseText);
            console.log(returnedLocations_raw);
            document.getElementById('products_select_list_from').innerHTML = "<option disabled>location</option>";
            for (let i = 0; i < returnedLocations_raw.length; i++) {
                console.log(returnedLocations_raw[i]);
                document.getElementById('products_select_list_from').innerHTML += "<option name=\"" + returnedLocations_raw[i] + "\">" + returnedLocations_raw[i] + "</option>";
            }
            // returnedProducts = Object.entries(returnedLocations_raw);
            // console.log(returnedProducts);
            //
            // document.getElementById('products_select_list_from').innerHTML = "";

        }
    };
    xhttp.open("POST", "dependencies/php/getlocationfromproduct.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("getproduct=" + getproduct);
}