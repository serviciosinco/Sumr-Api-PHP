<?php $pth = '../../'; $div_prtn = 'no'; include($pth.'inc/inc.php'); ?>
<?php mysql_select_db(DB, CnRd()); $query_LsRdTot = "SELECT * FROM por_rd ORDER BY id_rd DESC"; $LsRdTot = mysql_query($query_LsRdTot, CnRd()); $row_LsRdTot = mysql_fetch_assoc($LsRdTot);$totalRows_LsRdTot = mysql_num_rows($LsRdTot); $GotoRD = round($totalRows_LsRdTot/2); ?>
<?php /*?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>RevistaDigital.co</title>
    <meta name="description" content="Dise&ntilde;o y digitalizaci&oacute;n de revistas o publicaciones, con acceso desde diferentes plataformas, web o movil.">
    <meta name="keywords" content="revistas, digitalización, iPad, revistas interactivas, revistas digitales, revistero virtual, digitales, publisher, flip, pageflip, flipping, turn, turning, online, publicacion, fotos, albumes">
    <script src="http://servicios.in/inc/js/coverflow.js"></script>
	<script type="text/javascript" src="http://servicios.in/inc/js/jquery.js"></script>
	<script type="text/javascript" src="http://servicios.in/inc/js/superfish.js?ver=1.4.8"></script>
	<script type="text/javascript" src="http://servicios.in/inc/js/jquery.easing.1.3.js?ver=1.3"></script>
    <script type="text/javascript" src="http://servicios.in/inc/js/jquery.tools.min.js?ver=1.2.6"></script>
	<script type="text/javascript" src="http://servicios.in/inc/js/jquery.loader.js?ver=1.0"></script>
    <link rel="shortcut icon" href="http://img.servicios.in/sv.ico">
	<link rel="stylesheet" href="http://servicios.in/inc/sty/all_wb.css"/>
</head>
<body>


<script>
</script><?php */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  	<title>RevistaDigital.co</title>
  	<meta charset="utf-8">
    <base href="http://revistadigital.co/">
    <meta name="description" content="Dise&ntilde;o y digitalizaci&oacute;n de revistas o publicaciones, con acceso desde diferentes plataformas, web o movil.">
    <meta name="keywords" content="revistas, digitalización, iPad, revistas interactivas, revistas digitales, revistero virtual, digitales, publisher, flip, pageflip, flipping, turn, turning, online, publicacion, fotos, albumes">
    <meta name="author" content="Servicios.in">
    <link rel="icon" href="img/wb/favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="img/wb/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="inc/sty/all_wb.css">
    <script type="text/javascript" src="http://servicios.in/inc/js/jquery.js"></script>
    <script type="text/javascript" src="http://servicios.in/inc/js/superfish.js?ver=1.4.8"></script>
    <script type="text/javascript" src="http://servicios.in/inc/js/jquery.nivo.slider.js?ver=2.5.2"></script>
    <script type="text/javascript" src="inc/js/script.js"></script>

<!--[if lt IE 8]>

   <div style=' clear: both; text-align:center; position: relative;'>

     <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">

       <img src="http://storage.ie6countdown.com/assets/100/img/wb/banners/warning_bar_0000_us.jpg" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />

    </a>

  </div>

<![endif]-->

<!--[if lt IE 9]>

	<script src="js/html5.js"></script>

	<link rel="stylesheet" href="css/ie.css"> 

<![endif]-->

