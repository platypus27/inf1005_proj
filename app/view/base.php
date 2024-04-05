<!DOCtype html>
<html lang="en">

<head>
    <title>tint</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="SHORTCUT ICON" href= "/public/static/image/icon.ico" type="image/x-icon" >
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous">

    <script>
	    if (window.location.hostname === "35.212.238.114") {
     	   window.location.replace("https://tint.defmain.xyz");
    	}
        function animation(x) {
            var child = x.children;
            for (var i = 0; i < child.length; i++) {
                child[i].classList.toggle("change");
            }
        }
    </script>

    <?php
    if (isset($data['script'])) {
        $script = $data['script'];
        echo "<script defer src=\"$script\"></script>";
    }
    ?>
    <link rel="stylesheet" href="/public/static/css/style.css">

</head>

<body>
    <nav class="navbar navbar-expand-lg">
        
        <?php if ($_SESSION[SESSION_RIGHTS] == AUTH_ADMIN) : ?>
            <a class="nav-brand" href="/tints/all">
            <img class="rounded-circle" src="/public/static/image/logo.jpg" id="logo" alt="Home">
            </a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navicon" onclick="animation(this)">   
                    <span class="bar1"></span>
                    <span class="bar2"></span>
                    <span class="bar3"></span>
                </span> 
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav mr-0">
                    <li class="nav-item searchitem">
                        <div id="cover">
                            <form class="searchbar" method="post" action="/search">
                                <input type="hidden" name="<?= FORM_CSRF_FIELD ?>" value="<?= $_SESSION[SESSION_CSRF_TOKEN] ?>">
                                <input id="searchbar" type="text" placeholder="search..." name="search" aria-label="Search" required>
                                <div id="s-cover" aria-label="search">
                                    <button type="submit">
                                        <div id="s-circle"></div>
                                    <span id="search"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/u">manage</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/contact">contacts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/signout">sign out</a>
                    </li>
                </ul>
                
            </div>
        <?php elseif ($_SESSION[SESSION_RIGHTS] == AUTH_LOGIN) : ?>
            <a class="nav-brand" href="/tints/all">
            <img class="rounded-circle" src="/public/static/image/logo.jpg" id="logo" alt="Home">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navicon" onclick="animation(this)">   
                    <span class="bar1"></span>
                    <span class="bar2"></span>
                    <span class="bar3"></span>
                </span>  
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav mr-0">
                    <li class="nav-item searchitem">
                        <div id="cover">
                            <form class="searchbar" method="post" action="/search">
                                <input type="hidden" name="<?= FORM_CSRF_FIELD ?>" value="<?= $_SESSION[SESSION_CSRF_TOKEN] ?>">
                                <input id="searchbar" type="text" placeholder="search..." name="search" aria-label="search" required>
                                <div id="s-cover">
                                    <button type="submit" aria-label="search">
                                    <div id="s-circle"></div>
                                    <span id="search"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/tint/u/<?= $_SESSION[SESSION_LOGIN] ?>"><?= $_SESSION[SESSION_LOGIN] ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/friends/u">friends</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/tint/create">create</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/account/profile">profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/signout">sign out</a>
                    </li>
                </ul>
                
            </div>
        <?php else : ?>
            <a class="nav-brand" href="/">
            <img class="rounded-circle" src="/public/static/image/logo.jpg" id="logo" alt="Home">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navicon" onclick="animation(this)">   
                    <span class="bar1"></span>
                    <span class="bar2"></span>
                    <span class="bar3"></span>
                </span>  
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav mr-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/main/aboutus">about us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/main/contactus">contact us</a>
                    </li>
                    <li class="nav-item pr-3">
                        <a class="nav-link" href="/login" title="Sign In"><i class="fas fa-sign-in-alt fa-lg"></i></a>
                    </li>
                    <li class="nav-item>">
                        <a class="nav-link" href="/register" title="Sign Up"><i class="fas fa-user-plus fa-lg"></i></a>
                    </li>
                </ul>
                
            </div>
        <?php endif; ?>
    </nav>
    <main <?= $data['page'] == 'main' ? "" : "class=\"container\""; ?>>
        <?php include '../app/view/' . $data['page'] . '.php'; ?>
    </main>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <?php if($data['page'] == 'main'): ?>
    <footer>
        <div class="footercont">
            <img src="/public/static/image/logo.jpg" id="footer-logo" alt="footerimg">
            <h4 class="p-2">tint inc. 2024 all rights reserved</h4>
        </div>
    </footer>
</body>
<?php endif; ?>
</html>
