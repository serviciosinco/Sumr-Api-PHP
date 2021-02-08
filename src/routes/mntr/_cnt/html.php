 <?php


	$__mntr = new CRM_Mntr();
	$__mntr->__exst();

?>
<?php Hdr_HTML(); ob_start("compress_code"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>SUMR - Monitor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/" target="_blank">
</head>
<body>
   	<?php

	   	if(!function_exists('exec')) {
		    echo "exec is enabled";
		}

   	?>
   	<div class="__wrp">
	   	<h1>Node Version: <span><?php echo $__mntr->node_v ?></span> <br><span><?php echo Enc_Rnd('s'); ?></span></h1>
	   	<h2>Node</h2>
		<ul class="__modules">
	   		<?php foreach($__mntr->__chk_modules as $_mdl_k=>$_mdl_v){ ?>
	   			<li class="item <?php echo $_mdl_v->e; ?>" node-n="<?php echo $_mdl_k; ?>" node-v="<?php echo $_mdl_v->v; ?>">
	   				<?php echo $_mdl_k.' '.Spn($_mdl_v->e=='ok'?'installed':'not installed', 'ok'); ?>
	   			</li>
	   		<?php } ?>


	   		<?php

		   		$_CntJQ .= "

		   			$('.__modules li.item').click(function(){

		   				var __nn = $(this).attr('node-n');
		   				var __nv = $(this).attr('node-v');

		   				alert(__nn);

		   				__snd({
							t:'node',
							d:{
								nn:__nn,
								nv:__nv
							},
							_bs:function(){ $('body').removeClass('on'); },
							_cl:function(r){
								if(!isN(r)){  }
							},
							_cm:function(r){ $('body').addClass('on'); },
							_w:function(r){
								if(!isN(r)){  }
							}
						});


					});
		   		";

	   		?>



   		</ul>
   		<h2>PHP</h2>
	   	<ul class="__modules">
		   <?php if (!extension_loaded('imagick')){ $_e='no'; }else{ $_e='ok'; } ?>
		   <li class="item <?php echo $_e; ?>"><?php echo 'Imagick '.Spn($_e=='ok'?'installed':'not installed', 'ok'); ?></li>

		   <?php if (!extension_loaded('mbstring')){ $_e='no'; }else{ $_e='ok'; } ?>
		   <li class="item <?php echo $_e; ?>"><?php echo 'MBstring '.Spn($_e=='ok'?'installed':'not installed', 'ok'); ?></li>

		   <?php if (!extension_loaded('gzdeflate')){ $_e='no'; }else{ $_e='ok'; } ?>
		   <li class="item <?php echo $_e; ?>"><?php echo 'GZDeflate '.Spn($_e=='ok'?'installed':'not installed', 'ok'); ?></li>

		   <?php if (!extension_loaded('mysqli')){ $_e='no'; }else{ $_e='ok'; } ?>
		   <li class="item <?php echo $_e; ?>"><?php echo 'Mysqli '.Spn($_e=='ok'?'installed':'not installed', 'ok'); ?></li>


		   <?php if (!extension_loaded('exif_read_data')){ $_e='no'; }else{ $_e='ok'; } ?>
		   <li class="item <?php echo $_e; ?>"><?php echo 'exif_read_data '.Spn($_e=='ok'?'installed':'not installed', 'ok'); ?></li>

	   	</ul>

   	</div>


   <div class="bckgr"></div>
</body>
</html>
<script type="text/javascript">

	<?php $___font = __font(); ?>

	<?php if(!isN($___font->js->string)){ ?>

		var WebFontConfig = {  google: {families: <?php echo $___font->js->string; ?> },  timeout: 2000  };

	<?php } ?>


	var __ldsnd={};
	var SUMR_Main={slc:{ sch:''}};

	function __snd(p=null){

		if(!isN(p) && !isN(p.t) && !isN(p.d)){
			if (SUMR_Ld.f.onl() && isN( __ldsnd[p.t] ) ){

				__ldsnd[p.t] = $.ajax({
									type:'POST',
									url: '/process/',
									data: p.d,
									dataType: 'json',
									beforeSend: function() {
										if(!isN(p._bs)){ p._bs(); }
						 			},
						 			error:function(e){
							 			if(!isN(p._w)){ p._w(e); }
						 			},
									success:function(e){
										if(!isN(p._cl)){ p._cl(e); }
									},
									complete:function(e){
										__ldsnd[p.t] = '';
										if(!isN(p._cm)){ p._cm(e); }
									}
							});
			}
		}
	}

	function __ld_all(){

		SUMR_Ld.f.js({

			t:'c',
			u:'jquery.js',
			c:function(){

		        SUMR_Ld.f.js({ t:'c', u:'jquery-ui.js' });

	    		$(document).ready(function(){

					<?php echo $_CntJQ_Vld; ?>
					<?php echo $_CntJQ; ?>

					SUMR_Ld.f.css({

						t:'p',
				        h:'/css/',
				        c:function(){

				            SUMR_Ld.f.js({
					            u:'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js',
					            c:function(){

							    }
						    });


				        }

			        });


				});

			}

		});

	}


</script>
<script type="text/javascript" src="<?php echo DMN_JS ?>_ld.js<?php if(Dvlpr()){ echo '?__r='.Enc_Rnd('r'); } ?>" async></script>


<?php ob_end_flush(); ?>