window.addEventListener('DOMContentLoaded', (event) => {
    var selectedImg = document.getElementById('selected_img');
    var images = document.getElementById('image_list').getElementsByTagName('li');
    for (i = 0; i < images.length; i++) {
        images[i].addEventListener('click', activateImage);
    }
    function activateImage() {
        selectedImg.innerHTML = this.innerHTML;
    }
});
