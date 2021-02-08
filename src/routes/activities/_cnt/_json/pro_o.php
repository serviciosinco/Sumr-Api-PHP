<?php 
		
		$__q = Php_Ls_Cln($_POST['__q']);
		$__t = Php_Ls_Cln($_POST['__t']);
		
		$rsp['p'] = $__q;
		
				
		if($__q != ''){
			
			$__schcod = Sch_Cd('unipro_nm', $__q, 2); // Codigo Armado

			if($__t == 'prg'){ $__fl .= ' AND unipro_tp = 6 '; }
			
			$mysqli = CnRdi(); 
			$Ls_Qry = 'SELECT DISTINCT lower(f_Tx(unipro_nm)) AS _unq, unipro_enc, unipro_nm, unipro_tp 
			    	   FROM '.MDL_SIM_UNI_PRO_BD.' 
			    	   WHERE id_unipro != "" '.$__schcod.' '.$__fl.' 
					   GROUP BY lower(f_Tx(unipro_nm))
					   ORDER BY unipro_nm ASC';
			$Ls = $mysqli->query($Ls_Qry);
			$row_Ls = $Ls->fetch_assoc();
			$Tot_Ls = $Ls->num_rows;
			
			
			$rsp['tot'] = $Tot_Ls;
			
			
			if($Tot_Ls > 0){
				
				do{
					$rsp['items'][] = array('id'=>$row_Ls['unipro_enc'], 'text'=>ctjTx($row_Ls['unipro_nm'].$__sb_t, 'in') );
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
