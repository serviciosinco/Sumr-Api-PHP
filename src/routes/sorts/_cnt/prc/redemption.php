x<?php 
	
	$r['e'] = 'no';
	
	$_id = Php_Ls_Cln($_POST['id']);
	
	$_qry = "INSERT INTO con_registers_t_redepmtions (registerredemption_register) VALUES ('".$_id."')";
			
	$_chk = $cnx->prepare($_qry);	
	
	if($_chk->execute()){
	
		if($rsl){	
			$r['e'] = 'ok';
		}
	
	}
	
	
	header('Content-Type: application/json');
	echo json_encode($r);

					
?>