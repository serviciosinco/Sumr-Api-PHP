<?php

try {

	$__forms_qus_opt = _NwFb_Acc_Forms([
		't'=>'opt',
		'page_id'=>$___datprcs_v['sclacc_id'],
		'qus_id'=>$___datprcs_v['sclaccform_id'],
		'access_token'=>$_tkn_v->vl
	]);

	//echo compress_code(print_r($__forms_qus_opt, true));

	if(!isN( $__forms_qus_opt->w )){
		echo $this->err( print_r($__forms_qus->w, true) );
		$__tkn_scss = 'ok';
	}else{
		$__tkn_scss = 'no';
	}

	if(!isN($__forms_qus_opt->data)){

		foreach($__forms_qus_opt->data->questions as $_questions_k=>$_questions_v){
			if($_questions_v->id == $__accformqus_id){
				$__totformsqus = count($_questions_v->options);
			}
		}

		$__SclBd->Rqu([
			'tp'=>'forms_qus',
			'acc'=>$___datprcs_v['sclaccform_sclacc']
		]);


		$__SclBd = new CRM_Thrd();
		$__SclBd->__t = 'acc_form';
		$__SclBd->scl_rds = $___datprcs_v['scl_rds'];
		$__SclBd->form_acc = $___datprcs_v['id_sclacc'];
		$__SclBd->form_acc_id = $___datprcs_v['sclacc_id'];
		$__SclBd->form_id = $___datprcs_v['sclaccform_id'];
		$__SclBd->form_leads = $__forms_qus_opt->data->leads_count;
		$__SclBd->form_leads_expired = $__forms_qus_opt->expired_leads_count;

		$__SclBd->form_qus = $__forms_qus_opt->data->questions;
		$__Prc = $__SclBd->In();

		$___form_li[$__id_accformqus] .= $this->li('id:'.$__SclBd->form_id);
		$___form_li[$__id_accformqus] .= $this->li('options:'.$__totformsqus);

		if($__Prc->e == 'ok'){

			$___formin .=  $this->scss(
								'SUCCESS: '.
								'Form Question Id:'.$__id_accformqus.$this->br().
								'Account Name:'.$___datprcs_v['sclacc_nm'].$this->br().
								'Question Options Inserted:'.$___datprcs_v['__tot_qus_opt'].$this->br().
								'Question Options Suposed Inserted:'.$__totformsqus.$this->br()
							);
		}else{

			$___formin .= $this->err( print_r($__Prc, true) );

		}

	}else{

		echo $this->err( compress_code( print_r($__forms_qus_opt->w, true) ) );

	}

} catch (Exception $e) {

	$this->Rqu([ 't'=>'fb_forms_qus_opt' ]);
    echo $e->getMessage();

}


?>