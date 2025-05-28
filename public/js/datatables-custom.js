
function initializeDataTables() {
    customizeDataTablesElements();
    if ($.fn.dataTable) {
        if ($('#rolesTable').length) {
            $('#rolesTable').DataTable({
                "order": [[0, "asc"]],
                "pageLength": 10,
                "language": {
                    "search": "Search:",
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    }
                }
            });
        }
        if ($('#permissionsTable').length) {
            $('#permissionsTable').DataTable({
                "order": [[0, "asc"]],
                "pageLength": 10,
                "language": {
                    "search": "Search:",
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    }
                }
            });
        }
    }
}
function customizeDataTablesElements() {
    $('.dataTables_filter input').css({
        'padding': '5px 10px',
        'border': '1px solid #ccc',
        'border-radius': '4px',
        'margin-left': '10px',
        'font-size': '14px'
    });
    $('.dataTables_length select').css({
        'padding': '5px 10px',
        'border': '1px solid #ccc',
        'border-radius': '4px',
        'margin': '0 5px',
        'font-size': '14px'
    });
    $('.dataTables_paginate .paginate_button').css({
        'padding': '5px 10px',
        'margin': '0 2px',
        'cursor': 'pointer',
        'border-radius': '4px'
    });
    $('.dataTables_paginate .paginate_button.current').css({
        'background-color': '#f0f0f0',
        'font-weight': 'bold'
    });
}
$(document).ready(function() {
    initializeDataTables();
}); 