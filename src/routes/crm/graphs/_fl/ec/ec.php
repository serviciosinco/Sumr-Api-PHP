<?php


	$_t2 = Php_Ls_Cln($_GET['_t2']);
	$_tp = Php_Ls_Cln($_GET['_tp']);
	$_gr = Php_Ls_Cln($_GET['_g_r']);
	$___Dt->_strt();


	//-------------- FILTERS OUT  --------------//


		$__dt_1 = !isN($___Dt->_fl->f1) ? $___Dt->_fl->f1 : date('Y-m-01');
		$__dt_2 = !isN($___Dt->_fl->f2) ? $___Dt->_fl->f2 : date('Y-m-d');

		if(	!isN($___Dt->gt->tsb) &&
			$___Dt->gt->tsb != 'mycmz' &&
			$___Dt->gt->tsb != 'main'
		){
			$___Dt->qry_f .= " AND id_ec IN ( 	SELECT ecmdlstp_ec
												FROM "._BdStr(DBM).TB_MDL_S_TP."
														INNER JOIN "._BdStr(DBM).TB_EC_TP." ON ecmdlstp_mdlstp = id_mdlstp
												WHERE mdlstp_tp = '".$___Dt->gt->tsb."'
											) ";
		}

	//-------------- START QUERYS AND BUILDERS  --------------//

	$__id_prfx = '_'.Gn_Rnd(20);


	if($_tp == "grph_1"){

		if(isN($___Dt->_fl->f1) && isN($___Dt->_fl->f2)){
			$___Dt->qry_f .= ' AND DATE_FORMAT(ec_fi, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
		}

		if($___Dt->gt->tmpl == 'mycmz' || $___Dt->gt->tsb == 'mycmz'){
			$___Dt->qry_f .= ' AND ec_cmzrlc IS NOT NULL '.$__fl;
		}elseif($___Dt->gt->tmpl == 'cmz'){
			$___Dt->qry_f .= ' AND ec_cmz = 1 AND ec_cmzrlc IS NULL ';
		}elseif($___Dt->gt->tmpl == 'data'){
			$___Dt->qry_f .= ' AND ec_flj = 1 ';
		}else{
            $___Dt->qry_f .= ' AND (ec_flj != 1 AND ec_cmz != 1 AND ec_cmzrlc IS NULL) ';
        }



		$Ls_Qry = " SELECT 	COUNT(*) AS __tot,
							DATE_FORMAT(ec_fi, '%Y-%m-%d') as _f_i
					FROM "._BdStr(DBM).TB_EC."
							INNER JOIN "._BdStr(DBM).TB_CL." ON ec_cl = id_cl
					WHERE id_ec != '' AND cl_enc = '".CL_ENC."' ".$___Dt->qry_f."
					GROUP BY DATE_FORMAT(ec_fi, '%Y-%m-%d')
					ORDER BY id_ec DESC, ec_fa DESC
				";

		$Ls_Qry_Are = " SELECT 	COUNT(*) AS __tot,
								clare_tt as __tt,
								clare_clr as __clr
						FROM "._BdStr(DBM).TB_EC."
								INNER JOIN "._BdStr(DBM).TB_EC_ARE." ON ecare_ec = id_ec
								INNER JOIN "._BdStr(DBM).TB_CL_ARE." ON ecare_are = id_clare
								INNER JOIN "._BdStr(DBM).TB_CL." ON ec_cl = id_cl
						WHERE id_ec != '' AND cl_enc = '".CL_ENC."' ".$___Dt->qry_f."
						GROUP BY id_clare
					";

		$Ls_Qry_Est = " SELECT 	COUNT(*) AS __tot,
								"._QrySisSlcF([ 'als'=>'e', 'als_n'=>'Estado' ]).",
								".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Estado', 'als'=>'e' ])."
						FROM "._BdStr(DBM).TB_EC."
								INNER JOIN "._BdStr(DBM).TB_CL." ON ec_cl = id_cl
								".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'ec_est', 'als'=>'e' ])."
						WHERE id_ec != '' AND cl_enc = '".CL_ENC."' ".$___Dt->qry_f."
						GROUP BY ec_est
		";

		//if(SISUS_ID == 1){ echo compress_code( $Ls_Qry_Are ); exit(); }

		$Ls_Rg = $__cnx->_qry($Ls_Qry);
		$Ls_Rg_Are = $__cnx->_qry($Ls_Qry_Are);
		$Ls_Rg_Est = $__cnx->_qry($Ls_Qry_Est);

		if($Ls_Rg && $Ls_Rg_Are && $Ls_Rg_Est){

			$row_Ls_Rg = $Ls_Rg->fetch_assoc();
			$row_Ls_Rg_Are = $Ls_Rg_Are->fetch_assoc();
			$row_Ls_Rg_Est = $Ls_Rg_Est->fetch_assoc();

			$Tot_Ls_Rg = $Ls_Rg->num_rows;
			$Tot_Ls_Rg_Are = $Ls_Rg_Are->num_rows;
			$Tot_Ls_Rg_Est = $Ls_Rg_Est->num_rows;

			//---------------- PROCESS COUNT BY DATE ---------------- //

				if($Tot_Ls_Rg > 0){

					do {
						$Vl[$row_Ls_Rg['_f_i']]['date'] = $row_Ls_Rg['_f_i'];
						$Vl[$row_Ls_Rg['_f_i']]['tot'] = $row_Ls_Rg['__tot'];
					} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());

					$Vl_Grph = _jEnc($Vl);
				}

				for($i=$__dt_1;$i<=$__dt_2; $i=date("Y-m-d", strtotime($i ."+ 1 days"))){
					$__ctg[] = '"'.$i.'"';
					if(!isN($Vl_Grph->{$i}->tot)){ $_tot=$Vl_Grph->{$i}->tot; }else{ $_tot=0; }
					$_medio_tot[] = $_tot;
				}

				$_grph_d = "{ name:'Pushmail', data:[".implode(",", $_medio_tot)."] } ";
				$_grph_c = implode(",", $__ctg);


			//---------------- PROCESS COUNT BY DATE ---------------- //

				if($Tot_Ls_Rg > 0){

					do {
						$Vl[$row_Ls_Rg['_f_i']]['date'] = $row_Ls_Rg['_f_i'];
						$Vl[$row_Ls_Rg['_f_i']]['tot'] = $row_Ls_Rg['__tot'];
					} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());

					$Vl_Grph = _jEnc($Vl);
				}

			//---------------- PROCESS COUNT BY AREA ---------------- //

				if($Tot_Ls_Rg_Are > 0){

					do {

						$_are_data[] = "{ name:'".ctjTx($row_Ls_Rg_Are['__tt'],'in')."', y:".$row_Ls_Rg_Are['__tot'].", color:'".$row_Ls_Rg_Are['__clr']."' }";

					} while ($row_Ls_Rg_Are = $Ls_Rg_Are->fetch_assoc());

				}

			//---------------- PROCESS COUNT BY AREA ---------------- //

				if($Tot_Ls_Rg_Est > 0){

					do {
						$__estado = json_decode($row_Ls_Rg_Est['___Estado']);

				  		foreach($__estado as $__estado_k=>$__estado_v){
							$__estado_attr[$__estado_v->key] = $__estado_v->vl;
						}

						$_est_data[] = "{ name:'".ctjTx($row_Ls_Rg_Est['Estado_sisslc_tt'],'in')."', y:".$row_Ls_Rg_Est['__tot'].", color:'".$__estado_attr['clr']."' }";

					} while ($row_Ls_Rg_Est = $Ls_Rg_Est->fetch_assoc());

				}

			//---------------- BUILD JS GRAPH ---------------- //

				$CntWb .= "

					SUMR_Grph.f.g2({
						id: '#bx_grph_".$_gr."_1_2".$___Dt->id_rnd."',
						tp:'pie',
						g_h: 170,
						g_mrg_t:0,
						g_mrg_b:0,
						g_bck_clr:null,
						d: [".implode(',', $_are_data)."],
						tt: 'Áreas',
						tt_sb: ' ',
						dt_lbl:false,
						plot_sze:'100%',
						lgnd:false,
						tlt_frmt: '{series.name}<b style=\"font-size:9px;\">({point.y}) <span style=\"font-size:9px;\">{point.percentage:.1f}%</span></b>',
						i_s:'50%',
					});

					SUMR_Grph.f.g2({
						id: '#bx_grph_".$_gr."_1_3".$___Dt->id_rnd."',
						tp:'pie',
						g_h: 170,
						g_mrg_t:0,
						g_mrg_b:0,
						g_bck_clr:null,
						d: [".implode(',', $_est_data)."],
						tt: 'Estados',
						tt_sb: ' ',
						dt_lbl:false,
						plot_sze:'100%',
						lgnd:false,
						tlt_frmt: '{series.name}<b style=\"font-size:9px;\">({point.y}) <span style=\"font-size:9px;\">{point.percentage:.1f}%</span></b>',
						i_s:'50%',
					});

					SUMR_Grph.f.g4({
						id: '#bx_grph_".$_gr."_1_1".$___Dt->id_rnd."',
						c: [".$_grph_c."],
						d: [".$_grph_d."],
						tt: ' ',
						tt_sb: ' ',
						c_e: false
					});
				";

		}else{

			echo $__cnx->c_r->error;

		}


		$__cnx->_clsr($Ls_Rg);
		$__cnx->_clsr($Ls_Rg_Are);
		$__cnx->_clsr($Ls_Rg_Est);

	}

?>
<div class="ec_dsh_grph">
	<div class="c1"><div id="bx_grph_<?php echo $_gr; ?>_1_1<?php echo $___Dt->id_rnd; ?>" class="bx"></div></div>
	<div class="c2"><div id="bx_grph_<?php echo $_gr; ?>_1_2<?php echo $___Dt->id_rnd; ?>" class="bx"></div></div>
	<div class="c3"><div id="bx_grph_<?php echo $_gr; ?>_1_3<?php echo $___Dt->id_rnd; ?>" class="bx"></div></div>
</div>
<style>

	.ec_dsh_grph{ display:flex; position:relative; min-height: 150px; height: 150px; max-height: 150px; }

	.ec_dsh_grph .c1 .bx,
	.ec_dsh_grph .c2 .bx{ width:100%; min-height: 150px; height: 150px; max-height: 150px; }

	.ec_dsh_grph .c1{ width:70%; }
	.ec_dsh_grph .c2{ width:15%; margin-left:10px; }
	.ec_dsh_grph .c3{ width:14.8%; margin-left:5px; }

	.ec_dsh_grph .c2,
	.ec_dsh_grph .c3{ border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; border:2px solid #f6f7f7; height:160px; }


</style>