<?php 
	
	
	$_post_dt = GtSclAccPostDt(['id'=>$cv->value->post_id]);
	$__SclBd = new CRM_Thrd();
	
		
	if(!isN($_post_dt->id) && (!isN($cv->value->reaction_type) || !isN($cv->value->item)) ){
		
		
		if(!isN($cv->value->reaction_type)){ $__type = $cv->value->reaction_type; }else{ $__type = $cv->value->item; }
		
		$__SclBd->__t = 'acc_post_rct';	 
		$__SclBd->scl_rds = 344;
		$__SclBd->postrct_post = $_post_dt->id;
		$__SclBd->postrct_from = $cv->value->from->id;
		$__SclBd->postrct_from_o = json_encode(['id'=>$cv->value->from->id, 'name'=>$cv->value->from->name]);
		$__SclBd->postrct_type = strtoupper( $__type );		
		
		if(is_numeric($cv->value->created_time)){
			$__SclBd->postrct_created = date('Y-m-d H:i:s.u', $cv->value->created_time);
		}else{	
			$__SclBd->postrct_created = $cv->value->created_time;
		}
		
		$__Prc = $__SclBd->In();			
		 
	}else{
		
		
		$_accdt = GtSclAccDt(['acc_id'=>$___acc_chng_id]);
		$post_v = NULL;
		
		foreach($_accdt->acc_scl as $ak=>$vk){
			$__post = _NwFb_Acc_Post([
								't'=>'dt',
								'id'=>$cv->value->post_id,
								'access_token'=>$vk->tlvd,
							]); 
			
			if(!isN($__post->data)){ $post_v=$__post->data; break; }		
		}		
	
		
		if(!isN($post_v->id)){
			
			$__SclBd->__t = 'acc_post';	
			$__SclBd->scl_rds = 344;
			$__SclBd->post_acc = $_accdt->id;
			$__SclBd->post_acc_id = $___acc_chng_id;
			$__SclBd->post_id = $post_v->id;
			$__SclBd->post_created_time = $post_v->created_time;
			$__SclBd->post_link = $post_v->link;
			$__SclBd->post_name = $post_v->name;
			$__SclBd->post_message = $post_v->message;
			$__SclBd->post_caption = $post_v->caption;
			$__SclBd->post_full_picture = $post_v->full_picture;
			$__SclBd->post_icon = $post_v->icon;
			$__SclBd->post_c_shares = $post_v->shares->count;
			$__SclBd->post_c_comments = count($post_v->comments);
			$__SclBd->post_c_reacts = count($post_v->reactions);
			$__SclBd->post_picture = $post_v->picture;
			$__SclBd->post_type = $post_v->type;
			$__SclBd->post_attach = json_encode($post_v->attachments);
			$__Prc = $__SclBd->In();
			
			if($__Prc->e == 'ok'){
				
				if(!isN($cv->value->reaction_type)){ $__type = $cv->value->reaction_type; }else{ $__type = $cv->value->item; }
				
				$__SclBd->__t = 'acc_post_rct';	 
				$__SclBd->postrct_post = $__Prc->id;
				$__SclBd->postrct_from = $cv->value->from->id;
				$__SclBd->postrct_from_o = json_encode(['id'=>$cv->value->from->id, 'name'=>$cv->value->from->name]);
				$__SclBd->postrct_type = strtoupper( $__type );		
				$__SclBd->postrct_created = $cv->value->created_time;
				$__Prc = $__SclBd->In();

				if($__Prc->e == 'ok'){
					$__e = 'ok';
				}

			}
		
		}
				
	}
	
	
?>