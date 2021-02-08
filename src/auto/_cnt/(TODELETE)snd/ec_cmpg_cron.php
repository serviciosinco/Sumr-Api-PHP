<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'snd_ec_cmpg_cron' ]);
$_aws_iid = file_get_contents("http://instance-data/latest/meta-data/instance-id");

if( $_g_alw->est == 'ok' ){
		
	if(class_exists('CRM_Cnx')){

		$this->_RTme([ 'start'=>'ok' ]);
		
		echo $this->h1('ENVIO CAMPAÑAS EMAIL TO CRON', '_cmpg');

        //-------------------- AUTO TIME CHECK - START --------------------//

            $_AUTOP_d = $this->RquDt([ 't'=>'ec_cmpg_cron', 'cl'=>$_cl_v->id, 'm'=>3 ]);
            echo $this->h2($_cl_v->nm.' lock? '.$_AUTOP_d->lck, '', '_check');
            
        //-------------------- AUTO TIME CHECK - END --------------------//
        
        if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->lck != 'ok') || $_AUTOP_d->m_lck > 15){ 	
            

            $__tot_not_cron = GtEcCmpgOutCronTot([ 'inst'=>$_aws_iid ]);

            echo ' $__tot_not_cron:'. $__tot_not_cron;

            try {

                $LsCmpgCron_Qry = "
                
                    SELECT id_eccmpg, eccmpg_us, eccmpg_nm, eccmpg_p_f, eccmpg_p_h
                    FROM "._BdStr(DBM).TB_EC_CMPG." 
                    WHERE
                        (
                            eccmpg_est = '"._CId('ID_ECCMPGEST_APRBD')."' OR
                            eccmpg_est = '"._CId('ID_ECCMPGEST_SND')."'
                        ) AND
                        eccmpg_sndr = '"._CId('ID_SISEML_SUMR')."' AND
                        NOT EXISTS (
                            SELECT eccmpgcron_cmpg
                            FROM "._BdStr(DBM).TB_EC_CMPG_CRON." 
                            WHERE eccmpgcron_cmpg = id_eccmpg AND
                                    eccmpgcron_instance = '".$_aws_iid."'
                        )
                    ORDER BY eccmpg_p_f ASC, eccmpg_p_h ASC
                    LIMIT 1000
                
                "; 
                            
                $LsCmpgCron = $__cnx->_qry($LsCmpgCron_Qry); 
                
                if($LsCmpgCron){
                
                    $row_LsCmpgCron = $LsCmpgCron->fetch_assoc(); 
                    $Tot_LsCmpgCron = $LsCmpgCron->num_rows;
                    
                    echo $this->h3($this->ttFgr($_cl_v).$Tot_LsCmpgCron.' campañas para cronjob de '.$_cl_v->nm, '_cmpg');	
                    
                    if($Tot_LsCmpgCron > 0){
                            
                        do{ 
                            
                            try {	
                                
                                $this->id_eccmpg = $row_LsCmpgCron['id_eccmpg'];
                                $__rd_cmpg_p = $this->EcCmpg_Rd([ 'e'=>'on' ]);	

                                $___datprcs[] = $row_LsCmpgCron;
                                echo $this->h2( 'Campaign '. $row_LsCmpgCron['id_eccmpg'].' to process' );

                            } catch (Exception $e) {
                                
                                $___lck = $this->Rqu([ 't'=>'ec_cmpg_cron', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
                                echo $this->err($e->getMessage());
                                
                            }
                        
                        } while ($row_LsCmpgCron = $LsCmpgCron->fetch_assoc());	
                                        
                    }
                            
                }else{
                    
                    echo $this->err( 'Error:' . $__cnx->c_r->error);
                    
                }	

                $__cnx->_clsr($LsCmpgCron);
                
                $___lck = $this->Rqu([ 't'=>'ec_cmpg_cron', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
                
            
            } catch (Exception $e) {

                $___lck = $this->Rqu([ 't'=>'ec_cmpg_cron', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
        
                echo $this->err($e->getMessage());
                
            }
            
            
        }
		
	}else{
		
		echo $this->err('AUTO_CMPG_EC:off');
		
	}

}else{

	echo $this->nallw('Global Envios Masivos - Campañas - Off');

}

?>