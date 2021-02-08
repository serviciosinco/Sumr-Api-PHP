<?php 

    if($this->_gpj('_t') == 'act'){

	    //----------- Filtros Basicos -----------//

        $l = __Ls([ 'k'=>'act_est', 'id'=>'_actfl_est'.$this->id_rnd, 'va'=>$this->_gpj('_actfl_est'), 'ph'=>'Estado', 'mlt'=>'ok', 'attr'=>['send-id'=>'_actfl_est', 'send-fk'=>'ok'] ]);
		$this->c_flt .= $l->html;
		$this->js .= $l->js;

    }
				
?>