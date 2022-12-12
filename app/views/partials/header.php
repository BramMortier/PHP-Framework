<header class="header">

    <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>

    <nav class="header__nav">
        <ul class="header__navlinks">
            <li><a href="/home">home</a></li>
        </ul>
    </nav>
    <div class="header__profile">
        <ul class="header__profile-links">
            <li><a href="/auth/logout">Logout</a></li>
        </ul>
    </div>

    <?php endif; ?>

</header>