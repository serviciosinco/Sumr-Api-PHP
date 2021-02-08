<?php 
	
	//----------- Filtros Basicos -----------//
	
		$this->c_flt .= LsClAre([
									'id'=>'_mdlfl_are'.$this->id_rnd, 
									'v'=>'clare_enc', 
									'va'=>$this->_gpj('clare_enc'), 
									'rq'=> 2, 
									'mlt'=>'ok', 
									'attr'=> ['send-id'=>'clare_enc', 'send-fk'=>'ok'],
									'flt' => 'ok'
								]); 


		$this->c_flt .=	LsMdlS($this->gt->tsb, '_mdlfl_mdls'.$this->id_rnd, 'mdls_enc', $this->_gpj('mdls_enc'), '', 1, 'ok', [ 'cl'=>'ok', 'tp'=>'ok', 'attr'=>['send-id'=>'mdls_enc', 'send-fk'=>'ok'], 'flt' => 'ok' ]);
		
		$l = __Ls([ 'k'=>'sis_mdl_est', 'id'=>'_mdlfl_est'.$this->id_rnd, 'va'=>$this->_gpj('mdl_est'), 'ph'=>FM_LS_SLEST, 'mlt'=>'no', 'attr'=>['send-id'=>'mdl_est', 'send-fk'=>'ok'] ]);
		$this->c_flt .= $l->html;
		$this->js .= $l->js;
		
		$this->js .= JQ_Ls('_mdlfl_are'.$this->id_rnd, TX_SLCAR, '', '_slcClr', ['ac'=>'no']);	
		$this->js .= JQ_Ls('_mdlfl_mdls'.$this->id_rnd, FM_LS_SLTP );		
		

				
?>