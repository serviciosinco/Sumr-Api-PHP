<?php 
	try{

        $_enc = Php_Ls_Cln($_POST['enc']);
        $_tp = Php_Ls_Cln($_POST['tp']);
        $_lsts_tot = Php_Ls_Cln($_POST['lsts_tot']);

        if($_tp == 'ec_lsts'){
            $sgm_dt = GtEcLstsDt([ 'id'=>$_enc, 't'=>'enc' ]);
            $rsp['ec'] = $sgm_dt;
        }elseif($_tp == 'ec_lsts_sgm'){
            $tot = 0;

            $rsp['ec_sgm_tot'] = $_tot = count($_enc); 

            if($_tot == 1){
                foreach($_enc as $k => $v){
                    $sgm_dt = GtEcLstsSgmDt([ 'id'=>$v, 't'=>'enc', 'd'=>[ 'var'=>'ok' ] ]);
                    $rsp['ec_sgm_tot_eml'] = $sgm_dt->tot_eml;
                    $tot = $tot+$sgm_dt->tot_eml;
                }
            }else if($_tot > 1){
                foreach($_enc as $k => $v){
                    $sgm_dt = GtEcLstsSgmDt([ 'id'=>$v, 't'=>'enc', 'd'=>[ 'var'=>'ok' ] ]);
                    $_ids[] = $sgm_dt->id; 
                } 
                $sep = implode(",", $_ids);   
                $total = GtEcLstsSgmEmlCount([ 'id'=>$sep, 't'=>'id', 'd'=>[ 'mlt'=>'ok' ] ]);  
                $tot = $tot+$total->tot;
            }else{
                $tot = $_lsts_tot;   
            }

            
            $rsp['ec_sgm'] = $tot; 
        }

	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>