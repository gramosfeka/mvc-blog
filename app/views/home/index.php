<?php require APPROOT . '/views/inc/header.php'?>
    <div class="container">
        <div class="row">
            <div class='col-md-2'>
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active">
                        <i class="fa fa-home"></i> Categories
                    </a>
                    <?php foreach ($data['categories'] as $category) : ?>
                    <a href="<?php echo URLROOT; ?>/articles/getArticlesByCategory/<?php echo $category->id ?>"
                       class="list-group-item list-group-item-action">
                        <i class="fa fa-home"></i> <?php echo $category->name ?>
                    </a>
                    <?php endforeach; ?>

                </div>
            </div>
            <div class="row col-md-10">
            <?php foreach ($data['articles'] as $article) : ?>
                <div id="myTable" class='col-md-4' style="margin-bottom: 20px;">
                    <div class='panel panel-info'>

                        <div class='panel-body'>
                            <img src="<?php echo URLROOT; ?>/<?php echo $article->image ?> " style="width: 250px;height: 300px; margin-bottom: 10px;">
                            <h4><?php echo $article->title?></h4>
                            <p><?php echo substr(strip_tags($article->body), 0, 50), strlen($article->body) > 50 ? "..." : ""  ?></p>
                            <a href="<?php echo URLROOT; ?>/articles/single/<?php echo $article->id ?>" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>

        </div>
    </div>

<?php require APPROOT . '/views/inc/footer.php'?>