<?php 
    // Page data
    $login_data = $data["login_data"];
?>

<?php include PROJ_ROOT . "/app/views/partials/head.php" ?>

<body>

    <?php include PROJ_ROOT . "/app/views/partials/header.php" ?>

    <main>
        <section class="login container">

            <h2>Login</h2>

            <form class="form" action="/auth/login" method="POST">

                <div class="form__control">
                    <label for="username">Username</label>
                    <input type="text" name="username" value="<?= $login_data->username ?>">
                    <span class="invalid"><?= $login_data->username_err ?></span>
                </div>
                
                <div class="form__control">
                    <label for="password">Password</label>
                    <input type="password" name="password" value="<?= $login_data->password ?>">
                    <span class="invalid"><?= $login_data->password_err ?></span>
                </div>

                <button class="btn btn--primary" type="submit">Login</button>
                <p class="form__link">New user? <a href="/auth/register">Sign up</a></p>

            </form>
        </section>
    </main>

    <?php include PROJ_ROOT . "/app/views/partials/footer.php" ?>

</body>
</html>