console.log('locked and loaded')

jQuery(document).ready(function() {
    jQuery('#last-login-table').DataTable( {
        pageLength: 10,
        dom: 'Bfrtip',
        buttons: [
            'copy',
            {
              extend: 'excelHtml5',
              header: true,
              title: null
            },{
              extend: 'csvHtml5',
              header: true,
              title: null
            }          
        ]
    } );
} );