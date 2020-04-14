//GET, POST, DELETE, PUT
$(document).ready(function () {

    // $('#testconfirm').click(function (event) {
    //     event.preventDefault();
    //     $.confirm({
    //         title: 'Alert!',
    //         content: 'Simple alert!',
    //     });
    //
    // });

    $(".deletePost").click(function (e) {

        e.preventDefault();
        const $this = $(this);
        // var confirmdelete = false;
        $.confirm({
            title: 'Supprimer',
            content: 'Supprimer votre article ?',
            buttons: {
                Valider: {
                    text: 'Valider',
                    btnClass: 'btn-success',
                    action: function () {
                        $.ajax({
                            type: "DELETE",
                            url: 'public/ajax/delete.php?id=' + $this[0].dataset.id,
                            data: {
                                idpost: $this[0].dataset.id,
                                action: 'deletePost',
                            },
                            success: function (json) {
                                if (json.result == 'Success') {

                                    $("#postdeleted").html("<div class=\"alert alert-danger\">L'article est supprimé</div>");
                                    setTimeout(
                                        function () {
                                            location.reload();
                                        }, 2000);
                                }
                                else {

                                    $("#postdeleted").html("<div>Erreur : Article non supprimé</div>");
                                }


                            }	//	SUCCESS
                        });	//	AJAX
                    },
                },
                // Valider: function () {
                //
                // },
                Annuler: {
                    btnClass: 'btn-danger',

                },
            },

        });

    })
    ;

    $('#updatepostform').submit(function (e) {

        e.preventDefault();

        $.ajax({
            type: "PUT",
            url: 'public/ajax/update.php',
            contentType: false,
            processData: false,
            data: $(this).serialize(),

            success: function (json) {
                if (json.result == 'Success') {

                    $("#postedit").html("<div class=\"alert alert-success\">L'article est modifié</div>");
                }
                else {

                    $("#postedit").html('<div class="alert alert-danger">Erreur : Article non modifié </div>');
                }

            }	//	SUCCESS
        });	//	AJAX

    });

    $('#addpostform').submit(function (e) {

        e.preventDefault();

        var oPostData = new FormData();
        var files = $('#postimg')[0].files[0];

        oPostData.append('file', files);
        oPostData.append('title', $("input#title").val());
        oPostData.append('content', $("textarea#content").val());
        oPostData.append('idcategory', $("select#idcategory").val());

        $.ajax({
            type: "POST",
            url: 'public/ajax/add.php',
            contentType: false,
            processData: false,
            // data: $(this).serialize(),
            data: oPostData,

            success: function (json) {
                $("#postadd").html("<div class=\"alert alert-success\">Votre article a été ajouté</div>");

                // if (json.result == 'Success') {
                //
                //     $("#postadd").html("<div class=\"alert alert-success\">Votre article a été ajouté</div>");
                // }
                // else {
                //
                //     $("#postadd").html('<div class="alert alert-danger">Erreur : Ajout Article </div>');
                // }

            }	//	SUCCESS
        });	//	AJAX

    });

    $('#updateimgpost').submit(function (e) {

        e.preventDefault();
        // console.log($(this));

        var oFileData = new FormData();
        var files = $('#postimg')[0].files[0];

        oFileData.append('file', files);
        oFileData.append('id', $("input#id").val());
        // oFileData.append('url', the_slug());


        $.ajax({
            type: "POST",
            url: 'public/ajax/update.php',
            contentType: false,
            processData: false,
            data: oFileData,
            // dataType: 'json',
            success: function (json) {
                // alert(json);
                $("#imgpostedit").html("<div class=\"alert alert-success\">Image modifiée</div>");
                setTimeout(
                    function () {
                        location.reload();
                    }, 2000);

                // if (json.result == 'Success') {
                //
                //
                // }
                // else {
                //
                //     $("#imgpostedit").html('<div class="alert alert-danger">json.error </div>');
                // }

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


})
;