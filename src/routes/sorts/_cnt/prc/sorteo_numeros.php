<?php 
	
	$r['e'] = 'no';
	
	$_qry = "UPDATE con_registers_t SET winner=NULL, winner_n=NULL WHERE company_id = '".$__dt_sort->msv->cid."' ";
	
			
	$_chk = $cnx->prepare($_qry);	
	
	if($_chk->execute()){
	
		$row_chk = $_chk->fetchAll(PDO::FETCH_ASSOC); 
		$tot_chk = Pdo_Fix_RwTot($_chk); 
		
		if($tot_chk > 0){
			
			$r['e'] = 'ok';
			$r['tot'] = $tot_chk;
			
		}
	
	}
	
	
	
	header('Content-Type: application/json');
	echo json_encode($r);

					
?>