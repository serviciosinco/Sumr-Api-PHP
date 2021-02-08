<?php 
	
	//----------- Filtros Basicos -----------//
					
		$this->c_flt .= LsCl('_mdlfl_cl'.$this->id_rnd,'cl_enc', $this->_gpj('cl_enc'), TX_CL, 2, 'ok', '' ,['attr'=>['send-id'=>'cl_enc',  'send-fk'=>'ok']] ); 

		$this->js .= JQ_Ls('_mdlfl_cl'.$this->id_rnd, TX_SLCAR, '', '_slcClr', ['ac'=>'no']);
		
		
?>