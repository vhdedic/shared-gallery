<?php if (isset($notifications)): ?>
<br>
    <?php foreach ($notifications as $notification): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $notification; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<h1 class="my-4">My Account</h1>

<h4 class="my-4">Change Password</h4>

<div class="card bg-light">
    <div class="card-body">
        <form method="post">
            <div class="form-group">
                <label for="old_password">Old Password:</label>
                <input type="password" class="form-control" name="old_password">
                <small class="form-text text-muted">required</small>
            </div>
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" class="form-control" name="new_password">
                <small class="form-text text-muted">required, 8 characters minimum</small>
            </div>
            <div class="form-group">
                <label for="confirm_new_password">Confirm New Password:</label>
                <input type="password" class="form-control" name="confirm_new_password">
                <small class="form-text text-muted">required, confirm new password</small>
            </div>
            <br>
            <button type="submit" class="btn btn-dark" name="submit_password">Change Password</button>
        </form>
    </div>
</div>

<h4 class="my-4">Remove Account</h4>

<form method="post">
    <button type="submit" name="remove_account" class="btn btn-lg btn-danger" formaction="<?php echo Config::getParams('url'); ?>index.php?page=myaccount&action=remove">Remove Account</button>
</form>
