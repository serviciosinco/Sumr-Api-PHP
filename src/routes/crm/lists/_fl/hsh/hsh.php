<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'hsh_tt, hsh_tx';
	$___Ls->new->w = 800;
	$___Ls->new->h = 700;
	$___Ls->edit->w = 800;
	$___Ls->edit->h = 700;
	
	$___Ls->_strt();
	
	
	if(!isN($___Ls->gt->i)){	
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_HSH." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));	
	}elseif($___Ls->_show_ls == 'ok'){ 	
		$Ls_Whr = " FROM "._BdStr(DBM).TB_HSH." 
						INNER JOIN "._BdStr(DBM).TB_CL." ON id_cl = hsh_cl 
					WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." AND cl_enc = '".CL_ENC."' ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *, 
						(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 
			
	} 
	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr();?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
    	<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th> 
    	<th width="48%" <?php echo NWRP ?>><?php echo TX_TTLO ?></th> 
    	<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?> 
  	<tr> 
		<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>

		<td width="48%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['hsh_tt'],'in'),40,'Pt', true); ?></td>
		
		<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>

  	</tr>
  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
      	<?php $___Ls->_bld_f_hdr(); ?>      
	  	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
        <div class="ln_1">
	        <div class="col_1">
		        
		        <?php 
 
			        
			        echo HTML_inp_tx('hsh_tt', TX_TT , ctjTx($___Ls->dt->rw['hsh_tt'],'in'), FMRQD);
			        echo HTML_inp_tx('hsh_tx', TX_TXT, ctjTx($___Ls->dt->rw['hsh_tx'],'in'), FMRQD);  
			        echo HTML_inp_tx('hsh_hsh', MDL_HSH , ctjTx($___Ls->dt->rw['hsh_hsh'],'in')); 
			
					echo OLD_HTML_chck('hsh_on', TX_ACTV, $___Ls->dt->rw['hsh_on'], 'in').HTML_BR;
			
					echo HTML_inp_clr([ 'id'=>'hsh_bck_clr', 'plc'=>TX_CLR_FND, 'vl'=>'#'.$___Ls->dt->rw['hsh_bck_clr'] ]);
					echo HTML_inp_clr([ 'id'=>'hsh_hdr_bdclr', 'plc'=>TX_CLR_HDR, 'vl'=>'#'.$___Ls->dt->rw['hsh_hdr_bdclr'] ]);
					echo HTML_inp_clr([ 'id'=>'hsh_msg_bck', 'plc'=>TX_CLR_MSG, 'vl'=>'#'.$___Ls->dt->rw['hsh_msg_bck'] ]);
					echo HTML_inp_clr([ 'id'=>'hsh_msg_bdclr', 'plc'=>TX_CLR_BD, 'vl'=>'#'.$___Ls->dt->rw['hsh_msg_bdclr'] ]);
			        
			        
		        ?>
		        
	        </div>
	        <div class="col_2">
		        
		        	<?php 
			        	
						echo HTML_inp_tx('hsh_msg_bdwd', TX_MSG_BDWD , ctjTx($___Ls->dt->rw['hsh_msg_bdwd'],'in'));
						echo HTML_inp_tx('hsh_frm', TX_FRMT	, ctjTx($___Ls->dt->rw['hsh_frm'],'in'));  
						echo HTML_inp_tx('hsh_sng', TX_ONL_MSG , ctjTx($___Ls->dt->rw['hsh_sng'],'in'));
						echo HTML_inp_tx('hsh_tme_hdr', TX_TME_HDR , ctjTx($___Ls->dt->rw['hsh_tme_hdr'],'in'));
						echo HTML_inp_tx('hsh_tme_hdr_drt', TX_TME_DRC_HRD, ctjTx($___Ls->dt->rw['hsh_tme_hdr_drt'],'in'));  
						echo HTML_inp_tx('hsh_tme_hsh', TX_TME_MSG , ctjTx($___Ls->dt->rw['hsh_tme_hsh'],'in')); 
						echo HTML_inp_tx('hsh_tme_hsh_drt', TX_TME_DRC_MSJ , ctjTx($___Ls->dt->rw['hsh_tme_hsh_drt'],'in'));
						echo HTML_inp_tx('hsh_emb', TX_VD_EMB, ctjTx($___Ls->dt->rw['hsh_emb'],'in'));   

		        	?>
		        
		        
	        </div>
	        
	        <?php if($___Ls->dt->tot > 0){ ?>
				<?php /* ?><div id="_upl_fle"></div>
				<?php $CntWb .= "_ldCnt({ u:'".Fl_Rnd(FL_FM_GN.__t('up_tw',true)).Fl_i($___Ls->dt->rw[$___Ls->ik])."', c:'_upl_fle' });";*/ ?>
			<?php } ?>
	       
          	
        </div>
      	</div>
    </form>
  	</div>
</div>
<?php } ?>
<?php } ?>