<?php
if(class_exists('CRM_Cnx')){

	

	$___Ls->cnx->cl = 'ok';
	$___Ls->_strt();


	if(!isN($___Ls->gt->i)){
		
		$___Ls->qrys = sprintf("SELECT *,
								"._QrySisSlcF([ 'als'=>'t', 'als_n'=>'attr' ]).",
								".GtSlc_QryExtra(['t'=>'fld', 'p'=>'attr', 'als'=>'t'])."
								FROM ".TB_CNT_APPL_ATTR."
								".GtSlc_QryExtra(['t'=>'tb', 'col'=>'cntapplattr_attr', 'als'=>'t'])."
								
						   		WHERE  ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
						   		
	}elseif($___Ls->_show_ls == 'ok' || !isN($_i)){

		if( !isN($__i) ){ $_fl = " AND cntapplattr_cntappl IN ( SELECT id_cntappl FROM ".TB_CNT_APPL." WHERE cntappl_enc = '".$__i."' ) "; }

		$Ls_Whr = "FROM ".TB_CNT_APPL_ATTR."
						".GtSlc_QryExtra(['t'=>'tb', 'col'=>'cntapplattr_attr', 'als'=>'t'])."
						LEFT JOIN sumr_bd._sis_slc_f ON id_sisslc = sisslcf_slc
						LEFT JOIN sumr_bd._sis_slc_tp_f ON sisslcf_f = id_sisslctpf
						WHERE id_cntapplattr != '' $_fl ".$___Ls->sch->cod."
						
						/*AND sisslc_tp = 134*/
						AND sisslc_tp IN (SELECT id_sisslctp FROM sumr_bd._sis_slc_tp WHERE sisslctp_key = 'appl_attr')
						
						
						/*AND id_sisslctpf = 252*/
						AND sisslctpf_key = 'ctg'
						
						
						AND sisslcf_vl = '".$__t3."'
						ORDER BY attr_sisslc_tt ASC";
		$___Ls->qrys = "SELECT *,
						"._QrySisSlcF([ 'als'=>'t', 'als_n'=>'attr' ]).",
						".GtSlc_QryExtra(['t'=>'fld', 'p'=>'attr', 'als'=>'t']).",
						(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";

	}

	$___Ls->_bld();
	
?>

<?php if($___Ls->ls->chk=='ok'){

	$__blq = 'off'; ?>
	<?php //$___Ls->_bld_l_hdr(); ?>

	<?php if(($___Ls->qry->tot > 0)){ ?>
	
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
			<thead>
		        <tr>
		        	<th width="49%" <?php echo NWRP ?>><?php echo TX_TT; ?></th>
		            <th width="49%" <?php echo NWRP ?>><?php echo TX_VL; ?></th>
					<th width="1%" <?php echo NWRP ?>></th>
		        </tr>
			</thead>
			<tbody>
				<?php  do { ?>
					<?php if( !isN($___Ls->ls->rw['id_cntapplattr']) ){ ?>
						<?php if(!isN($___Ls->ls->rw['cntapplattr_vl'])){ $l_dt = LsDmc([ 'attr'=>$___Ls->ls->rw['cntapplattr_attr'], 'id'=>$___Ls->ls->rw['cntapplattr_vl'], 'tp'=>'dt' ]); } ?>
				        <tr>
				        	<td width="49%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['attr_sisslc_tt'], 'in'); ?></td>
				        	<td width="49%" align="left" nowrap="nowrap"><?php echo Spn( ((!isN($___Ls->ls->rw['cntapplattr_vl']) && $l_dt->e == "ok")? $l_dt->tt : $___Ls->ls->rw['cntapplattr_vl'] ) ,'','_f'); ?></td>
							<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
				        </tr>
					<?php }  ?>
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
      	<?php //$___Ls->_bld_f_hdr(); ?>

	  	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
			<div class="ln_1">
				<?php
					
					$l = LsDmc([
			    		'attr'=>$___Ls->dt->rw['cntapplattr_attr'],
			    		'id'=>'cntapplattr_vl',
			    		'va'=>$___Ls->dt->rw['cntapplattr_vl'],
			    		'tp'=>'ls',
			    		'ph'=>$___Ls->dt->rw['attr_sisslc_tt']
		    		]);
					
					if($l->e == "ok"){
		    			echo $l->html;
		    			$CntWb .= $l->js;
		    		}else{
			    		echo HTML_inp_tx('cntapplattr_vl', TX_VLR, ctjTx($___Ls->dt->rw['cntapplattr_vl'],'in'), '');
		    		}
		    		
				  ?>
            </div>
		</div>   
	           
    </form>
  </div>
</div>

<?php } ?>
<?php } ?>
