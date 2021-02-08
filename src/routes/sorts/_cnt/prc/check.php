<?php 
	
	$r['e'] = 'no';
	
	
	$_number = Php_Ls_Cln($_POST['number']);
	
	
	$_qry = "	SELECT 
					con_registers_t.name AS cliente_nombre,
					con_registers_t.id AS cliente_id
					
				FROM con_registers_t
					 INNER JOIN int_companies_t ON con_registers_t.company_id = int_companies_t.id	 
				WHERE origin_id= '".$_number."'
				LIMIT 1	 	 
			";
			
	$_chk = $cnx->prepare($_qry);
	
	if($_chk->execute()){
	
		$row_chk = $_chk->fetchAll(PDO::FETCH_ASSOC); 
		$tot_chk = Pdo_Fix_RwTot($_chk); 
		
		
		if($tot_chk > 0){
			
			$r['e'] = 'ok';
			$r['tot'] = $tot_chk;
			
			foreach($row_chk as $rcr){ 
				
				$r['id'] = $rcr['cliente_id'];
				$r['nm'] = $rcr['cliente_nombre'];
			
			}
		
		}
		
	}
	
	
	header('Content-Type: application/json');
	echo json_encode($r);

					
?>