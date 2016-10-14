$(document).ready(function() { // Attend que le DOM soit chargé
    $("#ligneSelect").change(function () { // Ecoute l'évenement change sur l'élement qui a l'id ligneSelect
        $.ajax({
            url: "pages/stop.php",
            data: {numeroLigne: $(this).val()}
        }).done(function (data) { // S'execute quand le requête est finie
            $('#arretSelect').html(''); // on supprime l'intérieur du arretselect avant de la remplir
            $.each(data, function (key, value) { // On parcourt le json
                $('#arretSelect').append($('<option>', { // On ajoute une option dans le select des arrêts
                    value: value,
                    text: value
                }))
            });
            $('#arretSelect').trigger('change'); // on déclenche l'événement change pour le résultat pré-selectionné
        });

    });

    $("#arretSelect").change(function () {
        $.ajax({
            url: "pages/direction.php",
            data: {nomArret: $(this).val(), numeroLigne: $("#ligneSelect").val()} // Recupère la valeur du arretSelect et le ligneSelect
        }).done(function (data) { // .done => s'exécute quand le serveur revoie la réponse data
            $('#directionSelect').html('');
            $.each(data, function (key, value) {
                $('#directionSelect').append($('<option>', {
                    value: key,
                    text: value
                }))
            })
        });
    });

});