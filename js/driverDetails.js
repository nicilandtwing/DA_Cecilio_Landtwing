// Function to load the driver modal content using AJAX
function loadDriverModal(js_driverId) {
    if ($('#driverDetails').length) {
  $('#driverDetails').remove();
}
      // Use AJAX to load the modal content from modal.php
      $.ajax({
          type: 'GET',
          url: 'raceDriverDetails.php?driver_id=' + js_driverId,
          success: function (data) {
              // Append the modal content to the body
              $('body').append(data);

              // Show the modal
              $('#driverDetails').modal('show');
          }
      });
  }