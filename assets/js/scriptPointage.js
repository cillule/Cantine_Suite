$(document).ready(function() {

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
        "scrollY": "300px",
        "scrollCollapse": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/French.json"
        }
    });

    $('#liste_enfant_famille').dataTable({
        "scrollY": "300px",
        "scrollCollapse": true,
        "paging": false,
        "ordering": true,
        "sDom": '<"top"i>rt<"bottom"flp><"clear">',
        "info": false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/French.json"
        }
    });

    $('#table_liste_enfants_parents').dataTable({
        "scrollY": "500px",
        "scrollCollapse": true,
        "paging": false,
        "ordering": true,
        "sDom": '<"top"i>rt<"bottom"flp><"clear">',
        "info": false,
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
            filter: function(list) {
                return $.map(list, function(enfant) {
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

    //génére le tableau
    $.fn.dataTable.ext.order['dom-checkbox'] = function(settings, col)
    {
        return this.api().column(col, {order: 'index'}).nodes().map(function(td, i) {
            return $('input', td).prop('checked') ? '1' : '0';
        });
    };
    $('#table_liste_facture').dataTable({
        "scrollY": "500px",
        "scrollCollapse": true,
        "info": false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/French.json"
        }
    });

    //permet de cocher l'enfant présent et d'envoyer à la base de données
    $(".checkbox_liste_facture").change(function() {
        var id_facture = $(this).val();

        $.ajax({
            url: 'change_etat_facture', // La ressource ciblée
            type: 'POST', // Le type de la requête HTTP.
            data: 'id_facture=' + id_facture,
            dataType: 'html',
            success: function() {
            },
            error: function() {
                alert("AJAX ne fonctionne pas, réessayez. Si l'erreur persiste, contactez l'administrateur");
            }
        });
    });


});



