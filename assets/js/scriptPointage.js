$(document).ready(function () {
    
    $('#table_gestion').dataTable({
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sSwfPath": "//cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf"
        },
        "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/French.json"
            }
    });
    
    $('#table_liste_famille').dataTable({
        
        "scrollY":        "300px",
        "scrollCollapse": true,
        "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/French.json"
            }
    });

    //permet de rechercher un enfant
    var enfants = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        limit: 10,
        prefetch: {
            ttl: 1,
            url: location.href + '/recherche',
            filter: function (list) {
                return $.map(list, function (enfant) {
                    return {name: enfant};
                });
            }
        }
    });

    enfants.initialize();

    $('#recherche').typeahead(null, {
        name: 'recherche',
        displayKey: 'name',
        source: enfants.ttAdapter()
    });
});

