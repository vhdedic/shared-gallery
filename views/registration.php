<h1 class="my-4">Registration</h1>
<div class="card bg-light">
    <div class="card-body">
        <form method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" class="form-control" name="confirm_password" required>
                <a href="<?php echo Config::getParams('url'); ?>?page=login&action=index">Already have an account. Login here.</a>
            </div>
            <button type="submit" class="btn btn-dark" name="submit" >Submit</button>
        </form>
    </div>
</div>
