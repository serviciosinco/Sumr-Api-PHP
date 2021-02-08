<?php 
	
	try {

		if(!isN($___datprcs_v['id_eccmpg'])){
				
			$_cmpg_dt = GtEcCmpgDt([ 						
				'bd'=>$_cl_v->bd,
				'id'=>$___datprcs_v['id_eccmpg'],
				'ec'=>'ok', 
				'q_btch'=>'ok', 
				'sgm'=>['e'=>'ok', 'ls'=>'ok', 'tot'=>'ok' ], 
				'lsts'=>['e'=>'ok', 'ls'=>'ok' ]
			]);
			
		}

		
	} catch (Exception $e) {
	    
	    $__rd_cmpg_p = $this->EcCmpg_Rd();
	    
	}
	
	
?>