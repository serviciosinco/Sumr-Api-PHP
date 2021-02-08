<?php 

    if(_ChckMd('snd_ec_lsts_all','ok')){ $_all = 'ok'; }else{ $_all = 'no'; }
            
    $this->c_flt .= LsClAre([
        'cnx'=>$_c_r,
        'id'=>'_mdlfl_are'.$this->id_rnd, 
        'v'=>'id_clare', 
        'va'=>$this->_gpj('id_clare'), 
        'rq'=> 2, 
        'mlt'=>'ok', 
        'attr'=> ['send-id'=>'id_clare', 'send-fk'=>'ok'],
        'flt' => 'ok',
        'all' => $_all
    ]); 

    $this->js .= JQ_Ls('_mdlfl_are'.$this->id_rnd, TX_SLCAR, '', '_slcClr', ['ac'=>'no']);

?>