<?php 
	
	//-------- Filtros Basicos --------//
								
		$this->c_flt .= LsUs('_mdlfl_us'.$this->id_rnd,'us_enc', $this->_gpj('us_enc'), '', 2, 'ok', [ 'attr'=> ['send-id'=>'us_enc', 'send-fk'=>'ok'] ]);
		
		$l = __Ls([ 'k'=>'ec_cmpg_est', 'id'=>'_mdlfl_eccmpg'.$this->id_rnd, 'va'=>$this->_gpj('eccmpg_est'), 'ph'=>TX_EST, 'mlt'=>'ok', 'attr'=>['send-id'=>'eccmpg_est'] ]);
		$this->c_flt .= $l->html;
		$this->js .= $l->js;

		$l = __Ls([ 'k'=>'sis_eml', 'id'=>'_mdlfl_eccmpgsndr'.$this->id_rnd, 'va'=>$this->_gpj('eccmpg_sndr'), 'ph'=>'Sender', 'mlt'=>'ok', 'attr'=>['send-id'=>'eccmpg_sndr', 'send-fk'=>'ok'] ]);
		$this->c_flt .= $l->html;
		$this->js .= $l->js;	
	
	//-------- Fecha de Envio --------//
	
		
		$this->c_flt .= h2('Fecha de Envío');
		
		$this->c_flt .= SlDt([ 
							'id'=>'_fsnd_strt'.$this->id_rnd, 
							'va'=>$this->_gpj('fs1'), 
							'rq'=>'ok',
							'ph'=>'- seleccione fecha -', 
							'lmt'=>'no', 
							'yr'=>'ok',
							'cls'=>CLS_CLND, 
							'attr'=>['send-id'=>'fs1']
						]);
							
					
	
	//-------- Filtros Basicos --------//
		
		$this->c_flt .= h2(TX_FI);
		$this->js .= JQ_Ls('_mdlfl_us'.$this->id_rnd, TX_US, '', '_slcClr', ['ac'=>'no']);
		
		
		
		
					
?>