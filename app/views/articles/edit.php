<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="col-md-8 offset-2">
        <form method="POST" enctype="multipart/form-data"
              action="<?php echo URLROOT; ?>/articles/edit/<?php echo $data['id']?>">

            <div class="form-group">
                <label for="title">Title:</label>
                <input class="form-control  <?php echo (!empty($data['title_err'])) ? 'is-invalid' : '' ?>" type="text" id="title" name="title"
                       value="<?php echo $data['title'] ?>">
                <span class="invalid-feedback"><?php echo $data['title_err'] ?></span>
            </div>
            <div class="form-group">
                <label for="slug">Slug:</label>
                <input class="form-control <?php echo (!empty($data['slug_err'])) ? 'is-invalid' : '' ?>" type="text" id="slug" name="slug"
                       value="<?php echo $data['slug'] ?>">
                <span class="invalid-feedback"><?php echo $data['slug_err'] ?></span>
            </div>

            <div class="form-group">
                <label for="category_id">Category:</label>
                <select class="form-control <?php echo (!empty($data['category_err'])) ? 'is-invalid' : '' ?>" name="category_id" id="category_id">
                    <?php foreach ($data['categories'] as $category) : ?>
                        <option value="<?php echo $category->id ?>"><?php echo $category->name ?></option>
                    <?php endforeach;?>
                </select>
                <span class="invalid-feedback"><?php echo $data['category_err'] ?></span>
            </div>

            <div class="form-group">
                <label for="tags">Tags:</label>
                <select multiple="multiple" class="form-control multiple <?php echo (!empty($data['tags_err'])) ? 'is-invalid' : '' ?>" name="tags[]" id="tags">
                    <?php foreach ($data['tags'] as $tag) : ?>
                        <option value="<?php echo $tag->id ?>"><?php echo $tag->name ?></option>
                    <?php endforeach;?>
                </select>
                <span class="invalid-feedback"><?php echo $data['tags_err'] ?></span>
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <input name="image" type="file" class="form-control-file <?php echo (!empty($data['image_err'])) ? 'is-invalid' : '' ?>" id="image">
                <span class="invalid-feedback"><?php echo $data['image_err'] ?></span>
            </div>
            <div class="form-group">
                <label for="body">Description:</label>
                <textarea class="form-control <?php echo (!empty($data['body_err'])) ? 'is-invalid' : '' ?>" name="body" id="editor"
                          rows="10"><?php echo $data['body'] ?></textarea>
                <span class="invalid-feedback"><?php echo $data['body_err'] ?></span>
            </div>
            <div class="row">
                <div class="col">
                  <input type="submit" value="Update" class="btn btn-success col-12 mt-2 btn-block">
                </div>
        </form>
        <div class="col">
            <form method="POST" action="<?php echo URLROOT; ?>/articles/delete/<?php echo $data['id']?>">
                <input type="submit" value="Delete" class="btn btn-danger col-12 mt-2">
            </form>
        </div>
    </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>