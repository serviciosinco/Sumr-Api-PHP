<?php 
if(class_exists('CRM_Cnx')){ 
					
					
	//-------------------- REQUEST GET --------------------//	
		
		$__aws_p = _jEnc(_PostRw());
		$__argv = $this->argv;
		
		if(!isN($__aws_p)){ 
			$_s2=$__aws_p->_s2;
			$_bd=$__aws_p->_bd; 	
		}elseif(!isN($__argv)){
			$_s2=$__argv->_s2;
			$_bd=$__argv->_bd;
		}else{ 
			$_s2 = $this->g__s2; 
			$_bd = $this->g__bd;
		}		
		
	//-------------------- CONSTANTES --------------------//
	
	$__AutoCns = new AUTO_Cns();

	
	if(!isN($_bd)){ 
	
		$__p = $__AutoCns->{$_bd}();
	
	}elseif(!isN($_s2)){ 
	
		$_fn = '_'.$_s2;
		$__p = $__AutoCns->{$_fn}(); 
	
	}else{
		
		echo $this->h1('$__AutoCns->_sis()');
		$__p = $__AutoCns->_sis();

		echo $this->h1('$__AutoCns->_sis_lng()');
		$__p = $__AutoCns->_sis_lng(); 

		echo $this->h1('$__AutoCns->_cl_sis()');
		$__p = $__AutoCns->_cl_sis();

		echo $this->h1('$__AutoCns->_cl_lng()');
		$__p = $__AutoCns->_cl_lng();

		echo $this->h1('$__AutoCns->_cl_mnu()');
		$__p = $__AutoCns->_cl_mnu();

		echo $this->h1('$__AutoCns->_cl_id()');
		$__p = $__AutoCns->_cl_id();

		echo $this->h1('$__AutoCns->_cl_data()');
		$__p = $__AutoCns->_cl_data();

		echo $this->h1('$__AutoCns->_sis_slc()');
		$__p = $__AutoCns->_sis_slc();

		echo $this->h1('$__AutoCns->_sis_ec()');
		$__p = $__AutoCns->_sis_ec();

		echo $this->h1('$__AutoCns->_sis_sms()');
		$__p = $__AutoCns->_sis_sms();

		echo $this->h1('$__AutoCns->_sis_md()');
		$__p = $__AutoCns->_sis_md();

		echo $this->h1('$__AutoCns->_sis_mdls_tp()');
		$__p = $__AutoCns->_sis_mdls_tp();

		echo $this->h1('$__AutoCns->_sis_ps()');
		$__p = $__AutoCns->_sis_ps();

		echo $this->h1('$__AutoCns->_sis_cd()');
		$__p = $__AutoCns->_sis_cd();
		
	}
	
	
	echo $this->h1('FINISH Constant Build');
	
	
}else{
	
	echo 'No exists CnRdi'.PHP_EOL;
	
}


?>