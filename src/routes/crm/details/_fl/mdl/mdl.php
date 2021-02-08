<?php
	
	$_enc = Php_Ls_Cln($_GET['_i']);
	
	$GtActDt = GtMdlDt([ "id"=>$_enc, "t"=>"enc" ]);
	
	if(SISUS_ID == 163){ print_r($GtActDt); }
		 	
	if($row_Ls_Pro['id_act'] != NULL){ $__fll_cnt = Gt_FllCnt(['act'=>$row_Ls_Pro['id_act']]); }
	
?>
	
<div class="ln_d_1" style=" display: block;">

<div class="ln_1">
	<ul class="ls_1" id="dtll2">
	 	<div class="col_1">
	 		<?php	
		 		echo h2(Strn('',true).ctjTx($GtActDt->tt, 'in'))."<br>";
		 		if(!isN($GtActDt->tt)){  echo '<li class="" id="_li_nm">'.Strn(TX_NM, '',true).ctjTx($GtActDt->tt, 'in').'</li>'; }
			 	/*if(!isN($GtActDt->pml)){ echo '<li class="" id="_li_nm">'.Strn(TX_TT, '',true).ctjTx($GtActDt->pml, 'in').'</li>'; }
			 	if(!isN($GtActDt->cod)){ echo '<li class="" id="_li_nm">'.Strn(TX_COD, '',true).ctjTx($GtActDt->cod, 'in').'</li>'; }
			 	if(!isN($GtActDt->actlgr)){ echo '<li class="" id="_li_nm">'.Strn(TX_TT, '',true).ctjTx($GtActDt->actlgr, 'in').'</li>'; }
				if(!isN($GtActDt->cnt)){  echo '<li class="" id="_li_nm">'.Strn(TX_CNT, '',true).ctjTx($GtActDt->cnt, 'in').'</li>'; }
				if(!isN($GtActDt->tp)){   echo '<li class="" id="_li_nm">'.Strn(TX_TP, '',true).utf8_encode(ctjTx($GtActDt->tp, 'in')).'</li>'; }
				if(!isN($GtActDt->dsc)){  echo '<li class="" id="_li_nm">'.Strn(TX_DSCRIP, '',true).utf8_encode(ctjTx($GtActDt->dsc, 'in')) .'</li>'; }
				if(!isN($GtActDt->tot)){  echo '<li class="" id="_li_nm">'.Strn(TX_TTEST, '',true).utf8_encode(ctjTx($GtActDt->tot, 'in')) .'</li>'; }
				if(!isN($GtActDt->totA)){ echo '<li class="" id="_li_nm">'.Strn(TX_TTACM, '',true).utf8_encode(ctjTx($GtActDt->totA, 'in')) .'</li>'; }*/
			?>
	 	</div>
	 	<div class="col_2">
		 	<br><br>
		 	<?php
			 	echo h2(Strn('',true).ctjTx(TX_EVN_P, 'in'))."<br>";
			 	if(!isN($GtActDt->dt_act->{ID_MDLSTPATTR_CD}->vl)){  
					$_cd = GtCdDt(['tp' => 'id', 'id' => $GtActDt->dt_act->{ID_MDLSTPATTR_CD}->vl]);
					echo '<li class="" id="_li_nm">'.Strn(TT_FM_CD, '',true).utf8_encode(ctjTx($_cd->tt, 'in')) .'</li>'; 
				}
			 	if(!isN($GtActDt->dt_act->{ID_MDLSTPATTR_LGR}->vl)){ 
				 	$__act_lgr = __LsDt(['k'=>'act_lgr']); 
					echo '<li class="" id="_li_nm">'.Strn(TX_WHR, '',true).utf8_encode(ctjTx($__act_lgr->ls->act_lgr->{$GtActDt->dt_act->{ID_MDLSTPATTR_LGR}->vl}->tt, 'in')) .'</li>'; 
				}
			 	if(!isN($GtActDt->dt_act->{ID_MDLSTPATTR_LGR_TX}->vl)){ echo '<li class="" id="_li_nm">'.Strn(TX_LGRTXT, '',true).utf8_encode(ctjTx($GtActDt->dt_act->{ID_MDLSTPATTR_LGR_TX}->vl, 'in')) .'</li>'; }
				if(!isN($GtActDt->dt_act->{ID_MDLSTPATTR_FCH_TX}->vl)){ echo '<li class="" id="_li_nm">'.Strn(TX_FCHTXT, '',true).utf8_encode(ctjTx($GtActDt->dt_act->{ID_MDLSTPATTR_FCH_TX}->vl, 'in')) .'</li>'; }
				if(!isN($GtActDt->dt_act->{ID_MDLSTPATTR_FINI}->vl)){ echo '<li class="" id="_li_nm">'.Strn(TX_ORD_FIN, '',true).utf8_encode(ctjTx($GtActDt->dt_act->{ID_MDLSTPATTR_FINI}->vl, 'in')) .'</li>'; }
				if(!isN($GtActDt->dt_act->{ID_MDLSTPATTR_FFIN}->vl)){ echo '<li class="" id="_li_nm">'.Strn(TX_ORD_FOU, '',true).utf8_encode(ctjTx($GtActDt->dt_act->{ID_MDLSTPATTR_FFIN}->vl, 'in')) .'</li>'; }
			?>
	 	</div>
	</ul>
</div>