<?php
/**
 * Admin Login View
 */
?>

<section class="section admin-login">
    <div class="container">
        <div class="login-form-wrapper">
            <h1>Admin Login</h1>
            <?php if (isset($error)): ?>
            <div class="alert alert-error" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>
            <form method="POST" action="/admin/login" class="login-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-large">Login</button>
            </form>
        </div>
    </div>
</section>

