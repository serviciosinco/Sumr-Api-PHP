<?php 
	
	//-------- Filtros Basicos --------//

		if($this->_gpj('_t2') == 'marks'){

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
			
		}

		if($this->_gpj('_t2') == 'clg'){

			$l = __Ls([ 'k'=>'org_clg_enf', 'id'=>'_fl_orgenf'.$this->id_rnd, 'va'=>$this->_gpj('_fl_orgenf'), 'ph'=>'Enfasis', 'mlt'=>'no', 'attr'=>['send-id'=>'_fl_orgenf', 'send-fk'=>'ok'] ]);
			$this->c_flt .= $l->html;
			$this->js .= $l->js;

			$this->c_flt .= LsLng(['id'=>'_fl_orglng'.$this->id_rnd, 'v'=>'id_sislng', 'va'=>$this->_gpj('_fl_orglng'), 'rq'=>1, 'attr'=>['send-id'=>'_fl_orglng', 'send-fk'=>'ok'] ]); 
			$this->js .= JQ_Ls('_fl_orglng'.$this->id_rnd);

			$l = __Ls([ 'k'=>'org_clg_bch', 'id'=>'_fl_orgbch'.$this->id_rnd, 'va'=>$this->_gpj('_fl_orgbch'), 'ph'=>'Bachillerato', 'mlt'=>'no', 'attr'=>['send-id'=>'_fl_orgbch', 'send-fk'=>'ok'] ]);
			$this->c_flt .= $l->html;
			$this->js .= $l->js;

			$l = __Ls([ 'k'=>'org_clg_exa', 'id'=>'_fl_orgexa'.$this->id_rnd, 'va'=>$this->_gpj('_fl_orgexa'), 'ph'=>'Examenes', 'mlt'=>'no', 'attr'=>['send-id'=>'_fl_orgexa', 'send-fk'=>'ok'] ]);
			$this->c_flt .= $l->html;
			$this->js .= $l->js;

			$this->c_flt .= h2("Atributos"); 

			$l = __Ls(['k'=>'ls_rdm','id'=>'_fl_orgrdm','ph'=>TX_RDM,'va'=>$this->_gpj('_fl_orgrdm'),'fcl'=>'ok', 'rq' => 2, 'attr'=>['send-id'=>'_fl_orgrdm', 'send-fk'=>'ok']]); 
			$this->c_flt .= $l->html; 
			$this->js .= $l->js;

			$l = __Ls(['k'=>'nvs','id'=>'_fl_orgnvs','ph'=>TX_NVS,'va'=>$this->_gpj('_fl_orgnvs'),'fcl'=>'ok', 'rq' => 2, 'attr'=>['send-id'=>'_fl_orgnvs', 'send-fk'=>'ok']]);
			$this->c_flt .= $l->html; 
			$this->js .= $l->js;

			$l = __Ls(['k'=>'tp_clg','id'=>'_fl_orgtpclg','ph'=>TX_NVS,'va'=>$this->_gpj('_fl_orgtpclg'),'fcl'=>'ok', 'rq' => 2, 'attr'=>['send-id'=>'_fl_orgtpclg', 'send-fk'=>'ok']]);
			$this->c_flt .= $l->html; 
			$this->js .= $l->js;

			$l = __Ls(['k'=>'nvl_atc','id'=>'_fl_orgnvlatc','ph'=>TX_NVS,'va'=>$this->_gpj('_fl_orgnvlatc'),'fcl'=>'ok', 'rq' => 2, 'attr'=>['send-id'=>'_fl_orgnvlatc', 'send-fk'=>'ok']]);
			$this->c_flt .= $l->html; 
			$this->js .= $l->js;

			$l = __Ls(['k'=>'org_ntz','id'=>'_fl_orgntz','ph'=>TX_NTZ,'va'=>$this->_gpj('_fl_orgntz'),'fcl'=>'ok', 'rq' => 2, 'attr'=>['send-id'=>'_fl_orgntz', 'send-fk'=>'ok']]);
			$this->c_flt .= $l->html; 
			$this->js .= $l->js;



			/*$l = __Ls(['k'=>'pft','id'=>'_fl_org_pft_____','ph'=>TX_RDM,'va'=>$this->_gpj('_fl_org_pft_____'),'fcl'=>'ok', 'rq' => 2, 'attr'=>['send-id'=>'_fl_org_pft_____', 'send-fk'=>'ok']]); 
			$this->c_flt .= $l->html; 
			$this->js .= $l->js;
			
			$l = __Ls(['k'=>'org_tmn','id'=>'_fl_orgtmn_______','ph'=>TX_SIZE,'va'=>$this->_gpj('_fl_orgtmn_______'),'fcl'=>'ok', 'rq' => 2, 'attr'=>['send-id'=>'_fl_orgtmn_______', 'send-fk'=>'ok']]); 
			$this->c_flt .= $l->html; 
			$this->js .= $l->js;*/

			
		}

		
?>