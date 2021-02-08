<?php
		$Rt = '../../includes/';
		$__tme_s = microtime(true);

		$Rstr = 'adm'; $_cls_gapi = 'ok';
		ob_start("compress_code");
		Hdr_HTML();

		 $__t = Php_Ls_Cln($_GET['_t']);
		 $__prfx = _Fx_Prx(['v'=>$__t]);
		 $__f = Php_Ls_Cln($_GET['_f']);

		 $__f_url = '&_f='.$__f;

		 if($__f != 'xls'){ ob_start("compress_code"); }

 		 if($__t == 'prg_cnt' || $__t == 'psg_cnt' || $__t == 'con_cnt' || $__t == 'rose_cnt'){
 		 	$_fl_tt = TX_CNT;
			$_fl = INF_PRO_CNT;
		 }elseif($__t == 'emp'){
 		 	$_fl_tt = TX_EMPS;
			$_fl = INF_EMP;
		 }elseif($__t == 'evns_mdl_cnt' || $__t == 'acd_mdl_cnt' || $__t == 'spa_mdl_cnt'  || $__t == 'rst_mdl_cnt'  || $__t == 'pqt_mdl_cnt'  || $__t == 'pqr_mdl_cnt'){
 		 	$_fl_tt = TX_EMPS;
			$_fl = 'mdl_cnt.php';
		 }elseif($__t == 'enc_cnt'){
 		 	$_fl_tt = TX_ENC;
			$_fl = 'enc_cnt.php';
		 }

		 $__tprnt = '_inf';

		 if($__f == 'xls'){


			$_fl_dt = date('h-i-s-j-m-y');
			$__xl_tt = 'style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #099; padding-top: 2pt; padding-bottom: 2pt; border-bottom-width: 2px; border-bottom-style: solid; border-bottom-color: #666;"';
			$__xl_td = 'style="font-size: 11px; color: #000; text-align: center; border: 1pt solid #CCC; vertical-align: middle;"';
			$__nw_tt = str_replace(' ','-',$_fl_tt).$_fl_dt.".xls";
			header('Content-type: application/vnd.ms-excel; charset=utf-8');
			header("Content-Disposition: attachment; filename=".$__nw_tt);
			header("Pragma: no-cache");
			header("Expires: 0");


		 }elseif($__f == 'prnt'){


			$__tprnt = '_prnt';


		 }

