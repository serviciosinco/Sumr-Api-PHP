<?php 
if(class_exists('CRM_Cnx')){
	 	
	$___Ls->sch->f = 'siscdn_tt, siscdn_url, siscdn_v';
	$___Ls->new->w = 600;
	$___Ls->new->h = 370;
	$___Ls->_strt();
	

	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_SIS_CDN." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
	
		$Ls_Whr = "FROM ".TB_SIS_CDN." WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
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
				<th width="1%" <?php echo NWRP ?>><?php echo TX_UPLCL ?></th>
				<th width="1%" <?php echo NWRP ?>><?php echo 'JS' ?></th>
				<th width="1%" <?php echo NWRP ?>><?php echo 'CSS' ?></th>
				<th width="1%" <?php echo NWRP ?>><?php echo TX_VRSN ?></th>
				<th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do { ?> 
				<tr>
					<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
					<td width="30%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['siscdn_tt'],'in'),40,'Pt', true); ?></td>
					<td width="1%" align="left" nowrap="nowrap"><?php echo mBln($___Ls->ls->rw['siscdn_up']); ?></td>
					<td width="1%" align="left" nowrap="nowrap"><?php echo mBln($___Ls->ls->rw['siscdn_js']); ?></td>
					<td width="1%" align="left" nowrap="nowrap"><?php echo mBln($___Ls->ls->rw['siscdn_css']); ?></td>
					<td width="1%" align="left" nowrap="nowrap"><?php echo ShortTx(strip_tags(ctjTx($___Ls->ls->rw['siscdn_v'],'in')),30,'Pt', true); ?></td>
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
	        	<?php echo HTML_inp_hd('siscdn_enc', $___Ls->dt->rw['siscdn_enc']); ?> 
				<?php echo HTML_inp_tx('siscdn_tt', TX_NM, ctjTx($___Ls->dt->rw['siscdn_tt'],'in'), FMRQD); ?>
			    <?php echo HTML_inp_tx('siscdn_url', TX_URL, ctjTx($___Ls->dt->rw['siscdn_url'],'in'), FMRQD); ?>
			    <?php echo HTML_inp_tx('siscdn_v', TX_VRSN, ctjTx($___Ls->dt->rw['siscdn_v'],'in'), FMRQD); ?>
			    
			    <?php echo OLD_HTML_chck('siscdn_up', TX_UPLCL, $___Ls->dt->rw['siscdn_up'], 'in'); ?>
			    <?php echo OLD_HTML_chck('siscdn_js', 'JS', $___Ls->dt->rw['siscdn_js'], 'in'); ?>
			    <?php echo OLD_HTML_chck('siscdn_css', 'CSS', $___Ls->dt->rw['siscdn_css'], 'in'); ?>
			</div>
	      </div>
	    </form>
	  </div>
	</div>   
<?php } ?>
<?php } ?>