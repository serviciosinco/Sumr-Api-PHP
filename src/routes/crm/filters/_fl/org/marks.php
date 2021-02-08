<?php 
	
    //-------- Filtros Basicos --------//
    
    $l = __Ls([ 'k'=>'lcl_lvl', 'id'=>'cllcl_lvl'.$this->id_rnd, 'va'=>$this->_gpj('cllcl_lvl'), 'ph'=>'Piso', 'mlt'=>'no', 'attr'=>['send-id'=>'cllcl_lvl', 'send-fk'=>'ok'] ]);
    $this->c_flt .= $l->html;
    $this->js .= $l->js;

    $l = __Ls([ 'k'=>'eti_org', 'id'=>'_fl_orgtag'.$this->id_rnd, 'va'=>$this->_gpj('_fl_orgtag'), 'ph'=>'Etiquetas', 'mlt'=>'no', 'attr'=>['send-id'=>'_fl_orgtag', 'send-fk'=>'ok'] ]);
    $this->c_flt .= $l->html;
    $this->js .= $l->js;

    $this->c_flt .= LsOrg('_fl_orgls'.$this->id_rnd, 'id_org', $this->_gpj('_fl_orgls'), 'Marca', 2, 'marks', '', '', ['attr'=>['send-id'=>'_fl_orgls', 'send-fk'=>'ok' ]]); $CntWb .= JQ_Ls('fl_orgls');
    $this->js .= JQ_Ls('_fl_orgls'.$this->id_rnd);

    $this->c_flt .= LsSis_SiNo('_fl_orgest'.$this->id_rnd, 'id_sissino', $this->_gpj('_fl_orgest'), 'Activo', 2, 'ok', '', ['attr'=>['send-id'=>'_fl_orgest','send-fk'=>'ok'] ]);
	$this->js .= JQ_Ls('_fl_orgest'.$this->id_rnd);

?>