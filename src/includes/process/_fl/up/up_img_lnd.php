<?php 
	
global $__cnx;

//ini_set('display_errors', true);

$_rnd = Gn_Rnd(20).Gn_Rnd(5);
$__max_w = Php_Ls_Cln($_REQUEST['maxw']);
$__max_h = Php_Ls_Cln($_REQUEST['maxh']);
$__max_d = Php_Ls_Cln($_REQUEST['maxd']);

if($_REQUEST['maxd'] != ''){ $__max_d = Php_Ls_Cln($_REQUEST['maxd']); }else{ $__max_d = 1; }

if(ChckSESS_usr()){ 
  
  	if (((isset($_POST['MM_update']))&&($_POST['MM_update'] == 'ImgUpl'))) { 
	  
		if (!empty($_FILES)) {
					
					
			$Sch = [DMN_BS];
			$Chn = [''];
			$Fldr_Rl = str_replace($Sch,$Chn,$_POST['_dr']);
			$allowed = ['jpg', 'png', 'svg'];
			
			if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
				
				$extension = strtolower( pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION) );
					
				if(!in_array(strtolower($extension), $allowed)){
				
					$rsp['status'] = 'error';
				
				}else{
						
					$__fl_tt = $_POST['_nm'].'_'.$_id_r;
					$__fl_nm = $_FILES['upl']['name'];
					$__tmp_nm = $_FILES['upl']['tmp_name'];
					$__nw_nm = $_rnd.'.'.$extension;
					$__nw_nm_o = $_rnd.'_o.'.$extension;
					
					if($_POST['_tp_img'] == 'lnd_img'){
						
						$__nw_fld = "../../../".DIR_TMP_FLE."lnd/img/";
						
					}
					
					
					try{	
						$_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir($__nw_fld.$__nw_nm_o), 'src'=>$__tmp_nm, 'ctp'=>mime_content_type($__tmp_nm), 'cfr'=>'ok' ]);
					}catch(Exception $e){
						$rsp['e'] = 'no';
						$rsp['w'] = $e->getMessage();
					}
						
						
					if( move_uploaded_file($__tmp_nm, $__nw_fld.$__nw_nm_o) && $_sve->e == 'ok'){
						
						copy($__nw_fld.$__nw_nm_o, $__nw_fld.$__nw_nm);
						
						try{	
							$_cpy = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir($__nw_fld.$__nw_nm), 'src'=>$__nw_fld.$__nw_nm_o, 'ctp'=>mime_content_type($__nw_fld.$__nw_nm_o), 'cfr'=>'ok' ]);
						}catch(Exception $e){
							$rsp['e'] = 'no';
							$rsp['w'] = $e->getMessage();
						}
					
						
						if($_POST['_tp_img'] == 'lnd_img' && $_cpy->e == 'ok'){
							
							$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_IMG." (climg_enc, climg_fle, climg_cl) VALUES (%s, %s, %s)",
						                       GtSQLVlStr(ctjTx($_rnd, 'out'), "text"),
						                       GtSQLVlStr(ctjTx($__nw_nm, 'out'), "text"),
						                       GtSQLVlStr($__dt_cl->id, "int"));
							
							$Result = $__cnx->_prc($insertSQL);
							
						}
						
						if($Result){
							$rsp['e'] = 'ok'; 
					 		$rsp['w'] = ' - Se movio a la carpeta:'; 
							$rsp['status'] = 'success';
						}else{
							$rsp['e'] = 'no';
							_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
							$rsp['status'] = 'error';
							$rsp['error'] = 'no se actualizo en BD';
						}
							
						$__cnx->_clsr($Result);
							
					}else{
						
						$rsp['e'] = 'no';
						$rsp['status'] = 'error';
						$rsp['error'] = 'no se movio archivo';
						_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
						
					}
				}
					
			}else{
				
				$rsp['e'] = 'no';
				$rsp['status'] = 'error';
				$rsp['error'] = 'no viene archivo en solicitud';
				_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
				
			}
		}
		
	}else{
		
		$rsp['e'] = 'no';
		$rsp['status'] = 'error';
		$rsp['w'] = 'No inicia el proceso';
		$rsp['m'] = 2;	
		$rsp['jd'] = 'Update es:'.$_POST['MM_update'];
		
	}
	
}

Hdr_JSON();
$rtrn = json_encode($rsp); echo $rtrn;
?>