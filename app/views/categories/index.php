<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="col-md-4">
        <div>
            <?php flash('category_success'); ?>
            <h2>New Category</h2>
            <form method="POST" action="<?php echo URLROOT; ?>/categories/add">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name"
                           class="form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : '' ?>"
                           value="<?php echo $data['name'] ?>">
                    <span class="invalid-feedback"><?php echo $data['name_err'] ?></span>
                </div>
                <div class="col">
                    <input type="submit" value="Create new Category" class="btn btn-primary col-12 mt-2">
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6 offset-md-2">
        <table class="table">
            <thead>
                <th>#</th>
                <th>Name</th>
                <th>Created At</th>
                <th>Edit</th>
            </thead>
            <tbody>
            <?php foreach ($data['categories'] as $category) : ?>
                <tr>
                    <th scope="row"><?php echo $category->id ?></th>
                    <td><?php echo $category->name ?></td>
                    <td><?php echo $category->created_at ?></td>
                    <td><a href="<?php echo URLROOT; ?>/categories/edit/<?php echo $category->id ?>"
                           class="btn btn-light btn-sm m-1">Edit</a></td>

                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>





