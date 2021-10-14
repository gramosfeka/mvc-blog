<?php require APPROOT . '/views/inc/header.php'?>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">

                <img src="<?php echo URLROOT; ?>/<?php echo $data['article']->image ?> " style="width: 450px;height: 400px;">
                <h1><?php echo $data['article']->title?></h1>
                <p class="lead"><?php echo$data['article']->body?></p>
                <hr>

                    <?php  foreach ( $data['categories'] as $category): ?>
                    <?php if( $data['article']->category_id == $category->id) :?>
                    <p>Category: <?php echo $category->name?></p>
                        <?php endif; ?>

                    <?php endforeach ;?>
                <hr>
                Tags:

                <?php foreach ($data['tags'] as $tag) : ?>
                    <button type="button" class="btn btn-secondary  btn-sm ">
                        <?php echo $tag->name ?>
                    </button>
                <?php endforeach; ?>
            </div>

        </div>

    </div>

<?php require APPROOT . '/views/inc/footer.php'?>