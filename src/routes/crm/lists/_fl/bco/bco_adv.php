<?php 
if(class_exists('CRM_Cnx')){
	$___Ls->sch->f = 'bcoadv_tx';
	$___Ls->new->w = 700;
	$___Ls->new->h = 700;

	$___Ls->_strt();

	if(!isN($___Ls->gt->i)){	
		$___Ls->qrys = sprintf("SELECT bcoadv_enc, bcoadv_tx, bcoadv_chk, bcoadv_ord FROM "._BdStr(DBM).TB_BCO_ADV." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
	}elseif($___Ls->_show_ls == 'ok'){ 	

		$Ls_Whr = "FROM "._BdStr(DBM).TB_BCO_ADV."
		        WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." AND bcoadv_cl = '".DB_CL_ID."'
		        ORDER BY ".$___Ls->ino." DESC";
				        	        
		 $___Ls->qrys = "SELECT id_bcoadv, bcoadv_enc, bcoadv_tx, bcoadv_chk, bcoadv_ord,
		        (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";         
		        
	} 
	
	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
		<th width="70%" <?php echo NWRP ?>><?php echo 'Texto' ?></th>
        <th width="10%" <?php echo NWRP ?>><?php echo 'Check' ?></th>
        <th width="10%" <?php echo NWRP ?>><?php echo 'Orden' ?></th>
		<th width="1%" <?php echo NWRP ?>>&nbsp;</th>  
  	</tr>
  	<?php do { ?>
  	<tr>   
   		<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
        <td style="width: 1px;word-wrap: break-word;"width="70%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['bcoadv_tx'],'in'),40,'Pt', true); ?> </td> 
        <td width="10%" align="left" nowrap="nowrap"><?php echo _sino($___Ls->ls->rw['bcoadv_chk']); ?></td> 
        <td width="10%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['bcoadv_ord'],'in'); ?> </td> 
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
		<div id="<?php  echo DV_GNR_FM ?>">                                        
			<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
				<?php $___Ls->_bld_f_hdr(); ?>      
				<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
					<div class="ln_1">
						<div class="col_1">

                            <?php echo HTML_textarea('bcoadv_tx', 'Texto', ctjTx($___Ls->dt->rw['bcoadv_tx'],'in'), FMRQD, 'ok');  ?>
							
						</div>
						<div class="col_2">
							
                            <?php echo OLD_HTML_chck('bcoadv_chk', 'Tipo Check', ctjTx($___Ls->dt->rw['bcoadv_chk'],'in'), 'in');  ?>
                            <?php echo HTML_inp_tx('bcoadv_ord', "Orden" , ctjTx($___Ls->dt->rw['bcoadv_ord'],'in')); ?>

						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php } ?>
<?php } ?>