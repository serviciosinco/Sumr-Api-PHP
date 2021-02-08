<?php 
if(class_exists('CRM_Cnx')){
	

	$___Ls->cnx->cl = 'ok';
	$___Ls->_strt();


	if(!isN($___Ls->gt->i)){	

		$___Ls->qrys = sprintf("SELECT * FROM ".TB_CNT_DC."
								INNER JOIN ".TB_CNT." ON cntdc_cnt = id_cnt
						   		WHERE cntdc_cnt = id_cnt AND 
								 ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));				 
		
	}elseif($___Ls->_show_ls == 'ok'){ 

		if( !isN($__i) ){ $_fl = " AND cnt_enc =  '$__i' "; }

		$Ls_Whr = "FROM ".TB_CNT_DC."
						INNER JOIN ".TB_CNT." ON cntdc_cnt = id_cnt
						INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON cntdc_tp = id_sisslc
						LEFT JOIN ".TB_CNT_PLCY." ON (cntplcy_cnt = cntdc_cnt AND cntplcy_sndi=1)
						LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." ON (cntplcy_plcy = id_clplcy AND clplcy_e=1)
					WHERE id_cntdc != '' $_fl ".$___Ls->sch->cod." 
					ORDER BY cntdc_fi DESC";

		$___Ls->qrys = "SELECT id_cntdc, cntdc_enc, cntdc_dc, cntplcy_sndi, cntdc_fi, sisslc_tt, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
		
	} 
		
	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ $__blq = 'off'; ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
	<thead>
        <tr>
        	<th width="1%" <?php echo NWRP ?>></th>
            <th width="10%" <?php echo NWRP ?>><?php echo TX_TP; ?></th>
            <th width="88%" <?php echo NWRP ?>><?php echo TX_DC; ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_FI; ?></th>

            <th width="1%" <?php echo NWRP ?>></th>
        </tr>
	</thead>
	<tbody>
		<?php 
		
			do { 
			
			$__dc_nrml = 	_plcy_scre([ 
				'v'=>ctjTx($___Ls->ls->rw['cntdc_dc'],'in'),
				'plcy'=>[ 'e'=>$___Ls->ls->rw['cntplcy_sndi'] ]  
			]);	

		?>
        <tr>
        	<td width="1%" align="left" nowrap="nowrap"><?php echo $___Ls->dt->rw[$___Ls->ino]; ?></td>
			<td width="10%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisslc_tt'],'in'),50); ?></td>
			<td width="88%" align="left" nowrap="nowrap"><?php echo ShortTx($__dc_nrml,50); ?></td>
			<td width="1%" align="left" nowrap="nowrap"><?php echo Spn($___Ls->ls->rw['cntdc_fi'],'','_f'); ?></td>
			<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>   
        </tr>
        <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
        <?php $CntWb .= " $('#".TBGRP."_gst ._n').html('".$___Ls->qry->tot."'); "; ?>
  	</tbody>
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
					<?php echo HTML_inp_hd('cntdc_cnt', _SbLs_ID('i')); ?>
					<?php echo HTML_inp_tx('cntdc_dc', TT_FM_DC, ctjTx($___Ls->dt->rw['cntdc_dc'],'in'), FMRQD_NMR); ?>  
					<?php echo HTML_inp_hd('cntdc_dc_bfr',ctjTx($___Ls->dt->rw['cntdc_dc'],'in') ); ?>  
					<?php echo SlDt([ 'id'=>'cntdc_exp', 'va'=>$___Ls->dt->rw['cntdc_exp'], 'rq'=>'no', 'ph'=>'Expedición', 'lmt'=>'no', 'yr'=>'ok', 'cls'=>CLS_CLND ]);  ?>	
				</div>
				<div class="col_2"> 
					<?php 
		                $l = __Ls([ 'k'=>'cnt_dc', 'id'=>'cntdc_tp_p', 'va'=>$___Ls->dt->rw['cntdc_tp'], 'ph'=>FM_LS_TPDOC ]); 
		                echo $l->html; $CntWb .= $l->js;    
	                ?> 
				</div>   
            </div>
	  </div>   
	           
    </form>
  </div>
</div>

<?php } ?>
<?php } ?>
