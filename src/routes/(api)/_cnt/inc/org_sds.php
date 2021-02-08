<?php 
	global $__cnx;
	
	$Dt_Qry = "SELECT * FROM ".TB_ORG." INNER JOIN ".TB_ORG_SDS." ON orgsds_org = id_org";
		
			
					
	$DtRg = $__cnx->_qry($Dt_Qry);
	
	if($DtRg){

		$row_DtRg = $DtRg->fetch_assoc(); 
		$Tot_DtRg = $DtRg->num_rows;
	
		if($Tot_DtRg > 0){	
			echo '<table width="100%">';	
			echo '<tr>
					<th width="15%">ID</th>
					<th width="85%">SEDES</th>
				</tr>';	
				
            do{    
					            
				echo '<tr class="s">';
					echo '<td width="15%">'.ctjTx( $row_DtRg['id_orgsds'],'in').'</td>';
					echo '<td width="85%">'.ctjTx( $row_DtRg['org_nm'],'in').'</td>';
				echo '</tr>';
				
			} while ($row_DtRg = $DtRg->fetch_assoc());
			echo '</table>';		
        }
	
	} 
	
	$__cnx->_clsr($DtRg);
	
?>