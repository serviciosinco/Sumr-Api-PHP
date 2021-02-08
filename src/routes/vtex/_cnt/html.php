<?php
	Hdr_HTML(); ob_start("compress_code");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?php echo $__head_tt; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<base href="https://<?php echo $_SERVER['HTTP_HOST']; ?>" target="_self">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="icon" href="<?php echo $__cl->lgo->ico->big; ?>" type="image/x-icon">
		<style>
		 	<?php include(DIR_INC.'css/hd.css'); ?>
			<?php

				$__cl_tag = $__cl->tag;
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
		<div class="_prld _anm"></div>
		<section class="_mcnt">
			<?php include(DIR_CNT."fm.php"); ?>
		</section>
	</body>
</html>
<script type="text/javascript">

	/*"use strict";*/

	<?php

		$____fmly[] = ['name'=>'Lato','size'=>'300,400,700,900'];
		$____fmly[] = ['name'=>'Roboto','size'=>'400,300,100,500', 'subset'=>'latin'];
		$___font = __font([ 'fly'=>$____fmly ]);

	?>

	<?php if(!isN($___font->js->string)){ ?>

		var WebFontConfig = {  google: {families: <?php echo $___font->js->string; ?> },  timeout:2000  };

	<?php } ?>


	var __ldsnd={};
	var SUMR_Main={slc:{ sch:'' }};
	var SUMR_Vtex={d:{ cnt:'' }, init:function(){} };

	function __ld_all(){

		SUMR_Ld.f.js({

			t:'c',
			u:'jquery.js',
			c:function(){

		        $('body').addClass('SUMR_Vtex');

		        SUMR_Ld.f.js({ t:'c', u:'jquery-ui.js' });

			    <?php if(!isN($__fm_thm)){ $__url_thm = '?_thm='.$__fm_thm; } ?>

		        SUMR_Ld.f.css({

					h:'sb/vtex/base',
					tag:'ok',
			        c:function(){

						SUMR_Ld.f.js({
							t:'c',
							u:'sb/vtex/base.js',
							tag:'ok',
			                c:function(){

								if(!SUMR_Ld.f.isN( SUMR_Vtex )){
									SUMR_Vtex.init({
										_lfrs:function(){
											<?php echo $_CntJQ_Vld; ?>
											<?php echo $_CntJQ; ?>
										},
										_lall:function(){
											<?php echo $_CntJQ_S2; ?>
										}
									});
								}

							}

						});

			            $(window).on('load',function(){

			            });
		            }
		        });
			}
		});

		function __ld_slc(_p){



			var __tp = _p.t;

			if(!SUMR_Ld.f.isN(_p.i)){ var __i = '&_i=' + _p.i; }else{ var __i = ''; }
			if(!SUMR_Ld.f.isN(_p.t_i)){ var __tp_i = '&_ts_i=' + _p.t_i; }else{ var __tp_i = ''; }
			if(!SUMR_Ld.f.isN(_p.t_e)){ var __tp_e = '&_ts_e=' + _p.t_e; }else{ var __tp_e = ''; }
			if(!SUMR_Ld.f.isN(_p.t_p)){ var __tp_p = '&_ts_p=' + _p.t_p; }else{ var __tp_p = ''; }
			if(!SUMR_Ld.f.isN(_p._mtrc)){ var _mtrc = '&_mtrc=' + _p._mtrc; }else{ var _mtrc = ''; }
			if(!SUMR_Ld.f.isN(_p._dms)){ var _dms = '&_dms=' + _p._dms; }else{ var _dms = ''; }
			if(!SUMR_Ld.f.isN(_p.t_f)){ var __tp_f = '&_ts_f=' + _p.t_f; }else{ var __tp_f = ''; }
			if(!SUMR_Ld.f.isN(_p.s_t)){ var __s_t = '&_ts_stot=' + _p.s_t; }else{ var __s_t = ''; }
			if(!SUMR_Ld.f.isN(_p.d)){ var __data = _p.d; }else{ var __data = ''; }
			if(!SUMR_Ld.f.isN(_p.enc)){ var __enc = '&__enc=' +_p.enc; }else{ var __enc = ''; }

			var __bx = _p.b;
			var __cl = function(){
							$('#'+__bx).find('.select2-chosen').effect('highlight', {color:'#00BFFF'}, 2000);
							$('#'+__bx).removeClass('_l_slc');
							if(!SUMR_Ld.f.isN(_p._cl)){
								_p._cl();
							}
						};

			if(!SUMR_Ld.f.isN(__tp)){

				$('#'+__bx).addClass('_l_slc').empty().fadeIn('fast');
				var __lnk = '_cnt/_ls/_slc.php?_ts=' + __tp + __i + __tp_i + __tp_e + __tp_p + __tp_f + _dms + _mtrc + __s_t + __enc;

				_ldCnt({ u:__lnk, c:__bx, _cl:__cl, anm:'no', d:__data });
			}

		}

		function ___slc_sch(_p){

			var _i = _p.id;
			var _ph = _p.ph;
			var _tp = _p.tp;
			var _t = _p.t;
			var _w = _p.w;

			$('#'+_i).select2({
			        placeholder: _ph,
			        minimumInputLength: 3,
			        ajax: {

				        url: '/json/'+_t+'.json',
				        dataType: 'json',
				        delay: 250,
				        method:'POST',
				        data: function (params) {
				            $('#'+_w).val(params.term);
				            SUMR_Main.slc.sch = params.term;
				            return { __q: params.term, __t: _tp };
			        	},
				        processResults: function (d) {
						   return { results: d.items };
						},
						cache: true
				    }
			});
		}

	}

</script>
<script type="text/javascript" src="<?php echo DMN_JS ?>_ld.js<?php if(Dvlpr() || $_GET['rnd']=='ok'){ echo '?__r='.Enc_Rnd('r'); } ?>" async></script>


<?php ob_end_flush(); ?>