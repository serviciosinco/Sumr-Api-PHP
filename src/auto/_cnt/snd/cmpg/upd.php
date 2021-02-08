<?php 
	
	try {
		
		echo $this->li('Actualizar Datos Reales de Leads Disponibles '.$_cmpg_dt->eml_allw, '_cmpg');
											
		echo $this->li('Update Fields?');	
		
		$this->_snd->eccmpg_enc = $_cmpg_dt->enc;
		$this->_snd->eccmpg_tot_lds = $_cmpg_dt->eml_allw;
		$this->_snd->eccmpg_tot_nallw = $_cmpg_dt->eml_noallw->all;
		$__upfld = $this->_snd->_ec_cmpg_upd();
		
		echo $this->li('Update Fields Result:'.$__upfld->e.' - Query '.$__upfld->qry );
																
	} catch (Exception $e) {
	    
	   $__rd_cmpg_p = $this->EcCmpg_Rd();
	    
	}
	
	
?>