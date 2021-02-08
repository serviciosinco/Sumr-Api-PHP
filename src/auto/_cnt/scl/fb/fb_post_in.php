<?php 
	
try {

	$__id_acc = $___datprcs_v['id_sclacc'];
						
	$__post = _NwFb_Acc_Post([
								't'=>'ls',
								'id'=>$___datprcs_v['sclacc_id'],
								'access_token'=>$_tkn_v->vl,
								'next'=>$__RquDt->nxt,
								'lmt'=>$_lmt 
							]);
							
	$__totpost = count($__post->data);
	
	if(isN( $__post->w )){ 
		$__tkn_scss = 'ok'; 
	}else{ 
		echo $this->err( $__post->w );
		$__tkn_scss = 'no'; 
	}

	$__SclBd->Rqu([
		'tp'=>'post',
		'acc'=>$___datprcs_v['id_sclacc'],
		'nxt'=>$__post->pg->paging->cursors->after		
	]);
	
	if(!isN( $__post->data )){

		foreach($__post->data as $post_k=>$post_v){
			
			$__SclBd = new CRM_Thrd();
			$__SclBd->__t = 'acc_post';	
			$__SclBd->scl_rds = $___datprcs_v['scl_rds'];
			$__SclBd->post_acc = $___datprcs_v['id_sclacc'];
			$__SclBd->post_acc_id = $___datprcs_v['sclacc_id'];
			$__SclBd->post_id = $post_v->id;
			$__SclBd->post_created_time = $post_v->created_time->date;
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
			
			if($__Prc->e != 'ok'){ $_sty = ' color:red;'; }else{ $_sty = ' color:green;'; }
			$___post_li[$__id_acc] .= $this->li($__SclBd->post_id, '', ' font-family:Arial; font-size:10px; '.$_sty );
			
		}

	}

	
	
	$___postin .= $this->li( 
					h1(
						'Account:'.$__id_acc.$this->br(). 
						'LastFa:'.$___datprcs_v['___lst_post_fa'].$this->br().
						'-> FanPage:'. $___datprcs_v['sclacc_id'].$this->br().
						'-> Posts:'. $__totpost. $this->br().
						'-> Limit:'.$_lmt.$this->br().
						'-> Posts:'.ul($___post_li[$__id_acc]).$this->br()
					) 
				);	
		

	

} catch (Exception $e) {
    
	$this->Rqu([ 't'=>'fb_post' ]);
    echo $e->getMessage();
    
}

	
?>