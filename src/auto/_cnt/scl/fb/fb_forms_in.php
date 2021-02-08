<?php

try {

	echo $this->li('SclAcc '.$___datprcs_v['id_sclacc'].' hb?'.$_AUTOP_a->hb);

	$_AUTOP_a->hb = 'ok';

	if($_AUTOP_a->hb == 'ok'){

		$__diff = _Df_Dte($___datprcs_v['___form_upd'], SIS_F_TS);

		if(isN($___datprcs_v['___lst_form_fa']) || ($__diff->Y > 0 || $__diff->m > 0) ){

			$_lmt = 100;

		}else{

			if($___datprcs_v['___lst_form_fa'] != ''){
				if($_lmt != ''){
					$_lmt = $_lmt;
				}elseif($__diff->d > 0){
					$_lmt = 1000;
				}
			}else{
				$_lmt = 1000;
			}

		}

		$__RquDt = $__SclBd->RquDt(['tp'=>'forms', 'acc'=>$___datprcs_v['id_sclacc'] ]);

		if(!isN($__RquDt->nxt)){ $_lmt = ''; }

		$__id_acc = $___datprcs_v['id_sclacc'];
		$__forms = _NwFb_Acc_Forms([
									't'=>'forms',
									'page_id'=>$___datprcs_v['sclacc_id'],
									'access_token'=>$_tkn_v->vl,
									'next'=>$__RquDt->nxt,
									'lmt'=>$_lmt
								]);


		//echo $this->li( compress_code(print_r( $__forms, true )) );

		echo $this->h2( '_NwFb_Acc_Forms limit '.$_lmt );
		echo $this->h2( 'Next: '.$__forms->next );

		$__totforms = count($__forms->data);

		if(isN( $__forms->w )){
			$__tkn_scss = 'ok';
		}else{
			$__tkn_scss = 'no';
			echo $this->err( print_r($__forms->w, true) );
		}

		$__SclBd->Rqu([
			'tp'=>'forms',
			'acc'=>$___datprcs_v['id_sclacc'],
			'nxt'=>$__forms->pg->paging->cursors->after
		]);

		foreach($__forms->data as $form_k=>$form_v){

			if(count($form_v) > 0){

				foreach($form_v as $__form_k=>$__form_v){

					//$__SclBd = new CRM_Thrd();
					$__SclBd->__t = 'acc_form';
					$__SclBd->scl_rds = $___datprcs_v['scl_rds'];
					$__SclBd->form_acc = $___datprcs_v['id_sclacc'];
					$__SclBd->form_acc_id = $___datprcs_v['sclacc_id'];
					$__SclBd->form_id = $__form_v->id;
					$__SclBd->form_name = $__form_v->name;
					$__SclBd->form_created_time = $__form_v->created_time->date;
					$__SclBd->form_status = $__form_v->status;

					//echo $this->li( 'Pagging:'.print_r($__forms->pg, true) );
					echo $this->scss( $__form_v->id	.' - '.$__form_v->status );

					$__SclBd->form_leads = $__form_v->leads_count;
					$__SclBd->form_leads_expired = $__form_v->expired_leads_count;

					$__SclBd->form_attr['creator_name'] = $__form_v->creator->name;
					$__SclBd->form_attr['creator_id'] = $__form_v->creator->id;
					$__SclBd->form_attr['context_card_title'] = $__form_v->context_card->title;
					$__SclBd->form_attr['context_card_content'] = $__form_v->context_card->content;
					$__SclBd->form_attr['context_card_style'] = $__form_v->context_card->style;
					$__SclBd->form_attr['context_card_format'] = $__form_v->context_card->format;
					$__SclBd->form_attr['context_card_id'] = $__form_v->context_card->id;
					$__SclBd->form_attr['follow_up_action_url'] = $__form_v->follow_up_action_url;
					$__SclBd->form_attr['privacy_policy_url'] = $__form_v->privacy_policy_url;

					$__SclBd->form_qus = $__form_v->questions;

					$__Prc = $__SclBd->In();

					if($__Prc->e != 'ok'){
						$_sty = ' color:red;';
						echo $this->err( print_r($__Prc,true) );
					}else{
						$_sty = ' color:green;';
					}

					echo $this->li( $this->Strn('name:').$__SclBd->form_name, '', ' font-family:Arial; font-size:14px; '.$_sty );
					echo $this->li( $this->Strn('id:').$__SclBd->form_id, '', ' font-family:Arial; font-size:14px; '.$_sty );
					echo $this->li( $this->Strn('leads:').$__form_v->leads_count, '', ' font-family:Arial; font-size:14px; '.$_sty );
					echo $this->li( $this->Strn('leads expired:').$__form_v->expired_leads_count, '', ' font-family:Arial; font-size:14px; '.$_sty );
					//$___form_li[$__id_acc] .= $this->li($this->br(2).json_encode($__form_v).$this->br(2).'-------------------------------------------------------');

				}

			}

		}


		if(!isN($__forms->next) && isN($__RquDt->nxt) && $__RquDt->all == 'ok'){ $__all=2; }else{ $__all=''; }


		$__sve = $__SclBd->Rqu([
			'tp'=>'forms',
			'acc'=>$___datprcs_v['id_sclacc'],
			'nxt'=>$__forms->next,
			'all'=>$__all
		]);

		if($__sve->e == 'ok'){
			echo $this->scss($_cl_v->nm.' forms_leads_dwn ('.$__form_v->id.') save down success');
		}else{
			echo $this->err('forms_leads_dwn not saved '.$__sve->w);
		}



		echo $this->li('Account Id:'.$__id_acc);
		echo $this->li('Account Name:'.$___datprcs_v['sclacc_nm']);
		echo $this->li('LastFa:'.$___datprcs_v['___lst_form_fa']);
		echo $this->li('-> FanPage:'. $___datprcs_v['sclacc_id']);
		echo $this->li('-> Limit:'.$_lmt);
		echo $this->li('-> Forms:'.$this->ul($___form_li[$__id_acc]));
		echo $this->li('-> Forms Total:'. $__totforms);

	}

	$this->Rqu([ 't'=>'fb_forms', 'id'=>$___datprcs_v['id_sclacc'] ]);


} catch (Exception $e) {

	$this->Rqu([ 't'=>'fb_forms' ]);
    echo $e->getMessage();

}


?>