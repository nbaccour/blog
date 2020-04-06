//GET, POST, DELETE, PUT
$(document).ready(function () {


    $(".deletePost").click(function (e) {

        e.preventDefault();
        const $this = $(this);

        $.ajax({
            // type: "DELETE",
            type: "POST",
            url: 'public/ajax/delete.php',
            data: {
                idpost: $this[0].dataset.id,
                action: 'deletePost',
            },
            success: function (json) {


                if (json.result == 'Success') {

                    $("#postdeleted").html("<div class=\"alert alert-danger\">L'article est supprimé</div>");
                }
                else {

                    $("#postdeleted").html("<div>Erreur : Article non supprimé</div>");
                }


            }	//	SUCCESS
        });	//	AJAX

    });

    // $("#submit").click(function (e) {
    //
    //     e.preventDefault();
    //
    //     $.ajax({
    //         type: "POST",
    //         url: 'public/ajax/connexion.php',
    //         data: {
    //             username: $("#username").val(),  // Nous récupérons la valeur de nos input que l'on fait passer à connexion.php
    //             password: $("#password").val()
    //         },
    //         success: function (json) {
    //
    //             console.log('testtesttetstet');
    //             console.log(json.result);
    //             if (json.result == 'Success') {
    //                 // Le membre est connecté. Ajoutons lui un message dans la page HTML.
    //
    //                 $("#resultat").html("<p>Vous avez été connecté avec succès !</p>");
    //             }
    //             else {
    //                 // Le membre n'a pas été connecté. (data vaut ici "failed")
    //
    //                 $("#resultat").html("<p>Erreur lors de la connexion...</p>");
    //             }
    //
    //
    //         }	//	SUCCESS
    //     });	//	AJAX
    //
    // });


});