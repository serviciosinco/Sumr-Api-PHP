<?php

//@ini_set('display_errors', true);
//error_reporting(E_ALL & ~E_NOTICE);


if(class_exists('CRM_Cnx')){

	$__dwn = _Dwn_S([ 't'=>'cnt_appl', 'e_s'=>_GetPost('_eml_snd'), 'frm'=>_GetPost('_frm'), 'us'=>_GetPost('_us') ]);

	//$rsp['qry'] = $__dwn;

	if(!isN($__dwn->id)){

		if(!isN($___Ls->tpg)){ $__fl .= " AND mdlstp_tp = '".$___Ls->tpg."' "; }

		$pdo = CnRd_Pdo();

		$Ls_Whr = "FROM ".$__dt_cl->bd.".".TB_CNT_APPL."
					INNER JOIN "._BdStr(DBM).TB_APPL_FM." ON id_applfm = cntappl_appl
					INNER JOIN ".$__dt_cl->bd.".".TB_CNT." ON id_cnt = cntappl_cnt
					LEFT JOIN ".$__dt_cl->bd.".".TB_MDL." ON id_mdl = cntappl_mdl
					WHERE id_cntappl != '' ";
		$Ls_WhrO = " ORDER BY id_cntappl DESC ";

		$Ls_Qry = "

			CREATE TABLE IF NOT EXISTS "._BdStr(DBD).$__dwn->tab." ENGINE=InnoDB ROW_FORMAT=COMPACT AS (

				SELECT

				id_cntappl AS ID,

				cntappl_idappl AS ID_Aplicacion,
				cntappl_idcntrc AS ID_Contrato,

				".DBD.".ctjTx(applfm_nm) AS Aplicacion,
				".DBD.".ctjTx(cnt_nm) AS Nombres,
				".DBD.".ctjTx(cnt_ap) AS Apellidos,
				".DBD.".ctjTx(mdl_nm) AS Modulo,

				(SELECT GROUP_CONCAT( cntdc_dc SEPARATOR ' | ') FROM ".$__dt_cl->bd.".".TB_CNT_DC." WHERE cntdc_cnt = id_cnt) AS Documentos,
				(SELECT GROUP_CONCAT( cnttel_tel SEPARATOR ' | ') FROM ".$__dt_cl->bd.".".TB_CNT_TEL." WHERE cnttel_cnt = id_cnt) AS Telefonos,
				(SELECT GROUP_CONCAT( cnteml_eml SEPARATOR ' | ') FROM ".$__dt_cl->bd.".".TB_CNT_EML." WHERE cnteml_cnt = id_cnt) AS Correos,

				cnt_fn AS Fecha_Nacimiento,
				(SELECT sisslc_tt FROM ".TB_SIS_SLC." WHERE id_sisslc = cnt_sx) AS Genero,

				'3' as __dwn_e,
				id_cntappl AS __dwn_i

				$Ls_Whr $__fl $Ls_WhrO

			);

			ALTER TABLE "._BdStr(DBD).$__dwn->tab." ADD id_dwnprc INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY AFTER __dwn_i;
			CREATE INDEX __indx_id ON "._BdStr(DBD).$__dwn->tab." (__dwn_i) USING BTREE;

		";

		if(!isN($__dwn->id)){

			$updateSQL_UPD = sprintf("UPDATE "._BdStr(DBD).TB_DWN." SET dwn_est=%s, dwn_qry=%s WHERE id_dwn=%s",
                               GtSQLVlStr(6, "int"),
                               GtSQLVlStr(compress_code($Ls_Qry), "text"),
                               GtSQLVlStr($__dwn->id, "int"));

			$Ls_RgC = $pdo->prepare($updateSQL_UPD);
			$Ls_RgC->execute();

			$__dwn_dt = GtDwnDt([ 'id'=>$__dwn->id ]);
			$rsp['err'] = $Ls_RgC->errorInfo();

			if(!$Ls_RgC){

				UPD_Dwn([ 'i'=>$__dwn_dt->id, 'e'=>5, 'w'=>json_encode($Ls_RgC->errorInfo(), true) ]);

			}else{

				$rsp['e'] = 'ok';
				$rsp['tb'] = $__dwn->tab;
				$rsp['tb_id'] = $__dwn->id;

				if(!isN($__dwn_dt->id)){

					$__upd = UPD_Dwn([ 	'i'=>$__dwn_dt->id,
										'e'=>6,
										'tt'=>MDL_CNT_APPL.' '.$___Ls->tt.' - '.$_POST['_f_in'].'-'.$_POST['_f_out'],
										't_r'=>$__dwn_dt->tot->no_u,
										'g'=>json_encode($_POST, true)
									]);
				}

			}

		}

	}


	$pdo=null;


}

?>