<?php


	function GtChtUsLs($p=NULL){

		global $__cnx;

		if(!isN($p['cnvr'])){

			$Ls_Qry_His = "	SELECT id_us, us_enc, us_nm, us_ap, us_img, us_gnr
							FROM "._BdStr(DBC).TB_CHAT_CNVR_US."
								 INNER JOIN "._BdStr(DBM).TB_US." ON cnvrus_us = id_us
							WHERE cnvrus_cnvr = '".$p['cnvr']."' ";

			$Ls_Rg = $__cnx->_qry($Ls_Qry_His);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc();
				$Tot_Ls_Rg = $Ls_Rg->num_rows;

				if($Tot_Ls_Rg > 0){

					do{

						$dt_img = _ImVrs(['img'=>$row_Ls_Rg['us_img'], 'f'=>DMN_FLE_US]);

						if( !isN($row_Ls_Rg['us_img']) ){

							if( !isN($dt_img->bg_s) ){
								$__img_url = $dt_img->bg_s;
							}else{
								$__img_url = $dt_img->th_c_100p;
							}

						}else{
							$__img_url = GtUsImg([ 'img'=>$row_Ls_Rg['us_img'], 'gnr'=>$row_Ls_Rg['us_gnr'] ]);
						}

						$_r[] = [
									'id'=>$row_Ls_Rg['id_us'],
									'enc'=>$row_Ls_Rg['us_enc'],
									'nm'=>ctjTx($row_Ls_Rg['us_nm'] ,'in'),
									'ap'=>ctjTx($row_Ls_Rg['us_ap'] ,'in'),
									'img'=>$__img_url
								];

					} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
				}

			}

			$__cnx->_clsr($Ls_Rg);
			return _jEnc($_r);

		}
	}


	function GtChtDt($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(is_array($_p)){

			if(!isN($_p['id'])){

				if($_p['t'] == 'enc'){ $__f = 'cnvr_enc'; $__ft = 'text'; }else{ $__f = 'id_cnvr'; $__ft = 'int'; }

				$query_DtRg = sprintf("	SELECT	id_cnvr, cnvr_enc
										FROM "._BdStr(DBC).TB_CHAT_CNVR."
										WHERE {$__f} = %s", GtSQLVlStr($_p['id'], $__ft)
									);

				$DtRg = $__cnx->_qry($query_DtRg);

				//$Vl['q'] = compress_code( $query_DtRg );

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_cnvr'];
						$Vl['enc'] = $row_DtRg['cnvr_enc'];
						$Vl['us'] = GtChtUsLs([ 'cnvr'=>$row_DtRg['id_cnvr'] ]);
						$Vl['enc'] = ctjTx($row_DtRg['cnvr_enc'],'in');

					}

				}else{

					$Vl['w'] = $__cnx->c_r->error;

				}

				$__cnx->_clsr($DtRg);

			}else{

				$Vl['w'] = 'No id on request';

			}

		}else{

			$Vl['w'] = 'No data on request';

		}

		$rtrn = _jEnc($Vl);
		return($rtrn);
	}



	function _Cht_Nw_B_Enc($p=NULL){

		if(!isN($p['u1']) && !isN($p['u2'])){

			$_ccnt[0] = $p['u1'];
			$_ccnt[1] = $p['u2'];
			sort($_ccnt);

			$__enc = implode('-', $_ccnt);
			$Vl['enc'] = enCad($__enc);

			$rtrn = _jEnc($Vl);
			return($rtrn);

		}

	}