<?php 
if(class_exists('CRM_Cnx')){

	$___Ls->cnx->aut = 'ok';
	$___Ls->sch->f = 'Trigger_sisslc_tt';
	$___Ls->_strt();
	
	
	
	if(!isN($___Ls->gt->i)){	
		 
		$___Ls->qrys = sprintf("	SELECT *,
										   "._QrySisSlcF([ 'als'=>'a', 'als_n'=>'Action' ]).", 
										   ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Action', 'als'=>'a' ])."				
									FROM ".TB_ATMT_TRGR_ACT."
										 INNER JOIN ".TB_ATMT_TRGR." ON atmttrgract_trgr = id_atmttrgr
										 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'atmttrgract_act', 'als'=>'a' ])."
									WHERE ".$___Ls->ik." = %s 
									LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
								);	
								
	}elseif($___Ls->_show_ls == 'ok'){
		
		if(!isN($___Ls->gt->isb)){ $__fl .= $___Ls->_andsql([ 'f'=>'atmttrgr_enc', 'v'=>$___Ls->gt->isb ]); }

		$Ls_Whr = "FROM ".TB_ATMT_TRGR_ACT."
						INNER JOIN ".TB_ATMT_TRGR." ON atmttrgract_trgr = id_atmttrgr
					    ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'atmttrgract_act', 'als'=>'a' ])."
				   WHERE id_atmttrgract != '' $__fl $__schcod 
				   ORDER BY id_atmttrgract DESC";
			  
		$___Ls->qrys = "SELECT *, 
							(SELECT COUNT(*) $Ls_Whr) AS __rgtot,
							"._QrySisSlcF([ 'als'=>'a', 'als_n'=>'Action' ]).", 
							".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Action', 'als'=>'a' ])."
						$Ls_Whr";		  
					  		
	} 
	
	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg LsRgNw LsRgAtmtTrgrAct">
  <tbody>
		  <?php do { 
			  
			  if($___Ls->ls->rw['atmttrgract_hbl'] == 2){ $__cls_tr = 'off'; }else{ $__cls_tr = 'on'; }
			  
			  $__actdt = GtAtmtTrgrActDt([ 'id'=>$___Ls->ls->rw[$___Ls->ino], 'dt'=>'ok' ]);
		  ?>
          <tr class="<?php echo $__cls_tr; ?>">   

            <td align="left" <?php echo $_clr_rw ?> class="__sgm_var" width="99%" nowrap="nowrap">
	            <?php
					echo h2( ctjTx($___Ls->ls->rw['Action_sisslc_tt'],'in')).
						 Strn(ctjTx($___Ls->ls->rw['sisecsgmvar_nm'] ,'in')).' '. (!isN($__actdt->dt->c->tt)?$__actdt->dt->c->tt:'')		 
		        ?>
	        </td>
			
            <?php if(ChckSESS_superadm() || (_ChckMd('ec_trgr_mod'))){ ?>
	            <td width="1%" align="left" nowrap="nowrap">
	                <?php echo $___Ls->_btn([ 't'=>'mod' ]); ?>
	            </td>
            <?php } ?>
          </tr>
          <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
          
          <?php 
	          
	          $CntWb .= " $('#".TBGRP."_gst ._n').html('".$Tot_Ls_Rg."'); ";
	          
          ?>
  </tbody>
</table>

<style>
				
	.LsRgNw.LsRgAtmtTrgrAct tr td{ padding-top: 5px; padding-bottom: 13px; }
	.LsRgNw.LsRgAtmtTrgrAct tr td.__sgm_var{ background-repeat: no-repeat; background-position: left 10px center; background-size: auto 40%; padding-left: 50px; }
	.LsRgNw.LsRgAtmtTrgrAct tr.on td.__sgm_var{ background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'atmt_on.svg') ?>); }
	.LsRgNw.LsRgAtmtTrgrAct tr.off td.__sgm_var{ background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'atmt_off.svg') ?>); }
	
</style>
		
		
<?php $___Ls->_bld_l_pgs(); ?>
<?php }?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>



<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  	<div id="<?php echo $___Ls->fm->bx->id ?>">
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
		
		<?php $___Ls->_bld_f_hdr(); ?> 

      	<?php echo $Bld_r->html; $CntWb .= $Bld_r->js; ?>
	  	<div id="<?php echo $___Ls->fm->fld->id ?>">
        
			<div class="ln_2col">
				<div class="_c">
					<?php echo HTML_inp_hd('atmttrgract_trgr', _SbLs_ID('i')); ?>
					<?php $l = __Ls(['k'=>'sis_atmt_act', 'id'=>'atmttrgract_act', 'v'=>'sisslc_enc', 'va'=>$___Ls->dt->rw['Action_sisslc_enc'] , 'ph'=>FM_LS_SLGN]); echo $l->html; $CntWb .= $l->js; ?>
					
				</div>
				<div class="_c">
					<div id="atmt_trgr_act_bx" class="_sbls">
                    	<?php 	
	                    	
                            $CntWb .= "
								
								function ShwActOpt(){	
									__var_id = $('#atmttrgract_act').val();
									__sl = $('#atmttrgract_act option:selected');
									__sl_r = __sl.attr('rel');	
									SUMR_Main.ld.f.slc({i:'atmttrgract_v_ls', t:'atmt_trgr_act_val', t_i:__sl_r });
								}
				
				
								$('#atmttrgract_act').change(function() {
									
									$('#atmt_trgr_act_bx').html('');
									
									__id = $(this).val();
									__est_i = $(this).val();
									
									SUMR_Main.ld.f.slc({
										i:__id, 
										t:'atmt_trgr_act_ls', 
										t_i:__est_i, 
										b:'atmt_trgr_act_bx'
									});
									
										
                        		});";
                        	
                        	
                        	
                        	if(!isN($___Ls->dt->rw['atmttrgract_act'])){ 
                        		$__t_s_i = $___Ls->dt->rw['Action_sisslc_enc']; 
                        	}else{ 
                            	$__t_s_i = 2; 
                           	} 
                            
                            if(!isN($___Ls->dt->rw['atmttrgract_v_ls'])){
	                        	$__i = $___Ls->dt->rw['atmttrgract_v_ls'];     
                            }else{
	                        	$__i = 1;     
                            }	

                            if($___Ls->dt->tot > 0){

						   		
						   		$CntWb .= "
											SUMR_Main.ld.f.slc({
												i:'".$__i."', 
												t:'atmt_trgr_act_ls', 
												t_i:'".$__t_s_i."', 
												b:'atmt_trgr_act_bx'
											});
										";
		                        	
						   	}
						   		
                        		 
						?>			
                    </div> 
				</div>  
				
				<?php echo OLD_HTML_chck('atmttrgract_hbl', 'Habilitado', $___Ls->dt->rw['atmttrgract_hbl']); ?>
				 
            </div>
            
            <?php if(!isN($__bxrld)){ $CntWb .= " $('#$__bxrld').removeClass('cnt_wrap'); "; } ?>
	  	</div>   
	           
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>