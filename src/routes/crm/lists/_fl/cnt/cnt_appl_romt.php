<?php
	
if(class_exists('CRM_Cnx')){

	$___Ls->cnx->cl = 'ok';
	$___Ls->_strt();

	if(!isN($___Ls->gt->i)){
		
		$___Ls->qrys = sprintf("SELECT *
								FROM ".TB_CNT_APPL_ROMT."
						   		WHERE  ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
						   		
	}elseif($___Ls->_show_ls == 'ok' || !isN($_i)){

		if( !isN($__i) ){ $_fl = " AND cntapplromt_cntappl IN ( SELECT id_cntappl FROM ".TB_CNT_APPL." WHERE cntappl_enc = '".$__i."' ) "; }

		$Ls_Whr = "FROM ".TB_CNT_APPL_ROMT."
						WHERE id_cntapplromt != '' $_fl ".$___Ls->sch->cod." ";
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";

	}

	$___Ls->_bld();

?>

<?php if($___Ls->ls->chk=='ok'){

	$__blq = 'off'; ?>
	<?php $___Ls->_bld_l_hdr(); ?>

	<?php if(($___Ls->qry->tot > 0)){ ?>
	
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
			<thead>
		        <tr>
		        	<th width="49%" <?php echo NWRP ?>><?php echo TX_TT; ?></th>
		            <th width="49%" <?php echo NWRP ?>><?php echo 'Roommates'; //Ricardo ?></th>
					<th width="1%" <?php echo NWRP ?>></th>
		        </tr>
			</thead>
			<tbody>
				<?php do { ?>
					<tr>
			        	<td width="49%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['cntapplromt_nm'], 'in'); ?></td>
			        	<td width="49%" align="left" nowrap="nowrap">
				        	<?php 
					        	if( $___Ls->ls->rw['cntapplromt_wtlve'] == 1 ){
						        	echo '<img src="'.DMN_IMG_ESTR_SVG.'good.svg" width="20px" rel="" class="_romt_wtlve ok _anm" />';
					        	}else if( $___Ls->ls->rw['cntapplromt_wtlve'] == 2 ){
						        	echo '<img src="'.DMN_IMG_ESTR_SVG.'bad.svg" width="20px" rel="" class="_romt_wtlve no _anm" />';
					        	}
				        	?>
			        	</td>
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
      	<?php //$___Ls->_bld_f_hdr(); ?>

	  	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
			<div class="ln_1">
				<?php
					
					echo HTML_inp_tx('cntapplromt_nm', TX_VLR, ctjTx($___Ls->dt->rw['cntapplromt_nm'],'in'), '');
					echo HTML_inp_hd('cntapplromt_wtlve', NULL);
					echo HTML_inp_hd('cntapplromt_cntappl', $__i);
					echo '<img src="'.DMN_IMG_ESTR_SVG.'good.svg"  rel="1" class="_romt_wtlve_dt ok '.( ($___Ls->dt->rw['cntapplromt_wtlve'] == 1)? '_chk' : '' ).' _anm" />';
					echo '<img src="'.DMN_IMG_ESTR_SVG.'bad.svg" rel="2" class="_romt_wtlve_dt no '.( ($___Ls->dt->rw['cntapplromt_wtlve'] == 2)? '_chk' : '' ).' _anm" />';
					
				  ?>
            </div>
		</div>
		
		<?php 
			$CntWb .= "
				$('._romt_wtlve_dt').off('click').click(function(){
					
					$('._romt_wtlve_dt').removeClass('_chk');
					$(this).addClass('_chk');
					$('#cntapplromt_wtlve').val( $(this).attr('rel') );
					
				});
			";
		?>
	    
	    <style>
		    ._romt_wtlve_dt{ margin-left: 10px; width: 30px; cursor: pointer; -webkit-filter: grayscale(100%); filter: grayscale(100%); }
		    ._romt_wtlve_dt:Hover{ filter: none; }
		    ._romt_wtlve_dt.no{ margin-left: 10px; }
		    ._romt_wtlve_dt._chk{ width: 35px; filter: none; }
	    </style>
	    
    </form>
  </div>
</div>

<?php } ?>
<?php } ?>
