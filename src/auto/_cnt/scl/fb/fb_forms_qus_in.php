<?php

try {

	$__id_accform = $___datprcs_v['id_sclaccform'];
	$__forms_qus = _NwFb_Acc_Forms([
								't'=>'qus',
								'page_id'=>$___datprcs_v['sclacc_id'],
								'form_id'=>$___datprcs_v['sclaccform_id'],
								'access_token'=>$_tkn_v->vl
							]);

	$__totforms = count($__forms_qus->data->questions);


	if(isN( $__forms_qus->w )){ echo $this->err( print_r($__forms_qus->w, true) ); $__tkn_scss = 'ok'; }else{ $__tkn_scss = 'no'; }

	$__SclBd->Rqu([
		'tp'=>'forms_qus',
		'acc'=>$___datprcs_v['id_sclacc']
	]);



	$__SclBd = new CRM_Thrd();
	$__SclBd->__t = 'acc_form';
	$__SclBd->scl_rds = $___datprcs_v['scl_rds'];
	$__SclBd->form_acc = $___datprcs_v['id_sclacc'];
	$__SclBd->form_acc_id = $___datprcs_v['sclacc_id'];
	$__SclBd->form_id = $___datprcs_v['sclaccform_id'];
	$__SclBd->form_leads = $__forms_qus->data->leads_count;
	$__SclBd->form_leads_expired = $__forms_qus->expired_leads_count;
	$__SclBd->form_qus = $__forms_qus->data->questions;

	$__Prc = $__SclBd->In();

	if($__Prc->e != 'ok'){ $_sty = ' color:red;'; }else{ $_sty = ' color:green;'; }

	$___form_li[$__id_accform] .= $this->li('id:'.$__SclBd->form_id, '', ' font-family:Arial; font-size:10px; '.$_sty );
	$___form_li[$__id_accform] .= $this->li('questions:'.$__totforms, '', ' font-family:Arial; font-size:10px; '.$_sty );



	$___formin .= $this->li(
					$this->h1(
						'Form Id:'.$__id_accform.$this->br().
						'Account Name:'.$___datprcs_v['sclacc_nm'].$this->br().
						'Question Inserted:'.$___datprcs_v['__tot_qus'].$this->br().
						'Question Suposed Inserted:'.$__totforms.$this->br()
					)
				);


} catch (Exception $e) {

	$this->Rqu([ 't'=>'fb_forms_qus' ]);
    echo $e->getMessage();

}


?>