?>
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

    <link href='<?php echo DMN_CSS.'all_print.css' ?>' rel='stylesheet' type='text/css' />



    <?php if($__f != 'xls'){ ?>
	<style type="text/css" <?php /* ?> media="print" <?php */ ?> >
			@page {
				size: letter portrait;
				margin: 1cm 1cm 1.5cm 1cm;
			}


			body{ font-family: Roboto; max }
			img, div, table { max-width:100% !important;}


			h1, h2, h3{ overflow: visible !important; font-family: Economica; text-transform: uppercase; white-space: normal; color: #3f3f3f; font-size: 18px; }
			th, td{ text-align:center !important; }

			.owl-controls{ display:none; }

			.page-break	{ display: block; page-break-before: always; }
			._inf_hdr_btn{ display:none; }
			.CollapsiblePanelContent{ background-color: #FFF !important; padding-top: 10px; padding-right: 0px !important; padding-bottom: 10px; padding-left: 0px !important; }
			.CollapsiblePanelContent ._g{ text-align: center; margin-right: auto; margin-left: auto; width: 100% !important; }

			._page-break{ display: block; page-break-after: auto; page-break-before: auto; }
			._col1{ max-width: 100% !important; width: 100% !important; display: block; position: relative; }
			._col2{ max-width: 100% !important; width: 100% !important; display: block; position: relative; }

			.__kyw{ padding: 20px; border: 1px dashed #CCC; }
			.__kyw h3{ margin: 0px; padding: 0px; }

			.__inf_dsgn_1 ._rsmn_cnt{ margin-top: 30px; margin-bottom: 30px; }
			.__inf_dsgn_1 ._rsmn_cnt li{ text-align: center !important; padding-right: 15px; padding-left: 15px; }
			.__inf_dsgn_1 ._rsmn_cnt li strong{ display:block !important; }

			._rsmn li{ text-align:center; }
			span._sbt{ font-size: 1em; color: #999; }

			.Ls_Rg{ margin-top: 30px; margin-bottom: 30px; width:100% !important; }
			.Ls_Rg th{
				border-bottom-width: 2px;
				border-bottom-style: solid;
				border-bottom-color: #CCC;
				text-transform: uppercase;
				color: #999;
				padding-bottom: 10px;
				font-family: 'Economica';
			}
			.Ls_Rg td{ border-bottom-width: 1px; border-bottom-style: dotted; border-bottom-color: #CCC; text-align: left !important; }
			.Ls_Rg._Sb td{ font-size: 11px; color: #969696 !important; }


			span.cmn_icn{ width: 10px; height: 10px; display: inline-block; margin-right: 10px; }
			span.cmn_icn._est_1{ background-image: url('<?php echo DMN_IMG_ESTR.'svg_positive.svg' ?>'); }
			span.cmn_icn._est_2{ background-image: url('<?php echo DMN_IMG_ESTR.'svg_neutral.svg' ?>'); }
			span.cmn_icn._est_3{ background-image: url('<?php echo DMN_IMG_ESTR.'svg_negative.svg' ?>'); }


			.wrp_info{ max-width: 770px; margin: auto; }

			.enc_blck{ margin-bottom: 50px; /*padding: 10px 20px;*/ overflow: hidden; min-height:200px; display: block; width: 100%; }
			.enc_blck ._c1{ width: 45%; display: inline-block; vertical-align: top; float: left; }
			.enc_blck ._c2{ width: 49%; display: inline-block; vertical-align: top; float: right; }

			._grph{ min-height: 200px;  }
			.d_data{ padding: 0px 2%; background-color: #eaeaea; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; }


			.d_comments{ /*border:2px dotted #6d6d6d;*/ margin-top:20px !important; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; display: block; width: 95%; padding-top: 0; padding-left: 2%; padding-right: 2%; overflow: hidden; position: relative; }
</style>

<style type="text/css" media="screen">



			.__inf_dsgn_1 ._ln1 { width: 100%; text-align: center; white-space: nowrap; }
			.__inf_dsgn_1 ._ln1 ._col1{ max-width: 47%; width: 47%; vertical-align: top; display: inline-table; margin-right: 1%; white-space: normal; }
			.__inf_dsgn_1 ._ln1 ._col2{ max-width: 47%; width: 47%; vertical-align: top; display: inline-table; white-space: normal; }

			<?php if($__f != 'prnt'){ ?>
			.__gst{ display:none; }
			<?php } ?>
</style>

<style type="text/css" >

			body{ font-family: "Roboto", Verdana, Arial !important; }

			._inf_grph_bx ._bg{ font-family: "Roboto", Verdana; color: #999; text-decoration: none; display: block; width: 100%; padding-top: 5px; padding-bottom: 5px; border: 1px dotted #CCC; font-size: 11px; font-weight: bolder; margin-top: 5px; text-align: center; }
			._inf_grph_bx ._bg:hover{ color: #333; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; border-top-color: #666; border-right-color: #666; border-bottom-color: #666; border-left-color: #666; }
			._inf_grph_bx ._sm{ border-radius: 6px 6px 6px 6px; -moz-border-radius: 6px 6px 6px 6px; -webkit-border-radius: 6px 6px 6px 6px; font-family: "Roboto", Verdana; color: #FFF; text-decoration: none; display: block; padding-top: 5px; padding-bottom: 5px; border: 1px solid #CCC; font-size: 11px; font-weight: bolder; margin-top: 5px; position: absolute; top: 0px; right: 0px; background-color: #666; padding-right: 10px; padding-left: 10px; }
			._inf_grph_bx ._sm:hover{ color: #FFF; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; border-top-color: #666; border-right-color: #666; border-bottom-color: #666; border-left-color: #666; background-color: #000; }


			.JQ_hd,
			._colbarx3 .JQ_hd{ opacity: 0; filter: alpha(opacity=0); max-height: 1px!important; max-width: 1px!important; overflow: hidden; -webkit-transition-property: all; -moz-transition-property: all; -ms-transition-property: all; -o-transition-property: all; transition-property: all; -webkit-transition-duration: 0.2s; -moz-transition-duration: 0.2s; -ms-transition-duration: 0.2s; -o-transition-duration: 0.2s; transition-duration: 0.2s; -webkit-transition-delay: 0s; -moz-transition-delay: 0s; -ms-transition-delay: 0s; -o-transition-delay: 0s; transition-delay: 0s; -webkit-transition-timing-function: ease; -moz-transition-timing-function: ease; -ms-transition-timing-function: ease; -o-transition-timing-function: ease; transition-timing-function: ease; border: 2px solid #F00; position: absolute; left: 0px; top: 0px; }
			.JQ_col ._sm{ display:none; }
			.JQ_col_fll,
			._colbarx3 .JQ_col_fll{ width: 100%!important; position: relative; height: auto!important; -webkit-transition-property: all; -moz-transition-property: all; -ms-transition-property: all; -o-transition-property: all; transition-property: all; -webkit-transition-duration: 0.3s; -moz-transition-duration: 0.3s; -ms-transition-duration: 0.3s; -o-transition-duration: 0.3s; transition-duration: 0.3s; -webkit-transition-timing-function: ease; -moz-transition-timing-function: ease; -ms-transition-timing-function: ease; -o-transition-timing-function: ease; transition-timing-function: ease; -webkit-transition-delay: 0s; -moz-transition-delay: 0s; -ms-transition-delay: 0s; -o-transition-delay: 0s; transition-delay: 0s; }
			.JQ_col_fll ._g{ width: 100%!important; }
			.JQ_col_fll ._bg{ display: none; text-align: center; }
			.JQ_col_fll ._sm{ display: block!important; text-align: center; }

			.JQ_col,
			._colbarx3 .JQ_col{ -webkit-transition-property: all; -moz-transition-property: all; -ms-transition-property: all; -o-transition-property: all; transition-property: all; -webkit-transition-duration: 0.3s; -moz-transition-duration: 0.3s; -ms-transition-duration: 0.3s; -o-transition-duration: 0.3s; transition-duration: 0.3s; -webkit-transition-timing-function: ease; -moz-transition-timing-function: ease; -ms-transition-timing-function: ease; -o-transition-timing-function: ease; transition-timing-function: ease; -webkit-transition-delay: 0s; -moz-transition-delay: 0s; -ms-transition-delay: 0s; -o-transition-delay: 0s; transition-delay: 0s; }
			.JQ_col ._g{height: 350px; margin: 0 auto;}

			._col3 .JQ_col1{ max-width: 22%!important; display: inline-block!important; position: relative; vertical-align: top; }
			._col3 .JQ_col1_1{ width:100%; height: 190px; display:block;}
			._col3 .JQ_col1_2{ width:100%; height: 190px; display:block;}
			._col3 .JQ_col2{ width: 40%; }
			._col3 .JQ_col3{ width: 33%; }

			._colbar{ white-space: nowrap; }
			._colbar .JQ_col ._g{height: 200px; margin: 0 auto; margin-bottom:20px; }
			._colbar .JQ_col1{ width: 33%!important; display: inline-block!important; position: relative; vertical-align: top; }
			._colbar .JQ_col2{ width: 33%; }
			._colbar .JQ_col3{ width: 33%; }


			._colbarx2{ white-space: nowrap; display: block; width: 100%; margin-bottom: 20px; position: relative; }
			._colbarx2 .JQ_col{ display: inline-block; }
			._colbarx2 .JQ_col ._g{height: 200px; margin: 0 auto; }
			._colbarx2 .JQ_col1{ display: inline-block!important; position: relative; vertical-align: top; }
			._colbarx2 .JQ_col2{ }

			._colbarx3{ white-space: nowrap; display: block; width: 100%; margin-bottom: 20px; position: relative; }
			._colbarx3 ._inf_grph_bx{ display: inline-block; vertical-align: top; width: auto; -webkit-transition: all 0.4s ease 0s; -moz-transition: all 0.4s ease 0s; -ms-transition: all 0.4s ease 0s; -o-transition: all 0.4s ease 0s; transition: all 0.4s ease 0s; }
			._colbarx3 ._inf_grph_bx ._g{height: 200px; margin: 0 auto; }

			._colbarx4{ white-space: nowrap; display: block; width: 100%; margin-bottom: 20px; position: relative; }
			._colbarx4 ._inf_grph_bx{ display: inline-block; vertical-align: top; width: auto; -webkit-transition: all 0.4s ease 0s; -moz-transition: all 0.4s ease 0s; -ms-transition: all 0.4s ease 0s; -o-transition: all 0.4s ease 0s; transition: all 0.4s ease 0s; }
			._colbarx4 ._inf_grph_bx ._g{height: 200px; margin: 0 auto; }


			.__numb{ mso-number-format:'\@'; }

			._inf_hdr{ height: 100px; max-height: 100px; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #CCC; z-index: 1; overflow: visible; width: 100%; position: relative; margin-bottom: 80px; }
			._inf_hdr ._logo{ margin-top: -70px; z-index: 9999; float: left; width: 200px;  }
			._inf_hdr ._info{ font-family: Economica; float: right; text-align: right; font-weight: 300; }
			._inf_hdr ._info h1{ margin: 0px; padding: 0px; text-transform: uppercase; }
			._inf_hdr ._info h1 span{ display: block; width: 100%; font-size: 0.7em; color: #999; }
			._inf_hdr ._info h2{ font-size: 12px; font-weight: 300; white-space: nowrap; margin: 0px; padding: 0px; }
			._inf_hdr ._info h2 span{ color: #0CF; text-transform: uppercase; margin-left: 5px; }


			._inf_hdr #__tt_inf{ font-size: 0.7em; font-weight: 300; color: #666; }

			._inf_hdr_btn{ background-color: #333; height: 50px; text-align: right; }
			._inf_hdr_btn input[type=button]{ outline:none; border-radius:7px; -moz-border-radius:7px; -webkit-border-radius:7px; font-family: Economica; color: #FFF; background-color: #000; border: 1px solid #FFF; text-transform: uppercase; margin-top: 10px; margin-right: 10px; padding-top: 10px; padding-right: 15px; padding-bottom: 10px; padding-left: 15px; cursor: pointer; }
			._inf_hdr_btn input[type=button]:hover{ background-color: #0CF; }



			.__gst{ padding: 20px; border-top-width: 0px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-top-style: none; border-right-style: dotted; border-bottom-style: dotted; border-left-style: dotted; border-right-color: #999; border-bottom-color: #999; border-left-color: #999; background-color: #F3F0F5; }
			.__gst h3{ font-family: Economica; text-transform: uppercase; color: #0CF; margin: 0px; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #0CF; padding-top: 0px; padding-right: 0px; padding-bottom: 5px; padding-left: 0px; }
    		.__gst ul{ margin: 0px; padding: 0px; list-style-type: none; }
			.__gst li{ font-size: 11px; color: #999; text-align: left; padding-top: 10px; padding-bottom: 10px; border-bottom-width: 1px; border-bottom-style: dotted; border-bottom-color: #999; list-style-type: none; }
   			.__gst li ._f{ font-size: 8px !important; color: #CCC; }
			.__gst li ._h{}
			.__gst li ._us{ color: #0CF; }







    </style>
<?php } ?>

<?php if($__f == 'prnt'){  ?>
		<script type="text/javascript" src="<?php echo DMN_JS ?>jquery.js"></script>
        <script type="text/javascript" src="<?php echo DMN_JS ?>jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo DMN_JS ?>js.js"></script>
        <script type="text/javascript" src="<?php echo DMN_JS ?>highcharts.js"></script>
		<script type="text/javascript" src="<?php echo DMN_JS ?>jquery.carousel.js"></script>
		<script type="text/javascript" src="<?php echo DMN_JS ?>js_grph.js?_c=<?php echo CL_ENC ?>"></script>
<?php } ?>
</head>
<body class="<?php echo $__tprnt; ?>">

<?php if($__f == 'prnt'){  ?>
<header>
    <div class="_inf_hdr_btn">
        <input name="_prnt_cll" type="button" id="_prnt_cll" value="Imprimir">
    </div>
    <div class="_inf_hdr">
        <div class="_logo"><img src="<?php echo DIR_IMG_ESTR ?>logo.png" width="120"/></div>
        <div class="_info">
            <h1>Informe <?php echo $_fl_tt. bdiv(['id'=>'__tt_inf']) . Spn(Php_Ls_Cln($_GET['_f_in']) . ' / ' . Php_Ls_Cln($_GET['_f_out'])  ); ?> </h1>
            <h2>Powered by<?php echo Spn('<img src="'.DIR_IMG_ESTR.'serviciosin.png" height="25">') ?></h2>
       </div>
    </div>
</header>
<?php } ?>

<section class="wrp_info">
	<?php
	 if($_fl != NULL && $_fl != ''){ include($_fl); }
	 if($__f != 'xls'){  echo CntJQ($CntWb, $__NOJQ); }
	?>
</section>

<?php if($__f == 'prnt'){  ?>
<script type="text/javascript">
                function PrintWindow(){ window.print(); }
			    function CheckWindowState(){  if(document.readyState=='complete') { window.close(); }else{ setTimeout('CheckWindowState()', 6000) } }

			    $(window).on('load',function(){
						$("#_prnt_cll").click( function(){
								PrintWindow();
						});

						<?php echo $CntGrph; ?>
                });
</script>
<?php echo CntJQ($CntJV, 'ok').CntJQ($CntWb); ?>
<?php } ?>
</body>
</html>

<?php $__tmexc = _Rg_Tme($__tme_s, microtime(true)); ?>
<?php if($__f != 'xls'){ ob_end_flush(); }  ?>