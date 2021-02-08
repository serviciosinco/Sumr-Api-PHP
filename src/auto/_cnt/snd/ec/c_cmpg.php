<?php 
	
	try {
			
			
		echo $this->h3(':: '.$this->__btch_id.':: Start process of send of record '.$___datprcs_v['id_ecsnd']);
			
								
		if(!isN($___datprcs_v['__idcmpg'])){ 
			
			if(isN($__cmpg_dt) || $__cmpg_dt->id != $___datprcs_v['__idcmpg']){
				
				echo $this->li(':: '.$this->__btch_id.':: Check campaign details');
				$__cmpg_dt = GtEcCmpgDt([ 'id'=>$___datprcs_v['__idcmpg'], 'bd'=>$_cl_v->bd ]); 
				echo $this->li(':: '.$this->__btch_id.':: No we get the campaign details');
			
			}else{
				
				echo $this->li(':: '.$this->__btch_id.':: Same data of campaign: '.$this->Spn('again'));
				
			}
			
		}else{
			
			$__cmpg_dt = '';
			
		}
		
		
		if(!isN($__cmpg_dt->eml->id)){ 

			$__snd_eml = $__cmpg_dt->eml->id;
			$__snd_eml_dt = '';

		}elseif(!isN($___datprcs_v['ecsnd_cleml'])){

			$__snd_eml = $___datprcs_v['ecsnd_cleml'];
			if($__snd_eml != $__snd_eml_dt->id){
				$__snd_eml_dt = GtEmlDt([ 'id'=>$__snd_eml, 'pss'=>'ok' ]);
			}

		}else{
			$__snd_eml = '';
			$__snd_eml_dt = '';
		}


	} catch (Exception $e) {
	    
	    $___lck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);
	    if($this->g__s3 == 'cmpg_snd'){ $__rd_cmpg_p = $this->EcCmpg_Rd(); }
	    
	    echo $this->err($e->getMessage());
	    
	}
	
	
?>