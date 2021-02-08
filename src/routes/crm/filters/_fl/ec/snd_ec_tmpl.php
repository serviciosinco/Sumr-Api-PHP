<?php 
	
	//----------- Filtros Basicos -----------//

	$this->c_flt .= LsUs('_mdlfl_us'.$this->id_rnd,'us_enc', $this->_gpj('us_enc'), '', 2, 'ok', [ 'attr'=> ['send-id'=>'us_enc', 'send-fk'=>'ok'] ]);
	$this->c_flt .= LsClAre([
								'id'=>'_mdlfl_are'.$this->id_rnd, 
								'v'=>'clare_enc', 
								'va'=>$this->_gpj('clare_enc'), 
								'rq'=> 2, 
								'mlt'=>'ok', 
								'attr'=> ['send-id'=>'clare_enc', 'send-fk'=>'ok'],
								'flt' => 'ok'
							]); 

		
	$l = __Ls([ 'k'=>'sis_est', 'id'=>'_mdlfl_est'.$this->id_rnd, 'va'=>$this->_gpj('ec_est'), 'ph'=>FM_LS_SLEST, 'mlt'=>'ok', 'attr'=>['send-id'=>'ec_est'] ]);
	$this->c_flt .= $l->html;
	$this->js .= $l->js;
																
																
	
	$this->js .= JQ_Ls('_mdlfl_are'.$this->id_rnd, TX_SLCAR, '', '_slcClr', ['ac'=>'no']);
	$this->js .= JQ_Ls('_mdlfl_us'.$this->id_rnd, TX_US, '', '_slcClr', ['ac'=>'no']);
		
?>