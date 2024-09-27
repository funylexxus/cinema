$(document).ready(function () {
  // Initialize the datepicker
  $('.date').datepicker({
    todayHighlight: true, // to highlight the today's date
    format: 'yyyy-mm-dd', // we format the date before we will submit it to the server side
    autoclose: true, //we enable autoclose so that once we click the date it will automatically close the datepicker
  });

  $('#btnSubmit').on('click', function () {
    var $this = $('#btnSubmit'); //submit button selector using ID
    var $caption = $this.html(); // We store the html content of the submit button
    var form = '#form'; //defined the #form ID
    var formData = $(form).serializeArray(); //serialize the form into array
    var route = $(form).attr('action'); //get the route using attribute action

    // Ajax config
    $.ajax({
      type: 'POST', //we are using POST method to submit the data to the server side
      url: route, // get the route value
      data: formData, // our serialized array data for server side
      beforeSend: function () {
        //We add this before send to disable the button once we submit it so that we prevent the multiple click
        $this.attr('disabled', true).html('Processing...');
      },
      success: function (response) {
        //once the request successfully process to the server side it will return result here
        $this.attr('disabled', false).html($caption);
        // We will display the result using alert
        alert(response);
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        // You can put something here if there is an error from submitted request
      },
    });
  });
});
