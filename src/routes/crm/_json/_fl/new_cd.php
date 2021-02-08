<?php 
	
	$__q = Php_Ls_Cln($_POST['__q']);
	$__t = Php_Ls_Cln($_POST['__t']);
	
	$rsp['p'] = $__q;
	
	if($__q != ''){

		$__schcod = Sch_Cd('siscd_tt', $__q, 2); // Codigo Armado
 
		$Ls_Qry = 'SELECT DISTINCT lower(f_Tx(siscd_tt)) AS _unq, siscd_enc, siscd_tt 
		    	   FROM '._BdStr(DBM).MDL_SIS_CD_BD.' 
		    	   WHERE id_siscd != "" '.$__schcod.' '.$__fl.' 
				   GROUP BY lower(f_Tx(siscd_tt))
				   ORDER BY siscd_tt ASC';
   
		$Ls = $__cnx->_qry($Ls_Qry);	
		$row_Ls = $Ls->fetch_assoc();
			
		$Tot_Ls = $Ls->num_rows;
		$rsp['tot'] = $Tot_Ls;

		if($Tot_Ls > 0){
			
			do{
				$rsp['items'][] = array('id'=>$row_Ls['siscd_enc'], 'text'=>ctjTx($row_Ls['siscd_tt'].$__sb_t, 'in') );
			} while ($row_Ls = $Ls->fetch_assoc());
			
			$rsp['e'] = 'ok';	
			
		}else{
			$rsp['e'] = 'no';
			$rsp['items'][] = array('id'=>'-wrt-', 'text'=>$__q );	
		}
	
	}else{
		
		$rsp['e'] = 'no';
			
	}

?>