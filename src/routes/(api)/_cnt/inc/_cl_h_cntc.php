<?php 
	
	global $__cnx;
	$Dt_Qry = "	SELECT
					*
				FROM
					".DBM."._cl_h_cntc
				WHERE 
                    clhcntc_cl = ".$_ClDt->id." ORDER BY clhcntc_nm DESC";	

	$DtRg = $__cnx->_qry($Dt_Qry);
	
	if($DtRg){

		$row_DtRg = $DtRg->fetch_assoc(); 
		$Tot_DtRg = $DtRg->num_rows;
	
		if($Tot_DtRg > 0){	
			echo '<table width="100%">';	
			echo '<tr><th width="5%">ID</th><th width="95%">NOMBRE</th></tr>';		
            do{    
					            
				echo '<tr class="s">';
					echo '<td width="5%">'.ctjTx( $row_DtRg['id_clhcntc'],'in').'</td>';
					echo '<td width="95%">'.ctjTx( $row_DtRg['clhcntc_nm'],'in').'</td>';
				echo '</tr>';
				
			} while ($row_DtRg = $DtRg->fetch_assoc());
			echo '</table>';		
        }
	
	}
	
	$__cnx->_clsr($DtRg); 
	
?>