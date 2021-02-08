<?php 

	if(_GetPost('tp') == "_tra_ls"){

		if(!isN(_GetPost('cl'))){
			$__dt_cl = __Cl(['id'=>_GetPost('cl'), 't'=>'enc']);
		}
		
		if($__dt_cl->sbd != NULL){ 
			_StDbCl(['sbd'=>$__dt_cl->sbd, 'enc'=>$__dt_cl->enc, 'mre'=>$__dt_cl]); 
		}
		
		$rsp["tra"] = GtTraLs(["k"=>"enc"]);
		
	}
	
?>