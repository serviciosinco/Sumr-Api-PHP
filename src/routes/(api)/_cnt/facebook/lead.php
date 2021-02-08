<?php 
	
	$__SclBd = new CRM_Thrd();
	$_formdt = GtSclAccFormDt([ 'form_id'=>$cv->value->form_id ]);
	
	
	// Si no existe formulario lo creamos
	
	if(isN($_formdt->id)){
		
		$_acc_dt = GtSclAccDt([ 'acc_id'=>$cv->value->page_id ]); 
		
		if(!isN($_acc_dt->id)){
			
			foreach($_acc_dt->acc_scl as $_acc_k=>$_acc_v){	
				if(!isN($_acc_v->tlvd)){
					$_tkn_lvd = $_acc_v->tlvd;
					break;
				}
			}
			
			if(!isN($_tkn_lvd)){
				
				$__form = _NwFb_Acc_Form_Dt([
								'id'=>$_acc_dt->cid,
								'access_token'=>$_tkn_lvd
							]);						
				
				if(!isN($__form->id)){
													
					$__SclBd->__t = 'acc_form';	
					$__SclBd->scl_rds = $_acc_dt->rds;
					$__SclBd->form_acc = $_acc_dt->id;
					$__SclBd->form_acc_id = $_acc_dt->cid;
					$__SclBd->form_id = $_formdt->id;
					$__SclBd->form_name = $__form->name;
					$__SclBd->form_created_time = $__form->created_time->date;
					$__SclBd->form_status = $__form->status;
					$__SclBd->form_leads = $__form->leads_count;
					$__SclBd->form_leads_expired = $__form->expired_leads_count;
					
					$__SclBd->form_attr['creator_name'] = $__form->creator->name;
					$__SclBd->form_attr['creator_id'] = $__form->creator->id;
					$__SclBd->form_attr['context_card_title'] = $__form->context_card->title;
					$__SclBd->form_attr['context_card_content'] = $__form->context_card->content;
					$__SclBd->form_attr['context_card_style'] = $__form->context_card->style;
					$__SclBd->form_attr['context_card_format'] = $__form->context_card->format;
					$__SclBd->form_attr['context_card_id'] = $__form->context_card->id;
					$__SclBd->form_attr['follow_up_action_url'] = $__form->follow_up_action_url;
					$__SclBd->form_attr['privacy_policy_url'] = $__form->privacy_policy_url;
					$__SclBd->form_qus = $__form->questions;
					
					$__Prc = $__SclBd->In();
					
					if($__Prc->e == 'ok'){
						$__e = 'ok';
					}

				}else{
					
					$__Prc = '';
					
				}
				
				if($__Prc->e == 'ok'){
					$_formdt = GtSclAccFormDt([ 'form_id'=>$cv->value->form_id ]);
				}
			
			}
		
		}
		
	}	
	
	// Si existe token se realiza la consulta
	
	if(!isN($_formdt->tlvd)){ 
	
		$__lead = _NwFb_Acc_Forms_Lead_Dt([
									't'=>'dt',
									'id'=>$cv->value->leadgen_id,
									'access_token'=>$_formdt->tlvd,
								]); 					
								
		$__SclBd->__t = 'acc_form_lead_dwn';	
		$__SclBd->form_lead = $cv->value->leadgen_id;
		$__SclBd->formlead_data = $__lead->data->field_data;
		$__SclBd->form_id = $_formdt->id;
		$__Prc = $__SclBd->In();
		

		if($__Prc->e == 'ok'){
			$__e = 'ok';
		}

	}
	
	
?>