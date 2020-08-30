<?php
if (isset($notifications)){
    echo '<br>';
    foreach($notifications as $notification){ ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $notification; ?>
        </div><?php
    }
} ?>
<h1 class="my-4">Management</h1>
<form method="POST" enctype="multipart/form-data" class="md-form">
	<input type="file" name="images">
	<br><br>
	<input type="submit" name="upload" value="Upload">
</form>
<table class="table border-bottom my-5">
    <?php foreach ($images as $image) : ?>
        <tr>
            <td class="w-50">
                <img class="mw-100" src="<?php echo Config::getParams('url').'uploads/'.$image['image']; ?>" alt="<?php echo $image['image']; ?>">
            </td>
            <td class="w-50">
                <div class="font-weight-bold">
                    <?php echo $image['username']; ?>&nbsp;&lt;<?php echo $image['email']; ?>&gt;
                </div>
                <?php if ($image['username'] == $_SESSION['username']): ?>
                    <div class="my-4">
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $image['id'] ?>">
                            <input type="hidden" name="image" value="<?php echo $image['image'] ?>">
                            <button type="submit" name="remove" class="btn btn-danger" formaction="<?php echo Config::getParams('url'); ?>index.php?page=management&action=remove">Remove Image</button>
                        </form>
                    </div>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
