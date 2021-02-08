<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'bco_tag' ]);

if( $_g_alw->est == 'ok' ){

	/*

	try {
		
		
		//--------- GET AND POST DATA ---------//
			
			$_bco = Php_Ls_Cln($_GET['id']);
			$_lmt = Php_Ls_Cln($_GET['lmt']);
		
		//--------- AUTO TIME CHECK - START ---------//

			$__Bco = new CRM_Bco();
			$_AUTOP_d = $this->RquDt(['t'=>'bco_tag', 'm'=>1]); 
			
		//--------- AUTO TIME CHECK - END ---------//

		$_AUTOP_d->hb = 'ok';
		
		if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){ 
		
			$this->Rqu([ 't'=>'bco_tag' ]);		
			
			if(class_exists('CRM_Cnx')){
				
				$Ls_Qry = " SELECT id_bcotag, bcotag_tag_es,
								( bcotag_fa < NOW() - INTERVAL 5 MINUTE ) AS __rd_lst
								
							FROM "._BdStr(DBM).TB_BCO_TAG." 
								INNER JOIN "._BdStr(DBM).TB_BCO." ON bcotag_bco = id_bco	 
							WHERE (
									bcotag_tag_en IS NULL || 
									bcotag_tag_it IS NULL || 
									bcotag_tag_fr IS NULL || 
									bcotag_tag_gr IS NULL || 
									bcotag_tag_krn IS NULL || 
									bcotag_tag_jpn IS NULL || 
									bcotag_tag_ptg IS NULL || 
									bcotag_tag_mdn IS NULL
								)
								AND bco_est = '"._CId('ID_SISBCOEST_ACTV')."'
								{$__fl} 
								
							ORDER BY id_bcotag ASC
							LIMIT 50";
												
				$LsBcoTag = $__cnx->_qry($Ls_Qry);
				
						
				if($LsBcoTag){
					
					$row_LsBcoTag = $LsBcoTag->fetch_assoc(); 
					$Tot_LsBcoTag = $LsBcoTag->num_rows; 
					
					echo $this->h1('Images Without Tag '.$Tot_LsBcoTag);
					
					if($Tot_LsBcoTag > 0){					
						
						do {
							
							$_AUTOP_a = $this->RquDt([ 't'=>'bco_tag', 'id'=>$row_LsBcoTag['id_bcotag'], 'm'=>5 ]); 
							
							$_AUTOP_a->hb = 'ok';
							
							if($_AUTOP_a->hb == 'ok'){		
								
								echo $this->h1( $row_LsBcoTag['id_bcotag'] );
								
								$trnsl = $this->_aws->_img_lbl_trnsl([ 'lng'=>'es', 'v'=>ctjTx($row_LsBcoTag['bcotag_tag_es'],'in') ]);
								
								if($trnsl->tot > 0){
									
									$__upd_o = '';
									$__upd_o['id'] = $row_LsBcoTag['id_bcotag'];
									
									foreach($trnsl->ls as $trnsl_k=>$trnsl_v){ 
										$__upd_o[$trnsl_k] = $trnsl_v;
									}
									
									$__upd_rsl = $__Bco->_Tag_Upd($__upd_o); 
								}
								
								echo $this->h2('Translate '.ctjTx($row_LsBcoTag['bcotag_tag_es'],'in'));
								print_r($__upd_rsl);
								
							}
							
							$this->Rqu([ 't'=>'bco_tag', 'id'=>$row_LsBcoTag['id_bcotag'] ]);		
								
						} while ($row_LsBcoTag = $LsBcoTag->fetch_assoc()); 

					}
				
				}else{
					
					echo $this->err($__cnx->c_r->error);
					
				}
			
			}
			
			$this->Rqu([ 't'=>'bco_tag' ]);
			
		
		}else{
			
			echo $this->h1('Image Tags - '.$this->Spn('Aws'), 'Auto_Tme_Prg');
			
		}
		
		

	} catch (Exception $e) {
		
		$this->Rqu([ 't'=>'bco_tag' ]);
		echo $e->getMessage();
		
	}

	*/

}else{

	echo $this->nallw('Global Banco Tags Off');

}

?>