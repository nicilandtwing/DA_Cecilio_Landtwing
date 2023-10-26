// Function to load the driver modal content using AJAX
function loadDriverModal(js_driverId) {
    if ($('#driverDetails').length) {
  $('#driverDetails').remove();
}
      // Use AJAX to load the modal content from modal.php
      $.ajax({
          type: 'GET',
          url: 'driverModal.php?driver_id=' + js_driverId,
          success: function (data) {
              // Append the modal content to the body
              $('body').append(data);

              // Show the modal
              $('#driverDetails').modal('show');
          }
      });
  }

  // Function to load the driver modal content using AJAX
function loadTeamModal(js_constructorId) {
    if ($('#teamDetails').length) {
  $('#teamDetails').remove();
}
      // Use AJAX to load the modal content from modal.php
      $.ajax({
          type: 'GET',
          url: 'teamModal.php?driver_id=' + js_constructorId,
          success: function (data) {
              // Append the modal content to the body
              $('body').append(data);

              // Show the modal
              $('#teamDetails').modal('show');
          }
      });
  }