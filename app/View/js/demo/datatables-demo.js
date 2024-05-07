// Call the dataTables jQuery plugin
$(document).ready(function () {
  $('#dataTable').DataTable({
    "language": {
      "url": "https://cdn.datatables.net/plug-ins/2.0.7/i18n/pt-BR.json"
    },
    columnDefs: [
      { type: 'natural', targets: 0 } // Substitua 0 pelo índice da coluna que contém os números
    ]
  });
});



