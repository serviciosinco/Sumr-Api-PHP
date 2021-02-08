<?php 
	
	
	if($__dtec->id != $___datprcs_v['ecsnd_ec']){							
		$__dtec = '';		
	}
	
	$___allw_snd_m = '';
	
	try {
		
		
		if($this->g__s3 == 'cmpg'){ 
			
			echo $this->h2('Work with specific campaign');
							
			if(!isN($this->g__i)){
				
				$__cmpg_to_work_id = $this->g__i;
				$__cmpg_to_work_id_f = 'eccmpg_enc';
				$_orby = 'RAND()';
				$_qry_lmt = 200;

			}else{
				
				$__cmpg_to_work = GtEcCmpg_ToSend([ 'bd'=>$_cl_v->bd, 'cl'=>$_cl_v->id, 'bld'=>'ok', /*'ord'=>'asc',*/ 'rdy'=>'2', 'ctp'=>'html' ]);
				
				if(!isN($__cmpg_to_work->id)){
					$__cmpg_to_work_id = $__cmpg_to_work->id;
				}else{
					$__cmpg_to_work_id = '';
				}
				
				$__cmpg_to_work_id_f = 'ecsndcmpg_cmpg';
				
			}
			
			if(!isN($__cmpg_to_work_id)){
				
				$__snd_vw = VW_EC_SND_CMPG;
				$__ord_by = 'RAND()';

				$__updchk = $this->UpdF(['t'=>'ec_cmpg', 'f'=>'eccmpg_f_chk_html', 'id'=>$__cmpg_to_work_id, 'v'=>SIS_F_D2 ]);
				
				if(!isN($__updchk->w)){ 
					echo $this->err( $__updchk->w ); 
				}else{
					echo $this->scss($__cmpg_to_work_id.' campaign update date check');
				}

				/*
				$__qry_innr = '
					INNER JOIN '.$_cl_v->bd.'.'.TB_EC_SND_CMPG.' ON ecsndcmpg_snd = id_ecsnd
					INNER JOIN '._BdStr(DBM).TB_EC_CMPG.' ON ecsndcmpg_cmpg = id_eccmpg
				';*/

				$__cmpg_fltr = '
					AND (
						eccmpg_est = '._CId('ID_ECCMPGEST_SNDIN').' || 
						eccmpg_est = '._CId('ID_ECCMPGEST_APRBD').'
					) 
					AND (
						eccmpg_sndr != '._CId('ID_SISEML_SISIN').'
					)
					AND '.$__cmpg_to_work_id_f.' = "'.$__cmpg_to_work_id.'"
				';  		
		   		
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
				
				} catch (Exception $e) {
				    
				    echo $this->err($e->getMessage());
				    
				}									
	   		
	   		}else{
		   		
		   		echo $this->err('No next campaign so lets continue random on '.$__cmpg_to_work->w);
		   		
		   		$__qry_innr = '
					INNER JOIN '.$_cl_v->bd.'.'.TB_EC_SND_CMPG.' ON ecsndcmpg_snd = id_ecsnd
					INNER JOIN '._BdStr(DBM).TB_EC_CMPG.' ON ecsndcmpg_cmpg = id_eccmpg
				';

				$__cmpg_fltr = '
					AND (
						eccmpg_est = '._CId('ID_ECCMPGEST_SNDIN').' || 
						eccmpg_est = '._CId('ID_ECCMPGEST_APRBD').' 
					)
					AND (
						eccmpg_sndr != '._CId('ID_SISEML_SISIN').'
					)
				';  
		   		
	   		}			
					   		 			 
		}else{
			
			echo $this->h2('Process all send out of campaign');

			$__qry_slc = ', ecsndcmpg_snd';
			$__qry_innr = ' LEFT JOIN '._BdStr($_cl_v->bd).TB_EC_SND_CMPG.' ON ecsndcmpg_snd = id_ecsnd';
			//$__cmpg_fltr = 'AND ecsndcmpg_snd IS NULL';

		}

		
	} catch (Exception $e) {
		
		
		$___lck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);
		
	    echo $this->err($e->getMessage());

	    
	}
	
	
?>