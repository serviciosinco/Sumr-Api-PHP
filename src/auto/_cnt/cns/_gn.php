<?php

	//-------------------- REQUEST GET --------------------//

		$__aws_p = _jEnc(_PostRw());

		if(!isN($this->argv) && !isN($this->argv->_t2)){
			$_t2 = $this->argv->_t2;
		}elseif(!isN($__aws_p) && !isN($__aws_p->_t2)){
			$_t2 = $__aws_p->_t2;
		}else{
			$_t2 = $this->g__t2;
		}

	//-------------------- REQUEST FILE --------------------//

		define('GRP_FL_EML', 'eml/');

		define('___JS_HDR', '<?php if(!function_exists(\'Hdr_JS\')){ $__ob_cls = \'ok\'; $Rt = \'../\'; $__tp = \'js\'; include(\'../../../includes/inc.php\'); Hdr_JS(); ob_start("cmpr_js"); }  ?>');
		define('___JS_FTR', '<?php ob_end_flush(); ?>');
		define('___JS_CRM', '../includes/_js/');
		define('___CSS_CRM', '../includes/_sty/');


		if(!isN($this->g__t2)){

			$this->_Auto_Inc(GL_CNS.$this->g__t2.'.php');

		}else{

			if(Gt_DMN() != 'massivespace.rocks' &&  SUMR_ENV != 'prd' &&  SUMR_ENV != 'dev'){
				$this->_Auto_Inc(GL_CNS.'sis_sync.php');
			}

			$this->_Auto_Inc(GL_CNS.'sis_cns.php');
			$this->_Auto_Inc(GL_CNS.'sis_grph.php');
			$this->_Auto_Inc(GL_CNS.'sis_js_lng.php');
			$this->_Auto_Inc(GL_CNS.'sis_js.php');
			$this->_Auto_Inc(GL_CNS.'sis_css.php');
			//$this->_Auto_Inc(GL_CNS.'cls_slc.php');


		}



?>