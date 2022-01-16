$(document).ready(function() {
    // $("#datepicker").datepicker();
    var dateFormat = "mm/dd/yy",
    from = $( "#from" )
      .datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        to.datepicker( "option", "minDate", getDate( this ) );
      }),
    to = $( "#to" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1
    })
    .on( "change", function() {
      from.datepicker( "option", "maxDate", getDate( this ) );
    });

  function getDate( element ) {
    var date;
    try {
      date = $.datepicker.parseDate( dateFormat, element.value );
    } catch( error ) {
      date = null;
    }

    return date;
  }

const $city = document.querySelector("#city");
const $RoomType = document.querySelector("#RoomType");
const form = document.querySelector("form");

$city.addEventListener("input", (e) => {
        console.log(`input name: ${e.target.name} event: ${e.type} value: ${e.target.value}`);
    });

$RoomType.addEventListener("input", (e) => {
    console.log(`input name: ${e.target.name} value: ${e.type} value: ${e.target.value}`);
});

var check_in_date = document.forms["searchForm"]["from"];
var check_out_date = document.forms["searchForm"]["to"];

var check_in_date_error = document.getElementById("check_in_date_error");
var check_out_date_error = document.getElementById("check_out_date_error");

function validateForm() {
  if (check_in_date.value == "") {
    check_in_date_error.textContent = "Please enter a Check-in Date."
    check_in_date.focus();
    return false;
  }
  if (check_out_date.value == "") {
    check_out_date_error.textContent = "Please enter a Check-out Date."
    check_out_date.focus();
    return false;
  }
}
    
});







