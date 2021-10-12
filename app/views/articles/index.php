<?php require APPROOT . '/views/inc/header.php'; ?>

    <div class="row">
        <div class="col-md-10">
            <?php  flash('articles_message') ?>
            <h1>All Articles</h1>
        </div>
        <div class="col-md-2">
            <a href="<?php echo URLROOT ?>/articles/create" class="btn btn-lg btn-block btn-primary btn-h1-spacing">Create New
                Article</a>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                <th>#</th>
                <th>Title</th>
                <th>Body</th>
                <th>Action</th>
                </thead>
                <tbody>
                <?php foreach ($data['articles'] as $article) : ?>
                    <tr>
                        <th><?php echo $article->id ?></th>
                        <td><?php echo $article->title ?></td>
                        <td><?php echo $article->body ?></td>
                        <td><a href="<?php echo URLROOT; ?>/articles/edit/<?php echo $article->id ?>" class="btn btn-default btn-sm">Edit</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
