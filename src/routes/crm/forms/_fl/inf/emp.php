<?php 
if(class_exists('CRM_Cnx')){

	$_inf = $__f;
	$__id = 'id_emp'; 
	$__nm = 'emp_rs'; 
	$__f = 'emp_fi'; 
	$__bd = MDL_EMP_BD; 
	$__bd2 = MDL_EMP_SUB_BD; 
	$__bd3 = TB_EMP_CNT;
	$__bd4 = 'sis_emp_sct';
	
	// Mes Inicial
	$f1 = Php_Ls_Cln($_GET['_f_in']); 
	$f2 = Php_Ls_Cln($_GET['_f_out']);
	
	// Todos los datos del año actual
	$_now_f1 = date('Y-m-d', strtotime($f1));
	$_now_f2 = date('Y-m-d', strtotime($f2));
	
	if($_now_f1 != '' && $_now_f2 != ''){ 
		$_f_grp .= " AND ($__f BETWEEN '".$_now_f1."' AND '".$_now_f2."') ";  
	}elseif($_now_f1 != '' && $_now_f2 != ''){ 
		$_f_grp .= " AND $__f = '".$_now_f1."' "; 
	}
		
	
	$Ls_Whr = "FROM $__bd, $__bd2, $__bd3, $__bd4
				WHERE 
				empsub_emp =  $__id AND
				empsub_sec =  id_empsct AND
				empcnt_emp = id_empsub $_f_grp"; 
	
	$Ls_Qry = "SELECT *, (SELECT COUNT(*) $Ls_Whr) 
	AS ".QRY_RGTOT." $Ls_Whr GROUP BY $__id ORDER BY $__nm ASC";
	$Ls_Rg = $__cnx->_qry($Ls_Qry); $row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	QuPgsi($_GET['totRws'],$row_Ls_Rg['__rgtot'],SIS_NMRG,$_SERVER['QUERY_STRING']); $Pgs = RcPg($_GET['pgN'],LS_QR,TT_PGS, FL_LS_GN);

?>
<?php if($___Ls->ls->chk=='ok'){ ?>

	<?php if(($___Ls->qry->tot > 0)){ ?>

   	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg"> 
    	<tr>
    	    <th nowrap="nowrap" <?php echo $__xl_tt ?> width="10%"><?php echo MDL_EMP_GRP ?></th>
            <th nowrap="nowrap" <?php echo $__xl_tt ?> width="10%"><?php echo MDL_EMP ?></th>
            <th nowrap="nowrap" <?php echo $__xl_tt ?> width="10%"><?php echo TX_SCT ?></th>
            <th nowrap="nowrap" <?php echo $__xl_st ?> class="_sb" width="10%"><?php echo TX_OFRTS ?></th>
            <?php //if(ChckSIS_v(2)){ ?>
            	<th nowrap="nowrap" <?php echo $__xl_tt ?> width="20%"><?php echo TX_TP.' '.TX_OFRTS ?></th>
                <th nowrap="nowrap" <?php echo $__xl_tt ?> width="10%"><?php echo TX_S.' '.TX_OFRTS ?></th>
			<?php //} ?>
            <th nowrap="nowrap" <?php echo $__xl_tt ?> width="10%"><?php echo TX_CNT ?></th>
            <th nowrap="nowrap" <?php echo $__xl_tt ?> width="5%"><?php echo TX_CRG ?></th>
            <th nowrap="nowrap" <?php echo $__xl_tt ?> width="5%"><?php echo TX_CEL ?></th>
            <th nowrap="nowrap" <?php echo $__xl_tt ?> width="5%"><?php echo TX_TEL ?></th>
            <th nowrap="nowrap" <?php echo $__xl_tt ?> width="10%"><?php echo TT_FM_EML ?></th>
            <th nowrap="nowrap" <?php echo $__xl_tt ?> width="5%"><?php echo TX_DEPTO ?></th>
            <th nowrap="nowrap" <?php echo $__xl_st ?> class="_sb" width="10%"><?php echo TX_VST?></th>
            <?php //if(ChckSIS_v(2)){ ?>
            	<th nowrap="nowrap" <?php echo $__xl_tt ?> width="20%"><?php echo TX_CRDN ?></th>
                <th nowrap="nowrap" <?php echo $__xl_tt ?> width="10%"><?php echo TX_FVST ?></th>
			<?php //} ?>
            <?php /* ?>
            <th nowrap="nowrap" <?php echo $__xl_st ?> class="_sb" width="10%"><?php echo TX_LNE ?></th>
            <?php */ ?>
	    </tr>
    <?php $_i = 1; do { ?> 
    <tr <?php  echo ' class="Rw_'.$Nm.'" ';  ?> >
        <?php 				
			$_rw_sty = ${'__xl_td_rw_'.$Nm};
			$subemp = GtEmpSubDt($row_Ls_Rg[id_empsub]);
		?>
        <td align="left" <?php echo $_rw_sty ?> class="_lft"><?php echo ctjTx($row_Ls_Rg[$__nm],'in') ?></td>
        <td align="left" <?php echo $_rw_sty ?> class="_lft"><?php echo ctjTx($row_Ls_Rg[empsub_rs],'in') ?></td>
        <td align="left" <?php echo $_rw_sty ?> class="_lft"><?php echo ctjTx($row_Ls_Rg[empsct_nm],'in') ?></td>
        <?php //if(ChckSIS_v(2)){ 
			$empofr = $row_Ls_Rg['id_empsub'];
            $Ls_Whr_ofr = "FROM emp_ofr
                        WHERE ofr_emp = $empofr"; 
            $Ls_Qry_ofr = "SELECT *, (SELECT COUNT(*) $Ls_Whr_ofr) AS ".QRY_RGTOT."_ofr $Ls_Whr_ofr ORDER BY ofr_fs ASC";
            $Ls_Rg_ofr = $__cnx->_qry($Ls_Qry_ofr); $row_Ls_Rg_ofr = $Ls_Rg_ofr->fetch_assoc(); $Tot_Ls_Rg_ofr = $Ls_Rg_ofr->num_rows;
            QuPgsi($_GET['totRws'],$row_Ls_Rg_ofr['__rgtot_ofr'],SIS_NMRG,$_SERVER['QUERY_STRING']); ?>
        <td nowrap="nowrap" <?php echo $_rw_sty ?>><?php echo $row_Ls_Rg_ofr['__rgtot_ofr']; ?> </td>
        <?php 
			$_ofr_est=''; $_ofr_tt='';	
			$_i_ofr = 1; do {
				$_ofr = GtOfrDt($row_Ls_Rg_ofr['id_ofr']);
        		$_ofr_tt .= $_ofr->tt.'<br>';
        		if ($_ofr->est != ''){ $_ofr_est .= $_ofr->est.'<br>'; }
			} while ($row_Ls_Rg_ofr = $Ls_Rg_ofr->fetch_assoc()); 
		?>
        <td <?php echo $_rw_sty ?>> <? echo $_ofr_tt; ?></td>
        <td <?php echo $_rw_sty ?>> <? echo $_ofr_est; ?></td>
        <?php //} ?>
        <td align="left" <?php echo $_rw_sty ?> class="_lft"><?php echo ctjTx($row_Ls_Rg[empcnt_nm],'in').' '.ctjTx($row_Ls_Rg[empcnt_ap],'in') ?></td>
        <td align="left" <?php echo $_rw_sty ?> class="_lft"><?php echo ctjTx($row_Ls_Rg[empcnt_crg],'in') ?></td>
        <td align="left" <?php echo $_rw_sty ?> class="_lft"><?php echo ctjTx($row_Ls_Rg[empcnt_cel],'in') ?></td>
        <td align="left" <?php echo $_rw_sty ?> class="_lft"><?php echo ctjTx($row_Ls_Rg[empcnt_tel],'in') ?></td>
        <td align="left" <?php echo $_rw_sty ?> class="_lft"><?php echo ctjTx($row_Ls_Rg[empcnt_mail],'in') ?></td>
        <td align="left" <?php echo $_rw_sty ?> class="_lft"><?php echo ctjTx($row_Ls_Rg[empcnt_depto],'in') ?></td>
        <?php //if(ChckSIS_v(2)){ 

			$cntvst = $row_Ls_Rg[id_empcnt];

            $Ls_Whr_sub = "FROM emp_vst
                        WHERE empvst_cnt = $cntvst"; 
            $Ls_Qry_sub = "SELECT *, (SELECT COUNT(*) $Ls_Whr_sub) AS ".QRY_RGTOT."_sub $Ls_Whr_sub ORDER BY id_empvst ASC";
            $Ls_Rg_sub = $__cnx->_qry($Ls_Qry_sub); $row_Ls_Rg_sub = $Ls_Rg_sub->fetch_assoc(); $Tot_Ls_Rg_sub = $Ls_Rg_sub->num_rows;
            QuPgsi($_GET['totRws'],$row_Ls_Rg_sub['__rgtot_sub'],SIS_NMRG,$_SERVER['QUERY_STRING']); 
        
        ?>
        <td nowrap="nowrap" <?php echo $_rw_sty ?>><?php echo $row_Ls_Rg_sub['__rgtot_sub']; ?> </td>
        <?php 
			$_coord=''; $_fvst='';	
			$_i_vst = 1; do {
				$vsts = GtVstDt($row_Ls_Rg_sub['id_empvst']);
        		$_coord .= $vsts->us->nm_fll.'<br>';
        		if ($vsts->f != ''){ $_fvst .= $vsts->f.' ('.$vsts->est.')<br>'; }
			} while ($row_Ls_Rg_sub = $Ls_Rg_sub->fetch_assoc()); 
		?>
        <td <?php echo $_rw_sty ?>> <? echo $_coord; ?></td>
        <td <?php echo $_rw_sty ?>> <? echo $_fvst; ?></td>
        <?php //} ?>
        
		
    </tr>
    <?php 
	
	
	
		   } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc()); 
	
	?>
    </table>
		
	<?php } ?>
	
	
	<?php //echo HTML_Ls_Nr(TT_RWS); ?>
    <?php } ?>
    
<?php } $Ls_Rg->free; $Ls_Hst_Rg->free;  ?>