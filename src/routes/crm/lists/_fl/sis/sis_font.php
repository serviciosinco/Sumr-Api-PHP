<?php 
if(class_exists('CRM_Cnx')){
	 	
	$___Ls->sch->f = 'sisfont_tt, sisfont_cod, sisfont_sze';
	$___Ls->new->w = 600;
	$___Ls->new->h = 310;
	$___Ls->_strt();
	

	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_SIS_FONT." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
	
		$Ls_Whr = "FROM ".TB_SIS_FONT." WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
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
				<th width="1%" <?php echo NWRP ?>><?php echo 'Subset' ?></th>
				<th width="1%" <?php echo NWRP ?>><?php echo 'Weigth' ?></th>
				<th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do { ?> 
				<tr>
					<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
					<td width="30%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['sisfont_tt'],'in'); ?></td>
					<td width="1%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['sisfont_sbst'],'in'); ?></td>
					<td width="1%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['sisfont_sze'],'in'); ?></td>
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
	        	<?php echo HTML_inp_hd('sisfont_enc', $___Ls->dt->rw['sisfont_enc']); ?> 
				<?php echo HTML_inp_tx('sisfont_tt', TX_NM, ctjTx($___Ls->dt->rw['sisfont_tt'],'in'), FMRQD); ?>
			    <?php echo HTML_inp_tx('sisfont_cod', 'Fuente', ctjTx($___Ls->dt->rw['sisfont_cod'],'in'), FMRQD); ?>
			    <?php echo HTML_inp_tx('sisfont_sze', 'Weigth', ctjTx($___Ls->dt->rw['sisfont_sze'],'in'), FMRQD); ?>
			    <?php echo HTML_inp_tx('sisfont_sbst', 'Subset', ctjTx($___Ls->dt->rw['sisfont_sbst'],'in') ); ?>
			</div>
	      </div>
	    </form>
	  </div>
	</div>   
<?php } ?>
<?php } ?>