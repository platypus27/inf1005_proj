<!DOCtype html>
<html lang="en">

<head>
    <title>tint</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="SHORTCUT ICON" href="/static/image/icon.ico" type="image/x-icon" />
    <!--jQuery-->
    <script defer src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--Clipboard JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.4/clipboard.min.js"></script>

    <!--Icons-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

    <!--Custom JS -->
    <?php
    if (isset($data['script'])) {
        $script = $data['script'];
        echo "<script defer src=\"$script\"></script>";
    }
    ?>
    <link rel="stylesheet" href="/static/css/style.css">

</head>

<body>
    <nav class="navbar navbar-expand-sm py-1">
        <?php if ($_SESSION[SESSION_RIGHTS] == AUTH_LOGIN || $_SESSION[SESSION_RIGHTS] == AUTH_ADMIN)  : ?>
            <a class="nav-brand" href="/blogs/all">   
        <?php else : ?>
            <a class="nav-brand" href="/">
        <?php endif; ?>
            <img class="rounded-circle" src="/static/image/logo.jpg" id="logo" alt="Home" />
        </a>
        <button class="navbar-toggler navbar-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mr-auto d-flex justify-content-end" id="navbarSupportedContent">
            <?php if ($_SESSION[SESSION_RIGHTS] == AUTH_LOGIN) : ?>
                <div id="cover">
                    <form class="searchbar" method="post" action="/search" method="get" action="">
                        <div class="tb">
                            <div class="td">
                                <input type="hidden" name="<?= FORM_CSRF_FIELD ?>" value="<?= $_SESSION[SESSION_CSRF_TOKEN] ?>">
                                <input id="searchbar" type="text" placeholder="search..." name="search" aria-label="Search" required></div>
                                <div class="td" id="s-cover">
                                <button type="submit">
                                <div id="s-circle"></div>
                                <span></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php elseif ($_SESSION[SESSION_RIGHTS] == AUTH_ADMIN) : ?>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/u">manage</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/contact">contacts</a>
                    </li>
                </ul>
                <div id="cover" style="width:62rem;">
                    <form class="searchbar" method="post" action="/search" method="get" action="">
                        <div class="tb">
                            <div class="td">
                                <input type="hidden" name="<?= FORM_CSRF_FIELD ?>" value="<?= $_SESSION[SESSION_CSRF_TOKEN] ?>">
                                <input id="searchbar" type="text" placeholder="search..." name="search" aria-label="Search" required></div>
                                <div class="td" id="s-cover">
                                <button type="submit">
                                <div id="s-circle"></div>
                                <span></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php else : ?>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/main/aboutus">about us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/main/contactus">contact us</a>
                    </li>
                </ul>
            <?php endif; ?>

            <?php if ($_SESSION[SESSION_RIGHTS] == AUTH_LOGIN) : ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/blog/u/<?= $_SESSION[SESSION_LOGIN] ?>"><?= $_SESSION[SESSION_LOGIN] ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/blog/create">create</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/account/profile">profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/signout">sign out</a>
                    </li>
                </ul>
            <?php elseif ($_SESSION[SESSION_RIGHTS] == AUTH_ADMIN) : ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/blog/u/<?= $_SESSION[SESSION_LOGIN] ?>"><?= $_SESSION[SESSION_LOGIN] ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/account/profile">profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/signout">sign out</a>
                    </li>       
                </ul>
            <?php else : ?>
                <ul class="nav navbar-nav navbar-right" id="signin">
                    <li class="nav-item pr-3">
                        <a class="nav-link" href="/login" title="Sign In"><i class="fas fa-sign-in-alt fa-lg"></i></a>
                    </li>
                    <li class="nav-item>">
                        <a class="nav-link" href="/register" title="Sign Up"><i class="fas fa-user-plus fa-lg"></i></a>
                    </li>
                </ul>

            <?php endif; ?>
        </div>
    </nav>
    <main <?= $data['page'] == 'main' ? "" : "class=\"container\""; ?>>
        <?php
        include '../app/view/' . $data['page'] . '.php';
        ?>
    </main>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</body>

</html>