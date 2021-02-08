<?php
if(class_exists('CRM_Cnx')){

	$___Ls->_strt();
	
	if(_SbLs_ID('i')){ $__fl .= _AndSql('ustkn_us', _SbLs_ID('i')); }
	
	if(!isN($___Ls->gt->i)){	
		
		 $___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_US_TKN." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
		 
		$Ls_Whr = "FROM "._BdStr(DBM).TB_US_TKN."
						INNER JOIN "._BdStr(DBM).TB_US." ON ustkn_us = id_us
						INNER JOIN "._BdStr(DBM).TB_CL." ON ustkn_cl = id_cl
				   WHERE id_ustkn != '' AND cl_enc = '".DB_CL_ENC."' $__fl ".$___Ls->sch->cod." 
				   ORDER BY ".$___Ls->ino." DESC";	
				   	   
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
                <th width="1%" <?php echo NWRP ?>><?php echo TX_FIN ?></th>
                <?php if($__lssb != 'ok'){ ?>
                <th width="49%" <?php echo NWRP ?>><?php echo TX_US ?></th>
                <?php } ?>
                <!--<th width="49%" <?php echo NWRP ?>><?php echo TX_USTKN ?></th>
                <th width="1%" <?php echo NWRP ?>><?php echo TX_PSSW ?></th>-->
                <th width="1%" <?php echo NWRP ?>></th>
            </tr>
  </thead>  
  <tbody>
		<?php do { ?>
        <tr>

            <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>

            <td width="1%" align="left" nowrap="nowrap" <?php echo $_clr_rw ?>><?php echo Spn($___Ls->ls->rw['ustkn_fi'], '_f'); ?></td>
            <?php if($__lssb != 'ok'){ ?>
            <td width="49%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['us_nm'].' '.$___Ls->ls->rw['us_ap'],'in'); ?></td>
            <?php } ?>
            
            <!--<td width="49%" align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw['ustkn_key']; ?></td>
            <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw['ustkn_pass'] ?></td>-->

            <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'dtl' ]); ?></td>

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
      <?php $___Ls->_bld_f_hdr(); ?>

      <div id="<?php echo DV_GNR_FM_CMP.$__prfx_fm ?>" class="<?php echo DV_GNR_FM_CMP ?>">

				<div class="ln_1">
                			 <?php echo HTML_inp_hd('ustkn_us', _SbLs_ID('i')); ?>
                             <?php echo h2(TX_GNRTK); ?>
                </div>
                
      </div>
    </form>
  </div>

</div>
<?php } ?>
<?php } ?>