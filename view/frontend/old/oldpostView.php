<?php
ob_start();
//print_r($post);
?>

        <div class="row">
            <div class="col-md-6">
                <h2 class="mb-4">Article</h2>
                Vous venez de créer votre premier template avec {{ moteur_name }} !
            </div>
        </div>
        <div class="row blog-entries">
            <div class="col-md-12 col-lg-8 main-content">
                <div class="row">

                    <h2><?= $post->title(); ?></h2>

                </div>
            </div>
            <?php
            $content = ob_get_clean();
            $titlePage = 'Page Article';
            require('view/frontend/template.php');

            ?>
