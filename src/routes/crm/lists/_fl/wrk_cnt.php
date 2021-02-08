
<?php
	
if(class_exists('CRM_Cnx')){
	
	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'wrkcnt_nm';
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_WRK_CNT.", ".TB_SIS_CNT_EST."  WHERE wrkcnt_est = id_siscntest AND ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){  
			
		$Ls_Whr = "FROM ".TB_WRK_CNT.", ".TB_SIS_CNT_EST."  WHERE wrkcnt_est = id_siscntest AND ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 
			

	} 
	
	$___Ls->_bld();
	
?>
<?php if($___Ls->ls->chk=='ok'){ ?>

<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  <tr>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    <th width="20%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
    <th width="20%" <?php echo NWRP ?>><?php echo TX_ESTS ?></th>
  </tr>
  <?php do { ?>
  
	  <?php $_clr_rw = NULL; $_clr_rw = ' style="background-color:'.$___Ls->ls->rw['siscntest_clr_bck'].';border: 1px solid white;"     '; ?>

	  <tr <?php  cl('javascript:'.PgRg($__ls, __t($__bdtp).ADM_LNK_DT.$___Ls->ls->rw[$___Ls->ino],1),$Nm); ?> <?php echo $_clr_rw ?>>
    <td style=" padding: 8px 0px " width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>

    <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['wrkcnt_nm'],'in'),150,'Pt', true); ?></td>
    <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['siscntest_tt'],'in'),150,'Pt', true); ?></td>
  </tr>
  <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>

<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>

<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>


<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">

  <div id="<?php  echo DV_GNR_FM ?>">
    
    
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
       	<?php $___Ls->_bld_f_hdr(); ?>

      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	  
        <div class="ln_1">
          <div class="col_1">
	          
		        <ul class="ls_1" >
			        
			        
			        <li id="_li_nm"><?php  echo Strn(TX_FIN,'',true).ctjTx($___Ls->dt->rw['wrkcnt_fi'],'in'); ?></li>
			        <li id="_li_nm"><?php  echo Strn(TX_NM,'',true).ctjTx($___Ls->dt->rw['wrkcnt_nm'],'in'); ?></li>
			        <li id="_li_ap"><?php  echo Strn(TX_CEL,'',true).ctjTx($___Ls->dt->rw['wrkcnt_cel'],'in');  ?></li>
			        <li id="_li_ap"><?php  echo Strn(TT_FM_EML,'',true).ctjTx($___Ls->dt->rw['wrkcnt_eml'],'in');  ?></li>
			        <li id="_li_ap"><?php  echo Strn(TX_CRG,'',true).ctjTx($___Ls->dt->rw['wrkcnt_crg'],'in');  ?></li>
			        <?php echo HTML_BR; ?>
			        
			
								        
			</ul> 
	          
	          
	        
          </div>
          <div class="col_2">
	          <style>
		          
		          a.file{     width: 180px;
    height: 180px;
    display: block;
    margin: 0 auto;
    background-repeat: no-repeat;
    background-image: url(DMN_IMG_ESTR_SVG.'wrk_cnt.svg');
    background-size: 115px;
    background-position: center;
    background-color: #d7deed;
    padding: 63px;
    border-radius: 50%;
    margin-top: 40px;
    font-size: 0;
    cursor: pointer; }
    		a.file:hover{  background-color: #d0d7e4; }
		          
	          </style>
		  		<a class="file" href="<?php echo $___Ls->dt->rw['wrkcnt_fld']; ?>" target="_blank"><?php echo TX_ARCHVS ?></a>
           
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
