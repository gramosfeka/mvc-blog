<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-8 offset-2">
        <div class="card">
            <div class="card-header">
                <h3>Add New Article</h3>
            </div>
            <div class="card-body">

                <form method="POST" enctype="multipart/form-data" action="<?php echo URLROOT ?>/articles/store">
                    <input type="hidden" name="id" value="<?php echo '$id' ?>">

                    <div class="form-group mt-2">
                        <label for="title">Title:</label>
                        <input class="form-control  <?php echo (!empty($data['errors']['title_err'])) ? 'is-invalid' : '' ?>"
                               type="text" id="title" name="title"
                               value="<?php echo $data['title'] ?>">
                        <span class="invalid-feedback"><?php echo $data['errors']['title_err'] ?></span>
                    </div>

                    <div class="form-group mt-2">
                        <label for="category_id">Category:</label>
                        <select class="form-control <?php echo (!empty($data['errors']['category_err'])) ? 'is-invalid' : '' ?>"
                                name="category_id" id="category_id">
                            <option value="">Select Category</option>
                            <?php foreach ($data['categories'] as $category) : ?>
                                <option value="<?php echo $category->id ?>"><?php echo $category->name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="invalid-feedback"><?php echo $data['errors']['category_err'] ?></span>
                    </div>

                    <div class="form-group mt-2">
                        <label for="tags">Tags:</label>
                        <select multiple="multiple"
                                class="form-control multiple <?php echo (!empty($data['errors']['tags_err'])) ? 'is-invalid' : '' ?>"
                                name="tags[]" id="tags">
                            <?php foreach ($data['tags'] as $tag) : ?>
                                <option value="<?php echo $tag->id ?>"><?php echo $tag->name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="invalid-feedback"><?php echo $data['errors']['tags_err'] ?></span>
                    </div>

                    <div class="form-group mt-2">
                        <label for="image">Image:</label>
                        <input name="image" type="file"
                               class="form-control <?php echo (!empty($data['errors']['image_err'])) ? 'is-invalid' : '' ?>"
                               id="image">
                        <span class="invalid-feedback"><?php echo $data['errors']['image_err'] ?></span>
                    </div>

                    <div class="form-group mt-2">
                        <label for="body">Description:</label>
                        <textarea
                                class="form-control <?php echo (!empty($data['errors']['body_err'])) ? 'is-invalid' : '' ?>"
                                name="body" id="editor"
                                rows="10"><?php echo $data['body'] ?></textarea>
                        <span class="invalid-feedback"><?php echo $data['errors']['body_err'] ?></span>
                    </div>
                    <div class="form-group mt-2">
                        <label for="date">Date:</label>
                        <input name="created_at" type="datetime-local"
                               class="form-control <?php echo (!empty($data['errors']['created_at_err'])) ? 'is-invalid' : '' ?>"
                               value="<?php echo $data['created_at'] ?>" id="created_at">
                        <span class="invalid-feedback"><?php echo $data['errors']['created_at_err'] ?></span>
                    </div>
                    <div class="form-group mt-2">
                        <input type="submit" value="Submit" class="btn btn-success btn-lg mt-2 btn-block">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php require APPROOT . '/views/inc/footer.php'; ?>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script>

