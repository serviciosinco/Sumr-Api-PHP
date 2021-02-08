<?php 
	
	try {
			
		if(!isN($this->g__i)){
			
			echo $this->li('Get specifi campaign detail', '', '_check');

			$_cmpg_dt = GtEcCmpgDt([ 						
				'bd'=>$_cl_v->bd,
				't'=>'enc',
				'id'=>$this->g__i
			]);

			if(!isN($_cmpg_dt->id)){
				$__cmpg_to_work_id = $_cmpg_dt->id;
			}

		}else{	
			
			if($this->g__rnd == 'ok'){

				echo $this->li('Search for random campaign', '', '_check');

				$__cmpg_to_work = 	GtEcCmpg_ToSend([ 
										'bd'=>$_cl_v->bd, 
										'cl'=>$_cl_v->id, 
										'bld'=>'ok', 
										'rd'=>'no', 
										'ord'=>'asc',
										'rdy'=>'2',
										'fl'=>"
											AND (  
													eccmpg_est = '"._CId('ID_ECCMPGEST_APRBD')."' AND
													eccmpg_est != '"._CId('ID_ECCMPGEST_PSD')."' AND
													eccmpg_est != '"._CId('ID_ECCMPGEST_SND')."'
												)
										"
									]);
				
				echo $this->li('Campaign random values '/*.print_r($__cmpg_to_work, true)*/ , '', '_check');

				if(!isN($__cmpg_to_work->id)){
					$__cmpg_to_work_id = $__cmpg_to_work->id;
				}
			
			}	
			
		}		
		
	} catch (Exception $e) {
		
		$___lck = $this->Rqu([ 't'=>'ec_cmpg', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
				
		echo $this->err($e->getMessage());
	    
	}
	
	
?>