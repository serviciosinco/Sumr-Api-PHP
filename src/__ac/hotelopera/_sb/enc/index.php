<?php Hdr_HTML(); ob_start("compress_code"); $_txt = GtClTexLng($_GET['lng']);


	function GtEncDis(){

		global $__cnx;

		$Sis_Qry = "SELECT id_mdlstp, mdlstp_nm, mdlstp_tp,  (SELECT count(*) FROM _mdl_enc WHERE id_mdlstp = enc_mdlstp ) as cont
					FROM "._BdStr(DBM).TB_MDL_S_TP."";

		$Ls_Sis = $__cnx->_qry($Sis_Qry);
		$row_Ls_Sis = $Ls_Sis->fetch_assoc();
		$Tot_Ls_Sis = $Ls_Sis->num_rows;

		if($Tot_Ls_Sis > 0){
			?><div class="fil fil1"><?php
			do {
				if($row_Ls_Sis['cont'] > 0){
					?>
						<div class="col <?php echo '_'.$row_Ls_Sis['mdlstp_tp']; ?>" id=""><div class="tt"><p><?php echo $row_Ls_Sis['mdlstp_nm']; ?></p></div></div>
					<?php
				}
			} while ($row_Ls_Sis = $Ls_Sis->fetch_assoc());
			?></div><?php
		}

		$__cnx->_clsr($Ls_Sis);

		return($_r);

	}


?>
<!DOCTYPE HTML>
<html lang="es">
	<head>
		<title>Hotel de la Opera</title>
		<base href="<?php echo DMN_ENC; ?>hotelopera/" target="_self">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

		<link rel="icon" href="img/touch-icon-iphone.png" type="image/x-icon" />
		<link rel="apple-touch-icon-precomposed" href="img/touch-icon-iphone.png"/>
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/touch-icon-ipad.png"/>
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/touch-icon-iphone-retina.png"/>
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/touch-icon-ipad-retina.png"/>
		<link rel="apple-touch-startup-image" href="img/ios-startup.png"/>
		<link rel="shortcut icon" sizes="196x196" href="img/icon-chrome-196.png"/>
		<link rel="shortcut icon" sizes="128x128" href="img/icon-chrome-128.png"/>
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="mobile-web-app-capable" content="yes">


	</head>
	<body>
		<header>
			<div class="wrp">
				<div class="lg _anm"></div>
			</div>
				<div class="lng">
					<a href="?lng=es"><div class="es"></div></a>
					<a href="?lng=en"><div class="en"></div></a>
					<a href="?lng=fr"><div class="fr"></div></a>
					<a href="?lng=ptg"><div class="po"></div></a>
				</div>

		</header>
		<section>
			<div class="wrp">
				<div class="tt_enc">

					<?php echo strtoupper('<h2>'.TX_ENC.'</h2><p>'.TX_MDC.'<span>'.TX_DE.'</span>'.TX_CLDD.'</p>'); ?>
				</div>
				<div class="enc _anm" id="enc">
					<div class="_ldr"><div class="_spn"></div></div>
					<div class="x"></div>
					<div class="ld_enc"></div>
					<ul class="_ul_enc"></ul>
				</div>


				<div class="btn">
					<?php echo GtEncDis(); ?>
					<?php /*<div class="fil fil1">
						<div class="col col1 _evns" id=""><div class="tt"><p>EVENTOS</p></div></div>
						<div class="col col2 _pqt"><div class="tt"><p>PAQUETES</p></div></div>
						<div class="col col3 _spa"><div class="tt"><p>SPA</p></div></div>
					</div>
					<div class="fil fil2">
						<div class="col col1 _acd"><div class="tt"><p>ACOMODACIÓN</p></div></div>
						<div class="col col2 _rst"><div class="tt"><p>RESTAURANTE</p></div></div>
						<div class="col col3 _pqr"><div class="tt"><p>PQR</p></div></div>
					</div> */?>

				</div>
			</div>

		</section>
		<footer>
			<div class="lg_sumr"></div>
		</footer>


	</body>
