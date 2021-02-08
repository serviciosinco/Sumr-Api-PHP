<?php

if(ChckSESS_superadm()){ // Tempo

	$rsp['chat']['tot'] = 0;

	//if($__frst == 'ok'){
		$__fl_opn = " AND maincnvus_opn = 1";
	//}

	$Ls_UsCht_Qry  = sprintf("	SELECT id_maincnv, maincnv_enc, maincnvus_maincnv, maincnvus_us, maincnv_tp, us_enc, us_nm, us_ap, us_img, us_gnr
							  	FROM "._BdStr(DBC).TB_MAIN_CNV."
									 INNER JOIN "._BdStr(DBC).TB_MAIN_CNV_US." ON maincnvus_maincnv = id_maincnv
									 INNER JOIN "._BdStr(DBM).TB_US." ON maincnvus_us = id_us
								WHERE maincnvus_us=%s AND
									  maincnv_est!=%s
									  {$__fl_opn}
								GROUP BY maincnvus_maincnv ",
								GtSQLVlStr(SISUS_ID, 'int'),
								GtSQLVlStr(_CId('ID_SCLCNVEST_RDY'), 'int')
							);

	$Ls_UsCht = $__cnx->_qry($Ls_UsCht_Qry);

	if($Ls_UsCht > 0){

	 	$row_Ls_UsCht = $Ls_UsCht->fetch_assoc();
	 	$Tot_Ls_UsCht = $Ls_UsCht->num_rows;

	 	$rsp['chat']['tot'] = $Tot_Ls_UsCht;
	 	$rsp['e'] = 'ok';

	 	if($Tot_Ls_UsCht > 0){

		 	do {

				$_id = $row_Ls_UsCht['maincnv_enc'];

				if( $row_Ls_UsCht['maincnv_tp'] == 'sumr' ){

					$__dt_us_oth = GtMainCnvUsOthDt( [ "maincnvus_maincnv"=>$row_Ls_UsCht['maincnvus_maincnv'], "maincnvus_us"=>$row_Ls_UsCht['maincnvus_us'] ] );

					if(isN( $__dt_us_oth->img )){
						$__img_url = GtUsImg([ 'img'=>$__dt_us_oth->img, 'gnr'=>$__dt_us_oth->gnr ]);
					}else{
						$__img_url = _ImVrs(['img'=>$__dt_us_oth->img, 'f'=>DMN_FLE_US]);
					}

				}

				$rsp['chat']['list'][ 'UsCht_'.$_id ]['cnv']['id'] = $row_Ls_UsCht['id_maincnv'];
				$rsp['chat']['list'][ 'UsCht_'.$_id ]['cnv']['enc'] = $row_Ls_UsCht['maincnv_enc'];
				$rsp['chat']['list'][ 'UsCht_'.$_id ]['cnv']['tp'] = $row_Ls_UsCht['maincnv_tp'];

				$rsp['chat']['list'][ 'UsCht_'.$_id ]['us']['enc'] = $__dt_us_oth->enc;
				$rsp['chat']['list'][ 'UsCht_'.$_id ]['us']['nm'] = $__dt_us_oth->nm;
				$rsp['chat']['list'][ 'UsCht_'.$_id ]['us']['ap'] = $__dt_us_oth->ap;
				$rsp['chat']['list'][ 'UsCht_'.$_id ]['us']['img'] = $__img_url;
				$rsp['chat']['list'][ 'UsCht_'.$_id ]['us']['img'] = $__img_url;

				/*
				$rsp['chat']['list'][ 'UsCht_'.$_id ]['lmsj']['tx'] = ctjTx($row_Ls_UsCht['__lst_msg'] ,'in');
				$rsp['chat']['list'][ 'UsCht_'.$_id ]['lmsj']['enc'] = ctjTx($row_Ls_UsCht['__lst_msg_enc'] ,'in');
				$rsp['chat']['list'][ 'UsCht_'.$_id ]['tp'] = 'sumr';
				*/

			} while ($row_Ls_UsCht = $Ls_UsCht->fetch_assoc());

		}

	}else{

		$rsp['chat']['w']['m'] = $__cnx->c_r->error;
		$rsp['chat']['w']['q'] = compress_code( $Ls_UsCht_Qry );

	}


	$__cnx->_clsr($Ls_UsCht);

}

?>