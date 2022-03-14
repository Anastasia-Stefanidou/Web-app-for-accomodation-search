window.onload = function() { 
    // Get the modal
    var modal = document.getElementById("myModal");
    var modal1 = document.getElementById("myModal1");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");
    var btn1 = document.getElementById("myBtn1");

    // Get the <span> element that closes the modal
    var p = document.getElementsByClassName("close")[0];
    var span = document.getElementsByClassName("close1")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
    modal.style.display = "block";
    }

    btn1.onclick = function() {
        modal1.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    p.onclick = function() {
        modal.style.display = "none";
    }

    span.onclick = function() {
    modal1.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        }
    } 

    window.onclick = function(event) {
        if (event.target == modal1) {
            modal1.style.display = "none";
            }
        } 

    var selectedImg = document.getElementById('selected_img');
    var images = document.getElementById('image_list').getElementsByTagName('li');
    for (i = 0; i < images.length; i++) {
    images[i].addEventListener('click', activateImage);
    }
    function activateImage() {
    selectedImg.innerHTML = this.innerHTML;
    }
};

