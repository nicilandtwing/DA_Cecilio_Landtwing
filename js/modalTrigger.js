// Funktionsbezeichnung, Fehrer ID Variabel laden
function loadDriverModal(js_driverId) {

    // Wenn ein Fahrer geladen wurde, das Modal zuerst löschen 
    if ($('#driverDetails').length) {
  $('#driverDetails').remove();
}
      // Per Ajax das Modal von driverModal.php Laden (im Link wird die Fahrer ID mitgegeben)
      $.ajax({
          type: 'GET',
          url: 'driverModal.php?driver_id=' + js_driverId,
          success: function (data) {
              // Das Modal zum momentanen HTML hinzufügen
              $('body').append(data);

              // Das Modal anzeigen
              $('#driverDetails').modal('show');
          }
      });
  }

  // Funktionsbezeichnung, Team ID Variabel laden
function loadTeamModal(js_constructorId) {

    // Wenn ein Team geladen wurde, das Modal zuerst löschen 
    if ($('#teamDetails').length) {
  $('#teamDetails').remove();
}
      // Per Ajax das Modal von driverModal.php Laden (im Link wird die Team ID mitgegeben)
      $.ajax({
          type: 'GET',
          url: 'teamModal.php?constructor_id=' + js_constructorId,
          success: function (data) {
               // Das Modal zum momentanen HTML hinzufügen
              $('body').append(data);

              // Das Modal anzeigen
              $('#teamDetails').modal('show');
          }
      });
  }