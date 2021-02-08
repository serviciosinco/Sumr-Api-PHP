<?php
	
	if($__pm_2 == 'qr'){
		$__f_inc = 'qr.php'; $_bdy_cls='_qr';
	}else{
		$__f_inc = 'dsgn.php'; $_bdy_cls='_lnd';
		
		if(!isN( $__dt_act->img->big )){
			$__imgbck = $__dt_act->img->big;
		}
	}
	
?>
<!doctype html>
	<html lang='es' class='no-js'>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title><?php echo $__dt_act->tt.SP.SIS_TT ?></title>
		<base href="/" target="_self">
		<meta name='description' content='<?php echo strip_tags($__dt_act->dsc); ?>' />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<!--[if lt IE 9]>
				<script type="text/javascript" src="<?php echo DMN_JS ?>html5.js"></script>
				<script type="text/javascript" src="<?php echo DMN_JS ?>modernizr.js"></script>
		<![endif]-->
	</head>
	<body style="display:none; background-image:url(<?php echo $__imgbck; ?>); " class="<?php echo $_bdy_cls; ?>">
		<?php include(DIR_CNT.$__f_inc); ?>
		<noscript>
		<div class="_JvRc"> Su navegador NO tiene activo JAVA, puede representar dificultades para navegar </div>
		</noscript>
	</body>
</html>
<?php if(_isFm()){ $_if_js = 'ok'; $_if__css = '&_iF=o'; } ?>
<?php if(_isFm()){ $__prfx_rp = 'if_'; } ?>
<script type="text/javascript">
	
	"use strict";
	
	<?php $___font = __font(); ?>
	
	<?php if(!isN($___font->js->string)){ ?> 

		var WebFontConfig = {  google: {families: <?php echo $___font->js->string; ?> },  timeout:2000  };
			
	<?php } ?>

	var SUMR_Main={slc:{ sch:''}};
	
	function __ld_all(){
		
		SUMR_Ld.f.js({
			
			u:'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js',
			c:function(){

		        SUMR_Ld.f.js({ u:'<?php echo DMN_JS; ?>jquery-ui.js' });			        
			    
		        SUMR_Ld.f.css({  
					t:'p',
			        h:'<?php echo DMN_CSS; ?>sb/act/main.css',
			        c:function(){
						<?php echo $CntWb.$_CntJQ; ?>
						$('body').addClass('_rdy');
		            }                             
		        });   
			}
		});	
	}
	
</script>
<script type="text/javascript" src="<?php echo DMN_JS; ?>_ld.js" async></script>
<?php if($__html_ga != ''){ echo Anl($__html_ga, false); } ?>