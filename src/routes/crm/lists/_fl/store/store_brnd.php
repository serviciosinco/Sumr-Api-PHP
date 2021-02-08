<?php 

if(class_exists('CRM_Cnx')){

    $___Ls->img->dir = DMN_FLE_CL_STORE_BRND;
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){

		$___Ls->qrys = sprintf("    SELECT *
                                    FROM "._BdStr(DBS).TB_STORE_BRND." 
                                    WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
	
	}elseif($___Ls->_show_ls == 'ok'){

		$Ls_Whr = "	FROM "._BdStr(DBS).TB_STORE_BRND."
                        INNER JOIN "._BdStr(DBS).TB_STORE." ON storebrnd_store = id_store
					WHERE store_enc != '' AND store_enc = '".$___Ls->gt->isb."' $__fl ".$___Ls->sch->cod." 
					ORDER BY id_storebrnd DESC";
				   
		$___Ls->qrys = "SELECT  *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
		
	} 
	
	
	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  <tr>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    <th width="20%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
    <th width="20%" <?php echo NWRP ?>><?php echo TX_VL ?></th>
    <th width="1%" <?php echo NWRP ?>></th>
  </tr>
  <?php do { ?>
	<tr>
	    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
	    <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['storebrnd_nm'],'in'),100,'Pt', true); ?></td>
      <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['storebrnd_e'],'in'),100,'Pt', true); ?></td>
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
                    <?php echo HTML_inp_hd('storebrnd_store', _SbLs_ID('i')); ?>
                    <?php echo HTML_inp_tx('storebrnd_nm', 'Nombre' , ctjTx($___Ls->dt->rw['storebrnd_nm'],'in'), FMRQD); ?>           
                    <?php echo OLD_HTML_chck('storebrnd_e', TX_ACTV, $___Ls->dt->rw['storebrnd_e'], 'in'); ?>
                    <?php echo OLD_HTML_chck('storebrnd_ftrd', 'Destacada', $___Ls->dt->rw['storebrnd_ftrd'], 'in'); ?>
                </div>
                <div class="col_2">

                    <?php echo HTML_inp_tx('storebrnd_pml', TX_PML , ctjTx($___Ls->dt->rw['storebrnd_pml'],'in')); ?>    
                    <?php echo HTML_inp_tx('storebrnd_dsc', TX_DSC , ctjTx($___Ls->dt->rw['storebrnd_dsc'],'in')); ?>

                </div>
            </div>
        </div>
        </form>
    </div>
    </div>
<?php } ?>
<?php } ?>