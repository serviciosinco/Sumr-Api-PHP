<?php 
	 
	class CRM_Rd extends CRM_Cl{
	    
	    function __construct($p=NULL) { 
			
			global $__cnx;
			global $__dt_cl; 
			global $__argv;
	        
	        $this->c_r = $__cnx->c_r;
			$__cnx->c_p = $__cnx->c_p;
			
	        $this->_aud = new CRM_Aud();
			$this->_aws = new API_CRM_Aws();
			$this->_auto = new API_CRM_Auto([ 'argv'=>$__argv ]);
			
			if(!isN($__dt_cl) && !isN($__dt_cl->id)){
				$this->cl = $__dt_cl;
			}elseif(!isN($p['cl'])){ 
				$this->cl = GtClDt($p['cl']);
			}else{
				$this->cl = GtClDt( Gt_SbDMN(), "sbd");
			}
		
			
			if(!isN($this->cl->bd)){ $this->bd = _BdStr($this->cl->bd); }else{ $this->bd = ''; }
	    }
	    
	    function __destruct() {
	       parent::__destruct();
	   	}

		function bld_json(){

            $r['data']['account']['name'] = $this->cl->nm;
            $r['data']['account']['prfl'] = $this->cl->prfl;
			$r['data']['account']['color']['main'] = $this->cl->clr->main->v;
			$r['data']['account']['color']['second'] = $this->cl->clr->second->v;

			if(!isN($this->id_rd)){ 

				$_data_rd = $this->_rd_d = GtRdDt($this->id_rd);
				echo $this->_auto->li( 'Get GtRdDt data' );

				if(!isN( $this->_rd_d->id )){
					//$r['e'] = 'ok';
					$r['data']['id'] = $this->_rd_d->enc;
					$r['data']['name'] = $this->_rd_d->tt;
					$r['data']['permalink'] = $this->_rd_d->pml;	
					$r['data']['url'] = $this->_rd_d->url;
					$r['data']['logo'] = $this->_rd_d->logo;
					$r['data']['bckg'] = $this->_rd_d->bckg;
					$r['data']['thme'] = $this->_rd_d->thme;
				}

			}
			
			return _jEnc( $r );
			
		}
		
		function sve_json($p=NULL){

			if($p['t'] == 'rd'){

				$__json = $this->bld_json();
		
				if(!isN( $this->_rd_d->id )){

					$_json = cmpr_fm( json_encode( $__json->data ) );
					$_sve_json = $this->_aws->_s3_put([ 'b'=>'rd', 'fle'=>$this->_rd_d->enc.'.json', 'cbdy'=>$_json, 'ctp'=>'application/json' ]);

					if($_sve_json->e == 'ok'){
						$_r['e'] = 'ok';
					}

				}else{
					$_r['w'][] = 'No data on rd_d'; 
					$_r['w'][] = $this->_rd_d; 
				}

			}
	
			return _jEnc($_r);
	
		}


	}
	
?>