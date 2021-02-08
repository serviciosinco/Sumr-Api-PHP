<?php 

	$_ida = Php_Ls_Cln($_GET['ida']);
    $_eml = Php_Ls_Cln($_GET['eml']);
    $_nm = Php_Ls_Cln($_GET['nm']);
	
	if(!isN($_ida)){ 
		$_wdgt_act_dt = GtClWdgtActDt([ 'id'=>$_ida, 't'=>'enc' ]);
	}
	
	if(!isN($_wdgt_act_dt->id) && !isN($_eml) && !isN($_nm)){
		
		if($_wdgt_act_dt->chnl->id == _CId('ID_WDGTCHNL_SMR_CALLV')){

			try{
                
                //---------------- Insert Lead - Before ----------------//	
                
                $__CntIn = new CRM_Cnt([ 'cl'=>$_wdgt_dt->cl->id ]);
                $__CntIn->cnt_nm = $_nm;
                $__CntIn->cnt_eml = $_eml;
                $__cntr = $__CntIn->_Cnt();
        
                //---------------- Get Data Global ----------------//	

                if(!isN( $__cntr->i )){

                    $__CallIn = new CRM_Call([ 'cl'=>$_wdgt_dt->cl->id ]);
                    $_room_nw = $__CallIn->CallRoom([ 'cnt'=>$__cntr->enc, 'url'=>[ 'cnt'=>'ok' ] ]);

                    if(!isN($_room_nw->id) && !isN($_room_nw->unm) && !isN($_room_nw->url)){
                        $r['e'] = 'ok';
                        $r['url'] = $_room_nw->url;
                    }else{
                        $r['w'] = 'Room not created';
                        $r['tmp'] = $_room_nw;
                    }

                }else{

                    $r['w'] = 'No lead created';
                    $r['tmp'] = $__cntr;  
        
                }

			}catch(Exception $e){    
			
				$r['w'] = $e->getMessage();    
					
			}

		}else{

            $r['w'] = 'No channel id';  

        }
	
	}else{

		$r['w'] = 'No detail';

	}
    
         
?>