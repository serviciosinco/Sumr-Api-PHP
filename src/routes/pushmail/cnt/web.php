<link href="<?php echo DMN_EC; ?>inc/sty/all.css?__c=<?php echo $__dtec->cl->enc ?>" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
		<script type="text/javascript" src="<?php echo DMN_JS ?>html5.js"></script>
        <script type="text/javascript" src="<?php echo DMN_JS ?>modernizr.js"></script>
<![endif]-->
</head>
<body>

<header id="Sty_H">
  <h1><?php echo $__dtec->tt ?></h1>
  <h2><?php echo strip_tags($__dtec->dsc); ?></h2>
</header>

  <section id="SvWrp">
    
    <article id="__Cnt" class="_cnt">
          <div id="__Cnt_html_ld" class="_cnt_html_ld"> <div id="LdBx"><div>cargando...</div></div> </div>
          <div class="_cnt_html">
                <div id="__Cnt_html"></div>
                <?php echo bdiv([ 'id'=>'eC_rlc', 'cls'=>'_ld_rlc' ]); echo bdiv([ 'id'=>'eC_cmn' ]); ?>
          </div>  
    </article>
    
    
    <nav id="_SvMn" class="_mn">
		  <?php include('inc/estr/mn.php'); ?>
          <div class="_SvPwrd"></div>
    </nav>
    
  </section>
   
  <?php if(($browser->getBrowser() == 'Internet Explorer')  && ($browser->getVersion() < 9)){ ?>	
  		<div class="_ieold">Le sugerimos usar una <a href="http://windows.microsoft.com/en-us/internet-explorer/ie-10-worldwide-languages" target="_new">versión mas actualizada</a> de su navegador </div>
  <?php } ?>
  
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo DMN_JS ?>jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo DMN_JS ?>jquery.colorbox-min.js"></script>
    <script type="text/javascript" src="<?php echo DMN_JS ?>jquery.form.js"></script>
    <script type="text/javascript" src="<?php echo DMN_JS ?>jquery.validate.js"></script>
	<script type="text/javascript" src="<?php echo DMN_JS ?>jquery.tinycarousel.js"></script>
    <script type="text/javascript" src="<?php echo DMN_JS ?>qtip.js"></script>
    <script type="text/javascript" src="<?php echo DMN_EC ?>inc/js/js.js"></script>
    
<?php 

if((isset($_GET['_c']))&&($_GET['_c'] != '')){
  $_CntJQ .= "__cnt('".$__dtec->enc."');";
}

if((isset($_GET['_tll']))&&($_GET['_tll'] != '')){
	$_CntJQ .= "__tll('".$__dtec->enc."');";
}

if((isset($_GET['_del']))&&($_GET['_del'] != '')){
	$_CntJQ .= "__del('".$__dtec->enc."');";
}

if((isset($_GET['_upd']))&&($_GET['_upd'] != '')){
	$_CntJQ .= "__upd('".$__dtec->enc."');";
}

$_s = Php_Ls_Cln($_GET['_s']);

$_CntJQ .= "
	
	__html('".$__dtec->enc."', '".$_s."');
    
	

setInterval(function(){ __onln('".$__dtec->enc."') }, 20000);"; ?>


<script type="text/javascript">
    <?php echo $_CntJV; ?>
	
	$(document).ready(function() {	
        <?php echo $_CntJQ; ?>
	});
	
	<?php if($_CntJQ_Ld != ''){ ?>
	$(window).bind("load", function() {
	    <?php echo $_CntJQ_Ld; ?>		
	});
	<?php } ?>
</script>