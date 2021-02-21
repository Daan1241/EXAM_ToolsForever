function mobile_opentopbar() {
    if (document.getElementById('topbar_others').style.display == "") {
        document.getElementById('topbar_others').style.display = "inherit";
        document.getElementsByClassName('topbar_container')[0].style.display = "block";
        document.getElementsByClassName('topbar_container')[1].style.display = "block";
        document.getElementsByClassName('topbar_container')[2].style.display = "block";
    } else {
        document.getElementById('topbar_others').style.display = "";
        document.getElementsByClassName('topbar_container')[0].style.display = "inline-block";
        document.getElementsByClassName('topbar_container')[1].style.display = "inline-block";
        document.getElementsByClassName('topbar_container')[2].style.display = "inline-block";
    }

}