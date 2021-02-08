<?php

	class CRM_Org{

		function __construct($p=NULL) {

			global $__cnx;
	        $this->c_r = $__cnx->c_r;
			$this->c_p = $__cnx->c_p;

	        $this->_aud = new CRM_Aud();

			if(!isN($p['cl'])){
				$this->cl = GtClDt($p['cl']);
				if(!isN($this->cl->bd)){ $this->bd = _BdStr($this->cl->bd); }else{ $this->bd=''; }
			}
	    }

	    function __destruct() {

	    }


	    public function GtOrgGrpLs($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->org_enc)){

				$query_DtRg = "
						SELECT *,
						(	SELECT COUNT(*)
							FROM  "._BdStr(DBM).TB_ORG_GRP_RLC."
							WHERE orggrprlc_grp = id_orggrp AND orggrprlc_org = (SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = '".$this->org_enc."')
						) AS tot
				FROM "._BdStr(DBM).TB_ORG_GRP." ORDER BY orggrp_nm ASC";

				$DtRg = $__cnx->_qry($query_DtRg);


				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						do{
							$Vl['ls'][$row_DtRg['orggrp_enc']]['enc'] = $row_DtRg['orggrp_enc'];
							$Vl['ls'][$row_DtRg['orggrp_enc']]['nm'] = ctjTx($row_DtRg['orggrp_nm'],'in');
							$Vl['ls'][$row_DtRg['orggrp_enc']]['tot'] = $row_DtRg['tot'];

						}while($row_DtRg = $DtRg->fetch_assoc());
					}
				}

				$__cnx->_clsr($DtRg);

			}

			return _jEnc($Vl);

        }

	    public function _Grp_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->org_enc.'-'.$this->orggrp_enc);

			$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_GRP_RLC." (orggrprlc_enc, orggrprlc_org, orggrprlc_grp) VALUES ( %s, (SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = %s), (SELECT id_orggrp FROM ".DBM.". ".TB_ORG_GRP." WHERE orggrp_enc = %s) )",
						GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->org_enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->orggrp_enc, 'out'), "text"));


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}


		public function _Grp_Eli($p=NULL){

			global $__cnx;

			$query_DtRg =   sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_GRP_RLC."  WHERE orggrprlc_org  IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = %s ) AND orggrprlc_grp  IN (SELECT id_orggrp FROM "._BdStr(DBM).TB_ORG_GRP." WHERE orggrp_enc = %s )",
						GtSQLVlStr(ctjTx($this->org_enc,'out'), "text"),
						GtSQLVlStr(ctjTx($this->orggrp_enc,'out'), "text"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

	   /*Grupos*/




		/*Zonas*/

		public function _Zna_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->orgsds_enc.'-'.$this->orgsdszna_enc);

			$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_SDS_ZNA_RLC." (orgsdsznarlc_enc, orgsdsznarlc_orgsds, orgsdsznarlc_zna) VALUES ( %s, (SELECT id_orgsds FROM "._BdStr(DBM).TB_ORG_SDS." WHERE orgsds_enc = %s), (SELECT id_orgsdszna FROM	"._BdStr(DBM).TB_ORG_SDS_ZNA." WHERE orgsdszna_enc = %s) )",
						GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->orgsds_enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->orgsdszna_enc, 'out'), "text"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		//Ingresa Enfasis
	    public function _Enf_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->org_enc.'-'.$this->orgenf_enc);

			$_Ls_Enf = __LsDt([ 'k'=>'org_clg_enf' ]);
			foreach($_Ls_Enf->ls->org_clg_enf as $_k => $_v){
				if($this->orgenf_enc == $_v->enc){
					$_id_enf = $_k;
				}
			}

			$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_ENF."
									(
										orgenf_enc,
										orgenf_org,
										orgenf_enf
									)
									VALUES
									(
										%s,
										(SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = %s),
										%s
									)",
						GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->org_enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($_id_enf, 'out'), "int"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		//Ingresa Bachiller
	    public function _Bch_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->org_enc.'-'.$this->orgbch_enc);

			$_Ls_Bch = __LsDt([ 'k'=>'org_clg_bch' ]);
			foreach($_Ls_Bch->ls->org_clg_bch as $_k => $_v){
				if($this->orgbch_enc == $_v->enc){
					$_id_bch = $_k;
				}
			}

			$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_BCH."
									(
										orgbch_enc,
										orgbch_org,
										orgbch_bch
									)
									VALUES
									(
										%s,
										(SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = %s),
										%s
									)",
						GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->org_enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($_id_bch, 'out'), "int"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		//Ingresa Examenes
	    public function _Exa_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->org_enc.'-'.$this->orgexa_enc);

			$_Ls_Exa = __LsDt([ 'k'=>'org_clg_exa' ]);

			foreach($_Ls_Exa->ls->org_clg_exa as $_k => $_v){
				if($this->orgexa_enc == $_v->enc){
					$_id_exa = $_k;
				}
			}

			$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_EXA."
									(
										orgexa_enc,
										orgexa_org,
										orgexa_exa
									)
									VALUES
									(
										%s,
										(SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = %s),
										%s
									)",
						GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->org_enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($_id_exa, 'out'), "int"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		//Ingresar seedes
		public function _Sds_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->org_enc.'-'.$this->orgsds_enc);

			$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_SDS_RLC." (orgsdsrlc_enc, orgsdsrlc_org, orgsdsrlc_sds) VALUES ( %s, (SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = %s), (SELECT id_orgsds FROM "._BdStr(DBM).TB_ORG_SDS." WHERE orgsds_enc = %s) )",
						GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->org_enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->orgsds_enc, 'out'), "text"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}



		//Ingresa idioma
		public function _Lng_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->org_enc.'-'.$this->orglng_enc);

			$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_LNG." (orglng_enc, orglng_org, orglng_lng) VALUES ( %s, (SELECT id_org FROM "._BdStr(DBM).TB_ORG."  WHERE org_enc = %s), (SELECT id_sislng FROM "._BdStr(DBM).TB_SIS_LNG." WHERE sislng_enc = %s) )",
						GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->org_enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->orglng_enc, 'out'), "text"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

	   	//Lista las zonas
	   	public function GtOrgSdsZnaLs($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->orgsds_enc)){

				$query_DtRg = "
						SELECT *,
						(	SELECT COUNT(*)
							FROM "._BdStr(DBM).TB_ORG_SDS_ZNA_RLC."
							WHERE orgsdsznarlc_zna = id_orgsdszna AND orgsdsznarlc_orgsds = (SELECT id_orgsds FROM "._BdStr(DBM).TB_ORG_SDS." WHERE orgsds_enc = '".$this->orgsds_enc."')
						) AS tot
				FROM "._BdStr(DBM).TB_ORG_SDS_ZNA." ORDER BY orgsdszna_tt ASC";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						do{
							$Vl['ls'][$row_DtRg['orgsdszna_enc']]['enc'] = $row_DtRg['orgsdszna_enc'];
							$Vl['ls'][$row_DtRg['orgsdszna_enc']]['nm'] = ctjTx($row_DtRg['orgsdszna_tt'],'in');
							$Vl['ls'][$row_DtRg['orgsdszna_enc']]['tot'] = $row_DtRg['tot'];
							$Vl['ls'][$row_DtRg['orgsdszna_enc']]['orgsdsznarlc_enc'] = $row_DtRg['_orgsdsznarlc_enc'];
						}while($row_DtRg = $DtRg->fetch_assoc());
					}
				}

				$__cnx->_clsr($DtRg);
			}

			return _jEnc($Vl);

        }

        public function InsGrp ($P=NULL) {

	        global $__cnx;

	        $__enc = Enc_Rnd($this->org_enc.'-'.$this->orggrp_enc);

			$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_GRP." (orggrp_enc,orggrp_nm) VALUES (%s,%s)",
						GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->id_orggrp, 'out'), "text"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);



        }


         public function InsZna ($P=NULL) {

	        global $__cnx;

	        $__enc = Enc_Rnd($this->org_enc.'-'.$this->orggrp_enc);

			$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_ZNA." (orgzna_enc,orgzna_tt,orgzna_clr) VALUES (%s,%s,%s)",
						GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->id_orgzna, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->id_orgzna, 'out'), "text")
						);

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);



        }


        // --------- Tipo de Organizacion ----------- //

        public function GtOrgTpLs($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->id_org)){

		    	$query_DtRg = "
		    					SELECT *
								FROM "._BdStr(DBM).TB_ORG_TP."
									 INNER JOIN "._BdStr(DBM).TB_ORG." ON id_org = orgtp_org
								WHERE org_enc = '".$this->id_org."'";

				$Vl['q'] = $query_DtRg;


				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';

						do{

							$id_on[] = $row_DtRg['orgtp_tp'];

						}while($row_DtRg = $DtRg->fetch_assoc());
					}

				}else{

					$Vl['w'] = $this->c_r->error;

				}

				$__cnx->_clsr($DtRg);

				$_org_tp = __LsDt([ 'k'=>'org_tp' ]);


				foreach($_org_tp->ls->org_tp as $k=>$v){

					if(in_array($v->id, $id_on)){ $_est = true; }else{ $_est = false; }

					$id_ob = $v->enc;

					$Vl['ls'][$id_ob]['enc'] = $v->enc;
					$Vl['ls'][$id_ob]['nm'] = $v->tt;
					$Vl['ls'][$id_ob]['est'] = $_est;

					$Vl['tot'] = $Vl['tot']+1;


				}


				return _jEnc($Vl);
			}
       	}



        public function GtOrgTpLs_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->id_org.'-'.$this->org_tp);

			$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_TP."  ( orgtp_enc, orgtp_org, orgtp_tp )
									VALUES
									(
										%s,
										(SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = %s),
										(SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s)
									)",
						GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->id_org, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->org_tp, 'out'), "text"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				$rsp['msss'] = $this->id_org.'  '.$this->org_tp;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}


        public function GtOrgTpLs_Del($p=NULL){

			global $__cnx;

			$query_DtRg =   sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_TP."
										WHERE orgtp_org IN (SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = %s)
										AND orgtp_tp IN (SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s) ",
						GtSQLVlStr(ctjTx($this->id_org,'out'), "text"),
						GtSQLVlStr(ctjTx($this->org_tp,'out'), "text"));
			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

        //Lista los enfasis
	   	public function GtOrgEnfLs($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->org_enc)){

			    $_Ls_Enf = __LsDt([ 'k'=>'org_clg_enf' ]);

			    if($_Ls_Enf->tot > 0){
				    $Vl['e'] = 'ok';

				    foreach($_Ls_Enf->ls->org_clg_enf as $_k => $_v){

				    	$Vl['ls'][$_v->enc]['enc'] = $_v->enc;
				    	$Vl['ls'][$_v->enc]['nm'] = $_v->tt;

				    	$query_DtRg = " SELECT COUNT(*) as _tot
										FROM "._BdStr(DBM).TB_ORG_ENF."
										WHERE orgenf_enf = ".$_k."
										AND orgenf_org = (SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = '".$this->org_enc."')
						";

						$DtRg = $__cnx->_qry($query_DtRg);

						if($DtRg){
							$row_DtRg = $DtRg->fetch_assoc();
							$Vl['ls'][$_v->enc]['tot'] = $row_DtRg['_tot'];
						}else{
							$Vl['ls'][$_v->enc]['w'] = $this->c_r->error;
						}

						$__cnx->_clsr($DtRg);

			    	}

			    }else{
				    $Vl['e'] = 'no';
			    }

			}

			return _jEnc($Vl);

        }

        //Lista los bachilleratos
	   	public function GtOrgBchLs($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->org_enc)){

			    $_Ls_Enf = __LsDt([ 'k'=>'org_clg_bch' ]);

			    if($_Ls_Enf->tot > 0){
				    $Vl['e'] = 'ok';

				    foreach($_Ls_Enf->ls->org_clg_bch as $_k => $_v){

				    	$Vl['ls'][$_v->enc]['enc'] = $_v->enc;
				    	$Vl['ls'][$_v->enc]['nm'] = $_v->tt;

				    	$query_DtRg = " SELECT COUNT(*) as _tot
										FROM  "._BdStr(DBM).TB_ORG_BCH."
										WHERE orgbch_bch = ".$_k."
										AND orgbch_org = (SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = '".$this->org_enc."')
						";

						$DtRg = $__cnx->_qry($query_DtRg);
						$row_DtRg = $DtRg->fetch_assoc();
						$Vl['ls'][$_v->enc]['tot'] = $row_DtRg['_tot'];

						$__cnx->_clsr($DtRg);

			    	}

			    }else{
				    $Vl['e'] = 'no';
			    }

			}

			return _jEnc($Vl);

        }

        //Lista los examenes
	   	public function GtOrgExaLs($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->org_enc)){

			    $_Ls_Exa = __LsDt([ 'k'=>'org_clg_exa' ]);

			    if($_Ls_Exa->tot > 0){
				    $Vl['e'] = 'ok';

				    foreach($_Ls_Exa->ls->org_clg_exa as $_k => $_v){

				    	$Vl['ls'][$_v->enc]['enc'] = $_v->enc;
				    	$Vl['ls'][$_v->enc]['nm'] = $_v->tt;

				    	$query_DtRg = " SELECT COUNT(*) as _tot
										FROM  "._BdStr(DBM).TB_ORG_EXA."
										WHERE orgexa_exa = ".$_k."
										AND orgexa_org = (SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = '".$this->org_enc."')
						";

						$DtRg = $__cnx->_qry($query_DtRg);
						$row_DtRg = $DtRg->fetch_assoc();
						$Vl['ls'][$_v->enc]['tot'] = $row_DtRg['_tot'];

						$__cnx->_clsr($DtRg);

			    	}

			    }else{
				    $Vl['e'] = 'no';
			    }

			}

			return _jEnc($Vl);

        }

        public function GtOrgSdsLs($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->org_enc)){

				$query_DtRg = "
						SELECT *,
								(SELECT COUNT(*)
									FROM  "._BdStr(DBM).TB_ORG_SDS_RLC."
									WHERE orgsdsrlc_sds = id_orgsds AND orgsdsrlc_org = (SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = '".$this->org_enc."')
								) AS tot
						FROM "._BdStr(DBM).TB_ORG_SDS."
						ORDER BY orgsds_nm ASC";



				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						do{
							$Vl['ls'][$row_DtRg['orgsds_enc']]['enc'] = $row_DtRg['orgsds_enc'];
							$Vl['ls'][$row_DtRg['orgsds_enc']]['nm'] = ctjTx($row_DtRg['orgsds_nm'],'in');
							$Vl['ls'][$row_DtRg['orgsds_enc']]['tot'] = $row_DtRg['tot'];

						}while($row_DtRg = $DtRg->fetch_assoc());
					}else{
						$Vl['e'] = 'no';
						$Vl['w'] = $this->c_r->error;
					}
				}
				$__cnx->_clsr($DtRg);
			}

			return _jEnc($Vl);

        }

        public function GtOrgLngLs($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->org_enc)){

				$query_DtRg = "
						SELECT *,
						(	SELECT COUNT(*)
							FROM  "._BdStr(DBM).TB_ORG_LNG."
							WHERE orglng_lng = id_sislng AND orglng_org = (SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = '".$this->org_enc."')
						) AS tot
				FROM "._BdStr(DBM).TB_SIS_LNG." ORDER BY sislng_nm ASC";

				$DtRg = $__cnx->_qry($query_DtRg);


				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						do{
							$Vl['ls'][$row_DtRg['sislng_enc']]['enc'] = $row_DtRg['sislng_enc'];
							$Vl['ls'][$row_DtRg['sislng_enc']]['nm'] = ctjTx($row_DtRg['sislng_nm'],'in');
							$Vl['ls'][$row_DtRg['sislng_enc']]['tot'] = $row_DtRg['tot'];

						}while($row_DtRg = $DtRg->fetch_assoc());
					}else{
						$Vl['e'] = 'no';
						$Vl['w'] = $this->c_r->error;
					}
				}
				$__cnx->_clsr($DtRg);
			}

			return _jEnc($Vl);

        }


		public function _Zna_Eli($p=NULL){

			global $__cnx;

			$query_DtRg =   sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_SDS_ZNA_RLC."  WHERE orgsdsznarlc_orgsds  IN ( SELECT id_orgsds FROM "._BdStr(DBM).TB_ORG_SDS." WHERE orgsds_enc = %s ) AND orgsdsznarlc_zna  IN (SELECT id_orgsdszna FROM  "._BdStr(DBM).TB_ORG_SDS_ZNA." WHERE orgsdszna_enc = %s )",
						GtSQLVlStr(ctjTx($this->orgsds_enc,'out'), "text"),
						GtSQLVlStr(ctjTx($this->orgsdszna_enc,'out'), "text"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		//Elimina Enfasis
		public function _Enf_Eli($p=NULL){

			global $__cnx;

			$_Ls_Enf = __LsDt([ 'k'=>'org_clg_enf' ]);

			foreach($_Ls_Enf->ls->org_clg_enf as $_k => $_v){
				if($this->orgenf_enc == $_v->enc){
					$_id_enf = $_k;
				}
			}

			$query_DtRg =   sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_ENF."
										WHERE orgenf_org  IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = %s )
										AND orgenf_enf = %s ",
						GtSQLVlStr(ctjTx($this->org_enc,'out'), "text"),
						GtSQLVlStr(ctjTx($_id_enf,'out'), "int"));
			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		//Elimina Bachiller
		public function _Bch_Eli($p=NULL){

			global $__cnx;

			$_Ls_Bch = __LsDt([ 'k'=>'org_clg_bch' ]);

			foreach($_Ls_Bch->ls->org_clg_bch as $_k => $_v){
				if($this->orgbch_enc == $_v->enc){
					$_id_bch = $_k;
				}
			}

			$query_DtRg =   sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_BCH."
										WHERE orgbch_org  IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = %s )
										AND orgbch_bch = %s ",
						GtSQLVlStr(ctjTx($this->org_enc,'out'), "text"),
						GtSQLVlStr(ctjTx($_id_bch,'out'), "int"));
			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		//Elimina Examenes
		public function _Exa_Eli($p=NULL){

			global $__cnx;

			$_Ls_Exa = __LsDt([ 'k'=>'org_clg_exa' ]);

			foreach($_Ls_Exa->ls->org_clg_exa as $_k => $_v){
				if($this->orgexa_enc == $_v->enc){
					$_id_exa = $_k;
				}
			}

			$query_DtRg =   sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_EXA."
										WHERE orgexa_org  IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = %s )
										AND orgexa_exa = %s ",
						GtSQLVlStr(ctjTx($this->org_enc,'out'), "text"),
						GtSQLVlStr(ctjTx($_id_exa,'out'), "int"));
			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		//Elimina idiomas
		public function _Lng_Eli($p=NULL){

			global $__cnx;

			$query_DtRg =   sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_LNG."  WHERE orglng_org  IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG."
			 WHERE org_enc = %s ) AND orglng_lng  IN (SELECT id_sislng FROM "._BdStr(DBM).TB_SIS_LNG." WHERE sislng_enc= %s )",
						GtSQLVlStr(ctjTx($this->org_enc,'out'), "text"),
						GtSQLVlStr(ctjTx($this->orglng_enc,'out'), "text"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}




		//Elimina idiomas
		public function _Sds_Eli($p=NULL){

			global $__cnx;

			$query_DtRg =   sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_SDS_RLC." WHERE orgsdsrlc_org  IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = %s ) AND orgsdsrlc_sds  IN (SELECT id_orgsds FROM "._BdStr(DBM).TB_ORG_SDS." WHERE orgsds_enc= %s )",

						GtSQLVlStr(ctjTx($this->org_enc,'out'), "text"),
						GtSQLVlStr(ctjTx($this->orgsds_enc,'out'), "text"));

			$Result = $$__cnx->_prc($query_DtRg);


			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}


		// Ingresar organizacion_sds_organizaciones.
		public function OrgSdsCnt(){

			global $__cnx;

			if( !isN($this->orgsdscnt_orgsds) && !isN($this->orgsdscnt_cnt) ){

				//$_dt = GtOrgDt([ 'i'=>$this->orgsdscnt_orgsds, 't'=>'enc' ]);
				$__chk = GtOrgSdsCntDt([
					'bd'=>$this->bd,
					'cnt'=>$this->orgsdscnt_cnt,
					'orgsds'=>$this->orgsdscnt_orgsds
				]);

				$rsp['w']['chk'] = $__chk;

				if(isN($__chk->id)){

					$__enc = Enc_Rnd($this->orgsdscnt_orgsds.'-'.$this->orgsdscnt_cnt);

					$query_DtRg = sprintf("INSERT INTO ".$this->bd.TB_ORG_SDS_CNT."

											(
												orgsdscnt_enc,
												orgsdscnt_orgsds,
												orgsdscnt_cnt,
												orgsdscnt_tpr,
												orgsdscnt_tpr_o,
												orgsdscnt_are,
												orgsdscnt_crs,
												orgsdscnt_smst,
												orgsdscnt_fs
											)
												VALUES
											(
												%s,
												%s,
												%s,
												%s,
												%s,
												%s,
												%s,
												%s,
												%s
											)",
								GtSQLVlStr(ctjTx($__enc,'out'), "text"),
								GtSQLVlStr($this->orgsdscnt_orgsds, "text"),
								GtSQLVlStr($this->orgsdscnt_cnt, "text"),
								GtSQLVlStr(ctjTx($this->orgsdscnt_tpr, 'out'), "int"),
								GtSQLVlStr(ctjTx($this->orgsdscnt_tpr_o, 'out'), "int"),
								GtSQLVlStr(ctjTx($this->orgsdscnt_are, 'out'), "int"),
								GtSQLVlStr($this->orgsdscnt_crs, "int"),
								GtSQLVlStr(ctjTx($this->orgsdscnt_smst, 'out'), "int"),
								GtSQLVlStr($this->orgsdscnt_fs, "text"));

					$Result = $__cnx->_prc($query_DtRg);

					$rsp['tmp_tpr'] = $this->orgsdscnt_tpr;
					$rsp['q'] = $query_DtRg;

				}else{

					$Result=true;

				}

				if($Result){
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
					$__CntIn = new CRM_Cnt();
					$__CntIn->UpdCntFA([ 'id'=>$this->orgsdscnt_cnt ]);
				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w'][] = $__cnx->c_p->error.' on '.compress_code($query_DtRg);
				}

			}else{
				$rsp['e'] = 'no';
			}

			return _jEnc($rsp);

		}


		public function _GTp($id=NULL){

			$__org_tp = __LsDt([ 'k'=>'org_tp' ]);

			foreach($__org_tp->ls->org_tp as $_k=>$_v){
				if($id == $_v->key->vl){
					$_tp = $_k;
				}
			}

			if(!isN($_tp)){ return $_tp; }
		}

















		public function _Org_Chk($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($p['id']) && !isN($p['chk'])){

				if($p['chk'] == 'web'){
	                $__qry = sprintf('SELECT * FROM '._BdStr(DBM).TB_ORG.' WHERE id_org IN (SELECT orgweb_org FROM '._BdStr(DBM).TB_ORG_WEB.' WHERE orgweb_web = %s) LIMIT 1', GtSQLVlStr( _url($p['id']), 'text') );
	            }elseif($p['chk'] == 'dc'){
	                $__qry = sprintf('	SELECT *
	                					FROM '._BdStr(DBM).TB_ORG.'
	                					WHERE id_org IN (	SELECT orgsds_org
															FROM '._BdStr(DBM).TB_ORG_SDS_DC.'
																 INNER JOIN '._BdStr(DBM).TB_ORG_SDS.' ON orgsdsdc_orgsds = id_orgsds
															WHERE orgsdsdc_dc = %s
														)
	                					LIMIT 1', GtSQLVlStr( _url($p['id']), 'text') );
	            }elseif($p['chk'] == 'enc'){
	                $__qry = sprintf('SELECT * FROM '._BdStr(DBM).TB_ORG.' WHERE org_enc = %s LIMIT 1', GtSQLVlStr($p['id'], 'text'));
	            }elseif($p['chk'] == 'id'){
	                $__qry = sprintf('SELECT * FROM '._BdStr(DBM).TB_ORG.' WHERE id_org = %s LIMIT 1', GtSQLVlStr($p['id'], 'int'));
	            }

				if(!isN($__qry)){ $Dt = $__cnx->_qry($__qry); }

				if($Dt){

					$row_Dt = $Dt->fetch_assoc();
					$Tot_Dt = $Dt->num_rows;

					if($Tot_Dt == 1){
						$rsp['e'] = 'ok';
						$rsp['id'] = $row_Dt['id_org'];
						$rsp['enc'] = $row_Dt['org_enc'];
						$rsp['m'] = 1;
					}else{
						$rsp['m'] = 2;
						$rsp['w'] = $this->c_r>error;
						$rsp['w_n'] = $this->c_r->errno;
					}

				}
				$__cnx->_clsr($Dt);

			}

			return _jEnc($rsp);

		}




		public function _Org_In($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->org_nm)){

				if(!isN($this->org_cd)){ $_cd = $this->org_cd; }else{ $_cd = 1; }
				if(!isN($this->org_clr)){ $_clr = $this->org_clr; }else{ $_clr = '#ccc'; }
				if(!isN($this->org_vrf)){ $_vrf = $this->org_vrf; }else{ $_vrf = 1; }

				$__enc = Enc_Rnd($this->org_nm.'-'.$this->org_dir.'-'.$this->org_cd);

				$qry_In = sprintf("INSERT INTO "._BdStr(DBM).TB_ORG." (org_enc, org_nm, org_dir, org_cd, org_clr, org_vrf, org_est) VALUES (%s, %s, %s, %s, %s, %s, %s)",
				                       GtSQLVlStr($__enc, "text"),
				                       GtSQLVlStr(ctjTx($this->org_nm, 'out'), "text"),
				                       GtSQLVlStr(ctjTx($this->org_dir, 'out'), "text"),
				                       GtSQLVlStr($_cd, "int"),
				                       GtSQLVlStr($_clr, "text"),
									   GtSQLVlStr($_vrf, "int"),
									   GtSQLVlStr(Html_chck_vl($this->org_est), "int"));

				$Rs = $__cnx->_prc($qry_In);

				if($Rs){
					$rsp['e'] = 'ok';
					$rsp['id'] = $__cnx->c_p->insert_id;
					$rsp['enc'] = $this->org_enc = $__enc;
					$rsp['m'] = 1;
				}else{
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}

			}

			return _jEnc($rsp);

		}




		public function _Org_Cl_Chk($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->_org->id) && !isN($this->cl->id)){

				$qry_Dt = "	SELECT *
							FROM "._BdStr(DBM).TB_ORG_CL."
							WHERE orgcl_org = '".$this->_org->id."' AND orgcl_cl = '".$this->cl->id."' ";

				$Dt = $__cnx->_qry($qry_Dt);

				if($Dt){

					$Tot_Dt = $Dt->num_rows;

					if($Tot_Dt == 1){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}else{
						$rsp['m'] = 2;
						$rsp['w'] = $this->c_r>error;
						$rsp['w_n'] = $this->c_r->errno;
					}

				}

				$__cnx->_clsr($Dt);

			}

			return _jEnc($rsp);

		}



		public function _Org_Cl_In($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->_org->id)){

				$__enc = Enc_Rnd($this->org_enc.'-'.$this->orggrp_enc);

				$qry_In = sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_CL." (orgcl_enc, orgcl_org, orgcl_cl) VALUES (%s, %s, %s)",
				                       GtSQLVlStr($__enc, "text"),
				                       GtSQLVlStr($this->_org->id, "int"),
				                       GtSQLVlStr($this->cl->id, "int"));

				$Rs = $__cnx->_prc($qry_In);

				if($Rs){
					$rsp['e'] = 'ok';
					$rsp['id'] = $__cnx->c_p->insert_id;
					$rsp['enc'] = $__enc;
					$rsp['m'] = 1;
				}else{
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}

			}

			return _jEnc($rsp);

		}




		public function _Org_Cnt_Chk($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->_org_sds->id) && !isN($this->_cnt->id)){

				$qry_Dt = "	SELECT *
							FROM ".$this->bd.TB_ORG_SDS_CNT."
							WHERE orgsdscnt_orgsds = '".$this->_org_sds->id."' AND orgsdscnt_cnt = '".$this->_cnt->id."' ";

				$Dt = $__cnx->_qry($qry_Dt);

				if($Dt){

					$Tot_Dt = $Dt->num_rows;

					if($Tot_Dt == 1){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}else{
						$rsp['m'] = 2;
						$rsp['w'] = $this->c_r>error;
						$rsp['w_n'] = $this->c_r->errno;
					}

				}

				$__cnx->_clsr($Dt);

			}

			return _jEnc($rsp);

		}



		public function _Org_Cnt_In($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->_org_sds->id) && !isN($this->org_cnt_tpr) && !isN($this->org_cnt_tpr_o)){

				$__enc = Enc_Rnd($this->_org_sds->id.'-'.$this->_cnt->id);

				$qry_In = sprintf("INSERT INTO ".$this->bd.TB_ORG_SDS_CNT." (orgsdscnt_enc, orgsdscnt_orgsds, orgsdscnt_cnt, orgsdscnt_tpr, orgsdscnt_tpr_o) VALUES (%s, %s, %s, %s, %s)",
				                       GtSQLVlStr($__enc, "text"),
				                       GtSQLVlStr($this->_org_sds->id, "int"),
				                       GtSQLVlStr($this->_cnt->id, "int"),
				                       GtSQLVlStr($this->org_cnt_tpr, "int"),
				                       GtSQLVlStr($this->org_cnt_tpr_o, "int"));

				$Rs = $__cnx->_prc($qry_In);


				$rsp['q'] = $qry_In;


				if($Rs){

					$rsp['e'] = 'ok';
					$rsp['id'] = $__cnx->c_p->insert_id;
					$rsp['enc'] = $__enc;
					$rsp['m'] = 1;

					$__CntIn = new CRM_Cnt();
					$__CntIn->UpdCntFA([ 'id'=>$this->_cnt->id ]);

				}else{
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}

			}

			return _jEnc($rsp);

		}



		public function _Org_Cnt_Del($p=NULL){

			global $__cnx;

			$this->_GtInfo();

			$rsp['e'] = 'no';

			if(!isN($p['id'])){

				$qry_Del = sprintf("DELETE FROM ".$this->bd.TB_ORG_SDS_CNT." WHERE orgsdscnt_enc=%s",
									GtSQLVlStr($p['id'], "text"));

				$Rs = $__cnx->_prc($qry_Del);

				if($Rs){
					$rsp['e'] = 'ok';
					$__CntIn = new CRM_Cnt();
					$__CntIn->UpdCntFA([ 'id'=>$this->_cnt->id ]);
				}else{
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}

			}

			return _jEnc($rsp);

		}






		public function _Org_Cnt_Upd($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($p['enc'])){

				if(!isN($p['tpr'])){ $_upd[] = sprintf('orgsdscnt_tpr=%s', GtSQLVlStr($p['tpr'], "int")); }
				if(!isN($p['tpr_o'])){ $_upd[] = sprintf('orgsdscnt_tpr_o=%s', GtSQLVlStr($p['tpr_o'], "int")); }
				if(!isN($p['are'])){ $_upd[] = sprintf('orgsdscnt_are=%s', GtSQLVlStr($p['are'], "int")); }
				if(!isN($p['crs'])){ $_upd[] = sprintf('orgsdscnt_crs=%s', GtSQLVlStr($p['crs'], "int")); }
				if(!isN($p['smst'])){ $_upd[] = sprintf('orgsdscnt_smst=%s', GtSQLVlStr($p['smst'], "int")); }

				if(!isN($_upd)){
					$qry_Upd = "UPDATE ".$this->bd.TB_ORG_SDS_CNT." SET ".implode(',', $_upd)." WHERE orgsdscnt_enc=".GtSQLVlStr( $p['enc'] , "text");
					$Rs = $__cnx->_prc($qry_Upd);
				}

				$rsp['q'] = $qry_Upd;

				if($Rs){
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}else{
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}

			}else{
				$rsp['w'] = 'no data';
			}

			return _jEnc($rsp);

		}























		public function _Org_Tp_Chk($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($p['org']) && !isN($p['tp'])){

				$qry_Dt = "	SELECT *
							FROM "._BdStr(DBM).TB_ORG_TP."
							WHERE orgtp_tp = '".strtolower($p['tp'])."' AND orgtp_org = '".strtolower($p['org'])."' ";

				$Dt = $__cnx->_qry($qry_Dt);

				if($Dt){

					$Tot_Dt = $Dt->num_rows;

					if($Tot_Dt == 1){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}else{
						$rsp['m'] = 2;
						$rsp['w'] = $this->c_r>error;
						$rsp['w_n'] = $this->c_r->errno;
					}

				}

				$__cnx->_clsr($Dt);

			}

			return _jEnc($rsp);

		}



		public function _Org_Tp_In($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->_org->id) && !isN($p['tp'])){

				$__enc = Enc_Rnd($this->_org->id.'-'.$p['tp']);

				$qry_In = sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_TP." (orgtp_enc, orgtp_tp, orgtp_org) VALUES (%s, %s, %s)",
				                       GtSQLVlStr($__enc, "text"),
				                       GtSQLVlStr(ctjTx($p['tp'], 'out'), "text"),
				                       GtSQLVlStr($this->_org->id, "int"));

				$Rs = $__cnx->_prc($qry_In);

				if($Rs){
					$rsp['e'] = 'ok';
					$rsp['id'] = $__cnx->c_p->insert_id;
					$rsp['enc'] = $__enc;
					$rsp['m'] = 1;
				}else{
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}

			}else{

				$rsp['w'] = 'no data';

			}

			return _jEnc($rsp);

		}


		public function _Org_Tp($p=NULL){

			$rsp['e'] = 'no';

			if(!isN($this->org_tp)){
				$_tp = $this->org_tp;
			}elseif(!isN($this->org_tp_t)){
				$_tp = $this->_GTp($this->org_tp_t);
			}else{
				//$_tp = _CId('ID_ORGTP_EMP'); Siempre invoca ingreso de Tipo, hay que quitar esto // Camilo
			}

			if(!isN($_tp)){
				$chk = $this->_Org_Tp_Chk([ 'tp'=>$_tp ]);
				if($chk->e != 'ok'){ $chk = $this->_Org_Tp_In([ 'tp'=>$_tp ]); }
				if($chk->e == 'ok'){ $rsp['e'] = 'ok'; }
			}

			return _jEnc($rsp);

		}




		public function _Org_Web_Chk($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($p['url'])){

				$qry_Dt = "	SELECT *
							FROM "._BdStr(DBM).TB_ORG_WEB."
							WHERE orgweb_web = '".strtolower($p['url'])."' ";

				$Dt = $__cnx->_qry($qry_Dt);

				if($Dt){

					$Tot_Dt = $Dt->num_rows;

					if($Tot_Dt == 1){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}else{
						$rsp['m'] = 2;
						$rsp['w'] = $this->c_r>error;
						$rsp['w_n'] = $this->c_r->errno;
					}

				}

				$__cnx->_clsr($Dt);

			}

			return _jEnc($rsp);

		}



		public function _Org_Web_In($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->_org->id) && !isN($p['url'])){

				$__enc = Enc_Rnd($this->_org->id.'-'.$p['url']);

				$qry_In = sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_WEB." (orgweb_enc, orgweb_web, orgweb_org) VALUES (%s, %s, %s)",
				                       GtSQLVlStr($__enc, "text"),
				                       GtSQLVlStr(ctjTx($p['url'], 'out'), "text"),
				                       GtSQLVlStr($this->_org->id, "int"));

				$Rs = $__cnx->_prc($qry_In);

				if($Rs){
					$rsp['e'] = 'ok';
					$rsp['id'] = $__cnx->c_p->insert_id;
					$rsp['enc'] = $__enc;
					$rsp['m'] = 1;
				}else{
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}

			}else{

				$rsp['w'] = 'no data';

			}

			return _jEnc($rsp);

		}


		public function _Org_Web($p=NULL){

			$rsp['e'] = 'no';
			//$rsp['_____orgweb'] = $this->org_web;
			$__url = _url($this->org_web);
			//$rsp['_____orgweb_new'] = $__url;


			$chk = $this->_Org_Web_Chk([ 'url'=>$__url ]);
			if($chk->e != 'ok'){ $chk = $this->_Org_Web_In([ 'url'=>$__url ]); }
			if($chk->e == 'ok'){ $rsp['e'] = 'ok'; }
			return _jEnc($rsp);
		}









		public function _Org_Scec_Chk($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->org_scec) && !isN($this->_org->id)){

				$qry_Dt = sprintf("	SELECT *
									FROM "._BdStr(DBM).TB_ORG_SCEC."
									WHERE orgscec_scec=%s AND orgscec_org=%s",
											GtSQLVlStr($this->org_scec, "int"),
											GtSQLVlStr($this->_org->id, "int")
								);

				$Dt = $__cnx->_qry($qry_Dt);

				if($Dt){

					$Tot_Dt = $Dt->num_rows;

					if($Tot_Dt == 1){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}else{
						$rsp['m'] = 2;
						$rsp['w'] = $this->c_r>error;
						$rsp['w_n'] = $this->c_r->errno;
					}

				}

				$__cnx->_clsr($Dt);

			}

			return _jEnc($rsp);

		}



		public function _Org_Scec_In($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->_org->id) && !isN($this->org_scec)){

				$__enc = Enc_Rnd($this->_org->id.'-'.$this->org_scec);

				$qry_In = sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_SCEC." (orgscec_enc, orgscec_scec, orgscec_org) VALUES (%s, %s, %s)",
				                       GtSQLVlStr($__enc, "text"),
				                       GtSQLVlStr($this->org_scec, "int"),
				                       GtSQLVlStr($this->_org->id, "int"));

				$Rs = $__cnx->_prc($qry_In);

				if($Rs){
					$rsp['e'] = 'ok';
					$rsp['id'] = $__cnx->c_p->insert_id;
					$rsp['enc'] = $__enc;
					$rsp['m'] = 1;
				}else{
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}

			}

			return _jEnc($rsp);

		}


		public function _Org_Scec($p=NULL){
			$rsp['e'] = 'no';
			$chk = $this->_Org_Scec_Chk();
			if($chk->e != 'ok'){ $chk = $this->_Org_Scec_In(); }
			if($chk->e == 'ok'){ $rsp['e'] = 'ok'; }
			return _jEnc($rsp);
		}









		public function _Org_Sds_Dc_Chk($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->org_sds_dc) && !isN($this->org_sds_dc_tp) && !isN($this->_org_sds->id)){

				$qry_Dt = sprintf("	SELECT *
									FROM "._BdStr(DBM).TB_ORG_SDS_DC."
									WHERE orgsdsdc_tp=%s AND orgsdsdc_dc=%s AND orgsdsdc_orgsds=%s",
											GtSQLVlStr($this->org_sds_dc_tp, "int"),
											GtSQLVlStr($this->org_sds_dc, "int"),
											GtSQLVlStr($this->_org_sds->id, "int")
								);

				$Dt = $__cnx->_qry($qry_Dt);

				if($Dt){

					$Tot_Dt = $Dt->num_rows;

					if($Tot_Dt == 1){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}else{
						$rsp['m'] = 2;
						$rsp['w'] = $this->c_r>error;
						$rsp['w_n'] = $this->c_r->errno;
					}

				}

				$__cnx->_clsr($Dt);

			}

			return _jEnc($rsp);

		}



		public function _Org_Sds_Dc_In($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->_org_sds->id) && !isN($this->org_sds_dc)){

				$__enc = Enc_Rnd($this->_org_sds->id.'-'.$this->org_sds_dc.'-'.$this->org_sds_dc_tp);

				$qry_In = sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_SDS_DC." (orgsdsdc_enc, orgsdsdc_tp, orgsdsdc_dc, orgsdsdc_orgsds) VALUES (%s, %s, %s, %s)",
				                       GtSQLVlStr($__enc, "text"),
				                       GtSQLVlStr($this->org_sds_dc_tp, "int"),
				                       GtSQLVlStr($this->org_sds_dc, "text"),
				                       GtSQLVlStr($this->_org_sds->id, "int"));

				$Rs = $__cnx->_prc($qry_In);

				if($Rs){
					$rsp['e'] = 'ok';
					$rsp['id'] = $__cnx->c_p->insert_id;
					$rsp['enc'] = $__enc;
					$rsp['m'] = 1;
				}else{
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}

			}

			return _jEnc($rsp);

		}


		public function _Org_Sds_Dc($p=NULL){
			$rsp['e'] = 'no';
			$chk = $this->_Org_Sds_Dc_Chk();
			if($chk->e != 'ok'){ $chk = $this->_Org_Sds_Dc_In(); }
			if($chk->e == 'ok'){ $rsp['e'] = 'ok'; }
			return _jEnc($rsp);
		}














		public function _Org_Sds_Tel_Chk($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->org_sds_tel) && !isN($this->org_sds_tel_tp) && !isN($this->_org_sds->id)){

				$qry_Dt = sprintf("	SELECT *
									FROM "._BdStr(DBM).TB_ORG_SDS_TEL."
									WHERE orgsdstel_tp=%s AND orgsdstel_tel=%s AND orgsdstel_orgsds=%s",
											GtSQLVlStr($this->org_sds_tel_tp, "int"),
											GtSQLVlStr($this->org_sds_tel, "int"),
											GtSQLVlStr($this->_org_sds->id, "int")
								);

				$Dt = $__cnx->_qry($qry_Dt);

				if($Dt){

					$Tot_Dt = $Dt->num_rows;

					if($Tot_Dt == 1){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}else{
						$rsp['m'] = 2;
						$rsp['w'] = $this->c_r>error;
						$rsp['w_n'] = $this->c_r->errno;
					}

				}

				$__cnx->_clsr($Dt);

			}

			return _jEnc($rsp);

		}



		public function _Org_Sds_Tel_In($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->_org_sds->id) && !isN($this->org_sds_tel)){

				$__enc = Enc_Rnd($this->_org_sds->id.'-'.$this->org_sds_tel.'-'.$this->org_sds_tel_tp);

				$qry_In = sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_SDS_TEL." (orgsdstel_enc, orgsdstel_tp, orgsdstel_tel, orgsdstel_orgsds) VALUES (%s, %s, %s, %s)",
				                       GtSQLVlStr($__enc, "text"),
				                       GtSQLVlStr($this->org_sds_tel_tp, "int"),
				                       GtSQLVlStr($this->org_sds_tel, "text"),
				                       GtSQLVlStr($this->_org_sds->id, "int"));

				$Rs = $__cnx->_prc($qry_In);

				if($Rs){
					$rsp['e'] = 'ok';
					$rsp['id'] = $__cnx->c_p->insert_id;
					$rsp['enc'] = $__enc;
					$rsp['m'] = 1;
				}else{
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}

			}

			return _jEnc($rsp);

		}


		public function _Org_Sds_Tel($p=NULL){
			$rsp['e'] = 'no';
			$chk = $this->_Org_Sds_Tel_Chk();
			if($chk->e != 'ok'){ $chk = $this->_Org_Sds_Tel_In(); }
			if($chk->e == 'ok'){ $rsp['e'] = 'ok'; }
			return _jEnc($rsp);
		}












		public function _Org_Sds_Eml_Chk($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->org_sds_eml) && !isN($this->_org_sds->id)){

				$qry_Dt = sprintf("	SELECT *
									FROM "._BdStr(DBM).TB_ORG_SDS_EML."
									WHERE orgsdsdc_tp=%s AND orgsdseml_eml=%s AND orgsdseml_orgsds=%s",
											GtSQLVlStr($this->org_sds_eml, "int"),
											GtSQLVlStr($this->_org_sds->id, "int")
								);

				$Dt = $__cnx->_qry($qry_Dt);

				if($Dt){

					$Tot_Dt = $Dt->num_rows;

					if($Tot_Dt == 1){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}else{
						$rsp['m'] = 2;
						$rsp['w'] = $this->c_r>error;
						$rsp['w_n'] = $this->c_r->errno;
					}

				}

				$__cnx->_clsr($Dt);

			}

			return _jEnc($rsp);

		}



		public function _Org_Sds_Eml_In($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->_org_sds->id) && !isN($this->org_sds_eml) && filter_var($this->org_sds_eml, FILTER_VALIDATE_EMAIL)){

				$__enc = Enc_Rnd($this->_org_sds->id.'-'.$this->org_sds_eml);

				$qry_In = sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_SDS_EML." (orgsdseml_enc, orgsdseml_eml, orgsdseml_orgsds) VALUES (%s, %s, %s)",
				                       GtSQLVlStr($__enc, "text"),
				                       GtSQLVlStr($this->org_sds_eml, "text"),
				                       GtSQLVlStr($this->_org_sds->id, "int"));

				$Rs = $__cnx->_prc($qry_In);

				if($Rs){
					$rsp['e'] = 'ok';
					$rsp['id'] = $__cnx->c_p->insert_id;
					$rsp['enc'] = $__enc;
					$rsp['m'] = 1;
				}else{
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}

			}

			return _jEnc($rsp);

		}


		public function _Org_Sds_Eml($p=NULL){
			$rsp['e'] = 'no';
			$chk = $this->_Org_Sds_Eml_Chk();
			if($chk->e != 'ok'){ $chk = $this->_Org_Sds_Eml_In(); }
			if($chk->e == 'ok'){ $rsp['e'] = 'ok'; }
			return _jEnc($rsp);
		}



		public function _Org_Sds_Chk($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->_org->id)){

				$qry_Dt = sprintf("	SELECT *
									FROM "._BdStr(DBM).TB_ORG_SDS."
									WHERE orgsds_org=%s",
									GtSQLVlStr($this->_org->id, "int")
								);

				$Dt = $__cnx->_qry($qry_Dt);

				if($Dt){

					$Tot_Dt = $Dt->num_rows;
					$rsp['tot'] = $Tot_Dt;

					if($Tot_Dt > 1){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}else{
						$rsp['m'] = 2;
						$rsp['w'] = $this->c_r>error;
						$rsp['w_n'] = $this->c_r->errno;
					}

				}

				$__cnx->_clsr($Dt);

			}

			return _jEnc($rsp);

		}



		public function _Org_Sds_In($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->_org->id)){

				if(!isN($this->orgsds_nm)){ $_nm = $this->orgsds_nm; }else{ $_nm = TX_PC; }
				if(!isN($this->orgsds_cd)){ $_cd = $this->orgsds_cd; }else{ $_cd = 1; }

				$__enc = Enc_Rnd($this->_org->id.'-'.$this->org_scec);

				$qry_In = sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_SDS." (orgsds_enc, orgsds_org, orgsds_nm, orgsds_cd) VALUES (%s, %s, %s, %s)",
				                       GtSQLVlStr($__enc, "text"),
				                       GtSQLVlStr($this->_org->id, "int"),
				                       GtSQLVlStr(ctjTx($_nm, 'out'), "text"),
				                       GtSQLVlStr($_cd, "int"));

				$Rs = $__cnx->_prc($qry_In);

				if($Rs){
					$rsp['e'] = 'ok';
					$rsp['id'] = $__cnx->c_p->insert_id;
					$rsp['enc'] = $this->orgsds_enc = $__enc;
					$rsp['m'] = 1;
				}else{
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}

			}

			return _jEnc($rsp);

		}

		public function _Org_Sds_Cnt_Upd($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->enc)){

				$qry_Upd = sprintf("UPDATE ".TB_ORG_SDS_CNT." SET orgsdscnt_tpr=%s, orgsdscnt_are=%s, orgsdscnt_crs=%s, orgsdscnt_smst=%s, orgsdscnt_fs=%s WHERE orgsdscnt_enc=%s",
												GtSQLVlStr($this->tpr, "int"),
												GtSQLVlStr($this->are, "int"),
												GtSQLVlStr($this->crs, "int"),
												GtSQLVlStr($this->smst, "int"),
												GtSQLVlStr($this->fs, "date"),
												GtSQLVlStr($this->enc, "text"));

				$Rs = $__cnx->_prc($qry_Upd);

				if($Rs){
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}else{
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}

			}

			return _jEnc($rsp);

		}


		public function _Org_Sds($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			$chk = $this->_Org_Sds_Chk();

			$rsp['chk'] = $chk;

			if($chk->e != 'ok' && $chk->tot == 0){

				$chk = null;
				$tryC = 1;

				while($tryC <= 20){
					$chk = $this->_Org_Sds_In(); // --------- Create Main Sucursal If Not Exist
					//$rsp['in'][] = $chk;

					if($chk->e == 'ok'){ break; }
					$tryC = $tryC + 1;
				}

			}

			if($chk->e == 'ok'){ $rsp['e'] = 'ok'; }



			if(!isN($this->orgsds_enc)){
				$this->_org_sds = GtOrgSdsDt([ 'i'=>$this->orgsds_enc, 't'=>'enc', 'cnx'=>$this->c_r ]);
			}

			if(!isN($this->_org_sds)){
				$rsp['dc'] = $this->_Org_Sds_Dc();
				$rsp['tel'] = $this->_Org_Sds_Tel();
				$rsp['eml'] = $this->_Org_Sds_Eml();
			}

			return _jEnc($rsp);
		}




		public function _GtInfo($p=NULL){

			if(!isN($this->org_enc)){
				$this->_org = GtOrgDt([ 'i'=>$this->org_enc, 't'=>'enc', 'cnx'=>$this->c_r ]);
			}

			if(!isN($this->orgsds_enc)){
				$this->_org_sds = GtOrgSdsDt([ 'i'=>$this->orgsds_enc, 't'=>'enc', 'cnx'=>$this->c_r ]);
			}

			if(!isN($this->cnt_enc)){
				$this->_cnt = GtCntDt([  't'=>'enc', 'id'=>$this->cnt_enc, 'bd'=>$this->bd ]);
			}

		}


		public function In($p=NULL){

			$rsp['e'] = 'no';

			if(!isN($this->org_web)){
				$__dtorg = $this->_Org_Chk([ 'id'=>$this->org_web, 'chk'=>'web' ]);
				if($__dtorg->e == 'ok'){ $this->u_all .= 'Found it with web -> '.$this->org_web; }
			}

			if($__dtorg->e != 'ok' || isN($__dtorg->id)){
				$__dtorg = $this->_Org_Chk([ 'id'=>$this->org_sds_dc, 'chk'=>'dc' ]);
				if($__dtorg->e == 'ok'){ $this->u_all .= 'Found it with document -> '.$this->cnt_eml; }
			}

			if($__dtorg->e != 'ok' || isN($__dtorg->id) ){
				$__dtorg = $this->_Org_Chk([ 'id'=>$this->org_id, 'chk'=>'id' ]);
				if($__dtorg->e == 'ok'){ $this->u_all .= 'Found it with id -> '.$this->cnt_id; }
			}

			if($__dtorg->e == 'ok' && !isN($__dtorg->id) && !isN($__dtorg->enc)){
				$this->org_enc = $__dtorg->enc;
			}else{
				if(isN($this->org_enc)){
					$_in = $this->_Org_In();
				}
			}


			$this->_GtInfo();


			if($this->r_org_cl == 'ok'){

				$rsp['tmp']['org_cl']['in'] = $_chk = $this->_Org_Cl_Chk();

				if($_chk->e != 'ok'){

					$rsp['tmp']['org_cl']['in'] = $_chk = $this->_Org_Cl_In();

				}

				if($_chk->e == 'ok' || $_in->e == 'ok' || $__dtorg->e == 'ok'){ $rsp['e'] = 'ok'; }

			}


			if($this->r_org_cnt == 'ok'){

				$rsp['tmp']['org_cnt']['cnk'] = $_chk = $this->_Org_Cnt_Chk();

				if($_chk->e != 'ok'){
					$rsp['tmp']['org_cnt']['in'] = $rsp['e'] = $_chk = $this->_Org_Cnt_In();
				}

				if($_chk->e == 'ok' || $_in->e == 'ok' || $__dtorg->e == 'ok'){ $rsp['e'] = 'ok'; }
			}


			if($_chk->e != 'ok' || $_in->e == 'ok' || $__dtorg->e == 'ok'){ $rsp['e'] = 'ok'; }


			//$rsp['tmp___uall'] = $this->u_all;

			$rsp['tp'] = $this->_Org_Tp();
			$rsp['web'] = $this->_Org_Web();
			$rsp['scec'] = $this->_Org_Scec();
			$rsp['sds'] = $this->_Org_Sds();


			return _jEnc($rsp);

		}


		public function InAttr(){
			$rsp['e'] = 'no';
			$__dtorgattr = $this->_Org_Attr_Chk([ 'id'=>$this->orgattr_org ]);

			if($__dtorgattr->e == 'ok' ){
				$_org_in = $this->_Org_Attr_Upd();
			}else{
				$_org_in = $this->_Org_Attr_In();
			}

			if($_org_in->e == 'ok'){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				$rsp['in'] = $_org_in;

			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);
		}

		public function _Org_Attr_Chk($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if( !isN( $p['id'] ) ){

	            $__qry = sprintf('SELECT * FROM '._BdStr(DBM).TB_ORG_ATTR.' WHERE orgattr_org = %s LIMIT 1', GtSQLVlStr($p['id'], 'int'));

				if(!isN($__qry)){ $Dt = $__cnx->_qry($__qry); }

				if($Dt){

					$row_Dt = $Dt->fetch_assoc();
					$Tot_Dt = $Dt->num_rows;

					if($Tot_Dt == 1){
						$rsp['e'] = 'ok';
						$rsp['id'] = $row_Dt['id_orgattr'];
						$rsp['enc'] = $row_Dt['orgattr_enc'];
						$rsp['m'] = 1;
					}else{
						$rsp['m'] = 2;
						$rsp['w'] = $this->c_r>error;
						$rsp['w_n'] = $this->c_r->errno;
					}
				}

				$__cnx->_clsr($Dt);
			}

			return _jEnc($rsp);
		}

		public function _Org_Attr_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->orgattr_org);

			$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_ATTR."  (orgattr_enc, orgattr_org, orgattr_rdm, orgattr_nvs, orgattr_tp, orgattr_nva, orgattr_fch_bnf, orgattr_prtf, orgattr_tmn, orgattr_ntz) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
						GtSQLVlStr($this->orgattr_org, "int"),
						GtSQLVlStr($this->orgattr_rdm, "int"),
						GtSQLVlStr($this->orgattr_nvs, "int"),
						GtSQLVlStr($this->orgattr_tp, "int"),
						GtSQLVlStr($this->orgattr_nva, "int"),
						GtSQLVlStr($this->orgattr_fch_bnf, "date"),
						GtSQLVlStr($this->orgattr_prtf, "int"),
						GtSQLVlStr($this->orgattr_tmn, "int"),
						GtSQLVlStr($this->orgattr_ntz, "int"));


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);
		}

		public function _Org_Attr_Upd($p=NULL){

			global $__cnx;

			$query_DtRg =   sprintf("UPDATE "._BdStr(DBM).TB_ORG_ATTR." SET orgattr_rdm= %s, orgattr_nvs= %s, orgattr_tp= %s, orgattr_nva= %s, orgattr_fch_bnf= %s, orgattr_prtf= %s, orgattr_tmn= %s, orgattr_ntz= %s WHERE orgattr_org = %s",

						GtSQLVlStr($this->orgattr_rdm, "int"),
						GtSQLVlStr($this->orgattr_nvs, "int"),
						GtSQLVlStr($this->orgattr_tp, "int"),
						GtSQLVlStr($this->orgattr_nva, "int"),
						GtSQLVlStr($this->orgattr_fch_bnf, "date"),
						GtSQLVlStr($this->orgattr_prtf, "int"),
						GtSQLVlStr($this->orgattr_tmn, "int"),
						GtSQLVlStr($this->orgattr_ntz, "int"),
						GtSQLVlStr($this->orgattr_org, "int"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);
		}


		public function pinfo($p=NULL){

			if($p['t'] == 'clg' || in_array('clg', $p['t'])){
				$_p_tot = 12;
			}elseif($p['t'] == 'marks' || in_array('marks', $p['t'])){
				$_p_tot = 7;
			}

			if(!isN($p) && !isN($p['drw']) ){

				$drw = $p['drw'];

				if(!isN($drw['org_img'])){ $_f_tot++; }
				if(!isN($drw['org_clr'])){ $_f_tot++; }

				if($drw['_eml'] > 0){ $_f_tot++; }
				if($drw['_tel'] > 0){ $_f_tot++; }
				if($drw['_sds'] > 0){ $_f_tot++; }
				if($drw['_dc'] > 0){ $_f_tot++; }
				if($drw['_web'] > 0){ $_f_tot++; }
				if($drw['_cnt'] > 0){ $_f_tot++; }

				if($p['t'] == 'clg' || in_array('clg', $p['t'])){
					if($drw['_enf'] > 0){ $_f_tot++; }
					if($drw['_lng'] > 0){ $_f_tot++; }
					if($drw['_bch'] > 0){ $_f_tot++; }
					if($drw['_exa'] > 0){ $_f_tot++; }
				}

			}

			if(!isN($_f_tot)){
				$rsp['p'] = ($_f_tot/$_p_tot)*100;
			}

			return _jEnc($rsp);

		}

		public function OrgGrp_Ls($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->org_enc)){

				$query_DtRg = "SELECT
									*,(
										SELECT
											COUNT(*)
										FROM
											"._BdStr(DBM).TB_ORG_GRP_ORG."
										INNER JOIN "._BdStr(DBM).TB_ORG." ON id_org = orggrporg_org
										WHERE
										orggrporg_orggrp = id_orggrp
										AND org_enc = '".$this->org_enc."'
									) AS __est
									FROM
										"._BdStr(DBM).TB_ORG_GRP."
									ORDER BY __est DESC";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';

						do{
							$Vl['ls'][$row_DtRg['orggrp_enc']]['enc'] = $row_DtRg['orggrp_enc'];
							$Vl['ls'][$row_DtRg['orggrp_enc']]['nm'] = ctjTx($row_DtRg['orggrp_nm'],'in');

							if( !isN($row_DtRg['orggrp_img']) ){
								$Vl['ls'][$row_DtRg['orggrp_enc']]['img'] = _ImVrs([ 'img'=>$row_DtRg['orggrp_img'], 'f'=>DMN_FLE_ORG_GRP ]);
							}

							$Vl['ls'][$row_DtRg['orggrp_enc']]['est'] = $row_DtRg['__est'];
						}while($row_DtRg = $DtRg->fetch_assoc());
					}

				}else{

					$Vl['w'] = $this->c_r->error;

				}

				$__cnx->_clsr($DtRg);

			}

			return _jEnc($Vl);
		}

		public function OrgGrp($p=NULL){

			$Vl['e'] = 'no';
			$__chk = $this->OrgGrp_Chk();


			$Vl['eddd'] = $__chk;
			if(isN($__chk->id)){
				$__in = $this->OrgGrp_In();
				if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }
			}elseif(!isN($__in) || !isN($__chk->id)){
				$__upd = $this->OrgGrp_Del();
				$Vl['_upd']=$__upd;
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}

			return(_jEnc($Vl));
		}

		public function OrgGrp_Chk($p=NULL){

			global $__cnx;

			if( !isN($this->org_enc) && !isN($this->grp_enc) ){

				$Vl['e'] = 'no';

				$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).TB_ORG_GRP_ORG."
									   WHERE orggrporg_org = (SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = %s) AND
									   orggrporg_orggrp = (SELECT id_orggrp FROM "._BdStr(DBM).TB_ORG_GRP." WHERE orggrp_enc = %s)
									   LIMIT 1", GtSQLVlStr($this->org_enc,'text'), GtSQLVlStr($this->grp_enc,'text'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $this->gt_id_mdlsch =$row_DtRg['id_orggrporg'];
						$Vl['enc'] = ctjTx($row_DtRg['orggrporg_enc'],'in');
					}
				}

				$__cnx->_clsr($DtRg);

			}

			return(_jEnc($Vl));
		}

		public function OrgGrp_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->org_enc.'-'.$this->grp_enc);

			$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_GRP_ORG." (orggrporg_enc, orggrporg_org, orggrporg_orggrp)
						VALUES (%s,(SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = %s),
						(SELECT id_orggrp FROM "._BdStr(DBM).TB_ORG_GRP." WHERE orggrp_enc = %s))",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->org_enc, "text"),
							GtSQLVlStr($this->grp_enc, "text"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['i'] = $this->gt_id_mdlsch = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		public function OrgGrp_Del($p=NULL){

			global $__cnx;

			$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_GRP_ORG." WHERE
									orggrporg_org = (SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = %s) AND
									orggrporg_orggrp = (SELECT id_orggrp FROM "._BdStr(DBM).TB_ORG_GRP." WHERE orggrp_enc = %s)",

									GtSQLVlStr($this->org_enc, "text"),
									GtSQLVlStr($this->grp_enc, "text")
								);


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;

			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
				$rsp['w_n'] = $__cnx->c_p->errno;

			}

			return _jEnc($rsp);

		}

		/* ------ Sector Economico - Organizacion ---- */

		public function OrgScec_Ls($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->org_enc)){

				$query_DtRg = "SELECT
									*,(
										SELECT
											COUNT(*)
										FROM
											"._BdStr(DBM).TB_ORG_SCEC."
											INNER JOIN "._BdStr(DBM).TB_ORG." ON id_org = orgscec_org
										WHERE
											id_sisslc = orgscec_scec
										AND org_enc = '".$this->org_enc."'
									) AS __est
								FROM
									"._BdStr(DBM).TB_SIS_SLC."
									INNER JOIN "._BdStr(DBM).TB_SIS_SLC_TP." ON sisslc_tp = id_sisslctp
								WHERE
									sisslctp_key = 'emp_scec'
								ORDER BY
									__est DESC, id_sisslc DESC";

				$DtRg = $__cnx->_qry($query_DtRg);

				//$Vl['qry'] = $query_DtRg;

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';

						do{
							$Vl['ls'][$row_DtRg['sisslc_enc']]['enc'] = $row_DtRg['sisslc_enc'];
							$Vl['ls'][$row_DtRg['sisslc_enc']]['nm'] = ctjTx($row_DtRg['sisslc_tt'],'in');
							$Vl['ls'][$row_DtRg['sisslc_enc']]['est'] = $row_DtRg['__est'];;
						}while($row_DtRg = $DtRg->fetch_assoc());
					}

				}else{

					$Vl['w'] = $this->c_r->error;

				}

				$__cnx->_clsr($DtRg);

			}

			return _jEnc($Vl);
		}

		public function OrgScec($p=NULL){

			$Vl['e'] = 'no';
			$__chk = $this->OrgScec_Chk();
			$Vl['sse'] = $__chk;
			if(isN($__chk->id)){
				$__in = $this->OrgScec_In();
				if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }
			}elseif(!isN($__in) || !isN($__chk->id)){
				$__upd = $this->OrgScec_Del();
				$Vl['_upd']=$__upd;
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}

			return(_jEnc($Vl));
		}

		public function OrgScec_Chk($p=NULL){

			global $__cnx;

			if( !isN($this->org_enc) && !isN($this->scec_enc) ){

				$Vl['e'] = 'no';

				$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).TB_ORG_SCEC."
												WHERE orgscec_org = (SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = %s) AND
												orgscec_scec = (SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s)
									   LIMIT 1", GtSQLVlStr($this->org_enc,'text'), GtSQLVlStr($this->scec_enc,'text'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_orgscec'];
						$Vl['enc'] = ctjTx($row_DtRg['orgscec_enc'],'in');
					}
				}

				$__cnx->_clsr($DtRg);
			}

			return(_jEnc($Vl));
		}

		public function OrgScec_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->org_enc.'-'.$this->scec_enc);

			$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_SCEC." (orgscec_enc, orgscec_org, orgscec_scec)
										VALUES (%s,(SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = %s),
										(SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s))",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->org_enc, "text"),
							GtSQLVlStr($this->scec_enc, "text"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['i'] = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		public function OrgScec_Del($p=NULL){

			global $__cnx;

			$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_SCEC." WHERE
									orgscec_org = (SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = %s) AND
									orgscec_scec = (SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s)",

									GtSQLVlStr($this->org_enc, "text"),
									GtSQLVlStr($this->scec_enc, "text")
								);


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;

			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
				$rsp['w_n'] = $__cnx->c_p->errno;

			}

			return _jEnc($rsp);

		}

		public function OrgGrphMarks($p){
			global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($p['org'])){

				$__dt_1 = date('Y-m-01');
				$__dt_2 = date('Y-m-d');

				$___Dt->qry_f .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';

				$query_DtRg = "
								SELECT
									SUM(orgsdsarrsls_vl) AS tot, SUM(orgsdsarrsls_trs) AS trs, SUM(orgsdsarrsls_vst) AS vst
								FROM
								"._BdStr(DBM).TB_ORG_SDS_ARR_SLS."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsdsarr = orgsdsarrsls_arr
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
								WHERE
									id_orgsdsarrsls != ''
								AND orgsdsarr_est = 1
								AND org_enc = '".$p['org']."' $___Dt->qry_f
								ORDER BY
									id_orgsdsarrsls";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['ventas']['tot'] = cnVlrMon('', $row_DtRg['tot'] );
						$Vl['ventas']['trs'] = $row_DtRg['trs'];
						$Vl['ventas']['vst'] = $row_DtRg['vst'];
					}
				}

				$__cnx->_clsr($DtRg);

			}

			return _jEnc($Vl);
		}

		// --------- Etiquetas de Organizacion ----------- //

        public function GtOrgTagLs($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->id_org)){

		    	$query_DtRg = "SELECT
									sisslc_enc, sisslc_tt, (
										SELECT
											COUNT(*)
										FROM
											"._BdStr(DBM).TB_ORG_TAG."
											INNER JOIN "._BdStr(DBM).TB_ORG." ON id_org = orgtag_org
										WHERE
											id_sisslc = orgtag_tag
										AND org_enc = '".$this->id_org."'
									) AS __est
								FROM
									"._BdStr(DBM).TB_SIS_SLC."
									INNER JOIN "._BdStr(DBM).TB_SIS_SLC_TP." ON sisslc_tp = id_sisslctp
								WHERE
									sisslctp_key = 'eti_org'
								ORDER BY
									__est DESC, id_sisslc DESC";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';

						do{

							$id_ob = $row_DtRg['sisslc_enc'];
							$Vl['ls'][$id_ob]['enc'] = $row_DtRg['sisslc_enc'];
							$Vl['ls'][$id_ob]['nm'] = $row_DtRg['sisslc_tt'];
							$Vl['ls'][$id_ob]['est'] = $row_DtRg['__est'];

						}while($row_DtRg = $DtRg->fetch_assoc());
					}
				}else{
					$Vl['w'] = $this->c_r->error;
				}

				$__cnx->_clsr($DtRg);

				return _jEnc($Vl);
			}
       	}

		public function GtOrgTagLs_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->id_org.'-'.$this->id_tag);

			$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_TAG."  ( orgtag_enc, orgtag_org, orgtag_tag )
									VALUES
									(
										%s,
										(SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = %s),
										(SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s)
									)",
						GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->id_org, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->id_tag, 'out'), "text"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

        public function GtOrgTagLs_Del($p=NULL){

			global $__cnx;

			$query_DtRg =   sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_TAG."
										WHERE orgtag_org IN (SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = %s)
										AND orgtag_tag IN (SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s) ",
						GtSQLVlStr(ctjTx($this->id_org,'out'), "text"),
						GtSQLVlStr(ctjTx($this->id_tag,'out'), "text"));
			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		// ------ Locales de Organizacion ---- //

		public function GtOrgSdsLcl_Chk($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';



				$qry_Dt = "	SELECT id_orgsdsarrlcl
								FROM "._BdStr(DBM).TB_ORG_SDS_ARR_LCL."
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsdsarr = orgsdsarrlcl_orgsdsarr
							INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON id_cllcl = orgsdsarrlcl_cllcl
							WHERE orgsdsarr_est = 1 AND cllcl_enc = '".$this->id_lcl."' ";

				$Dt = $__cnx->_qry($qry_Dt);

				if($Dt){

					$Tot_Dt = $Dt->num_rows;

					if($Tot_Dt == 1){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}else{
						$rsp['m'] = 2;
						$rsp['w'] = $this->c_r>error;
						$rsp['w_n'] = $this->c_r->errno;
					}

				}

				$__cnx->_clsr($Dt);



			return _jEnc($rsp);

		}

		public function GtOrgSdsLclLs($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->id_org)){

		    	$query_DtRg = "SELECT
									cllcl_enc, cllcl_tt,
									( SELECT
											COUNT(*)
										FROM "._BdStr(DBM).TB_ORG_SDS_ARR_LCL."
											INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarrlcl_orgsdsarr = id_orgsdsarr
										WHERE orgsdsarrlcl_cllcl = id_cllcl AND orgsdsarr_enc = '".$this->id_org."'
									) AS __est
								FROM
									"._BdStr(DBM).TB_CL_LCL."
								WHERE
									(
										id_cllcl NOT IN ( SELECT orgsdsarr_lcl FROM "._BdStr(DBM).TB_ORG_SDS_ARR." WHERE orgsdsarr_est = 1 )
										AND id_cllcl NOT IN (
											SELECT orgsdsarrlcl_cllcl FROM "._BdStr(DBM).TB_ORG_SDS_ARR_LCL."
												INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarrlcl_orgsdsarr = id_orgsdsarr
											WHERE orgsdsarr_est = 1
										)
									)
									OR id_cllcl IN (
										SELECT orgsdsarrlcl_cllcl
										FROM "._BdStr(DBM).TB_ORG_SDS_ARR_LCL."
											INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarrlcl_orgsdsarr = id_orgsdsarr
										WHERE orgsdsarrlcl_cllcl = id_cllcl  AND orgsdsarr_enc = '".$this->id_org."'
									)";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';

						do{

							$id_ob = $row_DtRg['cllcl_enc'];
							$Vl['ls'][$id_ob]['enc'] = $row_DtRg['cllcl_enc'];
							$Vl['ls'][$id_ob]['nm'] = $row_DtRg['cllcl_tt'];
							$Vl['ls'][$id_ob]['est'] = $row_DtRg['__est'];

						}while($row_DtRg = $DtRg->fetch_assoc());
					}
				}else{
					$Vl['w'] = $this->c_r->error;
				}

				$__cnx->_clsr($DtRg);

				return _jEnc($Vl);
			}
       	}

		public function GtOrgSdsLclLs_In($p=NULL){

			$chk = $this->GtOrgSdsLcl_Chk();

			if($chk->e == 'no'){
				global $__cnx;

				$__enc = Enc_Rnd($this->id_org.'-'.$this->id_lcl);

				$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_SDS_ARR_LCL." ( orgsdsarrlcl_enc, orgsdsarrlcl_orgsdsarr, orgsdsarrlcl_cllcl )
										VALUES
										(
											%s,
											(SELECT id_orgsdsarr FROM "._BdStr(DBM).TB_ORG_SDS_ARR." WHERE orgsdsarr_enc = %s),
											(SELECT id_cllcl FROM "._BdStr(DBM).TB_CL_LCL." WHERE cllcl_enc = %s)
										)",
							GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
							GtSQLVlStr(ctjTx($this->id_org, 'out'), "text"),
							GtSQLVlStr(ctjTx($this->id_lcl, 'out'), "text"));

				$Result = $__cnx->_prc($query_DtRg);

				if($Result){
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}
			}else{
				$rsp['msj'] = 'Este local ya esta asignado a un arriendo. Actualizando...';
			}



			return _jEnc($rsp);

		}

        public function GtOrgSdsLclLs_Del($p=NULL){

			global $__cnx;

			$query_DtRg =   sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_SDS_ARR_LCL."
										WHERE orgsdsarrlcl_orgsdsarr IN (SELECT id_orgsdsarr FROM "._BdStr(DBM).TB_ORG_SDS_ARR." WHERE orgsdsarr_enc = %s)
										AND orgsdsarrlcl_cllcl IN (SELECT id_cllcl FROM "._BdStr(DBM).TB_CL_LCL." WHERE cllcl_enc = %s) ",
						GtSQLVlStr(ctjTx($this->id_org,'out'), "text"),
						GtSQLVlStr(ctjTx($this->id_lcl,'out'), "text"));
			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		public function OrgSds_Sls_Ls($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->id_org)){

		    	$query_DtRg = "SELECT
									id_orgsdsarrsls, orgsdsarrsls_vl, orgsdsarrsls_trs, orgsdsarrsls_f, orgsdsarrsls_enc
								FROM "._BdStr(DBM).TB_ORG_SDS_ARR_SLS."
									INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsdsarr = orgsdsarrsls_arr
									INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
									INNER JOIN "._BdStr(DBM).TB_ORG."  ON orgsds_org = id_org
								WHERE orgsdsarr_est = 1 AND org_enc = '".$this->id_org."' ORDER BY orgsdsarrsls_f DESC LIMIT 5";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';

						do{
							$Vl['ls'][$row_DtRg['orgsdsarrsls_f']]['enc'] = $row_DtRg['orgsdsarrsls_enc'];
							$Vl['ls'][$row_DtRg['orgsdsarrsls_f']]['vl'] = cnVlrMon('',$row_DtRg['orgsdsarrsls_vl']);
							$Vl['ls'][$row_DtRg['orgsdsarrsls_f']]['trs'] = $row_DtRg['orgsdsarrsls_trs'];
							$Vl['ls'][$row_DtRg['orgsdsarrsls_f']]['f'] = $row_DtRg['orgsdsarrsls_f'];
						}while($row_DtRg = $DtRg->fetch_assoc());
					}
				}else{
					$Vl['w'] = $this->c_r->error;
				}

				$__cnx->_clsr($DtRg);

				return _jEnc($Vl);
			}
		}

		public function OrgSds_Sls_Chck($p=NULL){

			global $__cnx;

				$rsp['e'] = 'no';

	            $__qry = sprintf("SELECT * FROM "._BdStr(DBM).TB_ORG_SDS_ARR_SLS."
									WHERE orgsdsarrsls_f = %s AND orgsdsarrsls_arr = (
										SELECT id_orgsdsarr FROM "._BdStr(DBM).TB_ORG_SDS_ARR."
										WHERE orgsdsarr_est = 1 AND orgsdsarr_orgsds IN (
											SELECT id_orgsds FROM "._BdStr(DBM).TB_ORG_SDS." WHERE orgsds_enc = %s
										)
									) LIMIT 1",
										GtSQLVlStr($this->post['orgsdsarrsls_f'], 'text'),
										GtSQLVlStr($this->post['orgsdsarr_sls_enc'], 'text')
									);

				if(!isN($__qry)){ $Dt = $__cnx->_qry($__qry); }

				if($Dt){

					$row_Dt = $Dt->fetch_assoc();
					$Tot_Dt = $Dt->num_rows;

					if($Tot_Dt == 1){
						$rsp['e'] = 'ok';
						$rsp['id'] = $row_Dt['orgsdsarrsls_enc'];
						$rsp['f'] = $row_Dt['orgsdsarrsls_f'];
						$rsp['arr'] = $row_Dt['orgsdsarrsls_arr'];
						$rsp['m'] = 1;
					}else{
						$rsp['m'] = 2;
						$rsp['w'] = $this->c_r>error;
						$rsp['w_n'] = $this->c_r->errno;
					}
				}

				$__cnx->_clsr($Dt);

			return _jEnc($rsp);
		}

		public function OrgSds_Sls_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd( $this->post['orgsdsarr_sls_enc']." - ".$this->post['orgsdsarrsls_vl'] );

			$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_SDS_ARR_SLS." ( orgsdsarrsls_enc,orgsdsarrsls_vl,orgsdsarrsls_trs,orgsdsarrsls_vst,orgsdsarrsls_f,orgsdsarrsls_arr ) VALUES
														( %s, %s, %s, %s, %s,
															(
																SELECT id_orgsdsarr FROM "._BdStr(DBM).TB_ORG_SDS_ARR."
																WHERE orgsdsarr_est = 1 AND orgsdsarr_orgsds IN (
																	SELECT id_orgsds FROM "._BdStr(DBM).TB_ORG_SDS." WHERE orgsds_enc = %s
																)
															)
														)",
											GtSQLVlStr($__enc, "text"),
											GtSQLVlStr(ctjTx($this->post['orgsdsarrsls_vl'],'out'), "text"),
											GtSQLVlStr($this->post['orgsdsarrsls_trs'], "int"),
											GtSQLVlStr($this->post['orgsdsarrsls_vst'], "int"),
											GtSQLVlStr($this->post['orgsdsarrsls_f'], "date"),
											GtSQLVlStr(ctjTx($this->post['orgsdsarr_sls_enc'],'out'), "text")
											);


			$Result = $__cnx->_prc($insertSQL);

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				$this->post['id_insert'] = $__cnx->c_p->insert_id;
				$rsp['aud'] = $this->_aud->In_Aud([ "aud"=>_Cns('ID_AUDDSC_MRKS_SLS_IN'), "db"=>TB_ORG_SDS_ARR_SLS, "post"=> $this->post ]);
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		public function OrgSds_Sls_Upd($p=NULL){

			global $__cnx;

			$query_DtRg =   sprintf("UPDATE "._BdStr(DBM).TB_ORG_SDS_ARR_SLS." SET
												orgsdsarrsls_vl=%s,
												orgsdsarrsls_trs=%s,
												orgsdsarrsls_vst=%s,
												orgsdsarrsls_f=%s,
												orgsdsarrsls_arr= (
													SELECT id_orgsdsarr FROM "._BdStr(DBM).TB_ORG_SDS_ARR."
													WHERE orgsdsarr_est = 1 AND orgsdsarr_orgsds IN (
														SELECT id_orgsds FROM "._BdStr(DBM).TB_ORG_SDS." WHERE orgsds_enc = %s
													)
												)
												WHERE
												orgsdsarrsls_enc=%s
											",
									GtSQLVlStr(ctjTx($_POST['orgsdsarrsls_vl'],'out'), "text"),
									GtSQLVlStr($_POST['orgsdsarrsls_trs'], "int"),
									GtSQLVlStr($_POST['orgsdsarrsls_vst'], "int"),
									GtSQLVlStr($_POST['orgsdsarrsls_f'], "date"),
									GtSQLVlStr(ctjTx($_POST['orgsdsarr_sls_enc'],'out'), "text"),
									GtSQLVlStr(ctjTx($_POST['orgsdsarrsls_enc'],'out'), "text"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				$rsp['aud'] = $this->_aud->In_Aud([ "aud"=>_Cns('ID_AUDDSC_MRKS_SLS_MOD'), "db"=>TB_ORG_SDS_ARR_SLS, "post"=>$_POST ]);

			}else{

				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);
		}

		public function ChckPssMarks(){
			global $__cnx;

		    $Vl['e'] = 'no';

			$query_DtRg = sprintf("SELECT orgsdscntpss_orgsdscnt, orgsdscntpss_eml, orgsdscntpss_orgsds
										FROM "._BdStr($__cl->bd).TB_ORG_SDS_CNT_PSS." WHERE orgsdscntpss_eml = %s AND
										orgsdscntpss_pss = AES_ENCRYPT(%s, '".ENCRYPT_PASSPHRASE."' ) AND orgsdscntpss_est = 1 LIMIT 1",
									GtSQLVlStr($this->us, "text"), GtSQLVlStr($this->pss, "text") );

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['cnt'] = $row_DtRg['orgsdscntpss_orgsdscnt'];
					$Vl['org'] = $row_DtRg['orgsdscntpss_orgsds'];
				}
			}

			$__cnx->_clsr($DtRg);

			return _jEnc($Vl);
		}

		public function OrgSds_Aud_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd( $this->post['orgsdsarrsls_f']." - ".$this->post['orgsdsarr_sls_enc'] );

			if(!isN($this->cl)){

				$insertSQL = sprintf("INSERT INTO "._BdStr($this->cl)."org_sds_cnt_aud ( orgsdscntaud_enc, orgsdscntaud_cnt, orgsdscntaud_dsc, orgsdscntaud_post, orgsdscntaud_ip ) VALUES
														( %s,
															(
																SELECT id_orgsdscnt FROM "._BdStr($this->cl).TB_ORG_SDS_CNT."
																WHERE orgsdscnt_enc = %s
															), %s, %s, %s

														)",
												GtSQLVlStr($__enc, "text"),
												GtSQLVlStr(ctjTx($this->post['orgsdscnt_cnt'],'out'), "text"),
												GtSQLVlStr(ctjTx($this->post['dsc'],'out'), "text"),
												GtSQLVlStr(json_encode($this->post), "text"),
												GtSQLVlStr(KnIp("on"), "text")
											);


				$Result = $__cnx->_prc($insertSQL);

				if($Result){
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}
			}
			return _jEnc($rsp);

		}

		public function GtOrgDshRowLs($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->tp_org)){

				$query_DtRg = " SELECT orgdshrow_enc,orgdshrow_cols,orgdshrow_ord,id_orgdshrow
									FROM "._BdStr(DBM).TB_ORG_DSH_ROW."
								WHERE orgdshrow_tp = ".$this->tp_org." AND
									  orgdshrow_cl = ".DB_CL_ID."
								ORDER BY orgdshrow_ord ASC";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						do{
							$Vl['ls'][$row_DtRg['orgdshrow_enc']]['id'] = $row_DtRg['id_orgdshrow'];
							$Vl['ls'][$row_DtRg['orgdshrow_enc']]['enc'] = $row_DtRg['orgdshrow_enc'];
							$Vl['ls'][$row_DtRg['orgdshrow_enc']]['col'] = $row_DtRg['orgdshrow_cols'];
							$Vl['ls'][$row_DtRg['orgdshrow_enc']]['ord'] = $row_DtRg['orgdshrow_ord'];
							$Vl['ls'][$row_DtRg['orgdshrow_enc']]['cols'] = $this->GtOrgDshRowColLs([ 'id'=> $row_DtRg['id_orgdshrow']]);
						}while($row_DtRg = $DtRg->fetch_assoc());
					}
				}

				$__cnx->_clsr($DtRg);
			}

			return _jEnc($Vl);

		}

		public function GtOrgDshRowColLs($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->tp_org)){

				$query_DtRg = " SELECT orgdshrowcol_enc, orgdshrowcol_ord, id_orgdshrowcol
									FROM "._BdStr(DBM).TB_ORG_DSH_ROW_COL."
								WHERE orgdshrowcol_orgdshrow = ".$p['id']."
								ORDER BY orgdshrowcol_ord ASC";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						do{
							$Vl['ls'][$row_DtRg['orgdshrowcol_enc']]['enc'] = $row_DtRg['orgdshrowcol_enc'];
							$Vl['ls'][$row_DtRg['orgdshrowcol_enc']]['ord'] = $row_DtRg['orgdshrowcol_ord'];
							$Vl['ls'][$row_DtRg['orgdshrowcol_enc']]['fld'] = $this->GtOrgDshRowColFldLs([ 'id'=> $row_DtRg['id_orgdshrowcol'] ]);
						}while($row_DtRg = $DtRg->fetch_assoc());
					}
				}

				$__cnx->_clsr($DtRg);
			}

			return _jEnc($Vl);

		}

		public function GtOrgDshRowColFldLs($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->tp_org)){

				$query_DtRg = " SELECT orgdshrowcolfld_enc, orgdshrowcolfld_ord, id_orgdsh, orgdsh_vl, orgdsh_otp,
									"._QrySisSlcF([ 'als'=>'t', 'als_n'=>'Type']).",
								    "._QrySisSlcF([ 'als'=>'tob', 'als_n'=>'Object']).",
								    ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Type', 'als'=>'t' ]).",
								    ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Object', 'als'=>'tob' ])."
									FROM "._BdStr(DBM).TB_ORG_DSH_ROW_COL_FLD."
									INNER JOIN "._BdStr(DBM).TB_ORG_DSH." ON orgdshrowcolfld_orgdsh = id_orgdsh
									".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'orgdsh_tp', 'als'=>'t' ])."
								 	".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'orgdsh_otp', 'als'=>'tob' ])."
								WHERE orgdshrowcolfld_orgdshrowcol = ".$p['id']."
								ORDER BY orgdshrowcolfld_ord ASC";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						do{

							$__tipo = json_decode($row_DtRg['___Object']);

							foreach($__tipo as $__tipo_k=>$__tipo_v){
								$__tipo_attr[$__tipo_v->key] = $__tipo_v->vl;
							}

							if($__tipo_attr['grph'] == 1){
								$__tp = 'grph';
							}else if($__tipo_attr['card'] == 1){
								$__tp = 'card';
							}

							$Vl['ls'][$row_DtRg['orgdshrowcolfld_enc']][$__tp]['e'] = 'ok';
							$Vl['ls'][$row_DtRg['orgdshrowcolfld_enc']][$__tp]['id'] = $row_DtRg['id_orgdsh'];
							$Vl['ls'][$row_DtRg['orgdshrowcolfld_enc']][$__tp]['enc'] = $row_DtRg['orgdshrowcolfld_enc'];
							$Vl['ls'][$row_DtRg['orgdshrowcolfld_enc']][$__tp]['id_attr'] = $__tipo_attr['id'];
							$Vl['ls'][$row_DtRg['orgdshrowcolfld_enc']][$__tp]['vl'] = $row_DtRg['orgdsh_vl'];
							$Vl['ls'][$row_DtRg['orgdshrowcolfld_enc']][$__tp]['tt'] = $__tipo_attr['lbl'];
							$Vl['ls'][$row_DtRg['orgdshrowcolfld_enc']][$__tp]['img'] = DMN_FLE_SIS_SLC.$row_DtRg['Object_sisslc_img'];
							$Vl['ls'][$row_DtRg['orgdshrowcolfld_enc']][$__tp]['otp'] = $row_DtRg['orgdsh_otp'];
							$Vl['ls'][$row_DtRg['orgdshrowcolfld_enc']][$__tp]['tp_grph'] = $__tipo_attr['tp_grph'];

							if( $row_DtRg['orgdsh_otp'] == _CId('ID_ORGDSHOTP_GRPH_EST_PRD') ){
								$Vl['ls'][$row_DtRg['orgdshrowcolfld_enc']][$__tp]['data'] = $this->GtOrgDshEstPrd([ 'est' => $row_DtRg['orgdsh_vl'], 'tp' => $this->tp ]);
							}elseif( $row_DtRg['orgdsh_otp'] == _CId('ID_ORGDSHOTP_EST_ACT') ){
								$Vl['ls'][$row_DtRg['orgdshrowcolfld_enc']][$__tp]['data'] = $this->GtOrgDshEst([ 'est' => $row_DtRg['orgdsh_vl'], 'tp' => $this->tp ]);
							}elseif( $row_DtRg['orgdsh_otp'] == _CId('ID_ORGDSHOTP_EGRDS') ){
								$Vl['ls'][$row_DtRg['orgdshrowcolfld_enc']][$__tp]['data'] = $this->GtOrgDshEst_C([ 'est' => $row_DtRg['orgdsh_vl'], 'tp' => $this->tp ]);
							}elseif( $row_DtRg['orgdsh_otp'] == _CId('ID_ORGDSHOTP_GRPH_MRK_SLE') ){
								$Vl['ls'][$row_DtRg['orgdshrowcolfld_enc']][$__tp]['data'] = $this->GtOrgDshMrK([ 'est' => $row_DtRg['orgdsh_vl'], 'tp' => $this->tp ]);
							}elseif( $row_DtRg['orgdsh_otp'] == _CId('ID_ORGDSHOTP_NVL_ATC')  ){
								$Vl['ls'][$row_DtRg['orgdshrowcolfld_enc']][$__tp]['data'] = $this->GtOrgDshNvlAtc([ 'est' => $row_DtRg['orgdsh_vl'], 'tp' => $this->tp ]);
							}


						}while($row_DtRg = $DtRg->fetch_assoc());
					}
				}

				$__cnx->_clsr($DtRg);
			}

			return _jEnc($Vl);

		}

		/* ------ Graficas de Organizaciones ---- */

			public function GtOrgDshEstPrd($p=NULL){
				global $__cnx;

				$Vl['e'] = 'no';

				$query_DtRg = " SELECT
									id_mdlsprd, mdlsprd_nm, mdlcnt_est, siscntest_tt, mdlsprd_y, COUNT(*) as tot
								FROM
									"._BdStr(DBM).TB_MDL_S_PRD."
									INNER JOIN "._BdStr(DBM).TB_MDL_S_PRD_TP." ON mdlsprdtp_prd = id_mdlsprd
									INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." AS e ON mdlsprdtp_tp = e.id_mdlstp
									INNER JOIN ".TB_MDL_CNT_PRD." ON mdlcntprd_mdlsprd = id_mdlsprd
									INNER JOIN ".TB_MDL_CNT." ON mdlcntprd_mdlcnt = id_mdlcnt
									INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
									INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
									INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
									INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." AS s ON mdls_tp = s.id_mdlstp
									INNER JOIN ".TB_ORG_SDS_CNT." ON mdlcnt_cnt = orgsdscnt_cnt
									INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdscnt_orgsds = id_orgsds
									INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
								WHERE
									mdlsprd_cl = ".DB_CL_ID."
									AND e.mdlstp_tp = '".$p['tp']."'
									AND mdlcnt_est IN ( ".$p['est']." )
									AND s.mdlstp_tp = '".$p['tp']."'
									AND mdlcntprd_est = 1
									AND org_enc = '".$this->i."'
								GROUP BY
									id_mdlsprd,
									mdlcnt_est
								HAVING
									mdlsprd_y >= 2020
								ORDER BY
									mdlsprd_y,
									mdlsprd_nm";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';
						$Vl['tot'] = $Tot_DtRg;

						do{
							$r['ctg'][$row_DtRg['id_mdlsprd']] = $row_DtRg['mdlsprd_nm'];

							$r['d'][$row_DtRg['mdlcnt_est']]['nm'] = $row_DtRg['siscntest_tt'];
							$r['d'][$row_DtRg['mdlcnt_est']][$row_DtRg['id_mdlsprd']]['tot'] = $row_DtRg['tot'];

						}while($row_DtRg = $DtRg->fetch_assoc());

						$Vl_Grph = _jEnc($r);

						foreach($Vl_Grph->ctg as $k => $v){
							$__ctg[] = $v;

							foreach($Vl_Grph->d as $_k => $_v){

								$_d[$_k]['name'] = $_v->nm;
								$_d[$_k]['data'][] = ( !isN($_v->{$k}->tot) ) ? (int)$_v->{$k}->tot : 0 ;

							}

						}

						$Vl['c'] = $__ctg;
						$Vl['o'] = $_d;

					}else{
						$Vl['tot'] = 0;
					}

				}else{
					$Vl['w'] = $__cnx->c_r->error;
				}

				$__cnx->_clsr($DtRg);

				return(_jEnc($Vl));
			}

			public function GtOrgDshEst($p=NULL){
				global $__cnx;

				$Vl['e'] = 'no';

				$query_DtRg = " SELECT
									mdlcnt_est, siscntest_tt, COUNT(*) as tot
								FROM
									".TB_MDL_CNT."
									INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
									INNER JOIN ".TB_MDL." _mdl ON mdlcnt_mdl = id_mdl
									INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
									INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." AS s ON mdls_tp = s.id_mdlstp
									INNER JOIN ".TB_ORG_SDS_CNT." ON mdlcnt_cnt = orgsdscnt_cnt
									INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdscnt_orgsds = id_orgsds
									INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
								WHERE
									mdlcnt_est IN ( ".$p['est']." )
									AND s.mdlstp_tp = '".$p['tp']."'
									AND org_enc = '".$this->i."'
								GROUP BY
									mdlcnt_est";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';
						$Vl['tot'] = $Tot_DtRg;

						do{

							$r['d'][$row_DtRg['mdlcnt_est']]['nm'] = $row_DtRg['siscntest_tt'];
							$r['d'][$row_DtRg['mdlcnt_est']]['tot'] = $row_DtRg['tot'];

						}while($row_DtRg = $DtRg->fetch_assoc());

						$Vl_Grph = _jEnc($r);


						foreach($Vl_Grph->d as $_k => $_v){

							$_d[$_k]['name'] = $_v->nm;
							$_d[$_k]['data'][] = ( !isN($_v->tot) ) ? (int)$_v->tot : 0 ;

						}

						$Vl['c'] = $__ctg;
						$Vl['o'] = $_d;


					}else{
						$Vl['tot'] = 0;
					}

				}else{
					$Vl['w'] = $__cnx->c_r->error;
				}

				$__cnx->_clsr($DtRg);

				return(_jEnc($Vl));
			}

			public function GtOrgDshEst_C($p=NULL){
				global $__cnx;

				$Vl['e'] = 'no';

				$Ls_Cnt_Qry = " SELECT
									COUNT(DISTINCT id_mdlcnt) as tot, siscntest_tt
								FROM
									".TB_MDL_CNT."
									INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
									INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
									INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
									INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
									INNER JOIN ".TB_ORG_SDS_CNT." ON mdlcnt_cnt = orgsdscnt_cnt
									INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdscnt_orgsds = id_orgsds
									INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
								WHERE
									mdlcnt_est = ".$p['est']." AND
									mdlstp_tp = '".$p['tp']."' AND
									org_enc = '".$this->i."'
                ";

				$DtRg = $__cnx->_qry($Ls_Cnt_Qry);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';

						do{
							$Vl['tt'] = $row_DtRg['siscntest_tt'];
							$Vl['tot'] = $row_DtRg['tot'];
						}while($row_DtRg = $DtRg->fetch_assoc());


					}else{
						$Vl['tot'] = 0;
					}

				}else{
					$Vl['w'] = $__cnx->c_r->error;
				}

				$__cnx->_clsr($DtRg);

				return(_jEnc($Vl));
			}

			public function GtOrgDshMrk($p=NULL){
				global $__cnx;

				$Vl['e'] = 'no';

				$__dt_1 = date('Y-m-01');

				$__dt_2 = strtotime ( '- 1 days' , strtotime ( date('Y-m-d') ) );
				$__dt_2 = date ( 'Y-m-d' , $__dt_2 );

				$qry_f .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';

				$query_DtRg = " SELECT
									orgsdsarrsls_vl, orgsdsarrsls_f
								FROM "._BdStr(DBM).TB_ORG_SDS_ARR_SLS."
									INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarrsls_arr = id_orgsdsarr
									INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
									INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
								WHERE
									id_orgsdsarrsls != ''
								AND org_enc = '".$this->i."' AND orgsdsarr_est = 1
								$qry_f ORDER BY orgsdsarrsls_f ASC";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';
						$Vl['tot'] = $Tot_DtRg;

						do {

							$r[$row_DtRg['orgsdsarrsls_f']]['date'] = $row_DtRg['orgsdsarrsls_f'];
							$r[$row_DtRg['orgsdsarrsls_f']]['tot'] = $row_DtRg['orgsdsarrsls_vl'];

						} while ($row_DtRg = $DtRg->fetch_assoc());

						$Vl_Grph = _jEnc($r);

						for( $i = $__dt_1 ; $i <= $__dt_2 ; $i = date("Y-m-d", strtotime($i ."+ 1 days")) ){
							$__ctg[] = $i;

							if(!isN($Vl_Grph->{$i}->tot)){ $_tot_1 = $Vl_Grph->{$i}->tot; }else{ $_tot_1 = 0; }

							$_medio_tot_1[] = intval($_tot_1);
						}

						$Vl['c'] = $__ctg;
						$Vl['o'] = $_medio_tot_1;


					}else{
						$Vl['tot'] = 0;
					}

				}else{
					$Vl['w'] = $__cnx->c_r->error;
				}

				$__cnx->_clsr($DtRg);

				return(_jEnc($Vl));
			}

			public function GtOrgDshNvlAtc($p=NULL){
                global $__cnx;

                $Vl['e'] = 'no';

                $query_DtRg = " SELECT
                                    *,
                                    COUNT( * ) AS tot
                                FROM
									"._BdStr(DBM).TB_ORG."
                                    INNER JOIN "._BdStr(DBM).TB_ORG_TP." ON orgtp_org = id_org
                                    INNER JOIN "._BdStr(DBM).TB_ORG_ATTR." ON orgattr_org = id_org
                                    INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON orgattr_nva = id_sisslc
                                WHERE
                                    orgtp_tp = 681
                                GROUP BY
                                    orgattr_nva";

                $Vl['ew'] = $query_DtRg;

                $DtRg = $__cnx->_qry($query_DtRg);

                if($DtRg){

                    $row_DtRg = $DtRg->fetch_assoc();
                    $Tot_DtRg = $DtRg->num_rows;

                    if($Tot_DtRg > 0){

                        $Vl['e'] = 'ok';
                        $Vl['tot'] = $Tot_DtRg;

                        do{
                            $r['ctg'][$row_DtRg['id_sisslc']] = $row_DtRg['sisslc_tt'];

                            $r['d'][$row_DtRg['orgattr_nva']]['nm'] = $row_DtRg['sisslc_tt'];
                            $r['d'][$row_DtRg['orgattr_nva']][$row_DtRg['id_sisslc']]['tot'] = $row_DtRg['tot'];

                        }while($row_DtRg = $DtRg->fetch_assoc());

                        $Vl_Grph = _jEnc($r);

                        foreach($Vl_Grph->ctg as $k => $v){
                            $__ctg[] = $v;

                            foreach($Vl_Grph->d as $_k => $_v){

                                $_d[$_k]['name'] = $_v->nm;
                                $_d[$_k]['data'][] = ( !isN($_v->{$k}->tot) ) ? (int)$_v->{$k}->tot : 0 ;

                            }

                        }

                        $Vl['c'] = $__ctg;
                        $Vl['o'] = $_d;

                    }else{
                        $Vl['tot'] = 0;
                    }

                }else{
                    $Vl['w'] = $__cnx->c_r->error;
                }

                $__cnx->_clsr($DtRg);

                return(_jEnc($Vl));
            }

		/* ------ Fin Graficas de Organizaciones ---- */

		public function GtOrgDshRowIn($p=NULL){
			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->tp_org)){

				$__enc = Enc_Rnd($this->tp_org.'-'.DB_CL_ID);

				$_org_tot = $this->GtOrgDshRowLs();

				$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_DSH_ROW." (orgdshrow_enc, orgdshrow_cl, orgdshrow_tp, orgdshrow_cols, orgdshrow_ord) VALUES ( %s, %s, %s, %s, %s )",
							GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
							GtSQLVlStr(ctjTx(DB_CL_ID, 'out'), "int"),
							GtSQLVlStr(ctjTx($this->tp_org, 'out'), "int"),
							GtSQLVlStr(ctjTx(1, 'out'), "int"),
							GtSQLVlStr(ctjTx(($_org_tot->tot)+1, 'out'), "int"));


				$Result = $__cnx->_prc($query_DtRg);

				if($Result){

					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
					$rsp['enc'] = $__enc;
					$rsp['id'] = $__cnx->c_p->insert_id;

				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}
			}



			return _jEnc($rsp);
		}

		public function GtOrgDshColIn($p=NULL){
			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->id_row)){

				$__enc = Enc_Rnd($this->id_row.'-'.DB_CL_ID);
				$_org_tot = $this->GtOrgDshRowColLs([ 'id'=> $this->id_row ]);

				$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_DSH_ROW_COL." (orgdshrowcol_enc, orgdshrowcol_orgdshrow, orgdshrowcol_ord) VALUES ( %s, %s, %s )",
							GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
							GtSQLVlStr(ctjTx($this->id_row, 'out'), "int"),
							GtSQLVlStr(ctjTx(($_org_tot->tot)+1, 'out'), "int"));


				$Result = $__cnx->_prc($query_DtRg);

				if($Result){

					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
					$rsp['enc'] = $__enc;
					$rsp['id'] = $__cnx->c_p->insert_id;

				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}
			}



			return _jEnc($rsp);
		}

		public function GtOrgDshRowDel($p=NULL){
			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->id_row)){

				$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_DSH_ROW." WHERE id_orgdshrow=%s AND orgdshrow_tp=%s",
									GtSQLVlStr($this->id_row, 'int'),
									GtSQLVlStr($this->tp_org, 'int'));

				$Result = $__cnx->_prc($query_DtRg);

				if($Result){
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}
			}

			return _jEnc($rsp);
		}

		public function GtOrgDshColDel($p=NULL){
			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->id_col)){

				$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_DSH_ROW_COL." WHERE orgdshrowcol_enc=%s",
									GtSQLVlStr($this->id_col, 'text'));

				$Result = $__cnx->_prc($query_DtRg);

				if($Result){
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}
			}

			return _jEnc($rsp);
		}

	}

?>