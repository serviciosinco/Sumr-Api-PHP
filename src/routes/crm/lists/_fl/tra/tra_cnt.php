<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'eccmpg_nm';
	$___Ls->new->w = 600;
	$___Ls->new->h = 600;
	$___Ls->_strt();
	$__bd = '_mdl_cnt_tra';
	$__bd2 = _BdStr(DBM).TB_TRA;
	$__bd3 = _BdStr(DBM).TB_TRA_RSP;
	$__bd4 = _BdStr(DBM).TB_US;
	
	if(!isN($___Ls->gt->i)){ 
		
		$___Ls->qrys = sprintf("SELECT * FROM $__bd2 WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){

		$Ls_Whr = "FROM $__bd, $__bd2, $__bd3, $__bd4
				   WHERE mdlcnttra_tra = id_tra AND trarsp_tra = id_tra AND trarsp_us = id_us 
				   		 AND mdlcnttra_mdlcnt = (	SELECT id_mdlcnt 
				   		 							FROM _mdl_cnt 
				   		 							WHERE mdlcnt_enc = '".$___Ls->gt->isb."'
				   		 						) 
				   		 $__fl ".$___Ls->sch->cod."";
				   		 								   
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr GROUP BY id_tra  ORDER BY ".$___Ls->ino." DESC";	  
		
	} 
	
	// echo $___Ls->qrys;
	
	$___Ls->_bld(); 
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  <thead>
          	<tr>
	          	<th width="1%" ?></th>
                <th width="1%" <?php echo NWRP ?>><?php echo TX_RSPNS ?></th>
                <th width="49%" <?php echo NWRP ?>><?php echo TX_TT ?></th>
                <th width="1%" <?php echo NWRP ?>><?php echo TX_FIN ?></th>
                 <th width="1%" ?></th>
            </tr>
  </thead>  
  <tbody>
	  <?php do { ?>
	     <tr >
	        <td align="left" <?php echo $_clr_rw ?>><?php echo Spn('','','_cls _cls_'); ?></td>
	        <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo Spn(ctjTx($___Ls->ls->rw['us_nm']." ".$___Ls->ls->rw['us_ap'],'in'),'','_f') ?></td>
            <td width="49%" align="left" <?php echo $_clr_rw ?>><?php echo ShortTx(ctjTx(strip_tags($___Ls->ls->rw['tra_tt']),'in'),200,'Pt', true); ?></td>
            <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo Spn($___Ls->ls->rw['tra_fi'],'','_f') ?></td>
            <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'dtl' ]); ?></td>
	    </tr>
      <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
  </tbody>
</table>

<?php $___Ls->_bld_l_pgs(); ?>

