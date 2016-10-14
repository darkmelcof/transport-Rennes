$(document).ready(function() {
    $("#departSelect").change(function () {
        $.ajax({
            url: "../pages/ligne.php",
            data: {nomArret: $(this).val()}
        }).done(function (data) {
            $('#ligneSelect3').html('');
            $.each(data, function (key, value) {
                $('#ligneSelect3').append($('<option>', {
                    value: key,
                    text: value
                }))
            });
            $('#ligneSelect3').trigger('change');
        });

    });



    $("#ligneSelect3").change(function () {
        $.ajax({
            url: "../pages/arrivee.php",
            data: {nomArret: $("#departSelect").val(), numeroLigne: $("#ligneSelect3").val()}
        }).done(function (data) {
            $('#arriveeSelect').html('');
            $.each(data, function (key, value) {
                $('#arriveeSelect').append($('<option>', {
                    value: value,
                    text: value
                }))
            })
        });
    });
});