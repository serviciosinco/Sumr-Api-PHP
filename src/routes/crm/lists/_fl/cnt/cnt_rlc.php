<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'cnt_nm, cnt_ap, cnt_cel, cnt_tel, cnt_depto, cnt_mail';
	$___Ls->_strt();
	
	$__lsgt_flt_cmp = 'cntrlc_cnt';
	
	if(_Chk_GET('fl_cntrlcemp')){ $__fl .= _AndSql('cntrlc_cnt', $_GET['fl_cntrlcemp']); }
	if(_SbLs_ID('i')){ $__fl .= _AndSql('cntrlc_cnt', _SbLs_ID('i')); }

	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_CNT_RLC_BD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 


		$Ls_Whr = "FROM ".TB_CNT_RLC_BD.", ".TB_CNT." WHERE cntrlc_cnt = id_cnt AND ".$___Ls->ino." != '' $__fl ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 
		
	}
	
	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
	<thead>
        <tr>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
            <th width="90%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TT_FM_ID ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TT_FM_RLC ?></th>

			<th width="1%" <?php echo NWRP ?>>&nbsp;</th>
        </tr>
	</thead>
	<tbody>
	  	<?php do { ?>
	 		<?php            
                $__cnt = GtCntDt([  'id'=>$___Ls->ls->rw['cntrlc_cnt'] ]);    
                $__rlc_cnt = GtCntDt([  'id'=>$___Ls->ls->rw['cntrlc_rlc_cnt'] ]);    
            ?>
		<tr>
	        <td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
	        <td align="left" <?php echo $_clr_rw ?>><?php echo $__rlc_cnt->nm.' '.$__rlc_cnt->ap; ?></td>
	        <td align="left" <?php echo $_clr_rw ?>><?php echo $__rlc_cnt->dc; ?></td>
	        <td align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['cntrlc_rlc'],'in'); ?></td>
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
      
        <div class="ln_1">
          <div class="col_1"> 
                <?php 
					if($__lssb != 'ok'){
						echo LsCnt('cnt','id_cnt', $___Ls->dt->rw['cntrlc_cnt'], '', 2); $CntWb .= JQ_Ls('cntrlc_cnt', FM_LS_SLCNT);
					}else{
						echo HTML_inp_hd('cntrlc_cnt', _SbLs_ID('i'));
					}
				?>
          		<?php echo HTML_inp_tx('cntrlc_rlc', TT_FM_RLC, ctjTx($___Ls->dt->rw['cntrlc_rlc'],'in'), FMRQD); ?>
          </div>
          <div class="col_2">  
                <?php 
	                echo LsCnt('cntrlc_rlc_cnt','id_cnt', $___Ls->dt->rw['cntrlc_rlc_cnt'], '', 2, ['_f'=>' AND cnt_tp = 2 '] ); $CntWb .= JQ_Ls('cntrlc_rlc_cnt', FM_LS_SLCNT); 
	                echo OLD_HTML_chck('cntrlc_rcg', TX_ALLWRCG, $___Ls->dt->rw['cntrlc_rcg'], 'in');
                ?>
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
