<?php 

	if($__dtec->id != $___datprcs_v['ecsnd_ec']){							
		$__dtec = '';		
	}

	$___allw_snd_m = '';
	$__snd_vw = '';
	
	try {	
		
		if($this->g__s3 == 'cmpg_snd'){
			
			echo $this->h2('Work with specific campaign');

			if($this->g__i){
				
				$__cmpg_to_work_id = $this->g__i;
				$__cmpg_to_work_id_f = 'eccmpg_enc';
					
			}else{
				
				$__cmpg_to_work = GtEcCmpg_ToSend([ 'bd'=>$_cl_v->bd, 'cl'=>$_cl_v->id, 'ctp'=>'snd' ]);
				
				if(!isN($__cmpg_to_work->id)){
					$__cmpg_to_work_id = $__cmpg_to_work->id;
				}else{
					echo $this->err('No campaign to work');
					if($__cmpg_to_work->e != 'ok'){
						echo $this->err($__cmpg_to_work->qry);
					}
				}
				
				$__cmpg_to_work_id_f = 'ecsndcmpg_cmpg';
				
			}
			
			if(!isN($__cmpg_to_work_id) && !isN($__cmpg_to_work_id_f)){
				
				$__snd_vw = VW_EC_SND_CMPG;

				$__updchk = $this->UpdF(['t'=>'ec_cmpg', 'f'=>'eccmpg_f_chk_snd', 'id'=>$__cmpg_to_work_id, 'v'=>SIS_F_D2 ]);

				$__cmpg_fltr = "
					AND eccmpg_est = '"._CId('ID_ECCMPGEST_SNDIN')."' 
					AND ".$__cmpg_to_work_id_f." = '".$__cmpg_to_work_id."'
		   		";
		   		
		   		$this->id_eccmpg = $__cmpg_to_work_id;
		   		
		   		$__rd_cmpg_p = $this->EcCmpg_Rd([ 'e'=>'on', 'tot'=>$_qry_lmt ]);
				
				if($__rd_cmpg_p->e == 'ok'){	
					echo $this->h3('Lock Campaign '.$__cmpg_to_work_id.' to process');	
				}else{
					echo $this->err('Lock Campaign '.$__cmpg_to_work_id.' failed ');
				}	

				try {
					if($__rd_cmpg_p->e != 'ok'){	
						echo $this->err('Lock Campaign '.$__cmpg_to_work_id.' failed ');
					}
				}catch(Exception $e){
				    echo $this->err($e->getMessage());
				}
	   		
	   		}else{

				$__cmpg_fltr = " AND eccmpg_est = '"._CId('ID_ECCMPGEST_SNDIN')."' AND eccmpg_sndr != "._CId('ID_SISEML_SISIN')." ";		   		
		   		
	   		}	

		}
			
	} catch (Exception $e) {
		
		$___lck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);
		
		if(!isN($this->id_ecsnd)){ $this->EcSnd_Rd([ 'bd'=>$_cl_v->bd, 'btch_c'=>'ok' ]); }
	    
	    if($this->g__s3 == 'cmpg_snd'){ $__rd_cmpg_p = $this->EcCmpg_Rd(); }
	    
	    echo $this->err($e->getMessage());

	}
	
	
?>