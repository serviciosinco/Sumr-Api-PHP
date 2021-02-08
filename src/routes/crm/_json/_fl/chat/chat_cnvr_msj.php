<?php

$__id_rnd = '_'.Gn_Rnd(20);
$__chat = new CRM_Chat();

$__c = Php_Ls_Cln($_POST['cnv']);
$__u = Php_Ls_Cln($_POST['u']);

$__chat->maincnv_enc = $__c;
$__mcnv = $__chat->MainCnvDt();

if(!isN( $__mcnv->d->id )){

	$Ls_Qry = "	SELECT cnvrmsj_enc, cnvrmsj_msj, cnvrmsj_us, cnvrmsj_fi, us_gnr, us_img, 
						DATE_FORMAT(cnvrmsj_fi, '%Y-%m-%d') as _f_t, 
						( SELECT us_enc FROM "._BdStr(DBM).TB_US." WHERE id_us = cnvrmsj_us ) AS _nw_us_enc
				FROM "._BdStr(DBC).TB_CHAT_CNVR_MSJ."
				   		INNER JOIN "._BdStr(DBM).TB_US." ON cnvrmsj_us=id_us									
				WHERE cnvrmsj_cnvr = '".$__mcnv->d->id."' 
				ORDER BY cnvrmsj_fi ASC"; 
					  
	$Ls_Rg = $__cnx->_qry($Ls_Qry);

	if($Ls_Rg){

		$row_Ls_Rg = $Ls_Rg->fetch_assoc(); 
		$Tot_Ls_Rg = $Ls_Rg->num_rows;	

		$rsp['e'] = 'ok';
		
			if($Tot_Ls_Rg > 0){ 

				$_li_c = 0;
				$_count = 0; 
				
				do {

					$_iob = $row_Ls_Rg['cnvrmsj_enc'];

					$rsp['id'] = $__c;

					$rsp['ls'][ $_iob ]['id'] = $_iob;
					$rsp['ls'][ $_iob ]['tx'] = _Cht_Moji( ctjTx($row_Ls_Rg['cnvrmsj_msj'],'in') );
					$rsp['ls'][ $_iob ]['f']['main'] = $row_Ls_Rg['cnvrmsj_fi'];
					$rsp['ls'][ $_iob ]['f']['s1'] = _HrHTML($row_Ls_Rg['cnvrmsj_fi']);

					if($row_Ls_Rg['cnvrmsj_us'] == SISUS_ID){
						$rsp['ls'][ $_iob ]['me'] = 'ok';
					}else{
						$rsp['ls'][ $_iob ]['me'] = 'no';
					}

					$__img_url = '';
					$dt_img = _ImVrs(['img'=>$row_Ls_Rg['us_img'], 'f'=>DMN_FLE_US]);
					
					if( !isN($row_Ls_Rg['us_img']) ){
						if( !isN($dt_img->bg_s) ){
							$__img_url = $dt_img->bg_s;
						}else{
							$__img_url = $dt_img->th_c_100p;
						}	
					}else{
						$__img_url = GtUsImg([ 'img'=>$row_LsRg['us_img'], 'gnr'=>$row_LsRg['us_gnr'] ]);
					}

					$rsp['ls'][ $_iob ]['img'] = $__img_url;


					/*
					if($__nw_us != $row_Ls_Rg['cnvrmsj_us'] && $__nw_li != ''){ 
						if($_li_c > 1){ $_cls .= ' _mlt'; }
						
						$rsp['ls'][ $__nw_id ] = [
							'id'=>$__nw_id,
							'f'=>$__nw_fi,
							'html'=>bdiv([ 'id'=>'chat_msg_b_'.$__nw_id, 'c'=>$__img. ul($__nw_li, $_cls), 'cls'=>'_bx_li _bx_li_'.$__nw_us_enc ] )
						];

						$__nw_li = ''; 
						$_li_c = 0;
					}
					
					$__nw_us_enc = $row_Ls_Rg['_nw_us_enc']; 
					$__nw_us = $row_Ls_Rg['cnvrmsj_us'];
					$__nw_id = $row_Ls_Rg['cnvrmsj_enc'];
					$__nw_fi = $row_Ls_Rg['cnvrmsj_fi'];

					if($row_Ls_Rg['cnvrmsj_us'] == SISUS_ID){
						$_cls = '_own'; 
						$__img = '';
					}else{ 
						$dt_img = _ImVrs(['img'=>$row_Ls_Rg['us_img'], 'f'=>DMN_FLE_US]);
						$_cls = '_oth';
						
						if( !isN($row_Ls_Rg['us_img']) ){
							
							if( !isN($dt_img->bg_s) ){
								$__img_url = $dt_img->bg_s;
							}else{
								$__img_url = $dt_img->th_c_100p;
							}
							
						}else{
							if($row_Ls_Rg['us_gnr'] == _CId('ID_SX_H')){
								$__img_url = DIR_IMG_ESTR_SVG.'myp_nopic_m.svg';
							}elseif($row_Ls_Rg['us_gnr'] == _CId('ID_SX_M')){
								$__img_url = DIR_IMG_ESTR_SVG.'myp_nopic_w.svg';
							}
						}
						
						$__img = '<figure class="_img"><img src="'.$__img_url.'"></figure>';
					}
					
					$_hr_go = _HrHTML($row_Ls_Rg['cnvrmsj_f']);
					
					if( $row_Ls_Rg['_f_t'] == date("Y-m-d") && $_count == 0 ){ 
						$_f_t = "<div class='_f'>Hoy</div><br>";
					}else{
						unset($_f_t);
					}
					
					$__nw_li .= $_f_t.li( '<div title="'.$_hr_go.'">'. _Cht_Moji( ctjTx($row_Ls_Rg['cnvrmsj_msj'],'in') ).'</div>' ); 
					$_li_c++;
					
					if( $row_Ls_Rg['_f_t'] == date("Y-m-d") && $_count == 0 ){ 
						$_count = 1;
					}*/
		
				} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
				/*
				$_msj_lst = bdiv( [ 'c'=>$__img. ul( $__nw_li, $_cls) , 'cls'=>'_bx_li' ] );
				
				$rsp['ls'][ $__nw_id ] = [
					'id'=>$__nw_id,
					'f'=>$__nw_fi,
					'html'=>$_msj_lst
				];
				*/
			
			}else{

				$rsp['id'] = $__mcnv->d->enc;
				
			} 
			
			$__chat->_Cht_UPD_Us([ 'c'=>$__chat->_chat_d->id, 'us'=>SISUS_ID, 't'=>'od' ]);
		
	}

} 

?>