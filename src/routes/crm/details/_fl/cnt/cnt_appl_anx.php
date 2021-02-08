<?php
	if(class_exists('CRM_Cnx')){

		
		
		$Dt_Qry = sprintf(" 
							SELECT * FROM ".TB_CNT_APPL_ANX."
							WHERE cntapplanx_enc = %s
					   	", GtSQLVlStr($_GET['_i'], "text"));
		
				   
		$Ls_Rg = $__cnx->_qry($Dt_Qry);
		$row_Ls_Rg = $Ls_Rg->fetch_assoc();
		$Tot_Ls_Rg = $Ls_Rg->num_rows;
		
		if($Tot_Ls_Rg > 0){
			
			$info = new SplFileInfo($row_Ls_Rg['cntapplanx_fle']);
			$_ext = $info->getExtension(); //Extension
			
			if( $_ext == "jpg" ){
				
				echo "<img class='cntapplanx_fle' src='".DMN_FLE_ANX.$row_Ls_Rg['cntapplanx_fle']."' />";
				
			}elseif( $_ext == "pdf" ){
				echo " <embed class='cntapplanx_fle' src='".DMN_FLE_ANX.$row_Ls_Rg['cntapplanx_fle']."' type='application/pdf'></embed> ";
			}else{
				echo " La extensión ".$info->getExtension()." no es permitida. ";
			}
			
		}
		
		$Ls_Rg->free; 

	}
?>

<style>
	/*.cntapplanx_fle{ width: 100%; height: 600px; }*/
</style>