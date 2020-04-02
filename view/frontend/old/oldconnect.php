<?php
ob_start();

?>

<div class="row">
    <div class="col-md-6">
        <h2 class="mb-4">Connectez- vous</h2>
    </div>
</div>
<div class="row blog-entries">
    <div class="col-md-12 col-lg-8 main-content">
        <div class="row">

            <!--Section: Contact v.2-->
            <section class="col-lg-12">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="main">
                            <form action="index.php?action=verifUser" method="post">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i
                                                    class="fa fa-user prefix grey-text"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="votre identifiant"
                                           name="login" required="" value="">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i
                                                    class="fa fa-lock prefix grey-text"></i></span>
                                    </div>
                                    <input type="password" class="form-control" placeholder="Mot de passe"
                                           name="password" required="" value="">
                                </div>
                                <span><a href="index.php?action=forgetPwd">Mot de passe oublié</a></span>
                                <div class="button">
                                    <br>
                                    <button type="submit" class="btn btn-primary">Valider</button>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>

            </section>
            <!--Section: Contact v.2-->


        </div>
    </div>
    <?php
    $content = ob_get_clean();
    $titlePage = 'Page Article';
    require('view/frontend/template.php');

    ?>
