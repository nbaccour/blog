<?php
ob_start();
?>


        <div class="row">
            <div class="col-md-6">
                <h2 class="mb-4">Latest Posts</h2>
            </div>
        </div>
        <div class="row blog-entries">
            <div class="col-md-12 col-lg-8 main-content">
                <div class="row">
                    <?php
                    foreach ($posts as $post) {

                        ?>
                        <div class="col-md-6">
                            <a href="?action=post&id=<?= $post->id(); ?>"
                               class="blog-entry element-animate"
                               data-animate-effect="fadeIn">
                                <img src="images/img_5.jpg" alt="Image placeholder">
                                <div class="blog-content-body">
                                    <div class="post-meta">
                                    <span class="author mr-2"><img src="images/person_1.jpg"
                                                                   alt="Colorlib"> <?= $post->author(); ?></span>&bullet;
                                        <span class="mr-2"><?= $post->createDate(); ?> </span> &bullet;
                                        <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                                    </div>
                                    <h2><?= $post->title(); ?></h2>
                                </div>
                            </a>
                        </div>
                    <?php } ?>

                </div>

                <!--                <div class="row mt-5">-->
                <!--                    <div class="col-md-12 text-center">-->
                <!--                        <nav aria-label="Page navigation" class="text-center">-->
                <!--                            <ul class="pagination">-->
                <!--                                <li class="page-item  active"><a class="page-link" href="#">&lt;</a></li>-->
                <!--                                <li class="page-item"><a class="page-link" href="#">1</a></li>-->
                <!--                                <li class="page-item"><a class="page-link" href="#">2</a></li>-->
                <!--                                <li class="page-item"><a class="page-link" href="#">3</a></li>-->
                <!--                                <li class="page-item"><a class="page-link" href="#">4</a></li>-->
                <!--                                <li class="page-item"><a class="page-link" href="#">5</a></li>-->
                <!--                                <li class="page-item"><a class="page-link" href="#">&gt;</a></li>-->
                <!--                            </ul>-->
                <!--                        </nav>-->
                <!--                    </div>-->
                <!--                </div>-->
            </div>

            <?php
            $content = ob_get_clean();
            $titlePage = 'Liste des articles';
            require('view/frontend/template.php');

            ?>
