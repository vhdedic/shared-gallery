<h1 class="my-4">My Account</h1>
<h4 class="my-4">Change Password</h4>
<div class="card bg-light">
    <div class="card-body">
        <form method="post">
            <div class="form-group">
                <label for="old_password">Old Password:</label>
                <input type="password" class="form-control" name="old_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" class="form-control" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_new_password">Confirm New Password:</label>
                <input type="password" class="form-control" name="confirm_new_password" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary" name="submit_password" >Change Password</button>
        </form>
    </div>
</div>
