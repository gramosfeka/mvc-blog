<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="col-md-10">
        <?php flash('articles_message') ?>
        <h1>All Articles</h1>
    </div>
    <div class="col-md-2">
        <a href="<?php echo URLROOT ?>/articles/create" class="btn btn-lg btn-block btn-primary btn-h1-spacing">Create
            New
            Article</a>
    </div>
    <div class="col-md-12">
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php if (empty($data['pagination']['articles'])) : ?>
            <h2 class="text-center"> <?php echo "No data found"; ?></h2>

        <?php else: ?>
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Body</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody class="row_position">

                <?php foreach ($data['pagination']['articles'] as $article) : ?>
                    <tr data-index="<?php echo $article->id ?>" data-position="<?php echo $article->position ?>">
                        <td><?php echo $article->id ?></td>
                        <td><?php echo $article->title ?></td>

                        <td><?php echo substr(strip_tags($article->body), 0, 50), strlen($article->body) > 50 ? "..." : "" ?></td>

                        <?php if ((isAdmin()) && $article->status == 0) : ?>
                            <td class="text-center"><a
                                        href="<?php echo URLROOT; ?>/articles/approve/<?php echo $article->id ?>"
                                        class="btn btn-default btn-sm">Approve</a>
                                <a href="<?php echo URLROOT; ?>/articles/edit/<?php echo $article->id ?>"
                                   target='_blank' class="edit btn btn-default btn-sm">Edit</a>
                            </td>

                        <?php else: ?>

                            <td class="text-center"><a
                                        href="<?php echo URLROOT; ?>/articles/edit/<?php echo $article->id ?>"
                                        target='_blank' class="edit btn btn-default btn-sm">Edit</a></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="links text-center">
                <?php for ($page = 1; $page <= $data['pagination']['totalAll']; $page++): ?>

                    <a href="<?php echo URLROOT; ?>/articles/index/<?php echo $page ?>"
                       class="btn btn-primary"><?php echo $page ?></a>
                    </a>

                <?php endfor; ?>

            </div>
        <?php endif; ?>


    </div>
</div>


<?php require APPROOT . '/views/inc/footer.php'; ?>


<script>
    $(document).ready(function () {
        $(".table .row_position").sortable({
            update: function (event, ui) {
                $(this).children().each(function (index) {
                    if ($(this).attr('data-position') != (index + 1)) {
                        $(this).attr('data-position', (index + 1)).addClass('updated')
                    }
                });
                saveNewPositions();
            }
        });
    });

    function saveNewPositions() {
        var positions = [];
        $('.updated').each(function () {
            positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
            $(this).removeClass('updated');
        });

        $.ajax({
            url: '<?php echo URLROOT; ?>/articles/positions',
            method: 'Post',
            dataType: 'text',
            data: {
                positions: positions
            }, success: function (response) {
                console.log(response);
            }
        });
    }


</script>


