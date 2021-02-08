<?php $Rt = '../../includes/'; $__tme_s = microtime(true); $__fbsrc = 'ok'; include($Rt.'inc.php'); ob_start("cmpr_fm"); Hdr_HTML();

	$__cl_gn = '../../'.DR_AC.DMN_SB.'/'.FL_INF_GN;

	if(file_exists($__cl_gn)){ include($__cl_gn); }

	$__t = Php_Ls_Cln($_GET['_t']);
	$__t2 = Php_Ls_Cln($_GET['_t2']);
	$__prfx = _Fx_Prx(['v'=>$__t]);
	$__f = Php_Ls_Cln($_GET['_f']);
	$__i = Php_Ls_Cln($_GET['__i']);

	$__f_url = '&_f='.$__f;

	define('GL_MDL', __f('mdl'));
	define('GL_SIS', __f('sis'));
	define('GL_EC', __f('ec'));
	define('GL_MARKS', __f('marks'));

	if( !isN($__dt_cl->img->big) ){
		$__img = $__dt_cl->lgo->main->big;
	}else{
		$__img = DIR_IMG_ESTR."logo.png";
	}


	if($__t == 'snd_ec_cmpg'){
		$_fl_tt =  'Campañas Envios Masivos' ;
		$_fl = GL_EC.'ec_cmpg.php';
	}elseif($__t == 'sms_cmpg'){
		$_fl_tt =  TX_CMPSMS ;
		$_fl = 'sms_cmpg.php';
	}elseif($__t == 'mdl_cnt'){
		$_fl_tt = 'Tabla - Informes';
		$_fl = GL_MDL.'mdl_cnt.php';
	}elseif($__t == 'marks'){
		$_fl_tt = 'Tabla - Informes';
		$_fl = GL_MARKS.'marks.php';
	}elseif($__t == 'sis_bd'){
		$_fl_tt = ' Base de Datos';
		$_fl = GL_SIS.'sis_bd.php';
		$_bcls = 'wrp_no';
		$__sg_prnt = 'ok';
	}else{
		$_fl_tt = 'Tabla';
	}


	 //$_fl_tt = _FleN(array('tt'=>$_fl_tt));
	 //$__nw_tt = $_fl_tt->tt;
	 //$__nw_tt_pxls = $_fl_tt->tt_pxls;

	if($__f == 'xls' && $_pxls != 'ok'){

		$__xl_h1 = 'font-family: Arial, Helvetica, sans-serif; color: #444444; text-transform: uppercase; border-bottom: 2px solid #b0b0b0; font-size: 22px; ';
		$__xl_h2 = 'style="font-family: Arial, Helvetica, sans-serif; color: #898989; font-weight: 300; font-size: 14px;"';
		$__xl_tt = 'style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #099; padding-top: 2pt; padding-bottom: 2pt; border-bottom-width: 2px; border-bottom-style: solid; border-bottom-color: #666;"';
		$__xl_td = 'style="font-size: 11px; color: #000; text-align: center; border: 1pt solid #CCC; vertical-align: middle;"';


		header('Content-type: application/vnd.ms-excel; charset=utf-8');
		header("Content-Disposition: attachment; filename=".$_fl_tt.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private", false);

	}elseif($__f == 'prnt' && $_pxls != 'ok'){

		$__tprnt = '_prnt';

	}


	if($_pxls != 'ok'){ ?>
		<!DOCTYPE html>
		<html lang='es'>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Administrador - Servicios.in</title>
			<base href="<?php echo DMN_BS_ADM ?>" target="_self">
			<meta http-equiv="cache-control" content="max-age=0" />
			<meta http-equiv="cache-control" content="no-cache" />

			<?php if($__f == 'prnt'){ ?>
			<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
			<link href='https://fonts.googleapis.com/css?family=Economica:400,700' rel='stylesheet' type='text/css'>
			<?php } ?>

			<?php if($__f == 'prnt'){ ?>
			<link href='<?php echo DMN_CSS.'all_print.css' ?>' rel='stylesheet' type='text/css' />
			<link href='<?php echo DMN_CSS.'informes.css' ?>' rel='stylesheet' type='text/css' />
			<?php } ?>

		<?php
			$__top = '100px';
			if($__f == 'prnt'){  ?>
				<script type="text/javascript" src="<?php echo DMN_JS ?>_ld.js"></script>
				<script type="text/javascript" src="<?php echo DMN_JS ?>jquery.js"></script>
				<script type="text/javascript" src="<?php echo DMN_JS ?>jquery-ui.js"></script>
				<script type="text/javascript" src="<?php echo DMN_JS ?>js.js"></script>
				<script type="text/javascript" src="<?php echo DMN_JS ?>uploadnew/jquery.knob.js"></script>
				<script type="text/javascript" src="<?php echo DMN_JS ?>highcharts/highcharts.js"></script>
				<script type="text/javascript" src="<?php echo DMN_JS ?>highcharts/highcharts-more.js"></script>
				<script type="text/javascript" src="<?php echo DMN_JS ?>highcharts/highmaps.js.js"></script>
				<script type="text/javascript" src="<?php echo DMN_JS ?>highcharts/_mapdata/world.js"></script>
				<script type="text/javascript" src="<?php echo DMN_JS ?>highcharts/modules/funnel.js"></script>

				<script type="text/javascript" src="<?php echo DMN_JS ?>jquery.carousel.js"></script>
				<script type="text/javascript" src="<?php echo DMN_JS ?>js_grph.js"></script>
				<?php $__top = '50px'; ?>
			<?php } ?>

			<style>

				body{ background-color: transparent;  }
				.logo{height:100px;width:100px;-webkit-mask:url(<?php echo DMN_IMG_ESTR ?>logo_b_smll.svg) no-repeat 50% 50%;mask:url(<?php echo DMN_IMG_ESTR ?>logo_b_smll.svg) no-repeat 50% 50%;-webkit-mask-size:100px auto;-webkit-mask-position:bottom;background-color:<?php echo $__dt_cl->tag->clr->main->v; ?>;float:left;position:absolute;left:0;top:0;z-index:9999;-webkit-transition:all .3s ease 0;-moz-transition:all .3s ease 0;-ms-transition:all .3s ease 0;-o-transition:all .3s ease 0;transition:all .3s ease 0;overflow:hidden;cursor:pointer}
				.logo ._w{width:100%;height:100%;position:relative;display:block}
				.logo ._w .cl_logo{margin-top:15px;width:70px;height:70px;background-repeat:no-repeat;background-position:center center;background-size:100% 100%;margin-left:auto;margin-right:auto}
				.bx_informe ._inf_hdr ._info{ margin-top: 20px;margin-right: 50px; display: flex; }
				.bx_informe ._inf_hdr ._info h1{ color: #333333; margin-right:10px; }
				.__grph{ margin-top: 0 !important }
				.__grph h2{ margin-top: <?php echo $__top ?>; }

			</style>

		</head>
		<body class="<?php echo $__tprnt; ?>">

		<div id="___bx_inf" class="bx_informe <?php echo $_bcls; ?>">
				<?php if($__f == 'prnt'){  ?>
					<header>
						<div class="_inf_hdr_btn">
							<div class="logo" id="__logo" style="top: 0px;">
								<div class="_w">
									<div class="cl_logo" style="background-image:url(<?php echo DMN_FLE_CL_LGO.CL_ENC.'.svg' ?>);"></div>
								</div>
							</div>
							<input name="_prnt_cll" type="button" id="_prnt_cll_<?php echo $__rndn ?>" value="Imprimir">

							<div class="_inf_hdr">
								<div class="_info">
									<h1><?php echo TX_INFRM ?> <?php

													if( Php_Ls_Cln($_GET['_f_in']) != '' ){ $__t_f1 = Php_Ls_Cln($_GET['_f_in']); }
													if( Php_Ls_Cln($_GET['_f_out']) != '' ){ $__t_f2 = ' / ' . Php_Ls_Cln($_GET['_f_out']); }

													echo $_fl_tt->tt_bty.
														bdiv(['id'=>'__tt_inf']) .
														Spn( $__t_f1.$__t_f2);
												?>
									</h1>
									<h2>
										<span class="pwrdby">Powered by</span>
										<span class="logosumr"><?php echo '<img style="vertical-align: middle;" width="80" height"80" src="'.DMN_IMG_ESTR.'logo_gray.svg">' ?></span>
									</h2>
								</div>
							</div>

						</div>
					</header>
				<?php } ?>

				<?php if($__f != 'prnt' && $__sg_prnt == 'ok'){  ?>
					<?php $__rndn = Gn_Rnd(10);  ?>
					<header class="_hdr_gp">
						<div class="_inf_hdr_btn">
								<?php if($__t == 'sis_bd'){ ?>
								<a href="<?php echo JQ__ldCnt([ 'u'=>FL_FM_GN.__t('sis_bd',true).ADM_LNK_DT.$_GET['__i'], 'c'=>DV_LSFL.$__idtp_cmpg, 'p'=>'ok', 'js'=>'ok', 'w'=>'500', 'h'=>'350' ]) ; ?>" target="_self" class="run_code"><?php echo TX_EDT ?></a>
							<?php } ?>
							<input name="_prnt_cll" type="button" id="_prnt_cll_<?php echo $__rndn ?>" value="Imprimir">
							<input name="_dwn_cll" type="button" id="_dwn_cll_<?php echo $__rndn ?>" value="Descargar">
						</div>
					</header>
					<?php

						$CntWb = '	$("#_prnt_cll_'.$__rndn.'").click( function(){

										window.open(\''.DMN_BS_ADM.FL_INF_GN.__t($__t,true).'&__rnd=f07'.Fl_i($__i).'&_f=prnt\', \'_blank\');

									});';

					?>
				<?php } ?>

				<section class="wrp_info">
					<?php
						if(!isN($_fl)){ include($_fl); }
						if($__f != 'xls'){  echo CntJQ($CntWb, $__NOJQ); }
					?>
				</section>

		</div>

		<?php if($__f == 'prnt'){  ?>
		<script type="text/javascript">
			function PrintWindow(){ window.print(); }
			function CheckWindowState(){  if(document.readyState=='complete') { window.close(); }else{ setTimeout('CheckWindowState()', 6000) } }

			$(window).on('load',function(){
					$("#_prnt_cll_<?php echo $__rndn ?>").click( function(){
							PrintWindow();
					});
			});
		</script>
		<?php echo CntJQ($CntJV, 'ok').CntJQ($CntWb); ?>
		<?php } ?>

		</body>
		</html>
		<?php $__tmexc = _Rg_Tme($__tme_s, microtime(true)); ?>
		<?php if($__f != 'xls'){ ob_end_flush(); }

	}else{

		if(!isN($_fl)){ include($_fl); }

	}

?>