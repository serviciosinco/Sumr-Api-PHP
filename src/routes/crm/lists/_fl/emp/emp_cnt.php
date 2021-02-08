<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->cnx->tt = TX_EMP_CNT;
	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'empcnt_nm, empcnt_ap, empcnt_cel, empcnt_tel, empcnt_depto, empcnt_mail';
	$___Ls->_strt();
		                                                                                                                        
	$__lsgt_flt_cmp = 'empcnt_emp';
	
	if(_Chk_GET('fl_empcntemp')){ $__fl .= _AndSql('empcnt_emp', $_GET['fl_empcntemp']); }
	if(_SbLs_ID('i')){ $__fl .= _AndSql('empcnt_emp', _SbLs_ID('i')); }
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_EMP_CNT." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){  


		$Ls_Whr = "FROM ".TB_EMP_CNT.", ".MDL_EMP_BD." WHERE empcnt_emp = id_emp AND ".$___Ls->ino." != '' $__fl ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";	   

		
	}
	
	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr();?>
<?php if(($___Ls->qry->tot > 0)){ ?>


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<thead>
        <tr>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
            <th width="90%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
            <?php if($__lssb != 'ok'){ ?>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_EMP ?></th>
            <?php } ?>
            <th width="1%" <?php echo NWRP ?>>&nbsp;</th>

        </tr>
  	</thead>
  	<tbody>
		<?php do { ?>
        <tr>
	        <td align="left" <?php echo $_clr_rw ?> <?php echo NWRP ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>

            <td align="left" <?php echo $_clr_rw ?> <?php echo NWRP ?>><?php echo ctjTx($___Ls->ls->rw['empcnt_nm'],'in').' '.ctjTx($___Ls->ls->rw['empcnt_ap'],'in'); ?></td>
            <?php if($__lssb != 'ok'){ ?>
             <td align="left" <?php echo $_clr_rw ?> <?php echo NWRP ?>><?php echo ctjTx($___Ls->ls->rw['emp_rs'],'in'); ?></td>
            <?php } ?>

            <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
        </tr>
        <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
  </tbody>
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


	  
	  <?php echo bdiv(['cls'=>'bnr__emp_vst']); ?>
	  
	  <?php 
    	$CntJV .= "		        
									
			function __LdOrg(_id){	
				if(_id != '' && _id != undefined){ var __id = _id; }else{ var __id = '".$___Ls->dt->rw['id_empcnt']."'; }		
				if(__id != '' && __id != undefined){
					var __u = '".Fl_Rnd(FL_DT_GN.__t('emp_cnt',true))."'+'".ADM_LNK_DT."'+ __id;
					_ldCnt({ u:__u , c:'__emp_dt', trs:false });	
																					}
			}
			
			if($('#id_brf').val() != ''){
				__LdOrg('');
				$('#__emp_dt').show();
			}else{
				
			}";
		?>
		
		
		
		
        <div class="ln_1">
	        <div class="btnDt">
		        <div class="col_1">
			        <div class="__bx_dt __fm_opt">
				        <div class="__btn" style="cursor:pointer;right:100%!important; <?php if($___Ls->dt->tot == 0){ ?>display:none;<?php } ?>">
							<?php if( !_DtV() ){ 
					             echo '<a  class="___edt_btn">'.TX_EDIT.'</a>' ; 
					             $CntWb .= '$(".___edt_btn").click(function(){ 
												
													$(".btnDt").fadeOut();	
													$(".__edt").fadeIn();
												
											}); ';
							} ?>
				        </div>	
			        </div>
				 </div>
	     	   <section id="__emp_dt" class="__brf_dt"></section>
	        </div>
          <div class="col_1 __edt"  style=" <?php if($___Ls->dt->tot == 1){ ?>display:none;<?php } ?>"> 
                <?php 
					if($__lssb != 'ok'){
						echo LsEmp('empcnt_emp','id_emp', $___Ls->dt->rw['empcnt_emp'], '', 2, '', _SbLs_ID('i')); $CntWb .= JQ_Ls('empcnt_emp',FM_LS_SLEMP);
					}else{
						echo HTML_inp_hd('empcnt_emp', _SbLs_ID('i'));
					} 
				?>
          		<?php echo HTML_inp_tx('empcnt_nm', TT_FM_NM, ctjTx($___Ls->dt->rw['empcnt_nm'],'in'), FMRQD); ?>  
                <?php echo HTML_inp_tx('empcnt_ap', TT_FM_AP, ctjTx($___Ls->dt->rw['empcnt_ap'],'in'), FMRQD); ?>  
                <?php echo HTML_inp_tx('empcnt_cel', TX_CEL, ctjTx($___Ls->dt->rw['empcnt_cel'],'in')); ?>  
                <?php echo HTML_inp_tx('empcnt_tel', TX_TEL, ctjTx($___Ls->dt->rw['empcnt_tel'],'in')); ?>  
                <?php echo HTML_inp_tx('empcnt_ext', TX_EXT, ctjTx($___Ls->dt->rw['empcnt_ext'],'in')); ?> 
          </div>
          <div class="col_2 __edt"  style="<?php if($___Ls->dt->tot == 1){ ?>display:none;<?php } ?>">  
                <?php echo HTML_inp_tx('empcnt_depto', TX_DEPTO, ctjTx($___Ls->dt->rw['empcnt_depto'],'in')); ?>
                <?php echo HTML_inp_tx('empcnt_crg', TT_FM_CRG, ctjTx($___Ls->dt->rw['empcnt_crg'],'in')); ?>  
                <?php echo HTML_inp_tx('empcnt_mail', TT_FM_EML, ctjTx($___Ls->dt->rw['empcnt_mail'],'in'), FMRQD_EM); ?>  
                <?php echo HTML_textarea('empcnt_obs', '', ctjTx($___Ls->dt->rw['empcnt_obs'],'in'), '', 'ok'); ?>
          </div>
        </div>
      </div>
    </form>
  </div>
  <?php 
  
	if($__lssb != 'ok'){ 
		$CntJV .= " 
			
			function __NxtEmpSub(a, t){
				var _t = t;
				if(a == 'nxt_cnt'){
					$('#".TBGRP.$__idtp_2."_c').empty().append('('+_t+')');
					$('#".TBGRP.$__idtp_3."').removeClass('_hd').effect('highlight');
				} else if(a == 'nxt_vst'){
					$('#".TBGRP.$__idtp_3."_c').empty().append('('+_t+')');
					$('#".TBGRP.$__idtp_4."').removeClass('_hd').effect('highlight');
					$('#".TBGRP.$__idtp_5."').removeClass('_hd').effect('highlight');
				} else if(a == 'nxt_ofr'){
					$('#".TBGRP.$__idtp_4."_c').empty().append('('+_t+')');
					$('#".TBGRP.$__idtp_5."').removeClass('_hd').effect('highlight');
				} else if(a == 'last'){
					$('#".TBGRP.$__idtp_5."_c').empty().append('('+_t+')');
				}
			} 
		";
	}
	
	
	?>
</div>
<?php } ?>

<?php } ?>
