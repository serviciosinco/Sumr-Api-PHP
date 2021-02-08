
<?php
if(class_exists('CRM_Cnx') && !isN($___Ls->mdlstp->tp)){

	$___Ls->cnx->cl = 'ok';
	$___Ls->_strt();

	if(_SbLs_ID('i')){ 
		
		$__fl .= _AndSql($__id__rlc_2, _SbLs_ID('i')); 
		$__dt_mdlcnt = GtMdlCntDt([ 'id'=>_SbLs_ID('i'), 't'=>'enc', 'shw'=>[ 'cnt'=>'ok' ] ]); 
		$__id_mdlcnt = 'AND mdlcntec_mdlcnt = '.$__dt_mdlcnt->id; }
	
	
	if(!isN($___Ls->gt->i)){
		
		$___Ls->qrys = sprintf("	SELECT * 
									FROM ".TB_MDL_CNT_EC." 
										 INNER JOIN ec_snd ON id_ecsnd =  mdlcntec_ecsnd 
									WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
	
		
	}elseif($___Ls->_show_ls == 'ok'){  
		
		$Ls_TotApr = ", (SELECT COUNT(*) FROM ".TB_EC_OP." WHERE ecop_snd = id_ecsnd) AS __tot_apr ";
		
		$Ls_Whr = "FROM ".TB_MDL_CNT_EC."
						INNER JOIN ".TB_MDL_CNT." ON mdlcntec_mdlcnt = id_mdlcnt
						INNER JOIN ".TB_MDL_EC_SND." ON mdlcntec_ecsnd = id_ecsnd
						INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
						INNER JOIN "._BdStr(DBM).TB_US." ON ecsnd_snd = id_us	
						INNER JOIN "._BdStr(DBM).TB_EC." ON ecsnd_ec = id_ec	
						".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'ecsnd_est', 'als'=>'c' ])."
				   WHERE (".$___Ls->ino." IS NOT NULL) ".$__id_mdlcnt." $__fl ".$___Ls->sch->cod."
				   		
				   ORDER BY ".$___Ls->ino." DESC";
				   		   
		$___Ls->qrys = "SELECT *, 
								(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." 
								$Ls_TotApr,
								"._QrySisSlcF([ 't'=>'fld', 'p'=>'clase', 'als'=>'c' ]).",
								"._QrySisSlcF([ 'als'=>'c', 'als_n'=>'clase' ])."
						$Ls_Whr";
		
	}
	
	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>


<br>
<?php if(_SbLs_ID('i')){ ?>
<div class="<?php echo ID_HDRLS ?> lead_pushmail_list">
	
	<div class="btn">	
		<button id="_INRG_EcCmz_SbCnt" class="_anm _fll" style="padding-right:10px; background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>ec_tp_cmz.svg);" class="_tel"><span alt="Mis Pushmail">Mis Pushmail</span></button>
		<button id="_INRG_Ec_SbCnt" class="_anm _fll" style="padding-right:10px; background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>ec_tp_all.svg);" class="_mail"><span alt="Código">Código</span></button> 
		
		<?php if(ChckSESS_superadm()){ ?>
			<button id="_INRG_Eml_SbCnt" class="_anm" style="padding-right:10px; background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>ec_new_mail.svg);" class="_visit"><span alt="Email">Email</span></button>
		<?php } ?> 
	</div>
	
<?php 
		  
	$CntWb .= '
		
		$("#_INRG_Ec_SbCnt").off("click").click(function(e) { 
			
			e.preventDefault();
		
			if(e.target != this){
				e.stopPropagation(); return;
			}else{
				_ldCnt({ 
					u:\''.FL_LS_GN.__t($___Ls->tp, true)._SbLs_ID()._SbLs_Vst().TXGN_ING.Fl_i($___Ls->gt->i).'&_m=ec&__rnd=bcf'.$___Ls->bx_rld.$___Ls->ls->vrall.'\',
					c:\''.$___Ls->bx_rld.'\',
					pop:\'ok\',
					pnl:{
						e:\'ok\',
						s:\'l\',
						tp:\'h\'
					}
				});
			} 

		});
		
		
		$("#_INRG_EcCmz_SbCnt").off("click").click(function(e) { 
			
			e.preventDefault();
		
			if(e.target != this){
				e.stopPropagation(); return;
			}else{
				_ldCnt({
					u:\''.FL_LS_GN.__t($___Ls->tp, true)._SbLs_ID()._SbLs_Vst().TXGN_ING.Fl_i($___Ls->gt->i).'&_m=ec_cmz&__rnd=bcf'.TXGN_POP.$___Ls->ls->vrall.'\',
					c:\''.$___Ls->bx_rld.'\',
					pop:\'ok\',
					pnl:{
						e:\'ok\',
						s:\'l\',
						tp:\'h\'
					}
				}); 
			}
				
		});
		
		$("#_INRG_Eml_SbCnt").off("click").click(function(e) { 
			
			e.preventDefault();
			
			if(e.target != this){
				e.stopPropagation(); return;
			}else{
				_ldCnt({ 
					u:\''.FL_DT_GN.__t('my_eml_cnv', true).'&mdlcnt='.$__dt_mdlcnt->enc.'&tra='.$_dt_tra->enc.'&_m=eml'.TXGN_POP.$___Ls->ls->vrall.'&_t4='.$___Ls->gt->tsb_d.'\',
					pop:\'ok\',
					cls:\'_fll _thdr\',
					pnl:{
						e:\'ok\',
						s:\'l\',
						tp:\'h\'
					}
				}); 
			}
			
		});
	'; 

?>
</div>

<?php }else{
		$___Ls->_bld_l_hdr(); 
} ?>

<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<thead>
      	<tr>
            <th width="10%" <?php echo NWRP ?>></th>
            <th width="40%" <?php echo NWRP ?>><?php echo TX_SND ?></th>
            <th width="10%" <?php echo NWRP ?>><?php echo TX_EML ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_EML_APR ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_FIN ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_HR ?></th>
            <th width="1%" <?php echo NWRP ?>></th>
        </tr>
  	</thead>  
  	<tbody>
		<?php do { ?>
        <tr>
			
			<?php 
				
				
				if(!isN($___Ls->ls->rw['___clase'])){
				    
				    $__clase_attr = json_decode($___Ls->ls->rw['___clase']);
				    
				    if(!isN($__clase_attr) && is_array($__clase_attr)){
					    foreach($__clase_attr as $_attr_k=>$_attr_v){
						    $__toa_attr[ $_attr_v->key ] = $_attr_v;
					    }
				    }
				    
			    }else{
				    $__toa_attr = NULL;
			    }
				
				$__cls_snd = $__toa_attr['cls']->vl;			    
				$__tt_snd = $___Ls->ls->rw['sisslc_tt'];
							    
				if($___Ls->ls->rw['__tot_apr'] > 0){
					$__cls_snd = 'opn';
					$__tt_snd = 'Abierto';
				}
				
			?>
            
            <td width="10%" align="left"><?php echo Spn('','','_ec_snd _ec_snd_'.$__cls_snd); ?></td>       
            <td width="40%" align="left" >
	            <div style="text-overflow:ellipsis; overflow: hidden; width: 100%; ">
					<?php 
						echo ctjTx($___Ls->ls->rw['ec_tt'],'in').HTML_BR.
							 Spn(ctjTx($___Ls->ls->rw['us_nm'].' '.$___Ls->ls->rw['us_ap'],'in')); 
					?>
	            </div>
	        </td>
            <td width="10%" align="left" nowrap="nowrap" ><?php echo ctjTx($___Ls->ls->rw['ecsnd_eml'],'in').HTML_BR.Spn($__tt_snd, 'ok', '_tx'); ?></td>
            <td width="1%" align="left" nowrap="nowrap" ><?php echo Spn(ctjTx($___Ls->ls->rw['__tot_apr'],'in'),'','_nmb'); ?></td>
            <td width="1%" align="left" nowrap="nowrap" ><?php echo Spn($___Ls->ls->rw['ecsnd_f'],'','_f') ?></td>
            <td width="1%" align="left" nowrap="nowrap" ><?php echo Spn($___Ls->ls->rw['ecsnd_h'],'','_f') ?></td>
			<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'dtl', 'shw' => 'ok' ]); ?></td>
        </tr>
        <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
        <?php $CntWb .= " $('#".TBGRP."_ec ._n').html(' (".$___Ls->qry->tot.")'); "; ?>
  	</tbody>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>

<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">

  <div id="<?php echo DV_GNR_FM.$__prfx_fm ?>">                      
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
      	<?php $___Ls->_bld_f_hdr(); ?>
	  	<div id="<?php echo DV_GNR_FM_CMP.$__prfx_fm ?>">

	  			
	  			<?php if($__dt_mdlcnt->cnt->sndi != 'ok'){ $__cls_lckd='ok'; $__col_hdr = 'ln_x4'; ?>
						
					<div class="no_sndi">Este usuario ha decidido no recibir más información de tu compañía</div>
	
				<?php 
					
					}else{
						
						$__col_hdr = 'ln_x4';
					
					} 
				
				?>
					
				<div class="<?php echo $__col_hdr; ?> <?php if($__dt_mdlcnt->cnt->sndi != 'ok'){ echo '_blck_ok'; } ?>">
					
                    <div class="col_1">
                        <?php
	                        
	                        if($___Ls->gt->m == 'ec_cmz'){ $_frm='ec_cmz'; }
	                         
	                        echo LsEc('ecsnd_ec','id_ec', $___Ls->dt->rw['ecsnd_ec'], '', '', '' , ['tp'=>$___Ls->gt->tsb, 'frm'=>$_frm]); 
	                        $CntWb .= JQ_Ls('ecsnd_ec',FM_LS_TRSTP);
	                        
	                    ?> 
                    </div>
                    <div class="col_2">
                        <?php echo LsCntEml(['cnt'=>$__dt_mdlcnt->cnt->id, 'id'=>'ecsnd_eml', 'va'=>$___Ls->dt->rw['ecsnd_eml']]); $CntWb .= JQ_Ls('ecsnd_eml', FM_LS_SLEML); ?> 
                    </div> 
                    <div class="col_3">
                        
                    	<?php echo SlDt([ 'id'=>'ecsnd_f', 'va'=>$___Ls->dt->rw['ecsnd_f'], 'rq'=>'ok', 'ph'=>TX_FPRG, 'lmt'=>'no', 'cls'=>CLS_CLND]);
                        		 //SlDt('mdlcntec_f', $___Ls->dt->rw['mdlcntec_f'], 'ok','', TX_F. TX_PRGMD, 'no','','','',CLS_CLND); 
                    	?>     
                    </div> 
					<div class="col_4">
						<?php echo SlDt([ 'id'=>'ecsnd_h', 'va'=>$___Ls->dt->rw['ecsnd_h'], 'rq'=>'ok', 't'=>'hr', 'ph'=>TX_HP, 'lmt'=>'no', 'cls'=>CLS_CLND]);
								 //SlDt('mdlcntec_h',$___Ls->dt->rw['mdlcntec_h'], 'ok','hr', TX_HR.TX_PRGMD, 'no','','','',CLS_HOUR); ?> 
                        <?php echo HTML_inp_hd('mdlcntec_mdlcnt', _SbLs_ID('i')); ?>
                        <?php echo HTML_inp_hd('___t_cnt', $__dt_mdlcnt->cnt->id); ?>
                        <?php echo HTML_inp_hd('___t_rlc', _SbLs_ID('i')); ?>
					</div>    
                </div>
                <div class="ln_1">
                	<iframe id="__html_ec" width="100%" height="1500" frameborder="0">Here</iframe>
                </div>
                	
                <?php 
	                $CntWb .= "
	                	
	                	$('#ecsnd_ec').change(function() {
						  	var __id = $(this).val();
						  	__ifr_ec(__id);
						});
						
						
						function __ifr_ec(_i){
						
							var __js_ls = '".Fl_Rnd(FL_JSON_GN.__t('ec',true))."&__ec_i='+_i+'&Rd='+Math.random();
						  	
						  	SUMR_Main.ld_abrt({ p:'cnt_ec' });
						
						  	SUMR_Main.ibx['cnt_ec'] =$.ajax({
											url: __js_ls,
											dataType: 'json',
								            cache: false,
								            success: function(d) {
									        	var __if_url = '".DMN_EC.LNK_HTML."/'+d.enc+'/'+'?_snd=ok&Rd='+Math.random();  
												$('#__html_ec').attr('src', __if_url);
										    }
										});
						}
	                 ";
	                
					 if($___Ls->dt->tot > 0){  $CntWb .= "__ifr_ec('".$___Ls->dt->rw['ecsnd_ec']."');"; }
                ?>
                
      </div>
    </form>
  </div>                
</div>

<style>
	
	.ln_x4._blck_ok{ pointer-events: none; opacity: 0.4; }
	
	
	.no_sndi{ border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; border: 1px solid rgba(255, 158, 0, 1); margin-top: 15px; margin-bottom: 15px; text-align: center; padding: 15px 0; font-size: 11px; }
	.no_sndi:before{ display: inline-block; width: 20px; height: 20px; margin-right: 10px; margin-bottom: -7px; background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'cnt_sndi_no.svg') ?>); background-repeat: no-repeat; background-position: center center; background-size: 100% auto; }
	
</style>
    

<?php } ?>
<?php } ?>