<?php 
	
	$__us = Php_Ls_Cln($_POST['us']);

    $__dt_1 = date('Y-m-d H:i:s', strtotime('-4 hour'));
    $__dt_2 = date('Y-m-d H:i:s');
        
	/* Programas */
	$UsNvg_Qry = "  SELECT usnvgt_fi, usnvgt_cnx_spd, usnvgt_cnx_rtt
                    FROM "._BdStr(DBM).TB_US_NVGT."  
                         INNER JOIN "._BdStr(DBM).TB_US." ON usnvgt_us = id_us
                    WHERE us_enc='".$__us."' AND usnvgt_fi BETWEEN '".$__dt_1."' AND '".$__dt_2."'                
                "; 
	
    $UsNvg = $__cnx->_qry($UsNvg_Qry); 
    
    if($UsNvg){

        $row_UsNvg = $UsNvg->fetch_assoc();
        $Tot_UsNvg = $UsNvg->num_rows;

        if($Tot_UsNvg > 0){

            $rsp['e'] = 'ok';
            
            if($Tot_UsNvg > 0){

                do {		
                    $rsp['ctg'][] = ctjTx(strip_tags($row_UsNvg['usnvgt_fi']),'in');	
                    $rsp['data']['s'][] = $row_UsNvg['usnvgt_cnx_spd']*1000;
                    $rsp['data']['r'][] = $row_UsNvg['usnvgt_cnx_rtt'];
                } while ($row_UsNvg = $UsNvg->fetch_assoc());
                
            }

        }
    
    }

?>