<?php 
	
	try {
	
		$_li .= $this->li( 'Allow: '.$_cmpg_dt->eml_allw);	
		$_li .= $this->li( 'Queue: '.$_cmpg_dt->btch->in);	
		$_li .= $this->li( 'Estatus: '.$_cmpg_dt->est->id);	
		$_li .= $this->li( 'Html: '.$_cmpg_dt->tot->html);
		$_li .= $this->li( 'TimeOut: '.$_cmpg_dt->tme->out);
		
		
		if(
			( 
				!isN($_cmpg_dt->btch->in) && 
				!isN($_cmpg_dt->eml_allw) && 
				!isN($_cmpg_dt->tot->html) &&
				$_cmpg_dt->btch->in >= $_cmpg_dt->eml_allw && 
				$_cmpg_dt->est->id == _CId('ID_ECCMPGEST_APRBD') &&
				$_cmpg_dt->tot->html == $_cmpg_dt->btch->in
			) 
			
			|| $_cmpg_dt->tme->out == 'ok'
			
			){ 
				 	
				 		
				$_upd_eml_rdy = $_ec_snd->_EcCmpgUpd_Fld([ 'id'=>$_cmpg_dt->id, 'f'=>'eccmpg_rdy', 'v'=>1 ]);
				$_li .= $this->li( 'Ready change status: '.$_upd_eml_rdy->e );
				if($_upd_eml_rdy->e == 'ok'){ echo $this->scss('Campaign '.$_cmpg_dt->id.' mark as ready'); }
				
		}
		
	//-------- IMPRIME TODO EL UL --------//
																
		
	} catch (Exception $e) {
	    
	    $__rd_cmpg_p = $this->EcCmpg_Rd();
	    
	}
	
	
?>