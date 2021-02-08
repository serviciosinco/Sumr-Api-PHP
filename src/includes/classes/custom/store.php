<?php

    class CRM_Store{
    
        function __construct($p=NULL) { 
            
            global $__dt_cl; 

            if(!isN($__dt_cl) && !isN($__dt_cl->id)){
                $this->cl = $__dt_cl;
            }elseif(!isN($p['cl'])){ 
                $this->cl = $p['cl']; 
            }
            
            if(!isN($this->cl->bd)){ $this->bd=_BdStr($this->cl->bd); }else{ $this->bd=''; }

            $this->out = new CRM_Out(); 
            $this->_aws = new API_CRM_Aws();

	    }
	    
	    function __destruct(){

        }

        
        public function GtDt($p=NULL){
		
            global $__cnx;
            
            $Vl['e'] = 'no';
            
            if(!isN($p['id'])){
                
                if($p['t'] == 'enc'){ $__f = 'store_enc'; $__ft = 'text'; }
                elseif($p['t'] == 'pml'){ $__f = 'store_pml'; $__ft = 'text'; }
                elseif($p['t'] == 'sbd'){ $__f = 'CONCAT(cldmnsub_sub,\'.\',cldmn_dmn)'; $__ft = 'text'; }
                else{ $__f = 'id_store'; $__ft = 'int'; }
                
                if($p['strt']=='ok'){
                    $_slc = 'id_store, store_enc';
                }else{
                    $_slc = 'id_store, store_enc, store_nm, store_pml, store_img';
                }

                $query_DtRg = sprintf('	SELECT '.$_slc.'                                            
                                        FROM '._BdStr(DBS).TB_STORE.'
                                             INNER JOIN '._BdStr(DBM).TB_CL_DMN_SUB.' ON store_sbd = id_cldmnsub
                                             INNER JOIN '._BdStr(DBM).TB_CL_DMN.' ON cldmnsub_cldmn = id_cldmn
                                        WHERE '.$__f.' = %s 
                                        LIMIT 1', GtSQLVlStr($p['id'], $__ft));
                                        
                $DtRg = $__cnx->_qry($query_DtRg);

                if($DtRg){
                    
                    $row_DtRg = $DtRg->fetch_assoc(); 
                    $Tot_DtRg = $DtRg->num_rows;	
                
                    if($Tot_DtRg > 0){
                        
                        $Vl['e'] = 'ok';

                        $Vl['enc'] = $row_DtRg['store_enc'];

                        if($p['strt']!='ok'){
                            $Vl['nm'] = ctjTx($row_DtRg['store_nm'],'in');
                            $Vl['pml'] = ctjTx($row_DtRg['store_pml'],'in');
                            $Vl['img'] = _ImVrs(['img'=>ctjTx($row_DtRg['store_img'],'in'), 'f'=>DMN_FLE_CL_STORE ]);
                        }
                    
                    }
            
                }
    
                $__cnx->_clsr($DtRg);
                
            }else{
                
                $Vl['p'] = $p;
                $Vl['w'] = 'No all data';
                
            }
                                
            return(_jEnc($Vl));

        }


        function bld_json(){

            $this->_store_d = $this->GtDt([ 'id'=>$this->id_store, 't'=>'enc' ]); 
            
            if(!isN( $this->_store_d->enc )){
    
                $r['e'] = 'ok';
                $r['data']['id'] = $this->_store_d->enc;
                $r['data']['name'] = $this->_store_d->nm;
                $r['data']['permalink'] = $this->_store_d->pml;
                $r['data']['assets']['logo'] = $this->_store_d->img;
    
            }
            
            return _jEnc( $r );
            
        }
    
    
        function sve_json(){
            
            $_r['e'] = 'no';

            $__json = $this->bld_json();
    
            if(!isN( $this->_store_d->enc )){
    
                $_json = ''.cmpr_fm( json_encode( $__json->data ) ).'';
                $_css = cmpr_css( $__json->css );
    
                $_sve_json = $this->_aws->_s3_put([ 'b'=>'store', 'fle'=>$this->_store_d->enc.'.json', 'cbdy'=>$_json, 'ctp'=>'application/json', 'cfr'=>'ok' ]);
    
                if($_sve_json->e == 'ok'){
                    $_r['e'] = 'ok';
                }else{
                    $_r['e'] = 'no';
                    $_r['r'] = $_sve_json;
                }
            }
    
            return _jEnc($_r);
    
        }



    }

?>