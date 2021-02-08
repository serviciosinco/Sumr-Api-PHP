<?php 


	$_md = Php_Ls_Cln($_POST['md']);
	$_fnt = Php_Ls_Cln($_POST['fnt']);
	$_mdl_s_tp = Php_Ls_Cln($_POST['mdl_s_tp']);
	$_mdl_s_gen = Php_Ls_Cln($_POST['mdl_gen']);
	$_act = Php_Ls_Cln($_POST['act']);
	

	if(!isN($_mdl_s_tp)){ 	
		$___mdlstpdt = GtMdlSTpDt([ 'id'=>$_mdl_s_tp ]); 	
	}
	
	if(!isN($_mdl_s_gen)){ $___mdlgendt = GtMdlGenDt([ 'bd'=>$__dt_cl->bd, 'id'=>$_mdl_s_gen ]); }
	if(!isN($_act)){ 
		$___actdt = GtActDt([ 'bd'=>$__dt_cl->cl, 'id'=>$_act, 'bd'=>$__dt_cl->bd ]);
		
		$__url_qr = MyPssU([
			't'=>'act',
			'enc'=>PrmLnk('bld',$___actdt->enc)
		]);

		$url   = urlencode($__url_qr);

	}
	
	if(!isN($___actdt->tts)){
		$__nm = $___actdt->tts;
		$__icn = DMN_IMG_ESTR_SVG.'mdlact.svg';
	}elseif(!isN($___mdlstpdt->tt)){	
		$__nm = $___mdlstpdt->tt;
		$__icn = $___mdlstpdt->img->big;
	}
	
	if($___actdt->org->tot > 0){
		$__cls = 'shw_org';
	}

?>
<div class="col2x <?php echo $__cls; ?>">
	<div class="col c1">
		
		<?php if($___actdt->org->d->e == 'ok'){ ?>
			<div class="org_dt">
				<figure><div style="background-image:url(<?php echo $___actdt->org->d->org->img->th_c_400; ?>);"></div></figure>
				<h1><?php echo $___actdt->org->d->nm_fll ?></h1>
			</div>
		<?php } ?>

		<h1 class="tc1"><div class="icn" style="background-image: url(<?php echo $__icn; ?>);"></div><?php echo $__nm; ?></h1>
		<?php if(!isN($___actdt->id)){ ?>
		<button id="btn-qr" class="btn-qr">QR Code</button>
		<?php } ?>

		<h2 class="tc2">Registre aquí sus datos</h2>	
		<h3> <button class="_bck"></button>Volver</h3>	

	</div>
	<div class="col c2">
		
		<?php if(!isN($___actdt->id)){ ?>
			<div class="act_qr_bx _anm" id="d_bx_act_qr"><?php echo "<img src=\"https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl=$url\" />"; ?></div>
		<?php } ?>
		<div class="fm_bx _anm" id="d_bx_fm">
		<!-- Form - SUMR CRM --><iframe id='SUMR-FM-<?php echo $___mdlgendt->enc; ?>' width="100%"  border='0' style='border: none; min-height:1200px;'></iframe> <script >(function(w,d,s,l){ var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:''; j.async=true; j.src= '<?php echo DMN_FORM; ?>b.js?f=<?php echo $___mdlgendt->enc; ?>&id=<?php echo $__dt_cl->prfl ?>&app=ok&g=ok&opaque=ok&icon=ok&w=100%25&act=<?php echo $___actdt->enc; ?>&md=<?php echo $_md; ?>&fnt=<?php echo $_fnt; ?>'; f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer');</script>		
		</div>

	</div>
</div>