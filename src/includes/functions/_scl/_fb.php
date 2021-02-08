<?php


	use Facebook\FacebookApp;
	use Facebook\FacebookRequest;
	use Facebook\GraphNodes\GraphUser;
	use Facebook\GraphNodes\GraphNode;
	use Facebook\FacebookRequestException;
	use Facebook\AccessToken;


	define('GRPH_FB_V', 'v3.1');


	function _NwFb(){
		try{
			$fb = new Facebook\Facebook([ 'app_id' => APP_FB_ID, 'app_secret' => APP_FB_SC, 'default_graph_version' => GRPH_FB_V ]);
			return $fb;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  	$rsp['w'] = $e->getMessage();
		  	return _jEnc($rsp);
		}
	}


	function _NwFb_Login($p=NULL){
		try{

			$_c = _NwFb();
			$helper = $_c->getRedirectLoginHelper();
			$permissions = ['pages_messaging,public_profile,email,pages_show_list,manage_pages,business_management,read_page_mailboxes,publish_pages,read_insights,instagram_basic,instagram_manage_comments,instagram_manage_insights,ads_read'];
			$loginUrl = $helper->getLoginUrl(DMN_OAUTH.'/facebook/?'.$p['m'], $permissions);

			$rsp['e'] = 'ok';
			$rsp['url'] = $loginUrl;

			return _jEnc($rsp);

		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  	$rsp['w'] = $e->getMessage();
		  	return _jEnc($rsp);
		}
	}


	function _NwFb_Dt($p=NULL){
		if( !isN($p['access_token']) ){
			try{
				if(!isN($p['id'])){ $_ida = $p['id']; }else{ $_ida = 'me'; }
				$_c = _NwFb();
				$_pic = $_c->get('/'.$_ida.'/?fields=id,name,picture,cover', $p['access_token']);
				$_pic_o = json_decode($_pic->getGraphObject());
				return $_pic_o;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			  	$rsp['w'] = $e->getMessage();
			  	return _jEnc($rsp);
			}
		}
	}

	function _NwFb_Ac_Ls($p=NULL){

		if(!isN($p['access_token']) && !isN($p['id'])){

			try{

				$_c = _NwFb();

				$__url = '/'.$p['id'].'/accounts/?fields=access_token,name,id,picture.type(large),cover,about,can_post,fan_count,is_verified,new_like_count,talking_about_count,unread_message_count,unread_notif_count,unseen_message_count,were_here_count&limit=1000';

				//echo $p['access_token'].' '.$__url;

				$_accounts = $_c->get($__url, $p['access_token']);
				$_accounts_o = json_decode($_accounts->getGraphEdge());

				return $_accounts_o;

			} catch(Facebook\Exceptions\FacebookSDKException $e) {

			  	$rsp['w'] = $e->getMessage();
			  	$rsp['w_t'] = 'nwfb_ac_ls';
			}

		}else{
			$rsp['w'] = 'No id and token';
		}

		return _jEnc($rsp);
	}


	function _NwFb_Ac_Dt($p=NULL){

		if(!isN($p['access_token'])){
			try{
				$_c = _NwFb();
				$_accounts = $_c->get('/'.$p['id'].'/?fields=access_token,name,id,picture.type(large),cover,about,can_post,fan_count,is_verified,new_like_count,talking_about_count,unread_message_count,unread_notif_count,unseen_message_count,were_here_count&limit=1000', $p['access_token']);
				$_accounts_o = json_decode($_accounts->getGraphObject());
				return $_accounts_o;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			  	$rsp['w'] = $e->getMessage();
			  	return _jEnc($rsp);
			}
		}
	}


	function _NwFb_Acc_Msg($p=NULL){

		if( !isN($p['access_token']) ){

			try{

				$___pge_tkn = _NwFb_Acc_Pge_Tkn([ 'id'=>$p['id'], 'access_token'=>$p['access_token'] ]);

				$_c = _NwFb();

				if(!isN($p['lmt'])){
					$_m = '&limit='.$p['lmt'];
					$_m_lmt = '.limit('.$p['lmt'].')';
				}

				if(!isN( $___pge_tkn->data->access_token )){

					if($p['cnv']){
						$_messages = $_c->get('/'.$p['cnv'].'/?fields=id,unread_count,updated_time,senders,snippet,messages'.$_m_lmt.'{message,sticker,from,created_time,id,tags,attachments{name,mime_type,image_data,id,size,video_data,file_url}}'.$_m, $___pge_tkn->data->access_token);
						$_rtp = 'o';
					}else{
						$_messages = $_c->get('/'.$p['id'].'/conversations/?fields=id,unread_count,updated_time,senders,snippet,messages'.$_m_lmt.'{message,sticker,from,created_time,id,tags,attachments{name,mime_type,image_data,id,size,video_data,file_url}}'.$_m, $___pge_tkn->data->access_token);
						$_rtp = 'e';
					}

					if($_rtp == 'o'){
						$_messages_o = $_messages->getGraphObject();
					}else{
						$_messages_o = $_messages->getGraphEdge();
					}

					$rsp['data'] = json_decode($_messages_o);
					if($_rtp == 'e'){ $rsp['pg'] = $_messages_o->getMetaData(); }

				}

				return _jEnc($rsp);

			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			  	$rsp['w'] = $e->getMessage();
			  	return _jEnc($rsp);
			}
		}
	}

	function _NwFb_LAT($p=NULL){
		if($p['access_token'] != NULL){
			$_c = _NwFb();
			$o2 = $_c->getOAuth2Client();
			$accessToken = $o2->getLongLivedAccessToken( $p['access_token'] );
			return $accessToken;
		}
	}


	function _NwFb_Us_Dt($p=NULL){
		if( !isN($p['access_token']) ){
			$__rq = '/'.$p['id'].'/?fields=picture.type(large)';

			try{
				$_c = _NwFb();
				$_accounts = $_c->get($__rq, $p['access_token']);
				$_accounts_o = json_decode($_accounts->getGraphObject());
				return $_accounts_o;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			  	$rsp['w'] = $e->getMessage();
			  	$rsp['rqu'] = $__rq;
			  	return _jEnc($rsp);
			}
		}
	}



	function _NwFb_Acc_Msg_Rply($p=NULL){
		if($p['access_token'] != NULL && $p['id'] != NULL && $p['msg'] != NULL){
			try{
				$_c = _NwFb();
				$_reply = $_c->post('/'.$p['id'].'/messages', array('message'=>$p['msg']), $p['access_token']);
				$_reply_o = json_decode($_reply->getGraphObject());
				return _jEnc($_reply_o);
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			  	$rsp['w'] = $e->getMessage();
			  	return _jEnc($rsp);
			}
		}
	}


	function _NwFb_Acc_Sbsc($p=NULL){
		if($p['id'] != NULL){
			try{
				$_c = _NwFb();
				$_reply = $_c->post('/'.$p['id'].'/subscribed_apps', array(), $p['access_token']);
				$rsp['u'] = '/'.$p['id'].'/subscribed_apps';
				$rsp['r'] = $_reply;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			  	$rsp['w'] = $e->getMessage();
			  	return _jEnc($rsp);
			}
		}

		return _jEnc($rsp);
	}


	function _NwFb_Acc_Post($p=NULL){


		if(!isN($p['access_token']) && !isN($p['id'])){

			/*
			$rsp['r'] = '/'.$p['id'].'?fields=created_time,message,id,caption,call_to_action,full_picture,icon,shares,picture,description,type,name,link,reactions,comments,attachments'.$_m.'TKN----->'.$p['access_token'];*/


			try{

				$_c = _NwFb();

				if($p['lmt']){ $_m = '&limit='.$p['lmt']; }
				if($p['next']){ $_m = '&after='.$p['next']; }

				if($p['t'] == 'cmn'){
					$_post = $_c->get('/'.$p['id'].'/comments/?fields=id,message,message_tags,from,is_hidden,attachment,created_time,parent'.$_m, $p['access_token']);
					$_rtp = 'e';
				}elseif($p['t'] == 'rct'){
					$_post = $_c->get('/'.$p['id'].'/reactions/?fields=name,id,link,pic,pic_crop,pic_large,pic_small,pic_square,profile_type,type,username'.$_m, $p['access_token']);
					$_rtp = 'e';
				}elseif($p['t'] == 'ls'){
					$_post = $_c->get('/'.$p['id'].'/posts/?fields=created_time,message,id,caption,call_to_action,full_picture,icon,shares,picture,description,type,name,link,reactions,comments,attachments'.$_m, $p['access_token']);
					$_rtp = 'e';
				}elseif($p['t'] == 'dt'){
					$_post = $_c->get('/'.$p['id'].'?fields=created_time,message,id,caption,call_to_action,full_picture,icon,shares,picture,description,type,name,link,reactions,comments,attachments'.$_m, $p['access_token']);
					$_rtp = 'o';
				}

				if($_rtp == 'o'){ $_post_o = $_post->getGraphObject(); }else{ $_post_o = $_post->getGraphEdge(); }
				$rsp['data'] = json_decode($_post_o);
				if($_rtp == 'e'){ $rsp['pg'] = $_post_o->getMetaData(); }

		return _jEnc($rsp);

			} catch(Facebook\Exceptions\FacebookSDKException $e) {

			  	$rsp['w'] = $e->getMessage();

			  	return _jEnc($rsp);

			}
		}
	}




	function _NwFb_Acc_Pge_Tkn($p=NULL){

		if(!isN($p['access_token']) && !isN($p['id'])){

			try{

				$_c = _NwFb();
				$_post = $_c->get('/'.$p['id'].'/?fields=access_token', $p['access_token']);

				//echo '_NwFb_Acc_Pge_Tkn:----------->'.$p['id'].'/?fields=access_token';

				$rsp['data'] = json_decode( $_post->getGraphObject() );
				return _jEnc($rsp);

			} catch(Facebook\Exceptions\FacebookSDKException $e) {

			  	$rsp['w'] = '_NwFb_Acc_Pge_Tkn error:'.$e->getMessage().' -> '.$p['id'].'/?fields=access_token';
			  	return _jEnc($rsp);
			}

		}else{

			$rsp['w'] = 'No all data for _NwFb_Acc_Pge_Tkn';

		}

		return _jEnc($rsp);

	}


	function _NwFb_Acc_Forms($p=NULL){

		if(!isN($p['access_token']) && !isN($p['page_id']) && !isN($p['t'])){

			try{

				if(!isN($p['page_id'])){
					$___pge_tkn = _NwFb_Acc_Pge_Tkn([ 'id'=>$p['page_id'], 'access_token'=>$p['access_token'] ]);
				}

				$_c = _NwFb();

				if($p['lmt']){ $_m1 = '.limit('.$p['lmt'].')'; }else{ $_m1 = '.limit(1000)'; }
				if($p['next']){ $_m2 = '&after='.$p['next']; }

				if(!isN( $___pge_tkn->data->access_token )){

					if($p['t'] == 'forms'){

						$_post = $_c->get('/'.$p['page_id'].'/?fields=leadgen_forms'.$_m1.'{creator,id,status,name,creator_id,created_time,context_card,allow_organic_lead,expired_leads_count,follow_up_action_text,follow_up_action_url,is_optimized_for_quality,leadgen_export_csv_url,leads_count,legal_content,locale,privacy_policy_url,questions{key,label,type,id,options},qualifiers,tcpa_compliance,messenger_welcome_message}'.$_m2, $___pge_tkn->data->access_token );
						$_rtp = 'o';

						//print_r( $_post );

						if(isWrkr()){
							//echo '/'.$p['id'].'/?fields=leadgen_forms'.$_m1.'{creator,id,status,name,creator_id,created_time,context_card,allow_organic_lead,expired_leads_count,follow_up_action_text,follow_up_action_url,is_optimized_for_quality,leadgen_export_csv_url,leads_count,legal_content,locale,privacy_policy_url,questions{key,label,type,id,options},qualifiers,tcpa_compliance,messenger_welcome_message}'.$_m2;
						}

					}elseif($p['t'] == 'qus'){

						$_post = $_c->get('/'.$p['form_id'].'/?fields=questions{key,label,type,id,options},leads_count,expired_leads_count', $___pge_tkn->data->access_token);
						$_rtp = 'o';

					}elseif($p['t'] == 'opt'){

						$_post = $_c->get('/'.$p['qus_id'].'/?fields=questions{key,label,type,id,options},leads_count,expired_leads_count', $___pge_tkn->data->access_token);
						$_rtp = 'o';

					}else{
						$rsp['w'] = 'No type';
					}

					if($_rtp == 'o'){
						$_post_o = $_post->getGraphObject();

						if($p['t'] == 'forms'){
							if(!isN( $_post_o['leadgen_forms'] )){
								$rsp['next'] = $_post_o['leadgen_forms']->getNextCursor();
								$rsp['pg'] = $_post_o['leadgen_forms']->getMetaData();
							}
						}

					}else{
						$_post_o = $_post->getGraphEdge();
						$rsp['next'] = $_post_o->getNextCursor();
					}

					$rsp['data'] = json_decode($_post_o);


				}else{

					$rsp['w'][] = '$___pge_tkn->data->access_token empty '.print_r($___pge_tkn, true);
					$rsp['w'][] = $___pge_tkn->w;

				}


				if($_rtp == 'e'){

					$rsp['pg'] = $_post_o->getMetaData();

					if($p['t'] == 'forms'){
						//echo $p['id'].'---------PG 1------';
						//print_r($rsp['pg']);
					}

				}else{
					//echo $p['id'].'---------PG 2------';
					//print_r( $_post_o->getProperty('id') );
				}

				return _jEnc($rsp);


			} catch(Facebook\Exceptions\FacebookSDKException $e) {

			  	echo $rsp['w'] = $e->getMessage();
			  	return _jEnc($rsp);
			}

		}else{

			$rsp['w'][] = 'No all data for _NwFb_Acc_Forms';

			if(isN($p['access_token'])){ $rsp['w'][] = 'access_token empty'; }
			if(isN($p['id'])){ $rsp['w'][] = 'id empty'; }
			if(isN($p['t'])){ $rsp['w'][] = 't empty'; }

		}

		return _jEnc($rsp);

	}

	function _NwFb_Acc_Form_Dt($p=NULL){

		if(!isN($p['access_token']) && !isN($p['id'])){

			try{

				$_c = _NwFb();

				$_post = $_c->get('/'.$p['id'].'/?fields=creator,id,status,name,creator_id,created_time,context_card,allow_organic_lead,expired_leads_count,follow_up_action_text,follow_up_action_url,is_optimized_for_quality,leadgen_export_csv_url,leads_count,legal_content,locale,privacy_policy_url,questions{key,label,type,id,options},qualifiers,tcpa_compliance,messenger_welcome_message', $p['access_token']);

				$_post_o = $_post->getGraphObject();
				$rsp['data'] = json_decode($_post_o);

				return _jEnc($rsp);

			} catch(Facebook\Exceptions\FacebookSDKException $e) {

			  	$rsp['w'] = $e->getMessage();
			  	return _jEnc($rsp);
			}
		}
	}




	function _NwFb_Acc_Forms_Leads($p=NULL){

		if(!isN($p['access_token']) && !isN($p['id'])){

			try{

				if(!isN( $p['id'] )){

					$_c = _NwFb();
					if($p['lmt']){ $_m1 = '.limit('.$p['lmt'].')'; }
					if($p['next']){ $_m2 = '&after='.$p['next']; }

					if($p['t'] == 'leads'){
						$_post = $_c->get('/'.$p['id'].'/leads?'.$_m2, $p['access_token']); //?fields=field_data
						//print_r($_post);
					}

					$_post_o = $_post->getGraphEdge();

					if(!isN($_post_o)){
						$rsp['data'] = json_decode($_post_o);
						$rsp['prev'] = $_post_o->getPreviousCursor();
						$rsp['next'] = $_post_o->getNextCursor();
						$rsp['tot'] = $_post_o->getTotalCount();
					}

				}else{

					$p['w'] = 'No data get id '.$p['id'];

				}

				return _jEnc($rsp);

			} catch(Facebook\Exceptions\FacebookSDKException $e) {

			  	$rsp['w'] = $e->getMessage();
				  return _jEnc($rsp);

			}
		}
	}



	function _NwFb_Acc_Forms_Lead_Dt($p=NULL){

		if(!isN($p['access_token']) && !isN($p['id'])){

			try{

				$_c = _NwFb();
				$_post = $_c->get('/'.$p['id'].'/?fields=id,created_time,field_data'.$_m2, $p['access_token']); //?fields=field_data
				$_post_o = $_post->getGraphObject();

				$rsp['data'] = json_decode($_post_o);
		return _jEnc($rsp);

			} catch(Facebook\Exceptions\FacebookSDKException $e) {

			  	$rsp['w'] = $e->getMessage();
			  	return _jEnc($rsp);
			}
		}
	}






















	function _FB_Fpg($_i=NULL){
		try {
			$fb = new Facebook(array('appId' => APP_FB_ID,'secret' => APP_FB_SC,'cookie' => true));
			$fb->setAccessToken(APP_FB_TKN);
			$fb->setExtendedAccessToken();
			$_r = $fb->api('/'.$_i.'/');
			return($_r);
		} catch (FacebookApiException $e) {
			$_r = $e->getMessage();
			return false;
		}
	}

	function _FB_Fpg_Mre($_i=NULL){
		try {
			$fb = new Facebook(array('appId' => APP_FB_ID,'secret' => APP_FB_SC,'cookie' => true));
			$fb->setAccessToken(APP_FB_TKN);
			$fb->setExtendedAccessToken();
			$_r = $fb->api('/'.$_i.'/?fields=picture', 'GET');
			return($_r);
		} catch (FacebookApiException $e) {
			$_r = $e->getMessage();
			return false;
		}
	}

	function _FB_Fpg_In($_i=NULL, $_fi=NULL, $_fo=NULL){
		try {
			$fb = new Facebook(array('appId' => APP_FB_ID,'secret' => APP_FB_SC,'cookie' => true));
			$fb->setAccessToken(APP_FB_TKN);
			$fb->setExtendedAccessToken();
			$_r = $fb->api('/'.$_i.'/insights/page_fan_removes?since='.$_fi.'&until='.$_fo);
			return($_r);
		} catch (FacebookApiException $e) {
			$_r = $e->getMessage();
			return($_r);
		}
	}

	function _FB_Ad_Ls($_i=NULL){

		try {
			$fb = new Facebook\Facebook(['app_id'=>APP_FB_ID, 'app_secret'=>APP_FB_SC, 'default_graph_version'=>GRPH_FB_V]);
			$fb_r = $fb->get('/'.$_i.'/ads?fields=name,configured_status,effective_status,campaign_id,created_time,insights,adcreatives{object_story_id,run_status,image_url,id,object_story_spec,call_to_action_type,image_hash,name,object_type}', APP_FB_TKN);
			$fb_r_e = $fb_r->getGraphEdge();
			$fb_r_e_a = $fb_r_e->asArray();

			$_n = 0;
			foreach($fb_r_e_a as $row){
				$Vl[$_n]['adcreatives'] = $row['adcreatives'][0];
				$Vl[$_n]['insights'] = $row['insights'][0];
				$_n++;
			}

			return _jEnc($Vl);

		} catch(FacebookRequestException $ex) {
			$_r['w'] = $ex->getMessage();
			return($_r);
		}

	}

	function _FB_Ad_Insg($_i=NULL){

		if($_i != NULL){
			try {

				$fb = new Facebook\Facebook(['app_id'=>APP_FB_ID, 'app_secret'=>APP_FB_SC, 'default_graph_version'=>GRPH_FB_V]);
				$fb_r = $fb->get('/'.$_i.'/insights', APP_FB_TKN);
				$fb_r_e = $fb_r->getGraphEdge();
				$_r = $fb_r_e[0]->asArray();

				if(count($_r['actions']) > 0){
					foreach($_r['actions'] as $row){
						$Vl['a'][$row['action_type']] = $row['value'];
					}
				}

				if(count($_r['cost_per_action_type']) > 0){
					foreach($_r['cost_per_action_type'] as $row){
						$Vl['c'][$row['action_type']] = $row['value'];
					}
				}

				$Vl['f'] = $_r;

				$rtrn = _jEnc($Vl);
				return($rtrn);

			} catch(FacebookRequestException $ex) {
				print_r($ex);
				return NULL;
			}
		}else{
			return NULL;
		}
	}


	function _FB_FP_Insg($_i=NULL){

		if($_i != NULL){

			try {

				$session = new FacebookSession(APP_FB_TKN);
				$request = new FacebookRequest($session, 'GET', '/'.$_i.'/insights/');
				$response = $request->execute();
				$graphObject = $response->getGraphObject();
				$_r = $graphObject->getProperty('data');

				$Vl = $_r->asArray();

				$rtrn = _jEnc($Vl);
				return($rtrn);

			} catch(FacebookRequestException $ex) {
				return NULL;
			}

		}else{
			return NULL;
		}

	}

	function _Fb_Ad_Mod($_adset, $_grpset){
		$_s = array('{adset}', '{adgroup}');
		$_c = array($_adset, $_grpset);
		$_r = str_replace($_s, $_c, URL_FB_AD_MOD);
		return $_r;
	}


	function _FB_Ac(){
		try {
			$session = new FacebookSession(APP_FB_TKN);
			$request = new FacebookRequest($session, 'GET', '/me?fields=adaccounts{balance,account_status,name}');
			$response = $request->execute();
			$graphObject = $response->getGraphObject();
			return $graphObject->getProperty('adaccounts')->getProperty('data');
		} catch(FacebookRequestException $ex) {
			return false;
		}
	}


	function __FB_Ing_Sta($p=NULL){

		global $__cnx;

		$id_cmp = $p['c']; // array -> c = id de campaña
		$tp_cmp = $p['t']; // array -> t = tipo de modulo
		$id_fb = $p['f']; // array -> f = id de campaña facebook
		$p_c = $p['c_prs_c']; // Inversion Real de Usuario
		$i_s = $p['c_inv_s']; // Inversion Real de Servicios.in

		if($id_fb != ''){ $__dt_ads_fb = _FB_Ad_Insg($id_fb); }
		$_bd = 'pro_cmp_sta'; $_bd2 = MDL_PRO_CMP_BD; $__prfx = 'procmp'; $__prfx_2 = 'procmp';

		$rsp['date_start'] = $__dt_ads_fb->f->date_start;
		$rsp['date_stop'] = $__dt_ads_fb->f->date_stop;

		// Costos Reales
		$rsp['cost_per_result'] = $__dt_ads_fb->f->cost_per_result;
		$rsp['cost_per_total_action'] = $__dt_ads_fb->f->cost_per_total_action;
		$rsp['cpc'] = $__dt_ads_fb->f->cpc;
		$rsp['cost_per_unique_click'] = $__dt_ads_fb->f->cost_per_unique_click;
		$rsp['cpm'] = $__dt_ads_fb->f->cpm;
		$rsp['cpp'] = $__dt_ads_fb->f->cpp;
		$rsp['ctr'] = $__dt_ads_fb->f->ctr;

		// Costos Cliente
		$rsp['nw_cost_per_result'] = __FB_Gst_R(array('prs'=>$p_c, 'v_r'=>$__dt_ads_fb->f->cost_per_result, 'inv'=>$i_s));
		$rsp['nw_cost_per_total_action'] = __FB_Gst_R(array('prs'=>$p_c, 'v_r'=>$__dt_ads_fb->f->cost_per_total_action, 'inv'=>$i_s));
		$rsp['nw_cpc'] =  __FB_Gst_R(array('prs'=>$p_c, 'v_r'=>$__dt_ads_fb->f->cpc, 'inv'=>$i_s));
		$rsp['nw_cost_per_unique_click'] =  __FB_Gst_R(array('prs'=>$p_c, 'v_r'=>$__dt_ads_fb->f->cost_per_unique_click, 'inv'=>$i_s));
		$rsp['nw_cpm'] =  __FB_Gst_R(array('prs'=>$p_c, 'v_r'=>$__dt_ads_fb->f->cpm, 'inv'=>$i_s));
		$rsp['nw_cpp'] =  __FB_Gst_R(array('prs'=>$p_c, 'v_r'=>$__dt_ads_fb->f->cpp, 'inv'=>$i_s));
		$rsp['nw_ctr'] =  __FB_Gst_R(array('prs'=>$p_c, 'v_r'=>$__dt_ads_fb->f->ctr, 'inv'=>$i_s));


		$rsp['clicks'] = $__dt_ads_fb->f->clicks;
		$rsp['impressions'] = $__dt_ads_fb->f->impressions;
		$rsp['frequency'] = $__dt_ads_fb->f->frequency;

		$rsp['a_comment'] = $__dt_ads_fb->a->comment;
		$rsp['a_like'] = $__dt_ads_fb->a->like;
		$rsp['a_link_click'] = $__dt_ads_fb->a->link_click;
		$rsp['a_offsite_conversion'] = $__dt_ads_fb->a->offsite_conversion;
		$rsp['a_post'] = $__dt_ads_fb->a->post;
		$rsp['a_post_like'] = $__dt_ads_fb->a->post_like;
		$rsp['a_page_engagement'] = $__dt_ads_fb->a->page_engagement;
		$rsp['a_post_engagement'] = $__dt_ads_fb->a->post_engagement;


		// Costos Reales
		$rsp['c_comment'] = $__dt_ads_fb->c->comment;
		$rsp['c_like'] = $__dt_ads_fb->c->like;
		$rsp['c_link_click'] = $__dt_ads_fb->c->link_click;
		$rsp['c_offsite_conversion'] = $__dt_ads_fb->c->offsite_conversion;
		$rsp['c_post'] = $__dt_ads_fb->c->post;
		$rsp['c_post_like'] = $__dt_ads_fb->c->post_like;
		$rsp['c_page_engagement'] = $__dt_ads_fb->c->page_engagement;
		$rsp['c_post_engagement'] = $__dt_ads_fb->c->post_engagement;


		// Costos Cliente
		$rsp['nw_c_comment'] = __FB_Gst_R(array('prs'=>$p_c, 'v_r'=>$__dt_ads_fb->c->comment, 'inv'=>$i_s));
		$rsp['nw_c_like'] = __FB_Gst_R(array('prs'=>$p_c, 'v_r'=>$__dt_ads_fb->c->like, 'inv'=>$i_s));
		$rsp['nw_c_link_click'] = __FB_Gst_R(array('prs'=>$p_c, 'v_r'=>$__dt_ads_fb->c->link_click, 'inv'=>$i_s));
		$rsp['nw_c_offsite_conversion'] = __FB_Gst_R(array('prs'=>$p_c, 'v_r'=>$__dt_ads_fb->c->offsite_conversion, 'inv'=>$i_s));
		$rsp['nw_c_post'] = __FB_Gst_R(array('prs'=>$p_c, 'v_r'=>$__dt_ads_fb->c->post, 'inv'=>$i_s));
		$rsp['nw_c_post_like'] = __FB_Gst_R(array('prs'=>$p_c, 'v_r'=>$__dt_ads_fb->c->post_like, 'inv'=>$i_s));
		$rsp['nw_c_page_engagement'] = __FB_Gst_R(array('prs'=>$p_c, 'v_r'=>$__dt_ads_fb->c->page_engagement, 'inv'=>$i_s));
		$rsp['nw_c_post_engagement'] = __FB_Gst_R(array('prs'=>$p_c, 'v_r'=>$__dt_ads_fb->c->post_engagement, 'inv'=>$i_s));


		$rsp['spend'] = $__dt_ads_fb->f->spend;
		$rsp['score'] = $__dt_ads_fb->f->relevance_score->score;
		$rsp['positive_feedback'] = $__dt_ads_fb->f->relevance_score->positive_feedback;
		$rsp['negative_feedback'] = $__dt_ads_fb->f->relevance_score->negative_feedback;
		$rsp['status'] = $__dt_ads_fb->f->relevance_score->status;

		if($__dt_ads_fb != NULL && $id_cmp != NULL && ($rsp['date_start'] != '' || $rsp['date_stop'] != '' || $rsp['spend'] != '')){
					$insertSQL = sprintf("INSERT INTO {$_bd} ({$__prfx}sta_{$__prfx}, {$__prfx}sta_sta, {$__prfx}sta_end, {$__prfx}sta_cpr, {$__prfx}sta_cpa, {$__prfx}sta_cpc, {$__prfx}sta_cpuc, {$__prfx}sta_cpm, {$__prfx}sta_cpp, {$__prfx}sta_ctr, {$__prfx}sta_cli, {$__prfx}sta_prt, {$__prfx}sta_frc, {$__prfx}sta_com, {$__prfx}sta_lik, {$__prfx}sta_lnkcli, {$__prfx}sta_offcon, {$__prfx}sta_pst, {$__prfx}sta_pstlik, {$__prfx}sta_pgeng, {$__prfx}sta_psteng, {$__prfx}sta_cpa_com, {$__prfx}sta_cpa_lik, {$__prfx}sta_cpa_lnkcli, {$__prfx}sta_cpa_offcon, {$__prfx}sta_cpa_pst, {$__prfx}sta_cpa_pstlik, {$__prfx}sta_cpa_pgeng, {$__prfx}sta_cpa_psteng, {$__prfx}sta_gst, {$__prfx}sta_rlv_ad, {$__prfx}sta_rlv_pos, {$__prfx}sta_rlv_neg, {$__prfx}sta_rlv_est) VALUES (%s, %s, %s, %s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GtSQLVlStr($id_cmp, "int"),

						   GtSQLVlStr($rsp['date_start'], "date"),
						   GtSQLVlStr($rsp['date_stop'], "date"),
						   GtSQLVlStr($rsp['cost_per_result'], "double"),
						   GtSQLVlStr($rsp['cost_per_total_action'], "double"),
						   GtSQLVlStr($rsp['cpc'], "double"),
						   GtSQLVlStr($rsp['cost_per_unique_click'], "double"),
						   GtSQLVlStr($rsp['cpm'], "double"),
						   GtSQLVlStr($rsp['cpp'], "double"),
						   GtSQLVlStr($rsp['ctr'], "double"),
						   GtSQLVlStr($rsp['clicks'], "int"),
						   GtSQLVlStr($rsp['impressions'], "int"),
						   GtSQLVlStr($rsp['frequency'], "int"),

						   GtSQLVlStr($rsp['a_comment'], "text"),
						   GtSQLVlStr($rsp['a_like'], "int"),
						   GtSQLVlStr($rsp['a_link_click'], "int"),
						   GtSQLVlStr($rsp['a_offsite_conversion'], "int"),
						   GtSQLVlStr($rsp['a_post'], "int"),
						   GtSQLVlStr($rsp['a_post_like'], "int"),
						   GtSQLVlStr($rsp['a_page_engagement'], "int"),
						   GtSQLVlStr($rsp['a_post_engagement'], "int"),

						   GtSQLVlStr($rsp['c_comment'] , "text"),
						   GtSQLVlStr($rsp['c_like'], "int"),
						   GtSQLVlStr($rsp['c_link_click'], "double"),
						   GtSQLVlStr($rsp['c_offsite_conversion'], "double"),
						   GtSQLVlStr($rsp['c_post'], "int"),
						   GtSQLVlStr($rsp['c_post_like'], "int"),
						   GtSQLVlStr($rsp['c_page_engagement'], "double"),
						   GtSQLVlStr($rsp['c_post_engagement'], "double"),

						   GtSQLVlStr($rsp['spend'], "int"),
						   GtSQLVlStr($rsp['score'], "int"),
						   GtSQLVlStr($rsp['positive_feedback'], "text"),
						   GtSQLVlStr($rsp['negative_feedback'], "text"),
						   GtSQLVlStr($rsp['status'], "text"));

					$Result = $__cnx->_prc($insertSQL);


					if($rsp['spend'] != '' && $rsp['spend'] != 0 && filter_var($rsp['spend'], FILTER_VALIDATE_INT)){

						$updateSQL = sprintf("UPDATE ".$_bd2." SET {$__prfx_2}_gst=%s, {$__prfx_2}_rsl_clck=%s, {$__prfx_2}_rsl_alcn=%s WHERE id_{$__prfx_2}=%s",
										   GtSQLVlStr($rsp['spend'], "text"),
										   GtSQLVlStr($rsp['clicks'], "text"),
										   GtSQLVlStr($rsp['impressions'], "text"),
										   GtSQLVlStr($id_cmp, "int"));

						$Result = $__cnx->_prc($updateSQL);

					}

				if($Result){
					$rsp['e'] = 'ok';
				}else{
					$rsp['e'] = 'no';
					$rsp['w'] = $__cnx->c_p->error;
				}
		}else{
			$rsp['e'] = 'no';
		}

		return _jEnc($rsp);
	}

	function __FB_Gst_R($p=NULL){
		$_v = ($p['prs'] * (($p['v_r'] / $p['inv']) * 100)) / 100;
		return($_v);
	}


?>