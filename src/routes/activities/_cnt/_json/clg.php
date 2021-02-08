<?php 
		
		$__q = Php_Ls_Cln($_POST['__q']);
				
		if($__q != ''){
			
			$__schcod = Sch_Cd('clg_nm', $__q, 2); // Codigo Armado

			$Ls_Qry = '	SELECT *,  (SELECT cddp_tt FROM sis_cd_dp WHERE id_cddp = cd_dp ) AS _cd_dp  
						FROM '.MDL_CLG_SDS_BD.', '.MDL_CLG_BD.', '.MDL_SIS_CD_BD.' 
						WHERE clgsds_cd = id_cd AND clgsds_clg = id_clg '.$__schcod.' 
						ORDER BY id_clg ASC';

			$Ls = $__cnx->_qry($Ls_Qry);

			if($Ls){

				$row_Ls = $Ls->fetch_assoc();
				$Tot_Ls = $Ls->num_rows;

				$rsp['tot'] = $Tot_Ls;
				
				if($Tot_Ls > 0){
					
					do{
						if($row_Ls['clgsds_tt'] != ''){ $__sb_t = ' ('.$row_Ls['clgsds_tt'].')'; }elseif($row_Ls['cd_tt']){ $__sb_t = ' ('.$row_Ls['cd_tt'].' - '.$row_Ls['_cd_dp'].')'; }else{ $__sb_t = ''; }
						$rsp['items'][] = array('id'=>$row_Ls['clgsds_enc'], 'text'=>ctjTx($row_Ls['clg_nm'].$__sb_t, 'in') );
					} while ($row_Ls = $Ls->fetch_assoc());
					
					$rsp['e'] = 'ok';	
					
				}else{
					
					$rsp['e'] = 'no';
					$rsp['items'][] = array('id'=>'-wrt-', 'text'=>$__q );
						
				}

			}
		
		}else{
			
			$rsp['e'] = 'no';
			
		}

?>
