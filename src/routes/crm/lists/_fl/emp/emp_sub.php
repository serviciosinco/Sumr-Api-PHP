<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'empsub_nit, empsub_rs, empsub_dir, empsub_fnt, empsub_scec, empsub_faccnc';
	$___Ls->_strt();
	

	$__lsgt_flt_cmp = 'empsub_cd, empsub_faccnc, empsub_cls, empsub_est, empsub_sec, empsub_scec, empsub_emp';
	
	if(_Chk_GET('__i')){ $__fl .= _AndSql('empsub_emp', $_GET['__i']); }
	if(_Chk_GET('fl_empcd')){ $__fl .= _AndSql('empsub_cd', $_GET['fl_empcd']); }
	if(_Chk_GET('fl_empfaccnc')){ $__fl .= _AndSql('empsub_faccnc', $_GET['fl_empfaccnc']); }
	if(_Chk_GET('fl_empcls')){ $__fl .= _AndSql('empsub_cls', $_GET['fl_empcls']); }
	if(_Chk_GET('fl_empest')){ $__fl .= _AndSql('empsub_est', $_GET['fl_empest']); }
	if(_Chk_GET('fl_empsec')){ $__fl .= _AndSql('empsub_sec', $_GET['fl_empsec']); }
	if(_Chk_GET('fl_empscec')){ $__fl .= _AndSql('empsub_scec', $_GET['fl_empscec']); }
	
	$_dt_emp = GtEmpDt(_SbLs_ID('i'));
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM $__bd WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		$__tt_mre = ctjTx($___Ls->dt->rw['empsub_rs'],'in'); 
		
	}elseif($___Ls->_show_ls == 'ok'){ 
		 
		$Ls_Whr = "FROM ".MDL_EMP_SUB_BD.", ".MDL_EMP_EST_BD." WHERE empsub_est = id_empest AND ".$___Ls->ino." != '' $__fl ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
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
            <th width="0%" <?php echo NWRP ?>><?php echo TX_RS ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_FIN ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_FA ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_S ?></th>
            <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
        </tr>
	</thead>
	<tbody>
	<?php do { ?>
        <tr> 
            <td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
            <td align="left" <?php echo $_clr_rw ?>><?php if($___Ls->ls->rw['empsub_rs']!=''){echo ctjTx($___Ls->ls->rw['empsub_rs'],'in'); }else{ echo $_dt_emp->rs.Spn('('.TX_PC.')','','_f');} echo HTML_BR; if($___Ls->ls->rw['empsub_nit']!=''){echo Spn(ctjTx($___Ls->ls->rw['empsub_nit'],'in'),'','_f');} else { echo Spn($_dt_emp->nit ,'','_f');}?></td>
            <td width="1%" align="left" nowrap="nowrap" <?php echo $_clr_rw ?>><?php echo Spn($___Ls->ls->rw['empsub_fi']) ?></td>
            <td width="1%" align="left" nowrap="nowrap" <?php echo $_clr_rw ?>><?php echo Spn($___Ls->ls->rw['empsub_fa']) ?></td>
            <td width="1%" align="left" nowrap="nowrap" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['empest_nm'],'in'); ?></td>
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

    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >

    	<?php $___Ls->_bld_f_hdr(); ?>
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">

      	<?php echo bdiv(['cls'=>'bnr__emp']); ?>
      	<?php 
			$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); 
			$CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."'); "; 
		?>
        <div id="<?php echo $_id_tbpnl ?>" class="TabbedPanels TbCon">
              <ul class="TabbedPanelsTabGroup">
                    <li class="TabbedPanelsTab" id="<?php echo TBGRP ?>"><?php echo TX_DTSBSC ?></li>
              </ul>
              <div class="TabbedPanelsContentGroup">
                <div class="TabbedPanelsContent">

   					<div class="ln_1">         
                        <div class="col_1"> 
                            <?php 
								if($_dt_emp->tot_sub == 0){ $___nit_dflt = $_dt_emp->nit; $_cls_nt = '_hd'; }elseif($___Ls->dt->rw['empsub_nit'] == ''){ $_cls_nt = '_hd'; $_cls_frc = '_hd';  }else{ $___nit_dflt = $___Ls->dt->rw['empsub_nit']; }
								if($_dt_emp->tot_sub == 0){ $___rzn_dflt = $_dt_emp->rs; $_cls_rs = '_hd'; }else{ $___rzn_dflt = $___Ls->dt->rw['empsub_rs']; }
							?>
                            
                            <?php if($_cls_nt != ''){ echo OLD_HTML_chck('empsub_nit_chk', TX_NIT. TX_DFRT, $___Ls->dt->rw['empsub_nit_chk'], 'in'); } ?>
                            <?php if($_cls_rs != ''){ echo OLD_HTML_chck('empsub_rs_chk', TX_RS. TX_DFRT, $___Ls->dt->rw['empsub_rs_chk'], 'in', ['c'=>$_cls_frc]); } ?>
                            
							<?php echo HTML_inp_tx('empsub_nit', TX_NIT, ctjTx(  $___nit_dflt,'in'), '','', $_cls_nt); ?> 
                            <?php echo HTML_inp_tx('empsub_rs', TX_RS, ctjTx( $___rzn_dflt,'in'), '','', $_cls_rs.' '.$_cls_frc); ?>
							<?php 
								
								if($_dt_emp->tot_sub != ''){ $__hd_rs_js = " $('#empsub_rs_chk_div').addClass('_hd'); ";  }
									
								$CntJV .= "
									$('#empsub_nit_chk').change(function() {
										if(this.checked){
											$('#empsub_nit_chk_div').fadeOut('fast', function(){	$('#empsub_nit').removeClass('_hd');	});
											
											$('#empsub_rs').removeClass('_hd');
											{$__hd_rs_js}
										}
									});
									
									$('#empsub_rs_chk').change(function() {
										if(this.checked){
											$('#empsub_rs_chk_div').fadeOut('fast', function(){	$('#empsub_rs').removeClass('_hd');	});
										}
									});
									
									$('#empsub_dir_chk').change(function() {
										if(this.checked){
											$('#empsub_dir_chk_div').fadeOut('fast', function(){	$('#empsub_dir').removeClass('_hd');	});
										}
									});
									
							"; ?>
                            <?php echo HTML_inp_tx('empsub_dir', TX_DIRC, ctjTx($___Ls->dt->rw['empsub_dir'],'in'), '','',''); ?>
                            <?php echo HTML_inp_tx('empsub_fnt', TX_FNT, ctjTx($___Ls->dt->rw['empsub_fnt'],'in')); ?> 
                            <?php echo LsFacCnc('empsub_faccnc','id_faccnc', $___Ls->dt->rw['empsub_faccnc'], '', 2, 'ok'); $CntWb .= JQ_Ls('empsub_faccnc',FM_LS_SLFAC); ?>
                            
                    </div>
                    <div class="col_2">
                      		<?php 
								if($__lssb != 'ok'){
									echo LsCrr_Emp_Grp('empsub_emp','id_emp', $___Ls->dt->rw['empsub_emp'], '', 1); $CntWb .= JQ_Ls('empsub_emp',FM_LS_SLGRPEMP);
								}else{
									echo HTML_inp_hd('empsub_emp', _SbLs_ID('i'));
								}
							?>
                            <?php echo LsCdOld([ 'id'=>'empsub_cd', 'v'=>'id_siscd', 'va'=>$___Ls->dt->rw['empsub_cd'], 'rq'=>2 ]);
								 $CntWb .= JQ_Ls('empsub_cd',FM_LS_SLCD); 
							?>
                            <?php echo LsCrr_Emp_Cls('empsub_cls','id_empcls', $___Ls->dt->rw['empsub_cls'], '', 2); $CntWb .= JQ_Ls('empsub_cls',FM_LS_SLCLSTP); ?>
                            <?php echo LsCrr_Emp_Est('empsub_est','id_empest', $___Ls->dt->rw['empsub_est'], '', 1); $CntWb .= JQ_Ls('empsub_est',FM_LS_SLESTTP); ?>
                            <?php echo LsCrr_Emp_Sct('empsub_sec','id_empsct', $___Ls->dt->rw['empsub_sec'], '', 2); $CntWb .= JQ_Ls('empsub_sec',FM_LS_SLSC); ?>
                            <?php echo LsCrr_Emp_Scec('empsub_scec','id_empscec', $___Ls->dt->rw['empsub_scec'], '', 2, 'ok'); $CntWb .= JQ_Ls('empsub_scec',FM_LS_SLSCEC); ?>
                            
                            
                           
                	</div>
            </div>                  	 			 
        </div>
<?php } ?>
<?php } ?>

