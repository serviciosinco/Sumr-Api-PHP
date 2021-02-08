<?php 
/*
try {
	
	
	//--------- GET AND POST DATA ---------//
		
		$_bco = Php_Ls_Cln($_GET['id']);
		$_lmt = Php_Ls_Cln($_GET['lmt']);
	
	//--------- AUTO TIME CHECK - START ---------//

		$__Bco = new CRM_Bco();
		$_AUTOP_d = $this->RquDt([ 't'=>'bco_chk', 'm'=>5 ]); 
		
	//--------- AUTO TIME CHECK - END ---------//

	
	//$_AUTOP_d->hb = 'ok';// Tempo
	
	if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){ 
	
		$this->Rqu([ 't'=>'bco_chk' ]);		
		
		if(class_exists('CRM_Cnx')){
			
			if(!isN($_bco)){ $__fl .= " AND bco_enc = '".$_bco."' "; }
			
			$Ls_Qry = " SELECT id_bco, id_bcochk, id_bcochktp, bcochktp_key, bco_img,
							 ( bcochk_fa < NOW() - INTERVAL 5 MINUTE ) AS __rd_lst
							 
						FROM "._BdStr(DBM).TB_BCO_CHK." 
							 INNER JOIN "._BdStr(DBM).TB_BCO_CHK_TP." ON bcochk_chktp = id_bcochktp 
							 INNER JOIN "._BdStr(DBM).TB_BCO." ON bcochk_bco = id_bco
						WHERE (
								bcochk_w IS NULL || 
								bcochk_h IS NULL ||
								bcochk_w = '' || 
								bcochk_h = ''
							)
							AND id_bcochktp != 1
							AND bco_img != ''
							AND bco_est = '"._CId('ID_SISBCOEST_ACTV')."'
							{$__fl} 
							
						ORDER BY id_bcochk DESC
						LIMIT 50";
											
			$LsBcoChk = $__cnx->_qry($Ls_Qry);
			
					
			if($LsBcoChk){
				
				$row_LsBcoChk = $LsBcoChk->fetch_assoc(); 
				$Tot_LsBcoChk = $LsBcoChk->num_rows; 
				
				echo $this->h1('Images Without Sizes '.$Tot_LsBcoChk);
				
				if($Tot_LsBcoChk > 0){					
					
					do {
						
						$_AUTOP_a = $this->RquDt([ 't'=>'bco_chk', 'id'=>$row_LsBcoChk['id_bcochk'], 'm'=>5 ]); 
						
						//$_AUTOP_a->hb = 'ok';// Tempo
						
						if($_AUTOP_a->hb == 'ok'){
							
							$__fle = '../../'.DIR_BCO_TH.$row_LsBcoChk['bcochktp_key'].'_'.$row_LsBcoChk['bco_img'];
							$__fle_o = '../../'.DIR_BCO.$row_LsBcoChk['bco_img'];
							
							echo $this->h2( $row_LsBcoChk['id_bcochk'].' - '.$__fle );
							
							if(file_exists($__fle) && !isN($__fle)){
								$__fle_to_rd = $__fle;
							}elseif(file_exists($__fle_o) && !isN($__fle_o) && $row_LsBcoChk['id_bcochktp'] == 1){
								$__fle_to_rd = $__fle_o;	
							}else{
								$__fle_to_rd = '';
							}
								
							
							if(!isN($__fle_to_rd)){
								
								$image = getimagesize( $__fle_to_rd );
								$width = $image[0];
								$height = $image[1];
								
								if(!isN($width) && !isN($height)){
									
									$_prc = $__Bco->_ChkTp_Upd([ 'id'=>$row_LsBcoChk['id_bcochk'], 'w'=>$width, 'h'=>$height ]); 
									echo $this->h3('Result on _ChkTp_Upd: '.print_r($_prc, true));	
									
								}else{ 
								
									echo $this->h2('Not width or height '.$__fle);
									
								}
								
							}else{
								
								// Thumbnail 200
								
								if(file_exists($__fle_o)){
									
									
									try {
											
										echo $this->h2('Not exists th '.$__fle);
										echo $this->h2('Try '.$__fle_o);
										
										if($row_LsBcoChk['bcochktp_key'] == 'bg'){
											$___szecut = '800';
										}elseif($row_LsBcoChk['bcochktp_key'] == 'md'){
											$___szecut = '400';
										}elseif($row_LsBcoChk['bcochktp_key'] == 'th'){
											$___szecut = '200';
										}
										
										
										$image_th = new Imagick($__fle_o);
										$image_th->setImageFormat ("jpeg");
										$image_th->setImageCompression(imagick::COMPRESSION_JPEG);
										$image_th->setImageCompressionQuality(0.3);
										$image_th->thumbnailImage($___szecut, 0);
										
										if($image_th->writeImage($__fle)){
											
											$image_th->clear();
											$image_th->destroy();
											
											echo $this->h2('Write image '.$__fle, '', 'color:green;');
										
										}else{
											
											echo $this->h2('CaNNOT Write image '.$__fle, '', 'color:red;');
											
										}
									
									} catch (Exception $e) {
    
									    $this->Rqu([ 't'=>'bco_chk' ]);
									    echo $e->getMessage();
									    
									}

						
									
									
								}else{
									
									echo $this->h2('Not exists original '.$__fle_o, '', 'color:red;');
									$__upnoexst = $__Bco->_Bco_Upd([ 'id'=>$row_LsBcoChk['id_bco'], 'est'=>_CId('ID_SISBCOEST_NOSRC') ]);
									print_r($__upnoexst);
									
								}
								
							}
							
						}
						
						$this->Rqu([ 't'=>'bco_chk', 'id'=>$row_LsBcoChk['id_bcochk'] ]);		
							
					} while ($row_LsBcoChk = $LsBcoChk->fetch_assoc()); 

				}
			
			}else{
				
				echo $this->err($__cnx->c_r->error);
				
			}
			
			
			$__cnx->_clsr($LsBcoChk);
			
		}
		
		$this->Rqu([ 't'=>'bco_chk' ]);
		
	
	}else{
		
		echo $this->h1('Image Chck - '.$this->Spn('Aws'), 'Auto_Tme_Prg');
		
	}
	
	

} catch (Exception $e) {
    
    $this->Rqu([ 't'=>'bco_chk' ]);
    echo $e->getMessage();
    
}
*/
	
?>