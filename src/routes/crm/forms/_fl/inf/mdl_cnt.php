<?php 
if(class_exists('CRM_Cnx')){
	
	$_inf = $__f;
	$__bd = TB_MDL_CNT; 
	$__bd2 = 'sis_tp'; 
	$__bd3 = '_mdl';
	$__bd4 = 'cnt';
	$__bd5 = 'sis_cnt_est';
	
	if(_Chk_GET('_sistp')){ $__fl .= _AndSql('id_mdl', $_GET['_sistp']); }
	
	
	$Ls_Whr = "FROM cnt
				INNER JOIN _mdl_cnt ON mdlcnt_cnt = id_cnt
				INNER JOIN ".DBM."._sis_cnt_est ON id_siscntest = mdlcnt_est
				INNER JOIN _mdl ON id_mdl = mdlcnt_mdl
				INNER JOIN sumr_bd._mdl_s ON id_mdls = mdl_mdls
				INNER JOIN sumr_bd._mdl_s_tp ON id_mdlstp = mdls_tp 
				$__fl
				ORDER BY id_mdlcnt DESC , mdlcnt_fa DESC"; 
	
	$Ls_Qry = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr "; 
	$Ls_Rg = $__cnx->_qry($Ls_Qry); $row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	QuPgsi($_GET['totRws'],$row_Ls_Rg['__rgtot'],SIS_NMRG,$_SERVER['QUERY_STRING']); $Pgs = RcPg($_GET['pgN'],LS_QR,TT_PGS, FL_LS_GN);
	
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
	<?php if(($___Ls->qry->tot > 0)){ ?>

   	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg"> 
    	<tr>
            <th nowrap="nowrap" <?php echo $__xl_tt ?> width="10%"><?php echo TX_CNT ?></th>
            <th nowrap="nowrap" <?php echo $__xl_tt ?> width="10%"><?php echo TX_EST ?></th>
            <th nowrap="nowrap" <?php echo $__xl_tt ?> width="10%"><?php echo TX_FI ?></th>
        </tr>
    <?php $_i = 1; do { ?> 
	    <tr <?php  echo ' class="Rw_'.$Nm.'" ';  ?>>
		    <td align="left" nowrap="nowrap" <?php echo $_rw_sty ?>><?php echo ctjTx($row_Ls_Rg['cnt_nm']." ".$row_Ls_Rg['cnt_ap'],'in') ?></td> 
	        <td align="left" nowrap="nowrap" <?php echo $_rw_sty ?>><?php echo ctjTx($row_Ls_Rg['siscntest_tt'],'in') ?></td> 
	        <td align="left" nowrap="nowrap" <?php echo $_rw_sty ?>><?php echo ctjTx($row_Ls_Rg['cnt_fi'],'in') ?></td>
	    </tr>
    <?php  } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());  ?>
    </table>
		
	<?php } ?>
	
	
	<?php //echo HTML_Ls_Nr(TT_RWS); ?>
    <?php } ?>
    
<?php } $Ls_Rg->free; $Ls_Hst_Rg->free;  ?>