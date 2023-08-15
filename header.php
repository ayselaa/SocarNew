<?php 
if(!$security_test) exit;
?>



<div class="preloader">
    <div class="layer"></div>
    <!-- end layer -->
    <div class="inner">
        <figure><img src="/images/preloader.gif" alt="Socar Petroleum"></figure>
        <p><span class="text-rotater" data-text="Socar Petroleum"><?php print $yuklenir; ?></span></p>
    </div>
    <!-- end inner --> 
</div>
<!-- end prelaoder -->
<div class="transition-overlay">
    <div class="layer"></div>
</div>
<!-- end transition-overlay -->
<div class="side-navigation">
    <div class="select-box dropdown show"> <a class="dropdown-toggle" href="#" role="button" id="language-select" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span>
            <img src="/images/flag-az.svg" alt="Azərbaycanca"> Azərbaycanca</span> </a>
        <ul class="dropdown-menu" aria-labelledby="language-select">
            <li><a class="dropdown-item" href="#"><img src="/images/flag-en.svg" alt="English"> English</a></li>
            <li><a class="dropdown-item" href="#"><img src="/images/flag-ru.svg" alt="Русский"> Русский</a></li>
        </ul>
    </div>
    <div class="user"><a href="https://www.s-p.az/"><i class="fa-solid fa-credit-card  card-icon-nav"></i></a></div>
    <div class="menu">
        <ul>
            <?php
            ust_menyu($lang,$db_link);
            ?>
        </ul>
    </div>
</div>
<!-- end side-navigation -->
<nav class="navbar">
    <div class="container">
        <div class="upper-side">
            <div class="logo"> <a href="/index.html"><img src="/images/logo@4x.png" alt="Socar Logo"></a> </div>
            <!-- end logo -->
            <div class="phone-email row">
            </div>
            <!-- end phone -->
            <div class="select-box dropdown show d-none d-lg-block"> 
                <?php
                if($lang=='az') print "<a class='dropdown-toggle' href='#' role='button' id='language-select' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><span><img src='/images/flag-az.svg' alt='Azərbaycanca'> Azərbaycanca</span> </a>";
                if($lang=='en') print "<a class='dropdown-toggle' href='#' role='button' id='language-select' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><span><img src='/images/flag-en.svg' alt='English'> English</span> </a>";
                if($lang=='ru') print "<a class='dropdown-toggle' href='#' role='button' id='language-select' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><span><img src='/images/flag-ru.svg' alt='Русский'> Русский</span> </a>";  
                ?>
                
                <ul class="dropdown-menu" aria-labelledby="language-select">
                    <?php
                    if($lang!='az') print "<li><a class='dropdown-item' href='/az/'><img src='/images/flag-az.svg' alt='Azərbaycanca'> Azərbaycanca</a></li>";
                    if($lang!='en') print "<li><a class='dropdown-item' href='/en/'><img src='/images/flag-en.svg' alt='English'> English</a></li>";
                    if($lang!='ru') print "<li><a class='dropdown-item' href='/ru/'><img src='/images/flag-ru.svg' alt='Русский'> Русский</a></li>";
                    ?>
                </ul>
            </div>
            <img id="specialButton" style="cursor:pointer;height: 35px; padding-right: 30px;" src="/slep/eyeglass.png" alt="Görmə qabiliyyəti zəif olanlar üçü versiya" title="Görmə qabiliyyəti zəif olanlar üçü versiya" />
            <div class="user d-none d-lg-block">
                <a href="https://www.s-p.az/"><i class="fa-solid fa-credit-card  card-icon-nav"></i></a></div>
            <!-- end language -->
            <div class="hamburger"> <span></span> <span></span> <span></span><span></span> </div>
            <!-- end hamburger --> 
        </div>
        <!-- end upper-side -->
        <div class="menu">
            <ul>
                <?php
                ust_menyu($lang,$db_link);
                ?>
            </ul>
        </div>
        <!-- end menu --> 
    </div>
    <!-- end container --> 
</nav>
<!-- end navbar -->

