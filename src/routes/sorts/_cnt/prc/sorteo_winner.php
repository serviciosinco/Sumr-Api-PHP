<?php 
	
	$r['e'] = 'no';
	
	
	$_number = Php_Ls_Cln($_POST['number']);
	
	if(!isN($__dt_sort->snce)){ $__fl .= " AND con_registers_t.created >= '".$__dt_sort->snce."' "; }
	
	$_qry = "	SELECT
	 
					con_registers_t.name AS cliente_nombre,
					con_registers_t.id AS cliente_id,
					con_registers_t.origin_id AS cliente_number,
					con_registers_t.document_id AS cliente_document,
					con_registers_t.email AS cliente_email,
					con_registers_t.message_text AS cliente_message
					
				FROM con_registers_t
					 INNER JOIN int_companies_t ON con_registers_t.company_id = int_companies_t.id	 
				WHERE is_completed = 't' AND 
					  (winner != 't' OR winner IS NULL) AND 
					  con_registers_t.company_id='".$__dt_sort->msv->cid."' AND
					  (message_text IS NOT NULL AND message_text != '') AND
					  con_registers_t.name IS NOT NULL AND
					  con_registers_t.email IS NOT NULL
					  {$__fl}
					  
				ORDER BY RANDOM()
				LIMIT 1	 	 
			"; 
			
	//$r['q'] = $_qry;
			
	$_chk = $cnx->prepare($_qry);	
	
	if($_chk->execute()){ 
	
		$row_chk = $_chk->fetchAll(PDO::FETCH_ASSOC); 
		$tot_chk = Pdo_Fix_RwTot($_chk); 
		
		if($tot_chk > 0){
			
			$r['e'] = 'ok';
			$r['tot'] = $tot_chk;
			
			foreach($row_chk as $rcr){ 
				
				$_qry_upd = " UPDATE con_registers_t SET winner='t', winner_n='".$_POST['win_n']."' WHERE id='".$rcr['cliente_id']."' ";
				$_chk = $cnx->prepare($_qry_upd);	
				
				if($_chk->execute()){
					
					$r['d']['id'] = $rcr['cliente_id'];
					$r['d']['nm'] = $rcr['cliente_nombre'];
					$r['d']['no'] = $rcr['cliente_number'];
					$r['d']['doc'] = $rcr['cliente_document'];
					$r['d']['eml'] = $rcr['cliente_email'];
					$r['d']['msg'] = $rcr['cliente_message'];
					
				}
				
			}
			
		}else{
			$r['w'] = 'No data result';
		}
	
	}else{
		
		$r['q'] = $_qry;
		$r['w'] = $cnx->errorInfo();
		
	}
	
	
	header('Content-Type: application/json');
	echo json_encode($r);

					
?>