<?php 
	 
	class CRM_Bco extends CRM_Main{
	    
	    function __construct($p=NULL) {   
		    
		    parent::__construct();
		
		    $this->_aws = new API_CRM_Aws();										
			$this->_cdn = new API_CRM_Cdn();
														
		    $this->hb = 'ok';
		    $this->ext_allw = ['jpg', 'png', 'jpeg'];
			
			if(isN($p['cl'])){ 
		        $this->cl = GtClDt( Gt_SbDMN(), "sbd");
		    }else{
			    $this->cl = $p['cl'];
		    }
		    
	    }
	    
	    function __destruct() {
			parent::__destruct();
	   	}
	   	
	   	
	   	function _ChkExt(){  	
		   	if(!in_array(strtolower($this->ext), $this->ext_allw)){
				$this->hb = 'no';
				$this->w = 'Extension no valida';
			}
	   	}
	   	
	   	function _ChkShttr(){
			
			$__exists_shutter = strpos($this->nm, 'shutterstock');
			
			if($__exists_shutter === false){ 
				
				$rsp['shutter'] = 'NO es imagen shutter'; 
				$this->org = ''; 
				
			}else{ 
				
				$this->GtInfo();
				
				if(!isN($this->__dtbco->id)){ 
					$rsp['exists']['e'] = 'ok';
					$rsp['exists']['msj'] = 'Existe con Id:'.Strn($this->__dtbco->id); 
					$rsp['exists']['id'] = $this->__dtbco->id;	
					
					$this->nw_id_bco = $this->__dtbco->id;
					$this->hb = 'no';
				}
				
				$rsp['shutter'] = 'SI es imagen shutter'; 
				$this->org = $this->nm; 
			}
			
			return _jEnc($rsp);
				   	
	   	}
	   	
	   	
	   	public function GtInfo(){
		   	if(!isN($this->nw_id_bco)){
				$this->__dtbco = GtBcoDt([ 'id'=>$this->nw_id_bco ]);
			}elseif(!isN($this->nm)){
				$this->__dtbco = GtBcoDt([ 'id'=>$this->nm, 't'=>'org' ]);
			}
	   	}
	   	
	   	
	   	function _Bco($p=NULL){
			
			$rsp['e'] = 'no';
			
			$rsp['shtr'] = $this->_ChkShttr();
			$rsp['ext'] = $this->_ChkExt();
			
			if($this->hb == 'ok'){
				
				if(isN($this->__dtbco->id)){ 
					$_prc = $this->_Bco_In(); 
				}else{
					$this->nw_id_bco = $__chk->id;
				}
				
				$rsp['tag'] = $this->_Tag();
				$rsp['are'] = $this->_Are();
				$rsp['cd'] = $this->_Cd();
				$rsp['attr'] = $this->_Attr();
				$rsp['chk'] = $this->_ChkTp();
			}  
			
			if(!isN($this->nw_id_bco)){
				$rsp['e'] = 'ok';
				$rsp['id'] = $this->nw_id_bco;	
			}
			
			return _jEnc($rsp);
	    }
	
	
	    
	    public function _Bco_In($p=NULL){
			
			global $__cnx;
			
			if($this->hb == 'ok'){	
				
				$__enc = Enc_Rnd($this->cl->id.'-'.$this->org);
				if(!isN($this->est)){ $__est = $this->est; }else{ $__est = _CId('ID_SISBCOEST_ACTV'); } 
				
				$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_BCO." (bco_enc, bco_cl, bco_org, bco_ext, bco_out, bco_us, bco_est) VALUES (%s,%s,%s,%s,%s,%s,%s)",
									GtSQLVlStr($__enc, "text"),
								    GtSQLVlStr($this->cl->id, "text"),
								    GtSQLVlStr(ctjTx($this->org,'out'), "text"),
								    GtSQLVlStr($this->ext, "text"),
								    GtSQLVlStr($this->ftp->svc->bco->id, "int"),
								    GtSQLVlStr(SISUS_ID, "int"),
								    GtSQLVlStr($__est, "int"));		
																
				$Result = $__cnx->_prc($query_DtRg);
	
			}
			
			if($Result){	
				
				$rsp['e'] = 'ok';
				$rsp['id'] = $this->nw_id_bco = $__cnx->c_p->insert_id;
				$this->GtInfo();
				
			}else{
				$rsp = $this->_eNo([ 'r'=>$rsp, 'c'=>$__cnx->c_p ]);
			}

			return _jEnc($rsp); 
			
		}
		
		
		
		public function _Bco_Upd($p=NULL){
			
			global $__cnx;
			
			$rsp['e'] = 'no';
			
			if(!isN($p['id'])){
				$this->nw_id_bco = $p['id'];
				$this->GtInfo();
			}
			   	
			
			if(!isN($this->__dtbco->id)){

				if(!isN($p['img'])){ $_upd[] = sprintf('bco_img=%s', GtSQLVlStr($p['img'], "text")); }
				if(!isN($p['org'])){ $_upd[] = sprintf('bco_org=%s', GtSQLVlStr($p['org'], "text")); }
				if(!isN($p['w'])){ $_upd[] = sprintf('bco_w=%s', GtSQLVlStr($p['w'], "text")); }
				if(!isN($p['h'])){ $_upd[] = sprintf('bco_h=%s', GtSQLVlStr($p['h'], "text")); }
				if(!isN($p['b'])){ $_upd[] = sprintf('bco_b=%s', GtSQLVlStr($p['b'], "text")); }
				if(!isN($p['aws'])){ $_upd[] = sprintf('bco_aws=%s', GtSQLVlStr($p['aws'], "int")); }
				if(!isN($p['aws_w'])){ $_upd[] = sprintf('bco_aws_w=%s', GtSQLVlStr(ctjTx($p['aws_w'],'out'), "text")); }
				if(!isN($p['aws_c'])){ $_upd[] = sprintf('bco_aws_c=%s', GtSQLVlStr(ctjTx($p['aws_c'],'out'), "text")); }
				if(!isN($p['ornt'])){ $_upd[] = sprintf('bco_ornt=%s', GtSQLVlStr($p['ornt'], "int")); }
				if(!isN($p['est'])){ $_upd[] = sprintf('bco_est=%s', GtSQLVlStr($p['est'], "int")); }
						
				if(count($_upd) > 0){
					
					try{	
						$updateSQL = "UPDATE "._BdStr(DBM).TB_BCO." SET ".implode(',', $_upd)." WHERE id_bco=".GtSQLVlStr( $this->__dtbco->id, "int");
						//$rsp['q'] = $updateSQL;
						$ResultUPD = $__cnx->_prc($updateSQL);	
					}catch(Exception $e) {
						$rsp['w'] = $e->getMessage();
					}
				
				}
				
				if($ResultUPD){
					$rsp['e'] = 'ok';
				}else{
					$rsp = $this->_eNo([ 'r'=>$rsp, 'c'=>$__cnx->c_p ]);
				}
				
			}else{	
				$rsp['w'] = 'no all data';	
			}
				
			return _jEnc($rsp);	
		}
		
		
		
		
		function _Are($p=NULL){
		
			if(!isN( $this->are )){
				foreach($this->are as $_are_k=>$_are_v){
					$__chk = GtBcoAreDt([ 'bco'=>$this->nw_id_bco, 'are'=>$_are_v ]);
					if(isN($__chk->id)){ 
						$_prc = $this->_Are_In([ 'bco'=>$this->nw_id_bco, 'are'=>$_are_v ]);
						$rsp[] = $_prc; 
					}
				}
			}  
			
			return _jEnc($rsp); 
			
	    }
	
	
	    
	    public function _Are_In($p=NULL){
			
			global $__cnx;
			
			if(!isN($p['bco']) && !isN($p['are'])){
					
				$__enc = Enc_Rnd($p['bco'].'-'.$p['are']);
				
				$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_BCO_ARE." (bcoare_enc, bcoare_bco, bcoare_are) VALUES (%s,%s,%s)",
									GtSQLVlStr($__enc, "text"),
								    GtSQLVlStr($p['bco'], "int"),
								    GtSQLVlStr($p['are'], "int"));		
																
				$Result = $__cnx->_prc($query_DtRg);
	
			}
			
			if($Result){	
				$rsp['e'] = 'ok';
				$rsp['id'] = $__cnx->c_p->insert_id;;
			}else{
				$rsp = $this->_eNo([ 'r'=>$rsp, 'c'=>$__cnx->c_p ]);
			}

			return _jEnc($rsp); 
			
		}	
		
		
		public function _Are_Del($p=NULL){
			
			global $__cnx;
			
			if(!isN($p['bco']) && !isN($p['are'])){
				$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_BCO_ARE." WHERE bcoare_bco=%s AND bcoare_are=%s",
											GtSQLVlStr($p['bco'], "int"),
											GtSQLVlStr($p['are'], "int"));		
	
				$Result = $__cnx->_prc($query_DtRg);	
			}	
					
			if($Result){		
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;	
			}else{
				$rsp = $this->_eNo([ 'r'=>$rsp, 'c'=>$__cnx->c_p ]);
			}

			return _jEnc($rsp); 
			
		}
		
		
		
		
		
		function _Cd($p=NULL){
		
			if(!isN( $this->cd )){
				foreach($this->cd as $_cd_k=>$_cd_v){
					$__chk = GtBcoCdDt([ 'bco'=>$this->nw_id_bco, 'cd'=>$_cd_v ]);
					if(isN($__chk->id)){ 
						$_prc = $this->_Cd_In([ 'bco'=>$this->nw_id_bco, 'cd'=>$_cd_v ]); 
						$rsp[] = $_prc; 
					}
				}
			}  
			
			return _jEnc($rsp); 
			
	    }
	
	
	    
	    public function _Cd_In($p=NULL){
			
			global $__cnx;
			
			if(!isN($p['bco']) && !isN($p['cd'])){
					
				$__enc = Enc_Rnd($p['bco'].'-'.$p['are']);
				
				$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_BCO_CD." (bcocd_enc, bcocd_bco, bcocd_cd) VALUES (%s,%s,%s)",
									GtSQLVlStr($__enc, "text"),
								    GtSQLVlStr($p['bco'], "int"),
								    GtSQLVlStr($p['cd'], "int"));		
																
				$Result = $__cnx->_prc($query_DtRg);
			
			}
			
			if($Result){	
				$rsp['e'] = 'ok';
				$rsp['id'] = $__cnx->c_p->insert_id;;
			}else{
				$rsp = $this->_eNo([ 'r'=>$rsp, 'c'=>$__cnx->c_p ]);
			}

			return _jEnc($rsp); 
			
		}	
		
		
		public function _Cd_Del($p=NULL){
			
			global $__cnx;
			
			if(!isN($p['bco']) && !isN($p['cd'])){
				
				$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_BCO_CD." WHERE bcocd_bco=%s AND bcocd_cd=%s",
											GtSQLVlStr($p['bco'], "int"),
											GtSQLVlStr($p['cd'], "int"));		
	
				$Result = $__cnx->_prc($query_DtRg);	
			
			}
					
			if($Result){		
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;	
			}else{
				$rsp = $this->_eNo([ 'r'=>$rsp, 'c'=>$__cnx->c_p ]);
			}

			return _jEnc($rsp); 
			
		}
		
		
		
		
		
		
		
		
		
		function _Tag($p=NULL){
		
			if(!isN( $this->tag )){
				foreach($this->tag as $_tag_k=>$_tag_v){
					$__chk = GtBcoTagDt([ 'bco'=>$this->nw_id_bco, 'tag_es'=>$_tag_v ]);
					if(isN($__chk->id)){ 
						$_prc = $this->_Tag_In([ 'bco'=>$this->nw_id_bco, 'tag_es'=>$_tag_v ]);
						$rsp[] = $_prc; 
					}
				}
			}  
			
			return _jEnc($rsp); 
	    }
	
	
	    
	    public function _Tag_In($p=NULL){
			
			global $__cnx;
			
			if(!isN($p['bco']) && ( !isN($p['tag_es']) || !isN($p['tag_en']) )){
					
				if(!isN($p['aws'])){ $_aws = $p['aws']; }else{ $_aws = 2; }
					
				$__enc = Enc_Rnd($p['bco'].'-'.$p['tag_es']);
				
				$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_BCO_TAG." (bcotag_enc, bcotag_bco, bcotag_tag_es, bcotag_tag_en, bcotag_tag_it, bcotag_tag_fr, bcotag_tag_gr, bcotag_tag_krn, bcotag_tag_jpn, bcotag_tag_ptg, bcotag_tag_mdn, bcotag_cnfd, bcotag_aws) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
									GtSQLVlStr($__enc, "text"),
								    GtSQLVlStr($p['bco'], "int"),
								    GtSQLVlStr(ctjTx($p['tag_es'],'out'), "text"),
								    GtSQLVlStr(ctjTx($p['tag_en'],'out'), "text"),
								    GtSQLVlStr(ctjTx($p['tag_it'],'out'), "text"),
								    GtSQLVlStr(ctjTx($p['tag_fr'],'out'), "text"),
								    GtSQLVlStr(ctjTx($p['tag_gr'],'out'), "text"),
								    GtSQLVlStr(ctjTx($p['tag_krn'],'out'), "text"),
								    GtSQLVlStr(ctjTx($p['tag_jpn'],'out'), "text"),
								    GtSQLVlStr(ctjTx($p['tag_ptg'],'out'), "text"),
								    GtSQLVlStr(ctjTx($p['tag_mdn'],'out'), "text"),
								    GtSQLVlStr(ctjTx($p['cnfd'],'out'), "text"),
								    GtSQLVlStr($_aws, "int")); 
								    													
				$Result = $__cnx->_prc($query_DtRg);
				
				if($Result){	
					$rsp['e'] = 'ok';
					$rsp['id'] = $__cnx->c_p->insert_id;
				}else{
					$rsp = $this->_eNo([ 'r'=>$rsp, 'c'=>$__cnx->c_p ]);
					$rsp['q'] = $query_DtRg;
				}
			
			}else{
				
				$rsp['w'] = 'no data';
				
			}
			
			return _jEnc($rsp); 
			
		}	
		
		
		
		public function _Tag_Upd($p=NULL){
			
			global $__cnx;
			
			$rsp['e'] = 'no';
			
			if(!isN($p['id'])){

				if(!isN($p['en'])){ $_upd[] = sprintf('bcotag_tag_en=%s', GtSQLVlStr($p['en'], "text")); }
				if(!isN($p['it'])){ $_upd[] = sprintf('bcotag_tag_it=%s', GtSQLVlStr($p['it'], "text")); }
				if(!isN($p['fr'])){ $_upd[] = sprintf('bcotag_tag_fr=%s', GtSQLVlStr($p['fr'], "text")); }
				if(!isN($p['gr'])){ $_upd[] = sprintf('bcotag_tag_gr=%s', GtSQLVlStr($p['gr'], "text")); }
				if(!isN($p['krn'])){ $_upd[] = sprintf('bcotag_tag_krn=%s', GtSQLVlStr($p['krn'], "text")); }
				if(!isN($p['jpn'])){ $_upd[] = sprintf('bcotag_tag_jpn=%s', GtSQLVlStr($p['jpn'], "text")); }
				if(!isN($p['ptg'])){ $_upd[] = sprintf('bcotag_tag_ptg=%s', GtSQLVlStr($p['ptg'], "text")); }
				if(!isN($p['mdn'])){ $_upd[] = sprintf('bcotag_tag_mdn=%s', GtSQLVlStr($p['mdn'], "text")); }
						
				if(count($_upd) > 0){
					
					try{	
						$updateSQL = "UPDATE "._BdStr(DBM).TB_BCO_TAG." SET ".implode(',', $_upd)." WHERE id_bcotag=".GtSQLVlStr( $p['id'], "int");
						$ResultUPD = $__cnx->_prc($updateSQL);	
					}catch(Exception $e) {
						$rsp['w'] = $e->getMessage();
					}
				
				}
				
				if($ResultUPD){
					$rsp['e'] = 'ok';
				}else{
					$rsp = $this->_eNo([ 'r'=>$rsp, 'c'=>$__cnx->c_p ]);
				}
				
			}else{	
				$rsp['w'] = 'no all data';	
			}
				
			return _jEnc($rsp);	
		}
		
		
		
		public function _Tag_Del($p=NULL){
			
			global $__cnx;
			
			if(!isN($p['bco']) && !isN($p['tag'])){
				
				$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_BCO_TAG." WHERE bcotag_bco=%s AND bcotag_tag_es=%s",
											GtSQLVlStr($p['bco'], "int"),
											GtSQLVlStr($p['tag'], "text"));		
	
				$Result = $__cnx->_prc($query_DtRg);	
				
			}
					
			if($Result){		
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;	
			}else{
				
				$rsp = $this->_eNo([ 'r'=>$rsp, 'c'=>$__cnx->c_p ]);
			}

			return _jEnc($rsp); 
			
		}
		
		
		
		
		
		
		
		
		function _Attr($p=NULL){
		
			if(!isN( $this->exif )){
				foreach($this->exif as $_exif_s_k=>$_exif_s_v){
					foreach($_exif_s_v as $_exif_k=>$_exif_v){
						$__chk = GtBcoAttrDt([ 'bco'=>$this->nw_id_bco, 'attr'=>$_exif_v ]);
						if(isN($__chk->id)){ 
							$_prc = $this->_Attr_In([ 'bco'=>$this->nw_id_bco, 'attr'=>$_exif_k, 'vl'=>$_exif_v, 'tcn'=>1 ]); 
							$rsp[] = $_prc; 
						}
					}
				}
			}					
					
			if(!isN( $this->attr )){
				foreach($this->attr as $_attr_k=>$_attr_v){
					$__chk = GtBcoAttrDt([ 'bco'=>$this->nw_id_bco, 'attr'=>$_attr_v ]);
					if(isN($__chk->id)){ 
						$_prc = $this->_Attr_In([ 'bco'=>$this->nw_id_bco, 'attr'=>$_attr_v, 'img'=>1 ]); 
						$rsp[] = $_prc; 
					}
				}
			}  
		
			return _jEnc($rsp); 
			
	    }
	
	
	    
	    public function _Attr_In($p=NULL){
			
			global $__cnx;
			
			if(!isN($p['tcn'])){ $__tcn = $p['tcn']; }else{ $__tcn = 2; }
			if(!isN($p['img'])){ $__img = $p['img']; }else{ $__img = 2; }
			
			if(!isN($p['bco']) && !isN($p['attr'])){
					
				$__enc = Enc_Rnd($p['bco'].'-'.$p['dt']);
				
				$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_BCO_ATTR." (bcoattr_enc, bcoattr_bco, bcoattr_k, bcoattr_v, bcoattr_tcn, bcoattr_img) VALUES (%s,%s,%s,%s,%s,%s)",
									GtSQLVlStr($__enc, "text"),
								    GtSQLVlStr($p['bco'], "int"),
								    GtSQLVlStr(ctjTx($p['attr'],'out'), "text"),
								    GtSQLVlStr(ctjTx($p['vl'],'out'), "text"),
								    GtSQLVlStr($__tcn, "int"),
								    GtSQLVlStr($__img, "int"));	
																
				$Result = $__cnx->_prc($query_DtRg);
				
			}
			
			if($Result){	
				$rsp['e'] = 'ok';
				$rsp['id'] = $__cnx->c_p->insert_id;;
			}else{
				$rsp = $this->_eNo([ 'r'=>$rsp, 'c'=>$__cnx->c_p ]);
			}

			return _jEnc($rsp); 
			
		}	
		
		
		public function _Attr_Del($p=NULL){
			
			global $__cnx;
			
			if(!isN($p['bco']) && !isN($p['cd'])){
				
				$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_BCO_ATTR." WHERE bcocd_bco=%s AND bcocd_cd=%s",
											GtSQLVlStr($p['bco'], "int"),
											GtSQLVlStr($p['cd'], "int"));		
	
				$Result = $__cnx->_prc($query_DtRg);	
			
			}
					
			if($Result){		
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;	
			}else{
				$rsp = $this->_eNo([ 'r'=>$rsp, 'c'=>$__cnx->c_p ]);
			}

			return _jEnc($rsp); 
			
		}
		
		
		
		
		function _ChkTp($p=NULL){
		
			if(!isN( $this->chk )){
				foreach($this->chk as $_chk_k=>$_chk_v){
					$__chk = GtBcoChkDt([ 'bco'=>$this->nw_id_bco, 'chk'=>$_chk_v ]);
					if(isN($__chk->id)){ 
						$_prc = $this->_ChkTp_In([ 'bco'=>$this->nw_id_bco, 'chk'=>$_chk_v ]);
						$rsp[] = $_prc; 
					}
				}
			}  
			
			return _jEnc($rsp); 
			
	    }
	
	
	    
	    public function _ChkTp_In($p=NULL){
			
			global $__cnx;
			
			if(!isN($p['bco']) && !isN($p['chk'])){
				
				$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_BCO_CHK." (bcochk_bco, bcochk_chktp) VALUES (%s,%s)",
								    GtSQLVlStr($p['bco'], "int"),
								    GtSQLVlStr($p['chk'], "int"));		
																
				$Result = $__cnx->_prc($query_DtRg);
				
			}
			
			if($Result){	
				$rsp['e'] = 'ok';
				$rsp['id'] = $__cnx->c_p->insert_id;;
			}else{
				$rsp = $this->_eNo([ 'r'=>$rsp, 'c'=>$__cnx->c_p ]);
			}

			return _jEnc($rsp); 
			
		}
		
		
		
		public function _ChkTp_Upd($p=NULL){
			
			global $__cnx;
			
			$rsp['e'] = 'no';
			
			if(!isN($p['id'])){

				if(!isN($p['w'])){ $_upd[] = sprintf('bcochk_w=%s', GtSQLVlStr($p['w'], "text")); }
				if(!isN($p['h'])){ $_upd[] = sprintf('bcochk_h=%s', GtSQLVlStr($p['h'], "text")); }
						
				if(count($_upd) > 0){
					
					try{	
						$updateSQL = "UPDATE "._BdStr(DBM).TB_BCO_CHK." SET ".implode(',', $_upd)." WHERE id_bcochk=".GtSQLVlStr( $p['id'], "int"); //$rsp['q'] = $updateSQL;
						$ResultUPD = $__cnx->_prc($updateSQL);	
					}catch(Exception $e) {
						$rsp['w'] = $e->getMessage();
					}
				
				}
				
				if($ResultUPD){
					$rsp['e'] = 'ok';
				}else{
					$rsp = $this->_eNo([ 'r'=>$rsp, 'c'=>$__cnx->c_p ]);
				}
				
			}else{	
				$rsp['w'] = 'no all data';	
			}
				
			return _jEnc($rsp);	
		}

		
		
		
		public function _Fce_In($p=NULL){
			
			global $__cnx;
			
			if(!isN($p['bco']) && !isN($p['id'])){
					
				$__enc = Enc_Rnd($p['bco'].'-'.$p['id']);
				
				$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_BCO_FCE." (bcofce_enc, bcofce_bco, bcofce_id) VALUES (%s,%s,%s)",
									GtSQLVlStr($__enc, "text"),
								    GtSQLVlStr($p['bco'], "int"),
								    GtSQLVlStr(ctjTx($p['id'],'out'), "text"));
																
				$Result = $__cnx->_prc($query_DtRg);
			
			}
			
			if($Result){	
				$rsp['e'] = 'ok';
				$rsp['id'] = $__cnx->c_p->insert_id;;
			}else{
				$rsp = $this->_eNo([ 'r'=>$rsp, 'c'=>$__cnx->c_p ]);
			}

			return _jEnc($rsp); 
			
		}
		
		
		public function _Fce_Upd($p=NULL){
			
			global $__cnx;
			
			$rsp['e'] = 'no';
			
			if(!isN($p['id'])){

				if(!isN($p['img'])){ $_upd[] = sprintf('bcofce_img=%s', GtSQLVlStr($p['img'], "text")); }
				if(!isN($p['cnfd'])){ $_upd[] = sprintf('bcofce_cnfd=%s', GtSQLVlStr($p['cnfd'], "text")); }
						
				if(count($_upd) > 0){
					
					try{	
						$updateSQL = "UPDATE "._BdStr(DBM).TB_BCO_FCE." SET ".implode(',', $_upd)." WHERE id_bcofce=".GtSQLVlStr( $p['id'], "int"); //$rsp['q'] = $updateSQL;
						$ResultUPD = $__cnx->_prc($updateSQL);	
					}catch(Exception $e) {
						$rsp['w'] = $e->getMessage();
					}
				
				}
				
				if($ResultUPD){
					$rsp['e'] = 'ok';
				}else{
					$rsp = $this->_eNo([ 'r'=>$rsp, 'c'=>$__cnx->c_p ]);
				}
				
			}else{	
				$rsp['w'] = 'no all data';	
			}
				
			return _jEnc($rsp);	
		}
		
		
		
		
		
		function _Fce_Attr($p=NULL){
			
			if(!isN( $p['id'] ) && !isN( $p['attr'] )){
				
				$__tot_bd = 0;
				$__tot = count($p['attr']);
				
				foreach($p['attr'] as $_attr_k=>$_attr_v){
					
					$__chk = GtBcoFceAttrDt([ 'bco_fce'=>$p['id'], 'key'=>$_attr_k ]);
					
					if(isN($__chk->id)){ 
						$_prc = $this->_Fce_Attr_In([ 'bco_fce'=>$p['id'], 'key'=>$_attr_k, 'vl'=>$_attr_v ]);
						$rsp['ls'][] = $_prc; 
						
						if($_prc->e == 'ok'){ $__tot_bd++; }
						
					}else{
						
						$__tot_bd++;
					}
				}
				
				$rsp['tot']['g'] = $__tot;
				$rsp['tot']['in'] = $__tot_bd;

			}  
			
			return _jEnc($rsp); 
			
	    }
	
	
	    
	    public function _Fce_Attr_In($p=NULL){
			
			global $__cnx;
			
			if(!isN($p['bco_fce']) && !isN($p['key'])){
				
				$__enc = Enc_Rnd($p['bco_fce'].'-'.$p['key']); 
				
				if(is_array($p['vl']) || is_object($p['vl'])){ $vl = json_encode($p['vl']); }else{ $vl = $p['vl']; }
				
				$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_BCO_FCE_ATTR." (bcofceattr_enc, bcofceattr_bcofce, bcofceattr_key, bcofceattr_vl) VALUES (%s,%s,%s,%s)",
								    GtSQLVlStr(ctjTx($__enc,'out'), "text"),
								    GtSQLVlStr($p['bco_fce'], "int"),
								    GtSQLVlStr(ctjTx($p['key'],'out'), "text"),
								    GtSQLVlStr(ctjTx($vl,'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']), "text"));
																
				$Result = $__cnx->_prc($query_DtRg);
				
			}
			
			if($Result){	
				$rsp['e'] = 'ok';
				$rsp['id'] = $__cnx->c_p->insert_id;;
			}else{
				$rsp = $this->_eNo([ 'r'=>$rsp, 'c'=>$__cnx->c_p ]);
			}

			return _jEnc($rsp); 
			
		}
		
		
		function _Aws($p=NULL){
			
			$this->GtInfo();
			
			$__flee = '../../'.DIR_BCO_TH.'bg_'.$this->__dtbco->img;
			$__flee_o = '../../'.DIR_BCO.$this->__dtbco->img;
			
			if(file_exists( $__flee )){
				
				$_scan = $this->_aws->_imgattr([ 'fle'=>$__flee, 'fle_o'=>$__flee_o, 'id'=>$this->__dtbco->id ]);
				
				//echo h2('Faces Total:'.$_scan->fces->tot);
				
				if(!isN($_scan->w_c)){
					
					$__upd = $this->_Bco_Upd([ 'aws'=>1, 'aws_w'=>$_scan->w, 'aws_c'=>$_scan->w_c ]);
					
				}else{
					
					if($_scan->fces->tot > 0 && !isN( $_scan->fces->ls )){
						
						$rsp['tot']['fce'] = $_scan->fces->tot;
						
						$fces_s_tot = 0;
						
						foreach($_scan->fces->ls as $_fces_k=>$_fces_v){ 
							
							$__chk = GtBcoFceDt([ 'bco'=>$this->nw_id_bco, 'cid'=>$_fces_k ]);			
							
							if(isN($__chk->id)){
								
								$_prc = $this->_Fce_In([ 'bco'=>$this->nw_id_bco, 'id'=>$_fces_k, 'attr'=>$_fces_v->d ]);
								$rsp['fce'][] = $_prc; 
								
								if($_prc->e == 'ok'){ 
									
									$__chk = GtBcoFceDt([ 'bco'=>$this->nw_id_bco, 'cid'=>$_fces_k ]);
									
									$__nmfce_n = 'bco_fce_'.$__chk->id.'.jpg';
									$__nmfce_f = '../../'.DIR_BCO_FCE.$__nmfce_n; 
									$__nmfce_t = '../../'.DIR_BCO_FCE_TH.$__nmfce_n; 
	
									$image_bg = new Imagick($__flee_o);
									$image_bg->setImageFormat ("jpeg");
									$image_bg->setImageCompression(imagick::COMPRESSION_JPEG);
									$image_bg->setImageCompressionQuality(0);
									$image_bg->cropImage($_fces_v->cut->width, $_fces_v->cut->height, $_fces_v->cut->left, $_fces_v->cut->top);
	
									
									if($image_bg->writeImage($__nmfce_f)){
										
										$_sve = $this->_aws->_s3_put([ 'b'=>'bco', 'fle'=>_TmpFixDir('fce/'.$__nmfce_n), 'src'=>$__nmfce_f, 'ctp'=>mime_content_type($__nmfce_f), 'cfr'=>'ok' ]);
										
										$image_bg->clear();
										$this->_Fce_Upd([ 'id'=>$__chk->id, 'img'=>$__nmfce_n, 'cnfd'=>$_fces_v->d->Confidence ]);
	
										$image_th = new Imagick($__nmfce_f);
										$image_th->setImageFormat ("jpeg");
										$image_th->setImageCompression(imagick::COMPRESSION_JPEG);
										$image_th->setImageCompressionQuality(0.3);
										$image_th->thumbnailImage(50, 0);
										
										if($image_th->writeImage($__nmfce_t)){
											
											$_sve = $this->_aws->_s3_put([ 'b'=>'bco', 'fle'=>_TmpFixDir('fce/th/'.$__nmfce_n), 'src'=>$__nmfce_t, 'ctp'=>mime_content_type($__nmfce_t), 'cfr'=>'ok' ]);
											
											$image_th->clear();
											$image_th->destroy();
											
											$fces_s_tot++;
											
											$rsp['allw_fce']['sve'][] = $__nmfce_t.' saved';
											
										}else{
											
											$rsp['allw_fce']['sve'][] = $__nmfce_t.' not saved thumb';
											
										}
										
									}else{
											
										$rsp['allw_fce']['sve'][] = $__nmfce_t.' not saved original';
										
									}
	
								}else{
											
									$rsp['allw_fce']['sve'][] = $__nmfce_t.' not saved on tryng insert';
									
								}
								
							}else{
								
								
								$rsp['allw_fce']['sve'][] = $__chk->id.' existed before';
								$fces_s_tot++;
								
							}
							
							
							if($_prc->e == 'ok' || !isN($__chk->id)){
								
								$__attr_in = $this->_Fce_Attr([ 'id'=>$__chk->id, 'attr'=>$_fces_v->d ]);
								
								$rsp['tot']['fce']['ls'][$__chk->id]['attr']['get'] = $__attr_in->tot->g;
								$rsp['tot']['fce']['ls'][$__chk->id]['attr']['in'] = $__attr_in->tot->in;
									
								//if($__attr_in->tot->g != $__attr_in->tot->in || isN($__attr_in->tot->g)){ $___allw_s = 'no'; }	
								
							}
							
						
						}
						
						//echo h3($fces_s_tot.' != '.$_scan->fces->tot);
						
						if($fces_s_tot != $_scan->fces->tot){ 
							
							$rsp['allw_fce']['stot'] = $fces_s_tot;
							$rsp['allw_fce']['tot'] = $_scan->fces->tot;
							
							$___allw_s = 'no'; 
							$___allw_s_m[] = 'Not same faces inserted';  
						}
						
						
					}
					
					
					
					if($_scan->lbl->tot > 0 && !isN( $_scan->lbl->ls )){
						
						
						$lbl_s_tot = 0;
						$rsp['tot']['lbl'] = $_scan->lbl->tot;
						
						
						foreach($_scan->lbl->ls as $_lbl_k=>$_lbl_v){
							
							$_osn = '';
							$__chk = GtBcoTagDt([ 'bco'=>$this->nw_id_bco, 'tag_es'=>$_lbl_v->lng->es ]);
							
							if(isN($__chk->id)){ 
								
								$_osn['bco'] = $this->nw_id_bco;
								$_osn['aws'] = 1;
								$_osn['cnfd'] = $_lbl_v->cnfd;
								
								
								foreach($_lbl_v->lng as $_lbl_l_k=>$_lbl_l_v){
									$_osn['tag_'.$_lbl_l_k] = $_lbl_l_v;
								}
								
								$_prc = $this->_Tag_In($_osn);
								
								$rsp['lbl'][] = $_prc; 
								
								if($_prc->e == 'ok'){ $lbl_s_tot++; }
								
							}else{
								
								$lbl_s_tot++;
								
							}
							
						}
						
						if($lbl_s_tot != $_scan->lbl->tot){ 
							
							$rsp['allw_lbl']['stot'] = $lbl_s_tot;
							$rsp['allw_lbl']['tot'] = $_scan->lbl->tot;
							
							$___allw_s = 'no'; 
							$___allw_s_m[] = 'Not same labels inserted';
						}
					} 
					
					if(isN($_scan->w) && $_scan->lbl->tot == 0 && $_scan->fces->tot == 0){
						$this->_Bco_Upd([ 'aws'=>1, 'aws_w'=>'No data from AWS' ]); 
					}elseif($___allw_s != 'no'){ 
						$this->_Bco_Upd([ 'aws'=>1 ]); 
					}else{
						echo h1($this->__dtbco->id.' allw_s: '.$___allw_s.' -> '.print_r( $___allw_s_m , true));
					}
				
				}
				
				
				$rsp['allw_set']['e'] = $___allw_s;
				$rsp['allw_set']['m'] = $___allw_s_m;
				
			
			}elseif($this->__dtbco->out == 'no'){
				
				$__upd = $this->_Bco_Upd([ 'aws'=>3 ]);
				
			}
		
			return _jEnc($rsp); 
			
	    }
	    
	    public function BcoAre_Ls($p=NULL){
			
			global $__cnx;	

			if(!isN($this->bco_tp) && $this->bco_tp == 'hm'){ $fl = "HAVING __est > 0"; }else{ $fl = ""; }
									
			$query_DtRg = "	SELECT
								clare_enc, clare_tt,clare_clr,(
									SELECT
										COUNT(*)
									FROM
										"._BdStr(DBM).TB_BCO_ARE." ,
										"._BdStr(DBM).TB_BCO."
									WHERE
											bcoare_are = id_clare
										AND id_bco = bcoare_bco
										AND bcoare_bco = ( SELECT id_bco FROM "._BdStr(DBM).TB_BCO." WHERE bco_enc = '".$this->bco_id."' )
								) as __est
							FROM
								"._BdStr(DBM).TB_CL_ARE."
							WHERE
								clare_cl = ( SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = '".CL_ENC."' ) $fl 
									ORDER BY __est DESC, clare_tt ASC";
			
			$DtRg = $__cnx->_qry($query_DtRg);
					
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;
				
				if($Tot_DtRg > 0){
					
					$Vl['e'] = 'ok';
					
					do{	
						$Vl['ls'][$row_DtRg['clare_enc']]['enc'] = $row_DtRg['clare_enc'];	
						$Vl['ls'][$row_DtRg['clare_enc']]['nm'] = ctjTx($row_DtRg['clare_tt'],'in');
						$Vl['ls'][$row_DtRg['clare_enc']]['clr'] = ctjTx($row_DtRg['clare_clr'],'in');
						$Vl['ls'][$row_DtRg['clare_enc']]['tot'] = $row_DtRg['__est'];
					}while($row_DtRg = $DtRg->fetch_assoc());
					
				}
				
			}
			
			$__cnx->_clsr($DtRg);

			return _jEnc($Vl);	
  
        }
        
	    public function BcoAre_In($p=NULL){
			
			global $__cnx;
			
			$__enc = Enc_Rnd($this->are_id.' - '.$this->bco_id);
			
			$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_BCO_ARE." (bcoare_enc, bcoare_are, bcoare_bco) VALUES 
										(
											%s,
											(SELECT id_clare FROM "._BdStr(DBM).TB_CL_ARE." WHERE clare_enc = %s), 
											(SELECT id_bco FROM "._BdStr(DBM).TB_BCO." WHERE bco_enc = %s)
										)",
											GtSQLVlStr(ctjTx($__enc,'out'), "text"),
											GtSQLVlStr(ctjTx($this->are_id,'out'), "text"),
											GtSQLVlStr(ctjTx($this->bco_id,'out'), "text"));		
			
			$Result = $__cnx->_prc($query_DtRg);
			
			if($Result){	
				
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}
			
			return _jEnc($rsp); 
			
		} 
		
	    public function BcoAre_Del($p=NULL){
			
			global $__cnx;
			
			$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_BCO_ARE." WHERE 
										bcoare_are IN (SELECT id_clare FROM "._BdStr(DBM).TB_CL_ARE." WHERE clare_enc = %s) AND 
										bcoare_bco IN (SELECT id_bco FROM "._BdStr(DBM).TB_BCO." WHERE bco_enc = %s)",
			
								GtSQLVlStr(ctjTx($this->are_id,'out'), "text"),
								GtSQLVlStr(ctjTx($this->bco_id,'out'), "text"));		
			
			$Result = $__cnx->_prc($query_DtRg);
					
			if($Result){	
				
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}
			
			return _jEnc($rsp); 
			
		}
	    
		public function BcoTag_Ls($p=NULL){
			
			global $__cnx;
			
			$query_DtRgs = " SELECT id_bco FROM "._BdStr(DBM).TB_BCO." WHERE bco_enc = '".$this->bco_id."'";
			$DtRgs = $__cnx->_qry($query_DtRgs);
					
			if($DtRgs){
				$row_DtRgs = $DtRgs->fetch_assoc();
				$Vl['id'] = $row_DtRgs['id_bco'];
			}
			
			/* - - - Lista de Tags - - - */
			
			$query_DtRg = "	SELECT
								*
							FROM
								"._BdStr(DBM).TB_BCO_TAG."
							WHERE
								bcotag_bco = ( SELECT id_bco FROM "._BdStr(DBM).TB_BCO." WHERE bco_enc = '".$this->bco_id."' )";
			
			$DtRg = $__cnx->_qry($query_DtRg);
					
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;
				
				if($Tot_DtRg > 0){
					
					$Vl['e'] = 'ok';
					$_cnfd = number_format(ctjTx($row_DtRg['bcotag_cnfd'],'in'), 0, '.', '');
					
					do{	
						$Vl['ls'][$row_DtRg['bcotag_enc']]['enc'] = $row_DtRg['bcotag_enc'];	
						$Vl['ls'][$row_DtRg['bcotag_enc']]['nm'] = ctjTx($row_DtRg['bcotag_tag_es'],'in');
						$Vl['ls'][$row_DtRg['bcotag_enc']]['cnfd'] = $_cnfd;
						
						if(mBln($row_DtRg['bcotag_aws']) == 'no'){
							$Vl['ls'][$row_DtRg['bcotag_enc']]['cls'] = 'local';	
						}elseif($_cnfd > 80){
							$Vl['ls'][$row_DtRg['bcotag_enc']]['cls'] = 'high';	
						}elseif($_cnfd > 60){
							$Vl['ls'][$row_DtRg['bcotag_enc']]['cls'] = 'medium';	
						}else{
							$Vl['ls'][$row_DtRg['bcotag_enc']]['cls'] = 'low';	
						}
						
					}while($row_DtRg = $DtRg->fetch_assoc());
				}
			}
			
			
			$__cnx->_clsr($DtRgs);
			$__cnx->_clsr($DtRg);
			
			return _jEnc($Vl);	
  
        }
	     
	    
	    
	    
	    public function _Rote_Clr($p=NULL){
			
			global $__cnx;
			
			$__Cdn = new API_CRM_Cdn();
			$this->GtInfo();
			
			//$prc['dt'] = $this->__dtbco;
			
			if(!isN($this->__dtbco->img)){
				
				if(!isN($this->__dtbco->id)){
				
					$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_BCO_FCE." WHERE bcofce_bco=%s",
												GtSQLVlStr($this->__dtbco->id, "int"));		
					$ResultD = $__cnx->_prc($query_DtRg);
					
					
					$updateSQL = "UPDATE "._BdStr(DBM).TB_BCO_CHK." SET bcochk_w='', bcochk_h='' WHERE id_bcochk=".GtSQLVlStr( $this->__dtbco->id, "int");
					$ResultU = $__cnx->_prc($updateSQL);
					
					$this->_Bco_Upd([ 'aws'=>2 ]);	
						
				}
			
			}
		
			return _jEnc($prc);	
		
		} 
	    
		
			
	}
?>