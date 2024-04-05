<section class="mainpage">

<?php if(isset($_GET['timeout'])):
if ($_GET['timeout']):?>
    <article class="card border-0 intro-head p-5 container">
        <h5 class="text-center">session timeout please sign in again</h5>
    </article>
<?php endif;
endif; ?>
    <div class="mobilecontent">
        <h1>
            all the happenings
        </h1>
        <h1>
            here at tint
        </h1>
        <br>
        <h2>
            <a class="registerhome" href="/register">register today </a>
        </h2>
    </div>
    <div>
        <img class="mainbg" src="/public/static/image/background.jpg" alt="background">
    </div>
</section>