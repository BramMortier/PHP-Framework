<?php 
    // Page data
    $register_data = $data["register_data"];
?>

<?php include PROJ_ROOT . "/app/views/partials/head.php" ?>

<body>

    <?php include PROJ_ROOT . "/app/views/partials/header.php" ?>

    <main>
        <section class="register container">

            <h2>Register</h2>

            <form class="form" action="/auth/register" method="POST">

                <div class="form__control">
                    <label for="username">Username</label>
                    <input type="text" name="username" value="<?= $register_data->username ?>">
                    <span class="invalid"><?= $register_data->username_err ?></span>
                </div>
                
                <div class="form__control">
                    <label for="password">Password</label>
                    <input type="password" name="password" value="<?= $register_data->password ?>">
                    <span class="invalid"><?= $register_data->password_err ?></span>
                </div>

                <div class="form__control">
                    <label for="confirm_password">Confirm password</label>
                    <input type="password" name="confirm_password" value="<?= $register_data->confirm_password ?>">
                    <span class="invalid"><?= $register_data->confirm_password_err ?></span>
                </div>

                <button class="btn btn--primary" type="submit">Register</button>
                <p class="form__link">I have an account <a href="/auth/login">Login</a></p>

            </form>
        </section>
    </main>

    <?php include PROJ_ROOT . "/app/views/partials/footer.php" ?>

</body>
</html>