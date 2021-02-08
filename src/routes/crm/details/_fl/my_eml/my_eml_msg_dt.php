<?php 

	
	//---------------------- VARIABLES GET ----------------------//
			
		$__cnvmsg_id = Php_Ls_Cln($_GET['cnvmsg_id']);
		
		$__Eml = new CRM_Eml();
		$_aws = new API_CRM_Aws();
		$__msg = $__Eml->EmlMsgDt([ 't'=>'enc', 'id'=>$__cnvmsg_id, 'd'=>['attch'=>'ok'] ]);
		$__fcnt = $_aws->_s3_get([ 'b'=>'eml', 'fle'=>'message/html/'.$__msg->enc.'.html', 'lcl'=>'ok', 'gcnt'=>'ok' ]);
		
		if(!isN($__fcnt->w) && $__fcnt->w != 'file_exists'){
			//echo $__fcnt->w;
			$__fcnt = $_aws->_s3_get([ 'b'=>'eml', 'fle'=>'message/plain/'.$__msg->enc.'.html', 'lcl'=>'ok', 'gcnt'=>'ok' ]);
		}
		
		$__Eml->EmlMsgRead([ 'msg'=>$__msg->id ]);
		
	//---------------------- SELECCIONA CORREO ----------------------//		
				
?>
<base target="_blank">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
<style>
	body{ font-family: 'Roboto','Calibri',sans-serif; }
</style>
<?php 
	
	if(!isN($__fcnt->html)){

		$html = str_replace('http://', 'https://', $__fcnt->html);

		if($__msg->attch->tot > 0){
			foreach($__msg->attch->ls as $__msg_k=>$__msg_v){
				if(!isN($__msg_v->cid) && !isN($__msg_v->url) && !isN($__msg_v->url->uri)){
					$html = str_replace('cid:'.$__msg_v->cid, $__msg_v->url->uri, $html);
				}
			}
		}

		echo $html;

	}else{

		echo '<div class="no-html"><button id="recover-html">Recuperar Mensaje</button></div>';

	}

?>