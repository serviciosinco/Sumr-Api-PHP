<?php 

	$____autos = Php_Ls_Cln($_POST['auto_tp']);
	$__tp = Php_Ls_Cln($_POST['tp']);
	
	if(!isN($____autos)){

		$____autos_a = explode(',', $____autos);
		$____autos_a = implode("','", $____autos_a);

        $Ls_Qry = "SELECT 
                        autotp_enc, cl_enc, id_cl, cl_nm, cl_img     
                    FROM "._BdStr(DBA).TB_AUTO_TP."
                    LEFT JOIN "._BdStr(DBA).TB_AUTO_CL." ON autocl_tp = id_autotp
                    LEFT JOIN "._BdStr(DBM).TB_CL." ON autocl_cl = id_cl
                    WHERE autocl_e = 1 AND autotp_enc IN ('{$____autos_a}')";
   
        $Ls = $__cnx->_qry($Ls_Qry);
        
        if($Ls){
            
            $row_Ls = $Ls->fetch_assoc(); 
            $Tot_Ls = $Ls->num_rows;
            
            $rsp['total'] = $Tot_Ls;
            
            if($Tot_Ls>0){		
            
                $rsp['e'] = 'ok';	
                
                do {

                    $vl[] = $row_Ls;
      
                } while ($row_Ls = $Ls->fetch_assoc());

            }

        }else{
                
            $rsp['w'] = $__cnx->c_r->error;
            
        }

        $__cnx->_clsr($Ls);

        $vl = json_decode(json_encode($vl));
        
        foreach($vl as $k => $v){
            $li = '';

            $rsp['l'][$v->autotp_enc]['id'] = $v->autotp_enc;

            if(!isN($v->id_cl)){
                $rsp['l'][$v->autotp_enc]['cl'][$v->cl_enc]['id'] = $v->id_cl;
                $rsp['l'][$v->autotp_enc]['cl'][$v->cl_enc]['nm'] = $v->cl_nm;
                $rsp['l'][$v->autotp_enc]['cl'][$v->cl_enc]['img'] = $v->cl_img;
            }

        }
	}else{
					
		$rsp['w'] = 'No data';
		
	}	
?>