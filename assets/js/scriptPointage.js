$(document).ready(function () {
    
    //génére le tableau
    $.fn.dataTable.ext.order['dom-checkbox'] = function (settings, col)
    {
        return this.api().column(col, {order: 'index'}).nodes().map(function (td, i) {
            return $('input', td).prop('checked') ? '1' : '0';
        });
    };
    $('#table_gestion').dataTable({
        "columns": [
            null,
            null,
            null,
            null,
            null,
            null,
            {"orderDataType": "dom-checkbox"}
        ]
    });

    //permet de cocher l'enfant présent et d'envoyer à la base de données
    $(".checkbox").change(function () {
        var id_enfant = $(this).val();
        $.ajax({
            url: location.href + '/pointage', // La ressource ciblée
            type: 'POST', // Le type de la requête HTTP.
            data: 'id_enfant=' + id_enfant,
            dataType: 'html',
            success: function () {
            },
            error: function () {
                alert("AJAX ne fonctionne pas, réessayez. Si l'erreur persiste, contactez l'administrateur");
            }
        });
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

