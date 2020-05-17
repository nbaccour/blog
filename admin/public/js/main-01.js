$(document).ready(function () {


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
                            url: 'public/ajax/delete.php?deletepost&' + $this[0].dataset.id,
                            data: {
                                idpost: $this[0].dataset.id,
                                action: 'deletepost',
                            },
                            success: function (json) {
                                if (json.result == 'Success') {

                                    $("#postdeleted").html("<div class=\"alert alert-success\">L'article est supprimé</div>");
                                    $('#id_' + json.idpost).remove();
                                }
                                else {
                                    $("#postdeleted").html("<div class=\"alert alert-danger\" >Erreur : Article non supprimé</div>");
                                }


                            }	//	SUCCESS
                        });	//	AJAX
                    },
                },
                Annuler: {
                    btnClass: 'btn-danger',

                },
            },

        });

    });

    $(".deleteUser").click(function (e) {

        e.preventDefault();
        const $this = $(this);
        // var confirmdelete = false;
        $.confirm({
            title: 'Supprimer',
            content: "Supprimer l'utilisateur ?",
            buttons: {
                Valider: {
                    text: 'Valider',
                    btnClass: 'btn-success',
                    action: function () {
                        $.ajax({
                            type: "DELETE",
                            url: 'public/ajax/delete.php?deleteuser&' + $this[0].dataset.id,
                            data: {
                                iduser: $this[0].dataset.id,
                                action: 'deleteuser',
                            },
                            success: function (json) {
                                if (json.result == 'Success') {

                                    $("#userdeleted").html("<div class=\"alert alert-success\">Le membre est supprimé</div>");
                                    $('#id_' + json.iduser).remove();
                                }
                                else {
                                    $("#userdeleted").html("<div class=\"alert alert-danger\" >Erreur : Membre non supprimé</div>");
                                }


                            }	//	SUCCESS
                        });	//	AJAX
                    },
                },
                Annuler: {
                    btnClass: 'btn-danger',

                },
            },

        });

    });
    $(".deleteomment").click(function (e) {

        e.preventDefault();
        const $this = $(this);
        // var confirmdelete = false;
        $.confirm({
            title: 'Supprimer',
            content: "Supprimer le commentaire ?",
            buttons: {
                Valider: {
                    text: 'Valider',
                    btnClass: 'btn-success',
                    action: function () {
                        $.ajax({
                            type: "DELETE",
                            url: 'public/ajax/delete.php?deletecomment&' + $this[0].dataset.id,
                            data: {
                                iduser: $this[0].dataset.id,
                                action: 'deletecomment',
                            },
                            success: function (json) {
                                if (json.result == 'Success') {

                                    $("#commentdeleted").html("<div class=\"alert alert-success\">Le commentaire est supprimé</div>");
                                    $('#id_' + json.iduser).remove();
                                }
                                else {
                                    $("#commentdeleted").html("<div class=\"alert alert-danger\" >Erreur : Commentaire non supprimé</div>");
                                }


                            }	//	SUCCESS
                        });	//	AJAX
                    },
                },
                Annuler: {
                    btnClass: 'btn-danger',

                },
            },

        });

    });

    $('#updatecommentform').submit(function (e) {

        e.preventDefault();
        $('form input[type="submit"]').prop("disabled", true);
        $.ajax({
            type: "PUT",
            url: 'public/ajax/update.php',
            contentType: false,
            processData: false,
            data: $(this).serialize(),

            success: function (json) {
                if (json.result == 'Success') {

                    $("#useredit").html("<div class=\"alert alert-success\">Commentaire validé</div>");
                    $('form #updatecommentform input[type="submit"]').prop("disabled", true);
                }
                else {

                    $("#useredit").html('<div class="alert alert-danger">Erreur : Commentaire non validé </div>');
                    $('form #updatecommentform input[type="submit"]').prop("disabled", true);
                }

            }	//	SUCCESS
        });	//	AJAX

    });

    $('#updateuserform').submit(function (e) {

        e.preventDefault();
        $('form input[type="submit"]').prop("disabled", true);
        $.ajax({
            type: "PUT",
            url: 'public/ajax/update.php',
            contentType: false,
            processData: false,
            data: $(this).serialize(),

            success: function (json) {
                if (json.result == 'Success') {

                    $("#useredit").html("<div class=\"alert alert-success\">Les données du membre ont étaient modifiées</div>");
                    $('form #updateuserform input[type="submit"]').prop("disabled", true);
                }
                else {

                    $("#useredit").html('<div class="alert alert-danger">Erreur : Données non modifiées </div>');
                    $('form #updateuserform input[type="submit"]').prop("disabled", true);
                }

            }	//	SUCCESS
        });	//	AJAX

    });

    $('#updatepostform').submit(function (e) {

        e.preventDefault();
        $('form #btupdatepost input[type="submit"]').prop("disabled", true);
        $.ajax({
            type: "PUT",
            url: 'public/ajax/update.php',
            contentType: false,
            processData: false,
            data: $(this).serialize(),

            success: function (json) {
                if (json.result == 'Success') {

                    $("#postedit").html("<div class=\"alert alert-success\">L'article est modifié</div>");
                    $('form #updatepostform input[type="submit"]').prop("disabled", true);
                }
                else {

                    $("#postedit").html('<div class="alert alert-danger">Erreur : Article non modifié </div>');
                    $('form #updatepostform input[type="submit"]').prop("disabled", true);
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
        oPostData.append('action', $("input#addpost").val());
        oPostData.append('content', $("textarea#content").val());
        oPostData.append('idcategory', $("select#idcategory").val());

        $.ajax({
            type: "POST",
            url: 'public/ajax/add.php',
            contentType: false,
            processData: false,
            data: oPostData,
            success: function (json) {
                if (json.result === 'Success') {

                    $("#postadd").html("<div class=\"alert alert-success\">Votre article a été ajouté</div>");
                    $('form #addpostform input[type="submit"]').prop("disabled", true);
                }
                else {

                    $("#postadd").html('<div class="alert alert-danger">Erreur : Ajout Article </div>');
                    $('form #addpostform input[type="submit"]').prop("disabled", true);
                }

            }	//	SUCCESS
        })
        ;	//	AJAX

    });

    $('#adduser').submit(function (e) {

        e.preventDefault();

        var oPostData = new FormData();

        oPostData.append('lastname', $("input#lastname").val());
        oPostData.append('action', $("input#adduser").val());
        oPostData.append('firstname', $("input#firstname").val());
        oPostData.append('email', $("input#email").val());
        oPostData.append('role', $("select#role").val());
        oPostData.append('login', $("input#login").val());
        oPostData.append('password', $("input#password").val());

        $.ajax({
            type: "POST",
            url: 'public/ajax/add.php',
            contentType: false,
            processData: false,
            data: oPostData,
            success: function (json) {
                if (json.result === 'Success') {

                    $("#useradd").html("<div class=\"alert alert-success\">L'utilisateur a été ajouté</div>");
                    $('form #adduser input[type="submit"]').prop("disabled", true);
                }
                else {

                    $("#useradd").html('<div class="alert alert-danger">Erreur : Ajout Utilisateur </div>');
                    $('form #adduser input[type="submit"]').prop("disabled", true);
                }

            }	//	SUCCESS
        })
        ;	//	AJAX

    });

    $('#updateimgpost').submit(function (e) {

        e.preventDefault();
        $('form #btupdatepostImg input[type="submit"]').prop("disabled", true);
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
            dataType: 'json',
            success: function (json) {

                if (json.result == 'Success') {

                    $("#imgpostedit").html("<div class=\"alert alert-success\">Image modifiée</div>");
                    $('#postimgupdate').attr('src', 'public/images/post/' + json.filename);
                    $('form #updateimgpost input[type="submit"]').prop("disabled", true);
                }
                else {

                    $("#imgpostedit").html('<div class="alert alert-danger">json.error </div>');
                    $('form #updateimgpost input[type="submit"]').prop("disabled", true);
                }

            }	//	SUCCESS

        });	//	AJAX

    });


})
;