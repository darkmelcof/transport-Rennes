$(document).ready(function() {
    $("#arretSelect2").change(function () {
        $.ajax( {
            url:"pages/ligne.php",
            data: {nomArret: $(this).val()} // On envoie  le nom de l'arrêt qui a été selectionné
        }).done(function(data) {
            $('#ligneSelect2').html(''); // On supprime l'intérieur du ligneSelect2 avant de la remplir
            $.each(data, function (key, value) { // On parcourt le json
                $('#ligneSelect2').append($('<option>', { // On ajoute les résultats de la requête dans le ligneSelect2
                    value: key,
                    text: value
                }))
            });
            $('#ligneSelect2').trigger('change'); // on déclenche l'événement change pour le résultat pré-selectionné
        })
    });




    $("#ligneSelect2").change(function () {
        $.ajax({
            url: "pages/direction.php",
            data: {nomArret: $("#arretSelect2").val(), numeroLigne: $("#ligneSelect2").val()} // Recupère la valeur du arretSelect et le ligneSelect
        }).done(function (data) { // .done => s'exécute quand le serveur revoie la réponse data
            $('#directionSelect2').html('');
            $.each(data, function (key, value) {
                $('#directionSelect2').append($('<option>', {
                    value: key,
                    text: value
                }))
            })
        });
    });

});