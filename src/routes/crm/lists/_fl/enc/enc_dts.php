<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->tt = TX_RPTSABRT;
	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'encdts_dts';
	$___Ls->_strt();
	

	if(!isN($___Ls->gt->i)){
			
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_ENC_DTS.", ".DBM."._sis_qly, ".TB_SIS_FLD." WHERE encdts_fld = id_fld AND encdts_qly = id_qly AND ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	
	}elseif($___Ls->_show_ls == 'ok'){ 
		
		$Ls_Ec_Cnt_Nm = ", (SELECT cnt_nm FROM ".TB_CNT." WHERE id_cnt = enccnt_cnt) AS _ec_cnt_nm ";
		$Ls_Ec_Cnt_Ap = ", (SELECT cnt_ap FROM ".TB_CNT." WHERE id_cnt = enccnt_cnt) AS _ec_cnt_ap ";
		
		$Ls_Whr = "	FROM ".TB_ENC_DTS." 
						INNER JOIN ".TB_ENC_CNT." ON encdts_enccnt = id_enccnt
						INNER JOIN ".TB_ENC." ON enccnt_enc = id_enc
						INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON enc_mdlstp = id_mdlstp
						INNER JOIN "._BdStr(DBM).TB_SIS_QLY." ON encdts_qly = id_qly
						INNER JOIN ".TB_SIS_FLD." ON encdts_fld = id_fld
					WHERE (fld_tp = 1 OR fld_tp = 2) AND mdlstp_tp = '".$___Ls->gt->tsb."' ".$___Ls->sch->cod." 
					ORDER BY ".$___Ls->ino." DESC";
					
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Ec_Cnt_Nm $Ls_Ec_Cnt_Ap $Ls_Whr"; 
		

	} 
	
	$___Ls->_bld(); 
?>
<?php if($___Ls->ls->chk=='ok'){ ?>

<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  <tr>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    <th width="10%" <?php echo NWRP ?>><?php echo  TX_NM ?></th>
    <th width="40%" <?php echo NWRP ?>><?php echo TX_PRGT ?></th>
    <th width="40%" <?php echo NWRP ?>><?php echo TX_RSPST ?></th>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_CLR ?></th>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_CLDD ?></th>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_FI ?></th>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_MDFCD ?></th>
  </tr>
  <?php do { ?>

  <tr <?php /* cl('javascript:'.PgRg($__ls, __t($__bdtp).ADM_LNK_DT.$___Ls->ls->rw[$___Ls->ino],1),$Nm); */?>>
    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>

    <td width="10%" align="left" ><?php echo ctjTx($___Ls->ls->rw['_ec_cnt_nm']." ".$___Ls->ls->rw['_ec_cnt_ap'],'in'); ?></td>
    <td width="40%" align="left" ><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisfld_tt'],'in'),150,'Pt', true); ?></td>
    <td width="40%" align="left" ><?php echo ShortTx(ctjTx($___Ls->ls->rw['encdts_dts'],'in'),150,'Pt', true); ?></td>
    <?php if(_ChckMd('enc_dts_mod')){ ?>
	    <td width="1%" align="left" <?php echo $_clr_rw ?> class="chng_clr">

		    <div class="chng_clr_new" rel="<?php echo $___Ls->ls->rw[$___Ls->ino]; ?>">

		    	<?php echo Spn('','', '_clr_icn chng_clr_slc chng_clr_bad','background-color:#E04F5F; '); ?>
		    	<?php echo Spn('','', '_clr_icn chng_clr_slc chng_clr_ntr','background-color:#AFAFAF; '); ?>
		    	<?php echo Spn('','', '_clr_icn chng_clr_slc chng_clr_god','background-color:#43B05C; '); ?>
		    </div>

		    <?php echo Spn('','', '_clr_icn _clr_icn_'.$___Ls->ls->rw[$___Ls->ino] ,'background-color:'.$___Ls->ls->rw['qly_clr'].'; '); ?>
		</td>
	<?php } ?>
    <td width="1%" align="left" nowrap="nowrap" class="_qly_txt_<?php echo $___Ls->ls->rw[$___Ls->ino]; ?>"><?php echo ShortTx(ctjTx($___Ls->ls->rw['qly_tt'],'in'),100,'Pt', true); ?></td>
    
    <td width="1%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['encdts_fi'],'in'),150,'Pt', true); ?></td>
    <td width="1%" align="left" <?php echo $_clr_rw ?> class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
  </tr>
  <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>

<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>

<style>
	.chng_clr_new{ width: 90px;
    height: 28px;
    background: #f4f4f4;
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    border-radius: 10px;
    display: none;
    position: absolute;
    left: 50%;
    margin-left: -47px;
    padding-top: 7px;
    top: -28px;
    border: 1px solid gray; }
	._clr_icn:Hover{ opacity: 0.7;}
	._clr_icn{ cursor: pointer;  }
	.chng_clr_new:before {
    content: "";
    position: absolute;
    left: 46%;
    top: 26px;
    width: 0;
    height: 0;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-top: 8px solid grey;
}
.chng_clr{ 	position: relative; }
</style>

<?php 
	$CntWb .= "
		$('.chng_clr').hover(
			function(){
				$(this).find('.chng_clr_new').show();
			}, function(){
				$(this).find('.chng_clr_new').hide();
			}
		);
		
		$('.chng_clr_slc').click(function(){
			var _id = $(this).parent('.chng_clr_new').attr('rel');
			
			if($(this).hasClass('chng_clr_god')){
				var _clr = '_god';
			}else if($(this).hasClass('chng_clr_ntr')){
				var _clr = '_ntr';
			}else if($(this).hasClass('chng_clr_bad')){
				var _clr = '_bad';
			}
			
			$.ajax({
				type:'POST',
				url: '".Fl_Rnd(FL_JSON_GN.__t('enc_dts',true))."',
				data: { '_i':_id, '_tp':'_chng_clr', '_clr':_clr},
				beforeSend: function() {
				 				 },
				success:function(rsp){
					if(rsp.e == 'ok'){
						
						$('._clr_icn_'+_id).css({ 'background': rsp.clr_tt });
						$('._qly_txt_'+_id).html(rsp.qly_tt);
						
						
					}else{
						swal(' ".TX_ERROR." !', '".TX_ERMDFCR."', 'error'); 
					}
					 
				}
			});
		});
		
	";
?>

<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
	
  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >

    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
       <?php $___Ls->_bld_f_hdr(); ?>

      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	  
        <div class="ln_1">
          <div class="col_1">
            <?php echo LsSisQly('encdts_qly','id_qly', $___Ls->dt->rw['encdts_qly'], '', 1); $CntWb .= JQ_Ls('encdts_qly',FM_LS_SLFLD_TP); ?>
          </div>
          <div class="col_2">
	          <ul class="ls_1" style='white-space:normal;'>
		            <li><?php echo Strn(TX_PRGT).': '.ctjTx($___Ls->dt->rw['sisfld_tt'],'in'); ?></li><br>
		            <li><?php echo Strn(TX_RSPST).': '.ctjTx($___Ls->dt->rw['encdts_dts'],'in'); ?></li>
               </ul>
		  </div>
        </div>
      </div>
    </form>
  </div>
</div>

<?php } ?>
<?php } ?>
