<?php 	

    try{
    
        if(class_exists('CRM_Cnx')){

            if($this->_s_cl->tot > 0){
			
                foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){
                    
                    if($this->tallw_cl([ 't'=>'key', 'id'=>'tot_ec_snd', 'cl'=>$_cl_v->id ])->est == 'ok'){
                        //ec_snd
                        $_Ec_Snd_All = GtEcSndTot([ 't'=>'all', 'bd'=>$_cl_v->bd ])->tot; //Total
                        $_Ec_Snd_Acpt = GtEcSndTot([ 't'=>'snd', 'bd'=>$_cl_v->bd ])->tot; //Enviados
                        $_Ec_Snd_Op = GtEcSndTot([ 't'=>'op', 'bd'=>$_cl_v->bd ])->tot; //Abiertos
                        $_Ec_Snd_Err = GtEcSndTot([ 't'=>'err', 'bd'=>$_cl_v->bd ])->tot; //Rebotes
                        $_Ec_Snd_Efct = ($_Ec_Snd_Acpt-$_Ec_Snd_Err); //Efectivos
                        $_Ec_Snd_Trck = GtEcSndTot([ 't'=>'trck', 'bd'=>$_cl_v->bd ])->tot; //Clicks únicos
                        $_Ec_Snd_Rmv = GtEcSndTot([ 't'=>'rmv', 'bd'=>$_cl_v->bd ])->tot; //Removidos

                        $_Tot_All[] = [ "key"=>"ec_snd_all", "vl"=>$_Ec_Snd_All ];
                        $_Tot_All[] = [ "key"=>"ec_snd_snd", "vl"=>$_Ec_Snd_Acpt ];
                        $_Tot_All[] = [ "key"=>"ec_snd_op", "vl"=>$_Ec_Snd_Op ];
                        $_Tot_All[] = [ "key"=>"ec_snd_err", "vl"=>$_Ec_Snd_Err ];
                        $_Tot_All[] = [ "key"=>"ec_snd_efct", "vl"=>$_Ec_Snd_Efct ];
                        $_Tot_All[] = [ "key"=>"ec_snd_trck", "vl"=>$_Ec_Snd_Trck ];
                        $_Tot_All[] = [ "key"=>"ec_snd_rmv", "vl"=>$_Ec_Snd_Rmv ];

                        foreach( $_Tot_All as $_k => $_v ){

                            if( !isN($_v["vl"]) ){
                                
                                $updateSQL = sprintf(" UPDATE "._BdStr(DBP).TB_TOT." SET tot_vl=%s WHERE tot_key=%s AND tot_cl=%s",
                                    GtSQLVlStr(ctjTx($_v["vl"], 'out'), "text"),
                                    GtSQLVlStr(ctjTx($_v["key"], 'out'), "text"),
                                    GtSQLVlStr($_cl_v->id, "int")
                                );

                                $Result = $__cnx->_prc($updateSQL); 
                                if($Result){ echo $this->scss('Update totals for '.$_cl_v->nm); }

                            }

                        }

                    }
                    
                }
			
            }

        }

    }catch(Exception $e){
        echo h2("Error en trycatch ".$e->getMessage());
    }

?>