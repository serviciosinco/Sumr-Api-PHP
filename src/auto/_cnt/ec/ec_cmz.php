<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'ec_cmz' ]);

if( $_g_alw->est == 'ok' ){

	echo $this->h1('Personalizados');

	if(class_exists('CRM_Cnx')){


		//-------------------- AUTO TIME CHECK - START --------------------//

			$_AUTOP_d = $this->RquDt([ 't'=>'ec_cmz_rbld', 'm'=>1 ]);
			echo $this->h2($_AUTOP_d->e.' - allow? '.$_AUTOP_d->hb, '', '_check');

		//-------------------- AUTO TIME CHECK - END --------------------//

		if($_AUTOP_d->e == 'ok' && ($_AUTOP_d->hb == 'ok' || $_AUTOP_d->lck != 'ok')){

			$__ec_cmz = new API_CRM_ec_Cmz();

			if(!isN($this->g__i )){
				$qry_f = " AND id_eccmz = '".$this->g__i ."'";
			}else{
				$qry_f = " 	AND ( eccmz_est = 1 || eccmz_rbld = 1 )
							AND ( ec_est = ".ID_SISEST_PAPRB." || ec_est = ".ID_SISEST_APRB." || ec_est = ".ID_SISEST_OK." || ( eccmz_fa < NOW() - INTERVAL 1 HOUR ) )
						";
			}

			$qry = "
				SELECT id_eccmz, ( eccmz_fa < NOW() - INTERVAL 1 HOUR ) AS __mdf_aft
				FROM "._BdStr(DBM).TB_EC_CMZ."
					INNER JOIN "._BdStr(DBM).TB_EC." ON eccmz_ec = id_ec
					INNER JOIN "._BdStr(DBM).TB_CL." ON eccmz_cl = id_cl
				WHERE
					id_eccmz != ''
					{$qry_f}
				ORDER BY RAND()
				LIMIT 20
			";

			//echo compress_code( $qry );

			try {

				$___lck = $this->Rqu([ 't'=>'ec_cmz_rbld', 'lck'=>1 ]);

				$LsEcCmz = $__cnx->_qry($qry);

				if($LsEcCmz){

					$rwLsEcCmz = $LsEcCmz->fetch_assoc();
					$TotLsEcCmz = $LsEcCmz->num_rows;

					if($TotLsEcCmz > 0){

						echo $this->h2('Total:'.$TotLsEcCmz);

						do{

							echo $this->li('Process Record '.$rwLsEcCmz['id_eccmz']);
							//$__ec_cmz->cl = $rwLsEcCmz['eccmz_cl'];
							//$__ec_cmz->ec = $rwLsEcCmz['id_ec'];
							$__ec_cmz->ec_cmz = $rwLsEcCmz['id_eccmz'];
							$__rsl = $__ec_cmz->_bld_ec([ 'cche'=>'ok' ]);

							$this->print_json = $__rsl;

						}while($rwLsEcCmz = $LsEcCmz->fetch_assoc());

					}else{

						$this->print_json['w'] = 'No records to update';

					}

				} else{

					echo $this->err($__cnx->c_r->error);

				}

				$__cnx->_clsr($LsEcCmz);

				$___lck = $this->Rqu([ 't'=>'ec_cmz_rbld', 'lck'=>2 ]);

			} catch (Exception $e) {

				$___lck = $this->Rqu([ 't'=>'ec_cmz_rbld', 'lck'=>2 ]);
				echo $this->err($e->getMessage());

			}

		}else{

			echo $this->h1('Rebuild Custom Pushmail Not Allow');

		}

	}

}else{

	echo $this->nallw('Global Pushmail - Custom - Off');

}

?>