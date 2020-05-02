//GET, POST, DELETE, PUT
$(document).ready(function () {


    $(".replycommentchild").click(function (e) {

        e.preventDefault();
        const $this = $(this);
        // console.log($this);
        // console.log($this[0].id);
        $(".comment-list").find('#replycommentform_' + $this[0].id).removeClass('d-none');
        $(".comment-list").find("#" + $this[0].id).addClass('d-none');
    });

    $(".cancelsendcommentchild").click(function (e) {

        e.preventDefault();
        const $this = $(this);

        const idcomment = $this[0].id.substr(13);

        $(".comment-list").find('#replycommentform_' + idcomment).addClass('d-none');
        $(".comment-list").find("#" + idcomment).removeClass('d-none');
    });

    $('#connectuser').submit(function (e) {

        var oPostData = new FormData();
        oPostData.append('login', $("input#login").val());
        oPostData.append('password', $("input#password").val());

        e.preventDefault();
        $.ajax({
            type: "POST",
            url: 'public/ajax/connexion.php',
            contentType: false,
            processData: false,
            data: oPostData,

            success: function (json) {
                if (json.result == 'Success') {
                    // console.log(document.URL);
                    // console.log(document.location.href);
                    // console.log(document.location.pathname);
                    // console.log(document.location.origin);
                    window.location = document.location.origin + document.location.pathname;
                }
                else {

                    $("#errorconnect").html('<div class="alert alert-danger">' + json.error + '</div>');
                }

            }	//	SUCCESS
        });	//	AJAX

    });

    $('#adduser').submit(function (e) {

        e.preventDefault();

        var oPostData = new FormData();

        oPostData.append('lastname', $("input#lastname").val());
        oPostData.append('action', $("input#adduser").val());
        oPostData.append('firstname', $("input#firstname").val());
        oPostData.append('email', $("input#email").val());
        oPostData.append('role', $("input#role").val());
        oPostData.append('login', $("input#login").val());
        oPostData.append('password', $("input#password").val());

        $.ajax({
            type: "POST",
            url: 'public/ajax/add.php',
            contentType: false,
            processData: false,
            data: oPostData,
            // error: function (request, statut, error) {
            //     console.log(error);
            // },
            success: function (json) {
                if (json.result === 'Success') {

                    $("#useradd").html("<div class=\"alert alert-success\">Votre compte a été créé</div>");
                    $('#btsend').remove();
                    // window.location = document.location.origin + document.location.pathname;
                }
                else {

                    $("#useradd").html('<div class="alert alert-danger">Erreur : Création de compte</div>');
                }

            }	//	SUCCESS
        })
        ;	//	AJAX

    });
    $('#addcomment').submit(function (e) {

        e.preventDefault();

        // var oPostData = new FormData();
        //
        // oPostData.append('postid', $("input#postid").val());
        // oPostData.append('author', $("input#author").val());
        // oPostData.append('parentid', $("input#parentid").val());
        // oPostData.append('action', 'addcomment');
        // oPostData.append('comment', $("textarea#comment").val());

        var inputs = $(this).serialize();
        var oCommentData = new FormData();

        oCommentData.append('data', inputs);
        oCommentData.append('action', 'addcomment');

        $.ajax({
            type: "POST",
            url: 'public/ajax/add.php',
            contentType: false,
            processData: false,
            // data: oPostData,
            data: oCommentData,
            // error: function (request, statut, error) {
            //     console.log(error);
            // },
            success: function (json) {
                if (json.result === 'Success') {

                    $("#commentadd").html("<div class=\"alert alert-success\">Votre commentaire a été envoyé</div>");
                    $('form #btsendComment input[type="submit"]').prop("disabled", true);

                }
                else {

                    $("#commentadd").html('<div class="alert alert-danger">Erreur : Ajout commentaire</div>');
                    $('form #btsendComment input[type="submit"]').prop("disabled", true);
                }

            }	//	SUCCESS
        })
        ;	//	AJAX

    });

    $('.addcommentChild').submit(function (e) {

        e.preventDefault();

        // var inputs = $.extend(formAsObject($(".addcommentChild")), {"action": 'addcomment'});
        var inputs = $(this).serialize();
        var oCommentData = new FormData();

        oCommentData.append('data', inputs);
        oCommentData.append('action', 'addcomment');

        ;$.ajax({
            type: "POST",
            url: 'public/ajax/add.php',
            contentType: false,
            processData: false,
            data: oCommentData,
            // error: function (request, statut, error) {
            //     console.log(error);
            // },
            success: function (json) {
                if (json.result === 'Success') {
                    $("#childcommentadd_" + json.parentid).html("<div class=\"alert alert-success\">Votre commentaire a été envoyé</div>");
                    $('form #btsendCommentChild input[type="submit"]').prop("disabled", true);

                    // $("#childcommentadd").html("<div class=\"alert alert-success\">Votre commentaire a été envoyé</div>");
                    // $('form #addcommentChild input[type="submit"]').prop("disabled", true);
                    // $(".comment-list").find('#replycommentform').addClass('d-none');
                }
                else {
                    $("#childcommentadd_" + json.parentid).html("<div class=\"alert alert-danger\">Erreur : Ajout commentaire</div>");
                    $('form #btsendCommentChild input[type="submit"]').prop("disabled", true);
                }

            }	//	SUCCESS
        })
        ;	//	AJAX

    });


});