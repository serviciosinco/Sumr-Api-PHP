<?php 

try {
	
	
	//--------- GET AND POST DATA ---------//
		
		$_bco = Php_Ls_Cln($_GET['id']);
		$_lmt = Php_Ls_Cln($_GET['lmt']);
	
	//--------- AUTO TIME CHECK - START ---------//

		$__Bco = new CRM_Bco();
		$_AUTOP_d = $this->RquDt([ 't'=>'bco_ornt', 'm'=>5 ]);
        //$_AUTOP_d->e = 'ok';
        //$_AUTOP_d->hb = 'ok';
        
	//--------- AUTO TIME CHECK - END ---------//

	
	//$_AUTOP_d->hb = 'ok';// Tempo
	
	if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){ 
	
		$this->Rqu([ 't'=>'bco_ornt' ]);		
		
		if(class_exists('CRM_Cnx')){
			
			$Ls_Qry = " SELECT id_bco, bco_img, bco_w, bco_h	 
						FROM "._BdStr(DBM).TB_BCO."
						WHERE bco_ornt = 3 AND bco_w IS NOT NULL AND bco_h IS NOT NULL
						ORDER BY RAND()
						LIMIT 50";
											
			$LsBcoOrnt = $__cnx->_qry($Ls_Qry);
				
			if($LsBcoOrnt){
				
				$row_LsBcoOrnt = $LsBcoOrnt->fetch_assoc(); 
				$Tot_LsBcoOrnt = $LsBcoOrnt->num_rows;
				
				if($Tot_LsBcoOrnt > 0){					
					
					do {

                        if($row_LsBcoOrnt['bco_w'] > $row_LsBcoOrnt['bco_h']){
                            $_ornt = 2;
                        }elseif($row_LsBcoOrnt['bco_w'] < $row_LsBcoOrnt['bco_h']){
                            $_ornt = 1;
                        }else{
                            $_ornt = 3;
                        }
                        
                        $__upd_o = $__Bco->_Bco_Upd([ 'id'=>$row_LsBcoOrnt['id_bco'], 'ornt'=>$_ornt ]);
                        
                        if($__upd_o->e == 'ok'){ 
                            echo $this->scss($row_LsBcoOrnt['id_bco'].' definido exitosamente'); 
                        }else{
                            echo $this->err($row_LsBcoOrnt['id_bco'].' not saved');   
                        }
							
					} while ($row_LsBcoOrnt = $LsBcoOrnt->fetch_assoc()); 

				}
			
			}else{
				
				echo $this->err($__cnx->c_r->error);
				
			}
			
			
			$__cnx->_clsr($LsBcoOrnt);
			
		}
		
		$this->Rqu([ 't'=>'bco_ornt' ]);
		
	
	}else{
		
		echo $this->h1('Image Chck - '.$this->Spn('Orientation'), 'Auto_Tme_Prg');
		
	}
	
	

} catch (Exception $e) {
    
    $this->Rqu([ 't'=>'bco_ornt' ]);
    echo $e->getMessage();
    
}
	
?>