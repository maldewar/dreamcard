$(document).ready(function() {
  $('#received_dataTable').dataTable({
    scrollX: true,
    scrollY: false,
    searching: false,
    lengthChange: false
  });
  $('#sent_dataTable').dataTable({
    scrollX: true,
    scrollY: false,
    searching: false,
    lengthChange: false
  });
});
