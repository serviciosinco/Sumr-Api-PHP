<?php 
	
	//----------- Filtros Basicos -----------//

		
		$l = __Ls([ 'k'=>'sx', 'id'=>'_cntfl_sx'.$this->id_rnd, 'va'=>$this->_gpj('cnt_sx'), 'ph'=>FM_LS_SISSX, 'mlt'=>'ok', 'attr'=>['send-id'=>'cnt_sx'] ]);
		$this->c_flt .= $l->html;
		$this->js .= $l->js;


	//----------- Organizaciones -----------//
		
	
		$__org_tp = __LsDt([ 'k'=>'org_tp' ]);
		
		foreach($__org_tp->ls->org_tp as $_k=>$_v){
			
			$_gtvl = $this->_gpj('org');
			
			if(!isN($_gtvl->{$_v->key->vl})){ 
				if(is_array($_gtvl)){
					$_gtvl_v = $_gtvl[$_v->key->vl];
				}else{	
					$_gtvl_v = $_gtvl->{$_v->key->vl}; 
				}
			}
			
			$_key = $_v->key->vl.'_'.$this->id_rnd;
			$this->c_flt .= LsOrg('_cntfl_'.$_key, 'org_enc', $_gtvl_v, '', '', $_v->key->vl, 'orgsdscnt_org_'.$___Ls->gt->tsb, 'ok', ['attr'=>['send-id'=>$_v->key->vl, 'send-grp'=>'org']]); 
			$this->js .= JQ_Ls('_cntfl_'.$_key, _Cns('TX_SLC_'.strtoupper($_v->key->vl)));
		}
	
	//----------- Tipo de Vinculo -----------//
		
		$this->c_flt .= LsCntTp('_cntfl_tp'.$this->id_rnd, 'siscnttp_enc', $this->_gpj('siscnttp_enc'), FM_LS_VNCU, 2, 'ok', ['attr'=>['send-id'=>'siscnttp_enc']] );
		$this->js .= JQ_Ls('_cntfl_tp'.$this->id_rnd, FM_LS_VNCU);
		
	//----------- Checklist -----------//
	
		$this->c_flt .= h2('Checklist');
		$this->c_flt .= LsSis_SiNo('_cntfl_sndi'.$this->id_rnd, 'id_sissino', $this->_gpj('cntplcy_sndi'), TX_HBSACCPT, 2, 'ok', '', ['attr'=>['send-id'=>'cntplcy_sndi']] ); 
		$this->c_flt .= LsPlcy('_cntfl_plcy'.$this->id_rnd, 'clplcy_enc', $this->_gpj('clplcy_enc'), FM_LS_PLCY, 2, 'ok', ['attr'=>['send-id'=>'clplcy_enc']] );
		
		$this->js .= JQ_Ls('_cntfl_sndi'.$this->id_rnd, TX_HBSACCPT);
		$this->js .= JQ_Ls('_cntfl_plcy'.$this->id_rnd, FM_LS_PLCY);
	
	//----------- Checklist -----------//
	
		$this->c_flt .= h2('Ultima actualización');
		
		$this->c_flt .= SlDt([ 
							'id'=>'_fupd_strt'.$this->id_rnd, 
							'va'=>$this->_gpj('fu1'), 
							'rq'=>'ok',
							'ph'=>TX_ORD_FIN, 
							'lmt'=>'no', 
							'yr'=>'ok',
							'cls'=>CLS_CLND, 
							'attr'=>['send-id'=>'fu1']
						]);
		
		$this->c_flt .= SlDt([ 
							'id'=>'_fupd_end'.$this->id_rnd, 
							'va'=>$this->_gpj('fu2'), 
							'rq'=>'ok',
							'ph'=>TX_ORD_FOU, 
							'lmt'=>'no', 
							'yr'=>'ok',
							'cls'=>CLS_CLND, 
							'attr'=>['send-id'=>'fu2']
						]);				

		
	//----------- FIN -----------//
		
		
		$this->c_flt .= h2('Fecha de Ingreso');
	
	
				
?>