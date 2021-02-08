<?php 
	
	//error_reporting(E_ALL & ~E_NOTICE);
	//@ini_set('display_errors', true); 
	
	$__Bco = new CRM_Bco();
	$__Cdn = new API_CRM_Cdn();
	
	$_rote = Php_Ls_Cln($_POST['_rote']);
	$_id_bco = Php_Ls_Cln($_POST['_i']);
	$_img = Php_Ls_Cln($_POST['_img']);
	
	
	$bco_dt = GtBcoDt([ 'id'=>$_id_bco, 't'=>'enc' ]);
	
	if(!isN($bco_dt->img)){	
		
		$_img_big = '../../../'.DIR_BCO.$bco_dt->img;
		
		if($_rote == 'left'){ $_rote = '-90.0'; }else{ $_rote = '90.0'; } 
		
		$image_rte = new Imagick( $_img_big );
		$image_rte->setImageFormat ("jpeg");
		$image_rte->rotateImage ( 'white', $_rote );
		
		$rsp['rote'] = $_rote;
		
				
		if($image_rte->writeImage( $_img_big )){
			
			$rsp['aws']['sve'] = $_sve = $_aws->_s3_put([ 'b'=>'bco', 'fle'=>_TmpFixDir($bco_dt->img), 'src'=>$_img_big, 'ctp'=>mime_content_type($_img_big), 'cfr'=>'ok' ]);
			
			$___szes = GtBcoChkTpLs([ 'cnx'=>$__Bco->c_r ]);
				
			foreach($___szes as $___szes_k=>$___szes_v){
				
				if(!isN($___szes_v->key) && $___szes_v->key != 'bg'){
					
					$_img_big_th = '../../../'.DIR_BCO_TH.$___szes_v->key.'_'.$bco_dt->img;
					$_img_big_th_pblc = DMN_FLE_BCO_TH.$___szes_v->key.'_'.$bco_dt->img;
					
					$image_rte_big = new Imagick( $_img_big );
					$image_rte_big->setImageFormat ("jpeg");
					$image_rte_big->thumbnailImage($___szes_v->sze, 0);
					
					if($image_rte_big->writeImage( $_img_big_th )){
						
						$_sve = $_aws->_s3_put([ 'b'=>'bco', 'fle'=>_TmpFixDir(DR_IMG_TH.$___szes_v->key.'_'.$bco_dt->img), 'src'=>$_img_big_th, 'ctp'=>mime_content_type($_img_big_th), 'cfr'=>'ok' ]);
						
						//$rsp['cdn'][$___szes_v->key]['r'] = $__Cdn->_CFR_Prg([ 'f'=>[ $_img_big_th_pblc ] ]);	
						//$rsp['cdn'][$___szes_v->key]['f'] = $_img_big_th;
						
						$image_rte_big->clear();
						$image_rte_big->destroy();
						
					}

				}
				
			}
			
			__AutoRUN([ 't'=>'bco', /*'t2'=>'bco_chk',*/ 'id'=>$bco_dt->enc, '_fst'=>'ok' ]);	
			
			$image_rte->clear();
			$image_rte->destroy();
		
			$rsp['e'] = 'ok';
			
			$__Bco->nw_id_bco = $bco_dt->id;
			$prc = $__Bco->_Rote_Clr();
			
			$rsp['unlink'] = $prc;
			
					
			//$rsp['cdn']['main']['r'] = $__Cdn->_CFR_Prg([ 'f'=>[ DMN_FLE_BCO.$bco_dt->img ] ]);
			$rsp['cdn']['main']['f'] = DMN_FLE_BCO.$bco_dt->img;
			
		}
	
	}
		
?>