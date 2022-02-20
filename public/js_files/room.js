(function ($) {
    $(document).on('submit','form.favoriteForm', function(e) {
        //Stop default form behavior
        e.preventDefault();
        //Get form data
        const formData = $(this).serialize();

        //Ajax request
        $.ajax(
            // 'http://localhost:3000/public/ajax/room_favorite.php',
            {
                type: "POST",
                dataType: "json",
                data: formData,
                url : "../ajax/room_favorite.php",
            }).done(function(result) {
                console.log(result);
                if (result.status) {
                    $('input[name=is_favorite]').val(result.is_favorite ? 1 : 0);
                } else {
                    $('.fav .fav').toggleClass('selected', !result.is_favorite);
                }
            });
        });


        $(document).on('submit', 'form.reviewForm', function (e) {
            //Stop default form behavior
            e.preventDefault();
    
            //Get form data
            const formData = $(this).serialize();
    
            //Ajax
            $.ajax('http://localhost:3000/public/ajax/room_review.php', {
                type: 'POST',
                dataType: 'html',
                data: formData,
            }).done(function (result) {
                //Append results to container
                $('#room-reviews-container').append(result);
    
                //reset review form
                $('form.reviewForm').trigger('reset');
            });
        });
})(jQuery);