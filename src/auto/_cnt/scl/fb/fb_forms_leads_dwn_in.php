<?php 
	
try {

	$_inscss = 'ok';

	$_formdt = GtSclAccFormDt([ 'form_id'=>$rwFmLeadDwn['sclaccform_id'] ]); //print_r($_formdt);
	
	$__formd = _NwFb_Acc_Form_Dt([
		't'=>'dt',
		'id'=>$rwFmLeadDwn['sclaccform_id'],
		'access_token'=>$_formdt->tlvd,
	]); 

	if(isWrkr()){ 
		echo $this->h2('$__formd');
		//print_r($__formd);
	}

	$__leads = _NwFb_Acc_Forms_Leads([
								't'=>'leads',
								'id'=>$rwFmLeadDwn['sclaccform_id'],
								'access_token'=>$_tkn_v->vl,
								'next'=>$__RquDt->nxt,
								'lmt'=>$_lmt 
							]); //print_r($__leads);
	
	$__totleads = count($__leads->data);
	
	if(isN( $__leads->w )){ $__tkn_scss = 'ok'; }else{ $__tkn_scss = 'no'; }

	if($__totleads > 0){	
		
		foreach($__leads->data as $lead_k=>$lead_v){
			
			$__SclBd->__t = 'acc_form_lead_dwn';
			$__SclBd->form_lead = $lead_v->id;
			$__SclBd->formlead_data = $lead_v->field_data;
			$__SclBd->formlead_created = $lead_v->created_time->date;
			$__SclBd->form_id = $__id_accform;
			$__Prc = $__SclBd->In();
			
			echo $this->li( 'Result process:'.print_r($__Prc, true). $this->h2('Created:'.$lead_v->created_time->date) );	 
			echo $this->br(3);

			if($__Prc->e != 'ok'){ $_inscss='no'; }
								
		}
		
		if(!isN($__leads->next) && isN($__RquDt->nxt) && $__RquDt->all == 'ok'){ $__all=2; }else{ $__all=''; }
	
	}elseif(!isN( $__leads->w )){

		echo $this->err( 'Total leads get:'.$__leads->w );

	}
	
	if($_inscss == 'ok'){

		$__sve = $__SclBd->Rqu([
					'tp'=>'forms_leads_dwn',
					'acc'=>$rwFmLeadDwn['id_sclacc'],
					'id'=>$rwFmLeadDwn['id_sclaccform'],
					'nxt'=>$__leads->next,
					'all'=>$__all	
				]);

	}
	
	/*if($__sve->e == 'ok'){ 
		//echo $this->scss('forms_leads_dwn save down success');
	}else{
		//echo $this->err('forms_leads_dwn not saved '.$__sve->w);
	}*/

	$___formleadsin .= $this->li( 
					$this->h1(
						$this->Strn('Form Id Bd:').$__id_accform.$this->br(). 
						$this->Strn('Form Id Fb:').$rwFmLeadDwn['sclaccform_id'].$this->br(). 
						$this->Strn('Form Name Fb:').$rwFmLeadDwn['sclaccform_name'].$this->br().
						$this->Strn('Account Name:').$rwFmLeadDwn['sclacc_nm'].$this->br(). 
						$this->Strn('Leads Inserted:').$rwFmLeadDwn['sclaccform_tot_leads'].$this->br().
						$this->Strn('Leads Suposed Inserted:').$rwFmLeadDwn['sclaccform_leads'].$this->br().
						
						$this->Strn('Leads Expired:').$rwFmLeadDwn['sclaccform_leads_expired'].$this->br().
						
						$this->Strn('Fb Api - Total:').$__totleads.$this->br().
						$this->Strn('RquDt - All:').$__RquDt->all.$this->br().
						$this->Strn('RquDt - Next Cursor Save:').$__RquDt->nxt.$this->br().
						$this->Strn('RquDt - Next Cursor Request:').$__leads->next.$this->br() /*.
						Strn('Save?').print_r($__sve, true).$this->br()*/
					) 
				);
		
} catch (Exception $e) {
    
    $this->Rqu([ 't'=>'fb_forms_leads_dwn' ]);
    echo $e->getMessage();
    
}

	
?>