<?php


	$rsp['e'] = 'no';


	$_fle = new CRM_Fle();
	$_aws = new API_CRM_Aws();


	if($__p2 == 'ec'){

		$__ec = new API_CRM_ec();
		$__dtec = GtEcDt(Php_Ls_Cln($__p3), 'enc');
		$__url = DMN_EC.'html/'.$__dtec->enc.'/?_sc=ok&_rnd='.Gn_Rnd();
		$__fld = DIR_FLE_EC;
		$__nmi = $__dtec->enc;

	}

	if(!isN($__url) && !isN($__nmi)){


		$F_Nw = dirname(__FILE__, 5).'/'.$__fld.'ec_ste_'.$__nmi.'.jpg';
		$F_Nw_Th = dirname(__FILE__, 5).'/'.$__fld.'th/ec_ste_'.$__nmi.'.jpg';
		$F_Nw_Aws = $__fld.'ec_ste_'.$__nmi.'.jpg';

		$F_Url_Th = DMN_FLE_EC.'th/ec_ste_'.$__nmi.'.jpg';
		$F_Url_Bg = DMN_FLE_EC.'ec_ste_'.$__nmi.'.jpg';

		$__img = _GtUrl_Img([ 'u'=>$__url ]);

		if(!isN($__img->data)){

			$data_b = base64_decode( preg_replace('#^data:image/\w+;base64,#i', '', $__img->data )  );

			if(!isN($data_b)){

				if(file_exists($F_Nw)){

					$rsp['exst'] = 'ok';
					$rsp['opn'] = 'ok';

					try{

						$im = new Imagick( $F_Nw );
						$im->setImageFormat("jpeg");
						$im->cropImage(200,300,60,0);
						$im->setImageCompressionQuality(0);

						if($im->writeImage($F_Nw)){
							$_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir($F_Nw_Aws), 'src'=>$F_Nw, 'ctp'=>mime_content_type($F_Nw), 'cfr'=>'ok' ]);
							$rsp['aws'][] = _TmpFixDir($F_Nw);
						}else{
							$rsp['w'][] = 'Cant writeImage';
						}

						$_thmbgo = 'ok';

						$f = fopen($F_Nw,'w+');

						if($f){

							if (!is_writable($F_Nw)) {
								$rsp['permissions']['main']['write'] = 'no';

								if (!chmod($F_Nw, 0666)) {
									$rsp['permissions']['main']['chmod'] = "Cannot change the mode of file ($filename)";
								};
							}

							if(is_writable($F_Nw)){

								$rsp['permissions']['main']['write'] = 'ok';

								if(fwrite($f,$data_b) === FALSE){
									$rsp['process']['main']['write'] = 'no';
									$rsp['process']['main']['file'] = $F_Nw;
								}else{
									$rsp['process']['main']['write'] = 'ok';
								}

							}

							if(fclose($f)){

								$_cutgo='ok';

							}

						}


					}catch (Exception $e) {

						$rsp['process']['error'][] = $e->getMessage();
						$rsp['process']['error'][] = $e;

					}

				}else{

					$rsp['crte'] = 'ok';
					//$rsp['putto'] = $F_Nw;

					if(file_put_contents($F_Nw, $data_b)){

						$_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir($F_Nw), 'src'=>$F_Nw, 'ctp'=>mime_content_type($F_Nw), 'cfr'=>'ok' ]);

						if($_sve->e == 'ok'){
							$rsp['aws'][] = _TmpFixDir($F_Nw);
							$_cutgo='ok';
						}else{
							$rsp['w'][] = $_sve;
						}

					}

				}

			}

			if($_cutgo == 'ok'){

				$rsp['url'] = $__url;

				try{

					if(file_exists($F_Nw)){

						$im = new Imagick( $F_Nw );
						$im->setImageFormat("jpeg");
						$im->cropImage(200,300,60,0);
						//$im->setImageCompressionQuality(0);

						if($im->writeImage($F_Nw)){
							$_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir($F_Nw), 'src'=>$F_Nw, 'ctp'=>mime_content_type($F_Nw), 'cfr'=>'ok' ]);
							$rsp['aws'][] = _TmpFixDir($F_Nw);
						}

						$_thmbgo = 'ok';

					}else{

						$rsp['w'][] = 'File not exists on cut process';

					}


				}catch (Exception $e) {

		            $rsp['e'] = 'no';
		            $rsp['w'] = $e->getMessage();

		        }

			}

		}else{

			$rsp['w'][] = 'Empty image data';
			$rsp['w'][] = $__img;
			echo $__img->url;

		}

	}else{

		if(isN($__url)){ $rsp['w'][] = '$__url empty'; }
		if(isN($__nmi)){ $rsp['w'][] = '$__nmi empty'; }

	}


	//-------------------- CROP IMAGE --------------------//


		try{

			if(file_exists($F_Nw) && $_thmbgo == 'ok'){

				$im = new Imagick( $F_Nw );
				$im->setImageFormat("jpeg");
				$im->cropImage(200,200,0,0);

				if( $im->writeImage($F_Nw_Th) ){

					$_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir($F_Nw_Th), 'src'=>$F_Nw_Th, 'ctp'=>mime_content_type($F_Nw_Th)/*, 'cfr'=>'ok'*/ ]);

					$rsp['aws'][] = _TmpFixDir($F_Nw_Th);

					$rsp['process']['thumb']['write'] = 'ok';
					$rsp['process']['thumb']['file'] = $F_Nw_Th;
					$rsp['process']['thumb']['url']['th'] = $F_Url_Th;
					$rsp['process']['thumb']['url']['bg'] = $F_Url_Bg;

					$__ec->_EcUpd_Fld([ 'id'=>$__dtec->id, 'f'=>'ec_prnts', 'v'=>1 ]);

					$rsp['e'] = 'ok';

				}else{

					$rsp['process']['thumb']['write'] = 'no';

				}

			}

		}catch (Exception $e) {

            $rsp['e'] = 'no';
            $rsp['w'] = $e->getMessage();

        }


	//-------------------- RENDER CONTENT --------------------//


		if(file_exists($F_Nw)){
			unlink($F_Nw);
		}

		Hdr_JSON();
		ob_start("compress_code");

			$rtrn = json_encode($rsp);
			if(!isN($rtrn)){ echo $rtrn; }

		ob_end_flush();


?>