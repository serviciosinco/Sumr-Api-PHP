<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->cnx->cl = 'ok';
	$___Ls->_strt();

	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM
						".TB_ENC_DTS.",
						".TB_ENC_CNT.",
						".TB_CNT.",
						".TB_CNT_EML.",
						".TB_SIS_FLD."
					WHERE 
						encdts_enccnt = id_enccnt
					AND enccnt_cnt = id_cnt
					AND cnteml_cnt = id_cnt
					AND encdts_fld = id_fld AND ".$___Ls->ik." = %s ", GtSQLVlStr($___Ls->gt->i, "text"));
		
		
	}elseif($___Ls->_show_ls == 'ok'){ 


		$Ls_Whr = " FROM ".TB_ENC_CNT.", ".TB_CNT.", ".TB_CNT_EML."
					WHERE enccnt_cnt = id_cnt AND cnteml_cnt = id_cnt AND enccnt_enc = ".GtSQLVlStr($_GET['__i'], "int")." ORDER BY id_enccnt DESC";		   
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";		
		
	} 
	
	$___Ls->_bld(); 


?>
<?php if($___Ls->ls->chk=='ok'){ ?>


<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>


<style>
	
	.icn_view{    
		width: 50px;
	    height: 35px;
	    display: block;
	    background-size: 30px;
	    background-repeat: no-repeat;
	    background-position: center;
	}
    
</style>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  <thead>
            <tr>
	            <?php if(ChckSESS_superadm()){ ?>
	            	<th width="3%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
	            <?php } ?>
                <?php if($__lssb != 'ok'){ ?>
                <th width="49%" <?php echo NWRP ?>><?php echo TX_PRG ?></th>
                <?php } ?>
                <th width="49%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
                <th width="49%" <?php echo NWRP ?>><?php echo TT_FM_EML ?></th>
                <th width="1%" <?php echo NWRP ?>></th>
                <th width="1%" <?php echo NWRP ?>></th>
            </tr>
  </thead>  
  <tbody>
		  <?php do { ?>

          	<tr>
		        <?php if(ChckSESS_superadm()){ ?>
	            <td width="3%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['id_fld'],'in'); ?></td>
	            <?php } ?>
	            <?php if($__lssb != 'ok'){ ?>
	            <td width="49%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw[$___Ls->mdlstp->tp.'_nm'],'in'); ?></td>
	            <?php } ?>
	            <td width="49%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['cnt_nm'].' '.$___Ls->ls->rw['cnt_ap'],'in'); ?></td>
	            <td width="49%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['cnteml_eml'],'in'); ?></td>
	            <td width="1%" align="left" <?php echo $_clr_rw ?>><a class="icn_view" href="javascript:void(0);"></a></td>
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

  	<div id="<?php echo DV_GNR_FM.$__prfx_fm ?>">                      
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
      <?php /*$___Ls->_bld_f_hdr(); */?>
      	<div id="<?php echo DV_GNR_FM_CMP.$__prfx_fm ?>">

			<div class="ln_1">
                <div class="col_1"> 
                	
                	<ul class="ls_1" style='white-space:normal;'>
                		<li><?php echo Strn(TT_FM_NM).': '.ctjTx($___Ls->dt->rw['cnt_nm'].' '.$___Ls->dt->rw['cnt_ap'],'in'); ?></li><br>
						<li><?php echo Strn(TT_FM_EML).': '.ctjTx($___Ls->dt->rw['cnteml_eml'],'in'); ?></li><br>
                	</ul>
                	
					
                </div>
                <div class="col_2"> 
					<ul class="ls_1" style='white-space:normal;'>
						<?php do { ?>
						<?php if(is_numeric($___Ls->dt->rw['encdts_dts'])){
							$rsp = GtFldLstDt(['id'=>$___Ls->dt->rw['encdts_dts']]);
							$dts = $rsp->tt;			
						}else{
							$dts = ctjTx($___Ls->dt->rw['encdts_dts'],'in');	
						} ?>
                		<li><?php echo Strn(ctjTx($___Ls->dt->rw['sisfld_tt'],'in')).':<br>'.$dts; ?></li><br>
						<?php } while ($row_Dt_Rg = $Dt_Rg->fetch_assoc()); ?>
                	</ul>	
                </div>
			</div>    
      	</div>

    </form>
  	</div>

</div>
<?php } ?>
<?php } ?>