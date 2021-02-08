<?php 
	
	
	try{

        $__t = Php_Ls_Cln($_POST['tp']);
        $_fl = Php_Ls_Cln($_POST['fl']);
        $_cl = Php_Ls_Cln($_POST['cl']);
        $_sis = Php_Ls_Cln($_POST['sbd']);
        $__cl = Php_Ls_Cln($_POST['_cl']);
        $_api = Php_Ls_Cln($_POST['api']);

        $_ClDt = GtClDt($_cl,'id');

        $rsp['e'] = 'no';

        if($_fl == 'file'){

            include('_cnt/inc/'.$__t.'.php');

        }else if($_fl == 'n_file'){

            if(!isN($_sis) && $_sis == 'sis'){ 

                $__scl_ls = __LsDt(['k'=>$__t]);
                $__scl_ls1 = $__scl_ls->ls->{$__t};

                $Vl['e'] = 'ok';

                $Vl['ls']['l'][] =  [ 
                                        'ID', 
                                        'NOMBRE', 
                                    ];

                foreach($__scl_ls1 as $k1 => $v1){ 
                    
                    $Vl['ls']['l'][] =  [ 
                                            ctjTx( $v1->id,'in'), 
                                            ctjTx( $v1->tt,'in')
                                        ];
                }

                $rsp['ls'] = _jEnc($Vl); 

            }else{  
                
                global $__cnx;

                if(!isN($__cl) && $__cl == 'ok'){ 
                    $Dt_Qry = " SELECT * FROM ".$__t." WHERE ".$_api."_cl = ".$_cl;           
                }else{
                    $Dt_Qry = " SELECT * FROM ".$__t;         
                }

                $DtRg = $__cnx->_qry($Dt_Qry);

                if($DtRg){

                    $row_DtRg = $DtRg->fetch_assoc(); 
                    $Tot_DtRg = $DtRg->num_rows;
                
                    if($Tot_DtRg > 0){  

                        $Vl['e'] = 'ok';

                        $Vl['ls']['l'][] =  [ 
                            'ID', 
                            'NOMBRE', 
                        ];

                        do{  

                            if(!isN($row_DtRg[$_api.'_tt'])){ $nm = '_tt'; }else{ $nm = '_nm'; }
                            
                            $Vl['ls']['l'][] =  [ 
                                                    ctjTx( $row_DtRg['id_'.$_api],'in'), 
                                                    ctjTx( $row_DtRg[$_api.$nm],'in')
                                                ];
                        } while ($row_DtRg = $DtRg->fetch_assoc());

                        $rsp['ls'] = _jEnc($Vl); 

                    }
                } 

                $__cnx->_clsr($DtRg);

            }
        }
        
        if(!isN($rsp)){ 
            $rtrn = json_encode($rsp); 
            echo $rtrn; 
        }
        
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>