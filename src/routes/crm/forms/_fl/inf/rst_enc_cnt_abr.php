<?php if(class_exists('CRM_Cnx')){

	
	// Mes Inicial
	$f1 = Php_Ls_Cln($_GET['_f_in']); 
	$f2 = Php_Ls_Cln($_GET['_f_out']);
	$enc = Php_Ls_Cln($_GET['_enc']);
	// Todos los datos del año actual
	$_now_f1 = date('Y-m-d', strtotime($f1));
	$_now_f2 = date('Y-m-d', strtotime($f2));
	
	if($enc != '' && $enc != 'undefined'){ 
		$__fl_p .= ' AND id_enc = "'.$enc.'" '; 
		$__fl_r .= ' AND enccnt_enc = "'.$enc.'" '; 
	}
	
	if($_now_f1 != '' && $_now_f2 != ''){ 
		$__fl_f_p .= " AND (enccnt_fi BETWEEN '".$_now_f1."' AND '".$_now_f2."') "; 
		$__fl_f_r .= " AND (enccnt_fi BETWEEN '".$_now_f1."' AND '".$_now_f2."') "; 
	}elseif($_now_f1 != '' && $_now_f2 != ''){ 
		$__fl_f_p .= " AND enccnt_fi = '".$_now_f1."' "; 
		$__fl_f_r .= " AND enccnt_fi = '".$_now_f1."' "; 
	}


	//-------------------- Preguntas --------------------//
	
	
	
	//-------------------- Respuestas --------------------//	
		
		$Ls_Rs_Qry = sprintf("SELECT
								*
							FROM
								_enc,
								_enc_cnt,
								cnt,
								cnt_eml
							WHERE
								enccnt_enc = id_enc
							AND enccnt_cnt = id_cnt
							AND cnteml_cnt = id_cnt
				   	   		 $__fl_p 
				   	");	
				   	
					   
		$Ls_Rs = $__cnx->_qry($Ls_Rs_Qry); 
		$row_Ls_Rs = $Ls_Rs->fetch_assoc(); $Tot_Ls_Rs = $Ls_Rs->num_rows;
			
			//echo h2( 'Tot Results:'.$Tot_Ls_Rs );
		?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg"> 
	    	<tr>
	    	    <th nowrap="nowrap" <?php echo $__xl_tt ?> width="40%"><?php echo TX_NM; ?></th>
	            <th nowrap="nowrap" <?php echo $__xl_st ?> class="_sb" width="20%"><?php echo TT_FM_EML; ?></th>
		    </tr>
	    <?php $_i = 1; do { ?> 
	    <tr <?php  echo ' class="Rw_'.$Nm.'" ';  ?> >
	        <?php 				
				$_rw_sty = ${'__xl_td_rw_'.$Nm};
				
			?>
	        <td align="left" <?php echo $_rw_sty ?> class="_lft"><?php echo ctjTx($row_Ls_Rs['cnt_nm'].' '.$row_Ls_Rs['cnt_ap'],'in'); ?></td>
	        <td align="left" <?php echo $_rw_sty ?> class="_lft"><?php echo ctjTx($row_Ls_Rs['cnteml_eml'],'in'); ?></td>
	        <td align="left" nowrap="nowrap" <?php echo $_rw_sty ?>>
				
	        </td>
	    </tr>
	    <?php 
			   } while ($row_Ls_Rs = $Ls_Rs->fetch_assoc()); 
		?>
	    
	    </table>
    <?php
		
			
	//-------------------- Respuestas --------------------//
	
	
	$Ls_Qs->free; $Ls_Rs->free;  
	
}

?>