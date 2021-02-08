<?php Hdr_HTML(); ob_start("compress_code"); ?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?php echo $__head_tt; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<base href="/" target="_blank">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<style>
			<?php include(DIR_INC.'css/hd.css'); ?>
			<?php

				$__cl_tag = $__dt_cl->tag;
				$__cl_clr = $__cl_tag->clr;

				if(!isN($__cl_clr->main->v)){ $__root_v .= ' --main-bg-color: '.$__cl_clr->main->v.'; '; }else{ $__root_v .= ' --main-bg-color:#4f006f;'; }
				if(!isN($__cl_clr->second->v)){ $__root_v .= ' --second-bg-color: '.$__cl_clr->second->v.'; '; }else{ $__root_v .= ' --second-bg-color:#de86d4; '; }

				echo '
					:root {
						'.$__root_v.'
					}
				';

	        ?>
		</style>
	</head>
	<body class="<?php echo $_bdcss; if(!isN($__fm_thm)){ echo $__fm_thm; } ?>">
		<div class="_hdr">
			<div style="background-image: url('<?php echo $__dt_cl->lgo->main->big; ?>');" class="cl_logo"></div>
		</div>
		<section>
			<div class="_prld _anm"></div>
			<?php include(DIR_CNT."fm.php"); ?>
		</section>
		<footer></footer>
	</body>
</html>
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

		        $('body').addClass('SUMR_Form');

		        SUMR_Ld.f.js({ u:'https://js.sumr.co/jquery-ui.js' });

		        SUMR_Ld.f.css({
					t:'p',
			        h:'/css/base/<?php echo $__url_thm; ?>',
			        c:function(){
		                SUMR_Ld.f.js({
			                u:'<?php echo DMN_JS_SB_CLG; ?>base.js',
			                c:function(){
				                <?php echo $_CntJQ; ?>
			                }
			            });
		            }
		        });
			}

		});
	}

</script>
<script type="text/javascript" src="https://js.sumr.co/_ld.js" id="main-scrpt" data-id="<?php echo $__id_rnd; ?>" async></script>


<?php ob_end_flush(); ?>