<?php
if(class_exists('CRM_Cnx')){

	$___Ls->_strt();

	if(!isN($___Ls->gt->i)){	
        $___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_EC_CHNG." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
	}elseif($___Ls->_show_ls == 'ok'){ 	
		$Ls_Whr = " FROM "._BdStr(DBM).TB_EC_CHNG." 
                        INNER JOIN "._BdStr(DBM).TB_US." ON ecchng_us = id_us
                        INNER JOIN "._BdStr(DBM).TB_EC." ON ecchng_ec = id_ec
					WHERE ".$___Ls->ino." != '' AND ec_enc = '".$___Ls->gt->isb."' ORDER BY ecchng_fi DESC";

		$___Ls->qrys = "SELECT id_ecchng, ecchng_enc, ecchng_tx, us_nm, us_ap, ecchng_fi,
                        (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 
			
	} 
	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr();?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<?php 
	$__dmn = GtClDmnSubDt([ 't'=>'tp', 'id'=>'rd' ]);
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
    	<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    	<th width="65%" <?php echo NWRP ?>><?php echo 'Cambio' ?></th>
    	<th width="15%" <?php echo NWRP ?>><?php echo 'Usuarios' ?></th>
    	<th width="15%" <?php echo NWRP ?>><?php echo 'Fecha de Ingreso' ?></th>
    	<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?> 
  	<tr> 
		<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		<td width="65%" align="left" style="max-width: 1px;overflow: hidden;white-space: nowrap; text-overflow: ellipsis;" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['ecchng_tx'],'in'),100,'Pt', true); ?></td>
		<td width="15%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['us_nm'].' '.$___Ls->ls->rw['us_ap'],'in'),150,'Pt', true); ?></td>
		<td width="15%" align="left" nowrap="nowrap"><?php echo FechaESP([ 'f'=>$___Ls->ls->rw['ecchng_fi'], 't'=>'cmpr' ]); ?></td>
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
            <?php 
                echo HTML_textarea('ecchng_tx', 'Describe el cambio', $___Ls->dt->rw['ecchng_tx']); 
                echo HTML_inp_hd('ecchng_ec', $___Ls->gt->isb); 
                echo HTML_inp_hd('id_ecchng', $___Ls->dt->rw['id_ecchng']); 
            ?>
        </div>
      	</div>
    </form>
  	</div>
</div>
<?php } ?>
<?php } ?>