<?php }  ?><?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb task_detail" id="task_detail">
	<div id="<?php echo DV_GNR_FM.$__prfx_fm ?>">
     
		<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
			
			<?php $___Ls->_bld_f_hdr(); ?>
			
			<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	
				<div class="ln_1">
					<?php 		
						//echo LsTraCol('tra_col','id_tracol', $___Ls->dt->rw['tra_col'], '', 1, '', ''); $CntWb .= JQ_Ls('tra_col',FM_LS_SLCD);  	
					?>
					<?php
					
						if($___Ls->dt->tot > 0){
							$l = __Ls(['k'=>'tra_est', 'id'=>'tra_est', 'va'=>$___Ls->dt->rw['tra_est'] , 'ph'=>FM_LS_SLGN]); 
							echo $l->html; $CntWb .= $l->js;
						}else{
							echo HTML_inp_hd('tra_est', $___Ls->dt->rw['tra_est']); 
						}
							
						echo HTML_inp_hd('tra_cls', $___Ls->dt->rw['tra_cls']); 
						echo HTML_inp_hd('tra_tp', $___Ls->dt->rw['tra_tp']); 
						echo HTML_inp_hd('id_tra', $___Ls->dt->rw['id_tra']); 
						
					?>
					<?php echo HTML_inp_tx('_tt', TX_TT, ctjTx($___Ls->dt->rw['tra_tt'],'in'), FMRQD); ?>
					
					<div class="cx">
						<div class="cx_1">
							<?php echo SlDt([ 'id'=>'tra_f', 'va'=>$___Ls->dt->rw['tra_f'], 'rq'=>'ok', 'ph'=>TX_FCHLMT, 'lmt'=>'no', 'cls'=>CLS_CLND ]);  ?>
						</div>
						<div class="cx_2">
							<?php echo SlDt([ 'id'=>'tra_h', 'va'=>$___Ls->dt->rw['tra_h'], 't'=>'hr', 'rq'=>'ok', 'ph'=>TX_HR.' '.TX_LMT, 'lmt'=>'no', 'cls'=>CLS_HOUR ]);  ?>
						</div>	
						<div class="cx_3">
							<?php $l = __Ls([ 'k'=>'sis_tme_rng', 'id'=>'tra_bfr', 'va'=>'', 'ph'=>TX_RMBR ]); echo $l->html; $CntWb .= $l->js; ?> 
						</div>	
					</div>
					
					<?php //echo SlDt('tra_f', $___Ls->dt->rw['tra_f'] ,'ok','', TX_FCHLMT, 'no','','','',CLS_CLND); ?> 
					<?php //echo SlDt('tra_h', $___Ls->dt->rw['tra_h'] ,'ok','hr', TX_HR.''.TX_LMT, 'no','','','',CLS_HOUR); ?>
					
					<?php echo HTML_inp_hd('mdlcnttra_mdlcnt', _SbLs_ID('i')); ?>
					<?php echo HTML_textarea('tra_dsc', TX_DSC, ctjTx($___Ls->dt->rw['tra_dsc'],'in','',['sslh'=>'ok']) , '', 'ok'); ?> 
					<?php
						
						echo HTML_inp_hd('tra_col', $___Ls->dt->rw['tra_col']); 
						echo HTML_inp_hd('tra_us', $___Ls->dt->rw['tra_us']); 
						echo HTML_inp_hd('tra_cnt', $___Ls->gt->isb);	
					
					?>
					<br>
					<?php
						$TraColDt = GtTraColLs([ 'flt' => 'AND tracol_chk_tck != 1 AND tracol_chk_pqr != 1' ]);
						$TraUsDt = GtLsUsAll();
					?>
					
					<div class="col_1"> 
						<div class="_scrl">
							<!--<div class="_ls_col_new"></div>-->
							<?php echo h2( Spn('','','_tt_icn _tt_icn_col'). TX_ASIG, '__cmnt', '_ls_col_h2'); ?>
							<div class="_wrp">	
								<div id="Lead_Tml_Bx" class="_ls"></div>
							</div>
						</div>
						<div class="opt">	
							<?php $__id_op_crs = 'opt-'.Gn_Rnd(20); ?>
							<div id="<?php echo $__id_op_crs; ?>" class="owl-carousel owl_col ___mdl_cnt_tra">
								<?php foreach($TraColDt->ls as $_k => $_v){
									echo '										
										<div class="item _anm ls_col col" id="col_'.$_v->id.'" rel="'.$_v->id.'" style="background-color:'.$_v->clr->vl.'; background-image: url('.$_v->icn->slc->img.') ">
											<p style="color:'.$_v->clr->vl.';">'.$_v->tt.'</p>
										</div>
									';
									
								} ?>
							</div>
						</div>	
						<?php 
							$CntWb .= "
								SUMR_Main.ld.f.owl( function(){
									$('#".$__id_op_crs."').owlCarousel({
										items:4
									});
								});
							";
						?>
					</div>
					<div class="col_2">
						<div class="_scrl">
							<?php echo h2( Spn('','','_tt_icn _tt_icn_usr'). TX_RSPNS, '__cmnt'); ?>
							<div class="_wrp">	
								<div id="Lead_Tml_Bx" class="_ls"></div>
							</div>
						</div>
						<!-- <div class="opt">
							<?php $__id_op_crs1 = 'opt-'.Gn_Rnd(20); ?>
							<div id="<?php echo $__id_op_crs1; ?>" class="owl-carousel">
								<?php foreach($TraUsDt->ls as $_k => $_v){
									echo '
										<div class="item _anm ls_col us" id="us_'.$_v->id.'" rel="'.$_v->id.'" style="background-image: url('.$_v->img->sm_s.') "> 
											<p>'.$_v->nm.'</p>
										</div>
									';
									
								} ?>
							</div>
						</div> -->
						
						<?php 
							$CntWb .= "
								SUMR_Main.ld.f.owl( function(){
									$('#".$__id_op_crs1."').owlCarousel({
										items:4,
										autoPlay: false,
										center: true,
										margin:5,
										navigation: false,
										pagination: false,
										singleItem: false,
										autoHeight: false
									});
								}); 
							";
						?>
							
						<?php if(!isN($___Ls->dt->rw['tra_us'])){ $_us = $___Ls->dt->rw['tra_us']; }else{ $_us = SISUS_ENC; } ?>
																	
						<?php echo LsUs('tra_us1','us_enc', $_us , '', 2, '', ["are" => "ok"] ); $CntWb .= JQ_Ls('tra_us1','');?>
							
					</div> 
					
					<?php $CntWb .= 'SUMR_Main.ld.f.tra(function(){ SUMR_Tra.f.TraCntDomRbld(); });'; ?> 
				</div>                     
			</div>
		</form>
  	</div>              
</div>
<div>
<?php 
      if($___Ls->dt->tot == 1){      
			$__idtp_tra_rsp = 'rsp';
            echo bdiv(['id'=>DV_LSFL.$__idtp_tra_rsp]);
            $CntJV .= _DvLsFl_Vr(['i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>$__idtp_tra_rsp, 't'=>'tra_rsp']);		  
            $CntWb .= _DvLsFl(['t'=>'s', 'i'=>$__idtp_tra_rsp]);
	  }
?>
</div> 
<?php } ?>
<?php } ?>