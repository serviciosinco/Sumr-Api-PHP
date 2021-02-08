<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->cnx->prc = 'ok';
	$___Ls->sch->f = 'upcol_up, id_upcol';
 	$___Ls->_strt();
	
	for ($i = 0; $i <= (UPCOL_CNT); $i++) { $__sch_mre[] = 'upcol_'.$i; } $__sch_mre_v = implode(',', $__sch_mre);
	
	if(!isN($___Ls->gt->i)){	

		$___Ls->qrys = sprintf("SELECT * 
								FROM ".MDL_UP_COL_BD." 
									 INNER JOIN ".MDL_UP_BD." ON upcol_up = id_up 
								WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 


		$Ls_Whr = " FROM ".MDL_UP_COL_BD." 
						 INNER JOIN ".MDL_UP_BD." ON upcol_up = id_up 
					WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." 
					ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";   
		
	}
	
	$___Ls->_bld();
	
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>

<? //echo SIS_F.'<br>'.SIS_F_ALL ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  <tr>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    <th width="35%" <?php echo NWRP ?>><?php echo TX_ORGN ?></th>
     <th width="35%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
       <th width="1%" <?php echo NWRP ?>><?php echo TX_FIN ?></th>
                    <th width="0%" <?php echo NWRP ?>><?php echo TX_HR ?></th>
  </tr>
  
  	<?php do { ?>

  	<tr>
  		<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>

  		<td width="35%" align="left" > <?php echo ShortTx(ctjTx($___Ls->ls->rw['upcol_up'],'in'),100,'Pt', true); ?></td>
  		<td width="48%" align="left" nowrap="nowrap"><?php if($___Ls->ls->rw['up_nm'] != ''){ $_up_nm = $___Ls->ls->rw['up_nm']; }else{ $_up_nm = $___Ls->ls->rw['up_fle']; } echo ShortTx(ctjTx($_up_nm,'in'),60,'Pt', true) ?>
        <td width="1%" align="left" nowrap="nowrap"><?php echo Spn($___Ls->ls->rw['up_fi']); ?></td>
        <td width="1%" align="left" nowrap="nowrap"><?php echo Spn($___Ls->ls->rw['up_hi']); ?></td>
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
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
      <?php $___Ls->_bld_f_hdr(); ?>
	
      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	  
        <div class="ln_1">
          	<div class="col_1">
          	<?php echo HTML_inp_tx('upcol_up', 'upcol_up' , ctjTx($___Ls->dt->rw['upcol_up'],'in')); ?>
            <?php echo HTML_inp_tx('upcol_row', 'upcol_row' , ctjTx($___Ls->dt->rw['upcol_row'],'in')); ?>
            <?php echo HTML_inp_tx('upcol_w', 'upcol_w' , ctjTx($___Ls->dt->rw['upcol_w'],'in')); ?>
            <?php echo HTML_inp_tx('upcol_est', 'upcol_est' , ctjTx($___Ls->dt->rw['upcol_est'],'in')); ?>
            <?php 	
			
				$__hdr_col = json_decode($___Ls->dt->rw['up_fld'], true);
					
				for ($i = 0; $i <= (UPCOL_CNT/2); $i++) {
					$__fld = GtUpFldDt($__hdr_col['c_'.$i], 'vl');
				    echo HTML_inp_tx('upcol_'.$i, 'upcol_'.$i.' ('.$__fld->tt.')' , ctjTx($___Ls->dt->rw['upcol_'.$i],'in')); 
				} 
			?>   
          	</div>
		  	<div class="col_2">
			<?php 
				for ($i = ((UPCOL_CNT/2)+1); $i <= UPCOL_CNT; $i++) {
					$__fld = GtUpFldDt($__hdr_col['c_'.$i], 'vl');
					echo HTML_inp_tx('upcol_'.$i, 'upcol_'.$i.' ('.$__fld->tt.')' , ctjTx($___Ls->dt->rw['upcol_'.$i],'in')); 
				}
			?>
          	</div>
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