</head>
<body id="page1">
<div class="main-bg">
    <!-- Header -->
    <header>
        <div class="header-bg">
            <div class="inner">
                <div class="row-1">
                    <h1 class="logo"><a href="/">iRevista</a></h1>
                    <strong class="slogan">mundo digital</strong>
                    <form id="search" action="search.php" method="get" accept-charset="utf-8">
                        <input type="text" name="s" value="search" onFocus="if(this.value=='search'){this.value=''}" onBlur="if(this.value==''){this.value='search'}">
                        <a onClick="document.getElementById('search').submit()"></a>
                    </form>
                </div>
                <nav>
                    <ul class="sf-menu">
                        <li class="first current"><a href="/">inicio</a></li>
                        <li><a href="/revistas">revistas</a></li>
                        <li><a href="/tarifas">tarifas</a></li>
                        <li><a href="/soluciones">soluciones</a></li>
                        <li class="last"><a href="/contacto">contacto</a></li>
                    </ul>
                </nav>
            </div>

            <div class="slider-container">
            
            <div class="slider-wrapper theme-default">
                <div id="slider" class="nivoSlider">
                    <img src="img/wb/slide-1.jpg" alt="" />
                    <img src="img/wb/slide-2.jpg" alt="" />
                    <img src="img/wb/slide-3.jpg" alt="" />
                </div>
            </div>
            <?php /*?>
                <div class="mp-slider">
                    <ul class="mp-items">
                        <li>
                            <img src="img/wb/slide-1.jpg" alt="">
                            <div class="mp-banner">
                                <strong class="mp-row-1">Take <span>your</span></strong>
                                <div class="mp-row-2">
                                    benefit from our work!
                                </div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. <br>Praesent vestibulum molestie lacus. Aenean nonummy hendrerit mauris. Phasellus porta. Fusce suscipit varius mi. 
                                </p>
                                <a href="more.html" class="mp-button">more info</a>
                            </div>
                        </li>
                        <li>
                            <img src="img/wb/slide-2.jpg" alt="">
                            <div class="mp-banner">                          
                                <strong class="mp-row-1">Fresh<span>ideas</span></strong>
                                <div class="mp-row-2">
                                    for growing your business
                                </div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. <br>Praesent vestibulum molestie lacus. Aenean nonummy hendrerit mauris. Phasellus porta. Fusce suscipit varius mi. 
                                </p>
                                <a href="more.html" class="mp-button">more info</a>
                            </div>
                        </li>
                        <li>
                            <img src="img/wb/slide-3.jpg" alt="">
                            <div class="mp-banner">
                                <strong class="mp-row-1">Let's <span>create</span></strong>
                                <div class="mp-row-2">
                                    your company's growth strategy together!
                                </div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. <br>Praesent vestibulum molestie lacus. Aenean nonummy hendrerit mauris. Phasellus porta. Fusce suscipit varius mi. 
                                </p>
                                <a href="more.html" class="mp-button">more info</a>
                            </div>
                        </li>
                    </ul>
                </div>
                <?php */?>
            </div>
        </div>
    </header>

    <!-- Content -->

    <section id="content">
        <div class="container_24">
            <div class="grid_24 top-box">
                <div class="wrapper">
                    <div class="grid_8 alpha equal-columns vr-border">
                        <div class="heading-box first">
                            <h1>VENTAJAS</h1>
                        </div>
                        <div class="inner">
                            <div class="wrapper">
                                <img src="img/wb/page1-icon1.png" alt="" align="left" class="img-ico">
                                <strong class="str-1 extra-wrap">
                                    Diseños Personalizados
                                </strong>
                                 Los contenidos son totalmente interactivos y la interfaz de visualización de cada revista ofrece opciones graficas únicas para cada publicación. 
                                 
                            </div>
                            
                               
                            
                            
                        </div>
                    </div>
                    <div class="grid_8 equal-columns vr-border">
                        <div class="heading-box">
                            <h1>MOVÍLES</h1>
                        </div>
                        <div class="inner">
                            <div class="wrapper">
                                <img src="img/wb/page1-icon2.png" alt="" align="left" class="img-ico">
                                <strong class="str-1 extra-wrap">
                                    Responsive Web
                                </strong>
                            
                             Visualización desde cualquier dispositivo con acceso a internet y 
con Sistema Touch.


                            
                           
                            
                            </div>
                           
                               
                        </div>
                    </div>
                    <div class="grid_8 omega equal-columns">
                        <div class="heading-box last">
                            <h1>PLANES</h1>
                        </div>
                        <div class="inner">
                            <div class="wrapper">
                                <img src="img/wb/page1-icon3.png" alt="" align="left" class="img-ico">
                                <strong class="str-1 extra-wrap">
                                    Menor Inversión 
                                </strong>
                                Los costos de publicación de cada revista son mucho mas económicos y el alcance de la publicación es mayor. 
                                </div>
                            
                               
                      </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="wrapper">
                <div class="grid_16 suffix_1 pad-top">
                    <?php include('ls_rd.php'); ?>
                </div>
               <?php /*?>
                <article class="grid_7">
                    <div class="box-1">
                        <h2>Meet the Team</h2>
                        <div class="hr-border-1">
                            <div class="wrapper">
                                <figure class="img-indent-2">
                                    <a href="#"><img src="img/wb/page1-img2.jpg" alt=""></a>
                                </figure>
                                <strong class="str-1 extra-wrap">
                                    Andy Moor<br>Praesent vestibulum
                                </strong>
                            </div>
                            <p class="p0">
                                Lorem ipsum dolor amet, con sectetuer adipiscing elit.
                            </p>
                        </div>
                        <div class="hr-border-1">
                            <div class="wrapper">
                                <figure class="img-indent-2">
                                    <a href="#"><img src="img/wb/page1-img3.jpg" alt=""></a>
                                </figure>
                                <strong class="str-1 extra-wrap">
                                    Eric Priston <br>Veuum molestie 
                                </strong>
                            </div>
                            <p class="p0">
                                Praesent vestibulum molestie lacus. Aenean nonummy.
                            </p>
                        </div>
                        <div>
                            <div class="wrapper">
                                <figure class="img-indent-2">
                                    <a href="#"><img src="img/wb/page1-img4.jpg" alt=""></a>
                                </figure>
                                <strong class="str-1 extra-wrap">
                                    Laura Smith <br>Molestie<br>lacus
                                </strong>
                            </div>
                            <p>
                                Praesent vestibulum estie lacus. Aenean nonummy.
                            </p>
                        </div>
                        <a href="more.html" class="button">view more</a>
                    </div>
                </article>
                <?php */?>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer>
       <iframe width="300" height="50" src="http://iframe.servicios.in/pwr.php?tp=1&amp;a=_d&amp;_cl=b" frameborder="0" style="margin-right: auto; margin-left: auto;"></iframe>
    </footer>
</div>
<script type="text/javascript">
    $(window).on('load',function(){
        $('#slider').nivoSlider({effect:'fade', pauseOnHover: true, pauseTime: 7000});
    });
</script>
<?php if($GA != 'no'){echo Anl();} ?>
</body>
</html>
<?php mysql_free_result($LsRdTot); ?>