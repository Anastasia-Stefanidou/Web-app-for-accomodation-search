(function ($) {
    $(document).on('submit','form.searchForm', function(e) {
        //Stop default form behavior
        e.preventDefault();

        //Get form data
        const formData = $(this).serialize();
        console.log(formData);
        //Ajax request
        $.ajax(
            'http://localhost:3000/public/ajax/search_results.php',
            {
                type: "GET",
                dataType: "html",
                data: formData
            }).done(function(result) {
                console.log(result);
            });
    });
})(jQuery);