</html>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="<?php echo DMN_JS; ?>jquery.validate.js"></script>
<script src="<?php echo DMN_JS; ?>jquery.form.js"></script>
<script src="<?php echo DMN_JS; ?>jquery.mCustomScrollbar.js"></script>
<script src="<?php echo DMN_JS; ?>jquery.mousewheel.js"></script>
<script src="<?php echo DMN_JS; ?>js.js"></script>


<link rel=stylesheet href="inc/sty/estr.css" type="text/css" media=screen>
<script type="text/javascript" id="main-script">
	$( ".col" ).click(function() {
	  $( ".enc" ).toggle();
	  $( ".enc" ).css( "display", "inline-block" );
	  $( ".btn" ).css( "display", "none" );
	  $( "._h1" ).show();

	  $(".enc").css('-webkit-animation-name', 'shw');


	  $(".lg").addClass('logo_right');
	  $(".enc").removeClass('div_right');

	  $("footer").css('display', 'none');
	});


	$( ".x" ).click(function() {


		  $( ".btn" ).css( "display", "inline-block" );
		  $( "._ul_enc, .ld_enc" ).empty();
		  $( '.ld_enc, ._ul_enc, .__ok_enc, ._h1' ).hide();
		  $("footer").css('display', 'block');
		  $(".enc").css('-webkit-animation-name', 'ext');
		  $(".lg").removeClass('logo_right');
		  $(".enc").addClass('div_right');
	});


	$('.enc').mCustomScrollbar({
			setHeight:"100%",
			theme:"dark"
	});

</script>
<?php
	$__id_div_enc = 'enc';
	$CntJV .=	"
		function __ld_enc(id){
			$( '._ul_enc, .ld_enc' ).empty();
			$( '.ld_enc, ._ul_enc' ).show();
			$('.ld_enc').load( '_cnt/enc.php?_t=enc&_lng=".$_GET['lng']."&_i='+id+'&Rd='+Math.random(),function(){
				$('._ldr').fadeIn();
				$('._ldr').fadeOut();
			});
		}

		function __getJs(_v){
			$( '._ul_enc' ).show();
			if(_v._tp === undefined) { _v._tp = false; }
			var _Uli = '{$__id_div_enc}';
			$.ajax({
			    type: 'POST',
			    url: '".Fl_Rnd('_json/_gn.php'.__t('enc',true))."&Rd='+Math.random(),
			    data: { __tp:_v._tp },
			    success: function(d, status){
		            $('._ldr').fadeOut();
		            if(d.e == 'ok'){

			            $('#'+ _Uli+ ' ._ul_enc ').append('<h1 class=\"_h1\">Listado de encuestas abiertas</h1>');


		                $.each(d.enc.list, function(_k, _v) {
			                _ls = '<li class=\"_li_enc\" onclick=\"__ld_enc('+_v.id+')\"> '+_v.tt+' </li>';
	                   		$('#'+ _Uli + ' ._ul_enc ').append(_ls);
	                    });


		            }else{
			            _ls = '<h3>No hay encuestas disponibles</h3>';
		                $('#'+ _Uli + ' ._ul_enc ').append(_ls);
		            }
		        },
		        beforeSend: function( xhr ) {
		    		$('._ldr').fadeIn();
			    }
			});
		}

		$('._evns').click(function() { __getJs({_tp:'6'}); });
		$('._pqt').click(function() { __getJs({_tp:'2'}); });
		$('._spa').click(function() { __getJs({_tp:'5'}); });
		$('._acd').click(function() { __getJs({_tp:'3'}); });
		$('._rst').click(function() { __getJs({_tp:'4'}); });
		$('._pqr').click(function() { __getJs({_tp:'7'}); });

		";

		echo CntJQ($CntJV, 'ok').CntJQ($CntWb);

?>


<?php ob_end_flush();