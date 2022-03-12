<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
<link rel="stylesheet" href="starrr.css">
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="starrr.js"></script>
    <?php
        $DATABASE_HOST = "127.0.0.1";
        $DATABASE_USER = "hotel";
        $DATABASE_PASS = "password";
        $DATABASE_NAME = "hotel";
        
        $con =mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
        $result = mysqli_query($con, "SELECT * FROM room");
        while ($row = mysqli_fetch_object($result)) {
    ?>
        <p>
            <?php 
                echo $row->name;
            ?>
        </p>
        <form method="POST" onsubmit="return saveRatings(this);">
            <input type = "hidden" name = "room_id" value="<?php echo $row->room_id; ?>">
            <p>
                <div class="starrr"></div>
            </p>
            <input type="submit">
        </form>
    <?php
        }
    ?>
<div class="rate"></div>
<script>
    var rate = 0;
    $(function () {
        $(".starrr").starrr().on("starrr:change", function (event, value) {
            rate = value;
        });
    });

    function saveRatings(form) {
        var room_id = form.room_id.value;

        $.ajax({
            url: "save-ratings.php",
            method: "POST",
            data: {
                "room_id": room_id,
                "rate": rate
            },
            success: function (response) {
                alert(response);
            }
        });
        return false;
    }
</script>