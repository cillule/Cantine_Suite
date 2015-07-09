/**
 * Choisi type abonnement
 */
        $(function() {
            $('#select_abonnement').change(function() {

                if ($(this).val() === "Annuelle") {
                    $("#schema_annuel").removeClass("hidden");
                    $("#schema_hebdo").addClass("hidden");
                }

                if ($(this).val() === "Hebdomadaire") {
                    $("#schema_annuel").addClass("hidden");
                    $("#schema_hebdo").removeClass("hidden");
                }
            });
        });

/**
 * assistant d'aide à l'utilisateur pour admin
 */
$(function() {
    var tour_admin = new Tour();

    tour_admin.addSteps([
        {
            element: "#famille_admin",
            title: "Onglet famille!",
            content: "Permet de voir toutes les informations sur les familles.",
            placement: "bottom"
        },
        {
            element: "#facture_admin",
            title: "Onglet facture!",
            content: "Permet de voir l'état des factures et de les générer.",
            placement: "bottom"
        },
        {
            element: "#suivi_admin",
            title: "Onglet suivi des inscrits!",
            content: "Permet de générer des documents présentant le suivi des inscrits.",
            placement: "bottom"
        },
        {
            element: "#message_admin",
            title: "Onglet message!",
            content: "Permet d'envoyer un message à toutes les familles, ou à une famille en particulier.",
            placement: "bottom"
        },
        {
            element: "#documents_admin",
            title: "Onglet document!",
            content: "Permet de modifier les prix et d'ajouter des documents.",
            placement: "bottom"
        },
        {
            element: "#reglages_admin",
            title: "Onglet Reglages!",
            content: "Permet de modifier la période de vacances ainsi que le mot de passe administrateur.",
            placement: "bottom"
        },
        {
            element: "#aide_admin",
            title: "Onglet Aide!",
            content: "Permet de relancer l'assitant d'aide.",
            placement: "bottom"
        }
    ]);

//Démarre le tutoriel
    $("#aide_admin").click(function(e) {
        e.preventDefault();
        tour_admin.restart();
    });
});

/**
 * assistant d'aide à l'utilisateur pour admin
 */
$(function() {
    var tour_parents = new Tour();

    tour_parents.addSteps([
        {
            element: "#famille_parents",
            title: "Onglet famille!",
            content: "Permet de compléter les informations sur sa famille.",
            placement: "bottom"
        },
        {
            element: "#enfant_parents",
            title: "Onglet enfant!",
            content: "Permet d'ajouter des enfants, et de gérer leur inscription.",
            placement: "bottom"
        },
        {
            element: "#facture_parents",
            title: "Onglet facture!",
            content: "Permet de voir l'état des factures et de les générer.",
            placement: "bottom"
        },
        {
            element: "#document_parents",
            title: "Onglet document!",
            content: "Permet de voir les différents documents que propose la cantine ainsi que les différents tarifs des repas.",
            placement: "bottom"
        },
        {
            element: "#message_parents",
            title: "Onglet message!",
            content: "Permet d'envoyer un message à l'administrateur si on a des questions.",
            placement: "bottom"
        },
        {
            element: "#contact_parents",
            title: "Onglet document!",
            content: "Permet de savoir où se trouve la cantine, ainsi que diverses informations permettant de les contacter.",
            placement: "bottom"
        },
        {
            element: "#aide_parents",
            title: "Onglet aide!",
            content: "Permet de lancer l'assitant d'aide.",
            placement: "bottom"
        }
    ]);

//Démarre le tutoriel
    $("#aide_parents").click(function(e) {
        e.preventDefault();
        tour_parents.restart();
    });
});

/**
 * Défini une longueur maximale pour les textarea
 */
$(function() {
    $(".textarea").click(function() {
        $('textarea').maxlength({
            alwaysShow: true,
            placement: 'top-right',
            threshold: 10,
            warningClass: "label label-success",
            limitReachedClass: "label label-danger"
        });
    });
});

function deleteConfirm() {
    var choix = confirm("Etes vous sûr de votre choix ?");
    if (choix === true) { // Clic sur OK
        return true;
    } else {
        return false;
    }
}

$(function() {
    $('#date_suivi_inscrit').datepicker({
        minViewMode: 1,
        format: "mm/yyyy",
        language: "fr",
        orientation: "top auto"
    });
});

$(function() {
    $('#date_suivi_presence').datepicker({
        language: "fr",
        orientation: "top auto",
        todayHighlight: true,
        daysOfWeekDisabled: "0,6",
    });
});