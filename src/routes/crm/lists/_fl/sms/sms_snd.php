<?php 
	
if(class_exists('CRM_Cnx')){

	$___Ls->cnx->cl = 'ok';	
	$___Ls->sch->f = 'smssnd_msj, smssnd_cel';
	$___Ls->_strt();
	
	//__AutoRUN([ 't'=>'sms_snd' ]);	

	if(_SbLs_ID('i')){ 
		$__fl .= " AND id_smssnd IN ( SELECT mdlcntsms_snd FROM ".MDL_PRO_CNT_SMS_BD." WHERE mdlcntsms_mdlcnt = '"._SbLs_ID('i')."') "; 
		$__dt_rlccnt = GtMdlCntDt([ 'id'=>_SbLs_ID('i'), 'shw'=>[ 'cnt'=>'ok' ] ]);
		$__dt_rlccnt_tp = $__dt_rlccnt->apr->mdl_tp;
	}
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_SMS_SND." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		

	}elseif($___Ls->_show_ls == 'ok'){ 


		$Ls_Whr = "FROM ".TB_SMS_SND.", ".MDL_SMS_SND_CMPG_BD.", "._BdStr(DBM).TB_SIS_SLC.", ".MDL_TB_SMS_CMPG_BD." WHERE smssndcmpg_cmpg = $__i AND smssnd_est = id_sisslc AND smssndcmpg_cmpg = id_smscmpg AND id_smssnd = smssndcmpg_snd AND ".$___Ls->ino." != '' $_f_tp $__fl ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT."  $Ls_Whr";
	
	} 
	
	$___Ls->_bld(); 

?>
<?php if($___Ls->ls->chk=='ok'){ ?>

<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg LsRgNw">
  	<tbody>
		<?php do { ?>
        <tr>
            <td align="left" <?php echo $_clr_rw ?> class="__sgm_ls"><?php?></td>
            <td align="left" <?php echo NWRP.$_clr_rw ?>><?php echo Strn(ctjTx($___Ls->ls->rw['smssnd_cel'],'in')).HTML_BR.Spn(TX_CEL) ?></td>

            <td align="left" <?php echo NWRP.$_clr_rw ?>></td>
            <td align="left" <?php echo NWRP.$_clr_rw ?>><?php echo Spn('','','_tt_icn _tt_icn_sms_tmpl'); ?></td>

			<td align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['smssnd_msj'],'in').HTML_BR.Spn(TX_MSJ) ?></td>
            <td align="left" <?php echo NWRP.$_clr_rw ?>><?php echo Strn($___Ls->ls->rw['sissmscmpgest_nm']).HTML_BR.Spn(TX_S) ?></td>
        	<?php if($___Ls->ls->rw['smscmpg_est'] != 1){ ?>
		        <td width="1%" align="left" <?php echo NWRP.$_clr_rw ?>><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
	        <?php } ?>
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
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
     <?php $___Ls->_bld_f_hdr(); ?>       

	  <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
        <div class="ln_1">
	          
	          <div class="<?php echo $_cls_bxcnt ?> ln_1 __setup _hdr_sms" id="__edt_stp">
			 				<div class="col_1">
								<div class="_MblBx">
									<div class="_Hdr"></div>
									<div class="_Bdy">
										<div class="_Lft"></div>
										<div class="_Msj">
											<div class="_MsjBx" id="_MsjBxPop"></div>
										</div>
										<div class="_Rgh"></div>
									</div>
									<div class="_MsjCountBx" id="_MsjCountBx"><?php echo TX_NCRACT ?></div>
								</div>	
							</div>
							<div class="col_2">
								<?php echo h2(TX_DTSBSC); ?> 
								
								
								<?php echo HTML_inp_hd('id_cmpg', $__i); ?>
						        <?php echo HTML_inp_hd('cpmg_f', $___Ls->dt->rw['smscmpg_p_f']); ?>
						        <?php echo HTML_inp_hd('cpmg_h', $___Ls->dt->rw['smscmpg_p_h']); ?>
					          	<?php echo HTML_inp_tx('smssnd_cel', TX_CEL, ctjTx($___Ls->dt->rw['smssnd_cel'],'in'), FMRQD); ?>
								
								
								<?php echo HTML_inp_hd('___t_cnt', $__dt_rlccnt->cnt->id); ?>
								<?php echo HTML_inp_hd('___t', $__prfx->prfx3_c); ?>
								<?php echo HTML_inp_hd('___t_rlc', _SbLs_ID('i')); ?>
								
								
								<div class="__msj_cel"><?php echo HTML_textarea('smssnd_msj', TX_MSJ, ctjTx($___Ls->dt->rw['smssnd_msj'],'in'), '', 'no', '', 5, 160); ?> </div>
									
							</div>
							<?php 	
							  
								$CntWb .= "
										SUMR_Main.sms.bld({	
											bx:{
												msj:'_MsjBxPop',
												cnt:'_MsjCountBx'
											},
											msj:'smssnd_msj',
											_c:function(){
												
											}	
										});	
								";
									
					  		?>							  		
				</div>
				
        </div>
      </div>
        
    </form>
  </div>

</div>
<?php } ?>
<?php } ?>
