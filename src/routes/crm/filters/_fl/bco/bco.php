<?php 
	
		$this->c_flt .= $this->_inp_tx([ 'id'=>'id_bco'.$this->id_rnd, 'ph'=>'Identificador', 'vl'=>$this->_gpj('id_bco'), 'rq'=>FMRQD_NMR, 'attr'=>['send-id'=>'id_bco']]);
		
		$this->c_flt .= LsClAre([
									'all'=>_ChckMd('bco_are_all')?'ok':'',
									'id'=>'_mdlfl_are'.$this->id_rnd, 
									'v'=>'clare_enc', 
									'va'=>$this->_gpj('clare_enc'), 
									'rq'=> 2, 
									'mlt'=>'ok', 
									'attr'=> ['send-id'=>'clare_enc', 'send-fk'=>'ok'],
									'flt' => 'ok'
								]);
		
		$this->js .= JQ_Ls('_mdlfl_are'.$this->id_rnd, TX_SLCAR, '', '_slcClr', ['ac'=>'no']);

				
?>