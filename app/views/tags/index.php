<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="col-md-4">
        <div>
            <?php flash('tag_success'); ?>
            <h2>New Tag</h2>
            <form method="POST" action="<?php echo URLROOT; ?>/tags/store">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name"
                           class="form-control <?php echo (!empty($data['errors']['name_err'])) ? 'is-invalid' : '' ?>"
                           value="<?php echo $data['name'] ?>">
                    <span class="invalid-feedback"><?php echo $data['errors']['name_err'] ?></span>
                </div>
                <div class="col">
                    <input type="submit" value="Create new Tag" class="btn btn-primary col-12 mt-2">
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6 offset-md-2">
        <?php if (empty($data['tags'])) :?>
            <h2 class="text-center"> <?php echo "No data found"; ?></h2>

        <?php  else: ?>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Edit</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data['tags'] as $tag) : ?>
                <tr>
                    <th scope="row"><?php echo $tag->id ?></th>
                    <td><?php echo $tag->name ?></td>
                    <td><a href="<?php echo URLROOT; ?>/tags/edit/<?php echo $tag->id ?>"
                           class="btn btn-light btn-sm m-1">Edit</a></td>

                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
         <?php  endif; ?>
    </div>

</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>






