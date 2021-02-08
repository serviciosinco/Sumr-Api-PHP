<?php 
if(class_exists('CRM_Cnx')){
	 	
	$___Ls->sch->f = 'lng_nm, lng_tt_es, lng_tt_en, lng_tt_it, lng_tt_fr, lng_tt_gr, lng_cod, lng_flg';
	$___Ls->new->w = 1000;
	$___Ls->new->h = 600;
	$___Ls->_strt();
	$__bd = TB_SIS_LNG; 	

	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_SIS_LNG." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
	
		$Ls_Whr = "FROM ".TB_SIS_LNG." WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 
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
				<th width="30%" <?php echo NWRP ?>><?php echo TX_VLE_ES ?></th>
				<th width="30%" <?php echo NWRP ?>><?php echo TX_VLE_EN ?></th>
				<th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do { ?> 
				<tr>
					<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
					<td width="30%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sislng_nm'],'in'),40,'Pt', true); ?></td>
					<td width="30%" align="left" nowrap="nowrap"><?php echo ShortTx(strip_tags(ctjTx($___Ls->ls->rw['sislng_tt_es'],'in')),30,'Pt', true); ?></td>
					<td width="30%" align="left" nowrap="nowrap"><?php echo ShortTx(strip_tags(ctjTx($___Ls->ls->rw['sislng_tt_en'],'in')),30,'Pt', true); ?></td>
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
		        <?php echo HTML_inp_hd('sislng_enc', $___Ls->dt->rw['sislng_enc']); ?> 
			  	<div class="col_1">
					<?php echo HTML_inp_tx('sislng_nm', TX_NM, ctjTx($___Ls->dt->rw['sislng_nm'],'in'), FMRQD); ?>
					<?php echo HTML_inp_tx('sislng_cod', TX_COD, ctjTx($___Ls->dt->rw['sislng_cod'],'in'), FMRQD); ?>
					<?php //echo LsLngEst('sislng_est','id_lngest', $___Ls->dt->rw['sislng_est'], '', 2); ?>
				</div>
				<div class="col_2">
				    <?php echo HTML_inp_tx('sislng_tt_es', TX_VLE_ES, ctjTx($___Ls->dt->rw['sislng_tt_es'],'in'), FMRQD); ?>
				    <?php echo HTML_inp_tx('sislng_tt_en', TX_VLE_EN, ctjTx($___Ls->dt->rw['sislng_tt_en'],'in'), FMRQD); ?>
				    <?php echo HTML_inp_tx('sislng_tt_it', TX_VLE_IT, ctjTx($___Ls->dt->rw['sislng_tt_it'],'in')); ?>
				    <?php echo HTML_inp_tx('sislng_tt_fr', TX_VLE_FR, ctjTx($___Ls->dt->rw['sislng_tt_fr'],'in')); ?>
				    <?php echo HTML_inp_tx('sislng_tt_gr', TX_VLE_GR, ctjTx($___Ls->dt->rw['sislng_tt_gr'],'in')); ?>
				</div>
			</div>
	      </div>
	    </form>
	  </div>
	</div>   
<?php } ?>
<?php } ?>