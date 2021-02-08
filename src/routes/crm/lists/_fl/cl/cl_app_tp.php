<?php
if(class_exists('CRM_Cnx')){
	 	
	$___Ls->new->w = 1000;
	$___Ls->new->h = 600;
	$___Ls->_strt();	

	if(!isN($___Ls->gt->isb)){ $__fl .= $___Ls->_andsql([ 'f'=>'clapp_enc', 'v'=>$___Ls->gt->isb ]); }
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_CL_APP_TP." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
	
		$Ls_Whr = "	FROM "._BdStr(DBM).TB_CL_APP_TP."
						 INNER JOIN "._BdStr(DBM).TB_CL_APP." ON clapptp_clapp = id_clapp
						 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON clapptp_tp = id_mdlstp
					WHERE ".$___Ls->ino." != '' $__fl ".$___Ls->sch->cod." 
					ORDER BY ".$___Ls->ino." DESC";
					
		$___Ls->qrys = "SELECT *, 
								(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT."
						$Ls_Whr"; 
	
	}
	
	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
	<?php if(($___Ls->qry->tot > 0)){ ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg"> 
			<tr>
				<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
				<th width="30%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
				<th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do { ?> 
				<tr>
					<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
					<td width="30%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['mdlstp_nm'],'in'),40,'Pt', true).Spn( ShortTx(ctjTx($___Ls->ls->rw['clapptp_tt'],'in'),40,'Pt', true), 'ok' ); ?></td>
					<td width="1%" align="left" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
				</tr>
			<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
		</table>
		<?php $___Ls->_bld_l_pgs(); ?>
	<?php } ?>
	<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
  	
	<div class="FmTb">
	  <div id="<?php  echo DV_GNR_FM ?>"> 
                                       
	    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
	      <?php $___Ls->_bld_f_hdr(); ?>      
		  <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">			
	        <div class="ln_1">
			  	<div class="col_1">
				  	<?php echo HTML_inp_hd('clapptp_clapp', $__i); ?>
					<?php echo LsMdlSTp('clapptp_tp','id_mdlstp', $___Ls->dt->rw['clapptp_tp'], FM_LS_SLTP); $CntWb .= JQ_Ls('clapptp_tp',FM_LS_SLTP); ?>
					<?php echo HTML_inp_tx('clapptp_tt', TX_NM, ctjTx($___Ls->dt->rw['clapptp_tt'],'in')); ?>
					<?php echo OLD_HTML_chck('clapptp_e', TX_ACTV, $___Ls->dt->rw['clapptp_e'], 'in'); ?>
					<?php
							
						echo HTML_BR.HTML_BR;
						
						if( !isN($___Ls->dt->rw['clapptp_tp']) ){
							$CntWb .= "SUMR_Main.ld.f.slc({i:'".$___Ls->dt->rw['clapptp_tp']."', t_i: '".$___Ls->dt->rw['clapptp_fm']."', t:'cl_app_tp_gen', b:'sch_bx' });";	
						}
						
						$CntWb .= " 
	    
							$('#clapptp_tp').change(function(){
								
								$('._fm_spc.__cnt_sch_ing').removeClass('_shw');
								var __id = $(this).val();
								var __est_i = $(this).val();
								
								SUMR_Main.ld.f.slc({i:__id, t:'cl_app_tp_gen', b:'sch_bx' })	
							
								/*var _sch = $('#clapptp_tp ._slc_opt:selected').attr('_sch');			
							
								if(_sch == 1){
									SUMR_Main.ld.f.slc({i:__id, t:'clapptp_tp', b:'sch_bx' });
									$('._fm_spc.__cnt_sch_ing').addClass('_shw');
								}else{
									$('._fm_spc.__cnt_sch_ing').removeClass('_shw');
								}*/
								
							});
						"; 
					?>
						
					<div class="_fm_spc _c1 __cnt_sch __cnt_sch_ing">
						<?php echo '<div class="tt_slc">'.''.'</div>' ?>
						<div class="_d1"><div id="sch_bx" class="_sbls"></div></div>
					</div>
				</div>
				<div class="col_2">		
					<?php echo HTML_inp_tx('clapptp_lnk', TX_LNK, ctjTx($___Ls->dt->rw['clapptp_lnk'],'in')); ?>
					<?php echo HTML_inp_tx('clapptp_ord', TX_ORD, ctjTx($___Ls->dt->rw['clapptp_ord'],'in')); ?>
				</div>
			</div>
			
	      </div>
	    </form>
	  </div>
	</div>   
<?php } ?>
<?php } ?>