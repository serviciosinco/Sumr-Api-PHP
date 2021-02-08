<?php 
if(class_exists('CRM_Cnx')){


	$___Ls->sch->f = 'sms_ord, sms_cd, sms_tt';
	$___Ls->ino = 'id_sms';
	$___Ls->ik = 'sms_enc';
	
	$___Ls->new->w = 700;
	$___Ls->new->h = 500;
	
	
	$___Ls->_strt();
	
	if($__sch != ''){ $_adsch = ADM_LNK_SCH.$__sch; }
	$__lsgt_flt_cmp = ' sms_est, sms_pay, sms_cds';
	

	if(!isN($___Ls->mdlstp->id)){
		$_f_tp = " AND id_sms IN (SELECT smstp_sms FROM ".MDL_SMS_TP_BD." WHERE smstp_sms = id_sms AND smstp_tp = ".$___Ls->mdlstp->id.") ";
	}
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_SMS." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
		
		$Ls_Whr = "	FROM "._BdStr(DBM).TB_SMS." 
						 INNER JOIN "._BdStr(DBM).TB_CL." ON sms_cl = id_cl
					WHERE ".$___Ls->ino." != '' AND cl_enc = '".DB_CL_ENC."' $_f_tp $__fl ".$___Ls->sch->cod." 
					ORDER BY ".$___Ls->ino." DESC";
					
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_TotApr $Ls_TotLnk $Ls_TotLnkOpn $Ls_Whr";
	
	} 
	
	$___Ls->_bld(); 
?>
<?php 
	if($___Ls->ls->chk=='ok'){ $__blq = 'off';
	$___Ls->_bld_l_hdr();
?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
	    <th width="0%" nowrap="nowrap" <?php echo NWRP ?>><?php echo TX_FI ?></th>
	    <th width="95%" <?php echo NWRP ?>><?php echo TX_TT ?></th>
	    <th width="1%" <?php echo NWRP ?>><?php echo TX_COD ?></th>
	    <th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?> 
		<?php  			
	  		if($___Ls->ls->rw['sms_sis'] == 1){ $__icn_sis = Spn('sis','','___smssis'); }else{ $__icn_sis = ''; }
	  		$_clslnk = '';	
	  		$_clsopn = '';
  		?>
  	<tr>
	    <td width="0%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw['sms_fi'],'','_f'); ?></td>
	    <td width="95%" align="left" nowrap="nowrap">
		    <?php echo ShortTx(ctjTx($___Ls->ls->rw['sms_tt'],'in'),40,'Pt', true). HTML_BR . Spn(ctjTx($___Ls->ls->rw['sms_em'],'in'), '', '_f') .$__icn_sis; ?>		
		</td>
	    <td width="0%" align="left" nowrap="nowrap"><?php if(!_cdgwrn($___Ls->ls->rw['sms_cd'])){ echo Spn(TX_BN,'','ok'); } else{ echo Spn('Mal','','no') ; }?></td>
	    <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
  	</tr>
  <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>

<?php $___Ls->_h_ls_nr(); ?>
<?php $CntWb .= '
  					$("._rpr").colorbox({ width:"450px", height:"400px", overlayClose:false, escKey:false}); 
					$("._dwn").colorbox({ iframe:true, width:"1000px", height:"600px", overlayClose:false, escKey:false});'; 
?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">

  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >	
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
	   <?php $___Ls->_bld_f_hdr(); ?>    

      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
      
        <div class="ln_1 _anm" id="dv_col">
          
          <div class="col_1 _anm" style="position: relative; ">
	          	
          	<a href="<?php echo Void(); ?>" id="cmp_col" class="__cmpc"></a>
            <?php 
	            
	             $CntWb .= "
	             
	             		
	             		$('#cmp_col').click(function() {
		             		if( $('#dv_col').hasClass('_mny') ){
			             		$('#dv_col').removeClass('_mny');
		             		}else{
			             		$('#dv_col').addClass('_mny');
		             		} 
						});

	             ";
	            
            ?>
            
            
            <div class="ln_1 _anm">
	            
	            <?php 
		            if(!isN($___Ls->dt->rw['sms_key'])){ 
		            	$__key = Spn( "_CId('".strtoupper( 'SMS_'.str_replace('_','',$___Ls->dt->rw['sms_key']) ."');" ), '', '_key'); 
		            } 
		        ?>
		        <?php if($___Ls->dt->tot == 1){ echo bdiv(['c'=>$__key, 'cls'=>'pml']); } ?>
		        
		        <style>
	            	
	            	.FmTb .pml ._key{ color: #9ca7aa; font-family: Economica; font-size: 13px; }
	            	
            	</style>
            	
            	
	            <div class="_MblBx">
					<div class="_Hdr"></div>
					<div class="_Bdy">
						<div class="_Lft"></div>
						<div class="_Msj">
							<div class="_MsjBx" id="_MsjBx"></div>
						</div>
						<div class="_Rgh"></div>
					</div>
					<div class="_MsjCountBx" id="_MsjCountBx"><?php echo TX_NCRACT ?></div>
				</div>
            </div> 
            
          </div>
          <div class="col_2 _anm">

            	<input id="sms_us" name="sms_us" type="hidden" value="<?php echo SISUS_ID ?>" />
				<input id="sms_pml_UPD" name="sms_pml_UPD" type="hidden" value="<?php echo ctjTx($___Ls->dt->rw['sms_pml'],'in') ?>" />
				
				<?php 	
								
					$CntWb .= "
								
							SUMR_Main.sms.bld({	
								btn:'SndPss',
								bx:{
									msj:'_MsjBx',
									cnt:'_MsjCountBx'
								},
								ps:'sms_ps',
								frm:'sms_frm',
								tel:'sms_tel',
								msj:'sms_msj',
								_c:function(){}	
							});	
							
					";	
				  		
				?>
					
				<div class="__msj_cel">
					<?php echo HTML_BR.HTML_inp_tx('sms_tt', 'Titulo', ctjTx($___Ls->dt->rw['sms_tt'],'in')); ?> 
					<?php echo HTML_textarea('sms_msj', '', $___Ls->dt->rw['sms_msj'], FMRQD, 'no', '', 10, 160); ?> 
					<?php echo HTML_inp_tx('sms_key', TX_KEY, ctjTx($___Ls->dt->rw['sms_key'],'in')); ?> 
					<?php 
						
						$l = __Ls(['k'=>'snd_est', 'id'=>'sms_est', 'va'=>$___Ls->dt->rw['sms_est'] , 'ph'=>TX_ETD]); 
						echo $l->html; $CntWb .= $l->js;
						
						$l = __Ls(['k'=>'sis_sms_frm', 'id'=>'sms_frm', 'va'=>$___Ls->dt->rw['sms_frm'] , 'ph'=>TX_FRMT]); 
						echo $l->html; $CntWb .= $l->js;
							                            
					?>	
				</div>
                
            
          </div>
          <?php// } ?>
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } $CntWb .= JV_Blq($__blq).JV_HtmlEd($__jqte); 

?>
