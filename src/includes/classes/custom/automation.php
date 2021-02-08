<?php


	class CRM_Atmt{

		function __construct($p=NULL) {

			global $__cnx;

	        $this->_aud = new CRM_Aud();

			if(!isN($p['cl'])){
				$this->cl = GtClDt($p['cl']);
				if(!isN($this->cl->bd)){ $this->bd = _BdStr($this->cl->bd); }else{ $this->bd = ''; }
				if(!isN($this->cl->enc)){ $this->c->enc = $this->cl->enc; }
				if(!isN($this->cl->sbd)){ $this->c->sbd = $this->cl->sbd; }
			}

	    }

	    function __destruct() {
	    }


	    public function _Mdl($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($p['atmt'])){

				$query_DtRg = "
					SELECT *
					FROM ".$this->bd.TB_MDL_ATMT."
						 INNER JOIN ".$this->bd.TB_MDL." ON mdlatmt_mdl = id_mdl
						 INNER JOIN ".DBA.".".TB_ATMT." ON mdlatmt_atmt = id_atmt
					WHERE mdlatmt_atmt='".$p['atmt']."'
					ORDER BY mdl_nm ASC";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';

						do{

							$Vl['ls'][$row_DtRg['mdl_enc']]['id'] = $row_DtRg['id_mdl'];
							$Vl['ls'][$row_DtRg['mdl_enc']]['enc'] = $row_DtRg['mdl_enc'];
							$Vl['ls'][$row_DtRg['mdl_enc']]['nm'] = ctjTx($row_DtRg['mdl_nm'],'in');

						}while($row_DtRg = $DtRg->fetch_assoc());
					}

				}else{

					$Vl['w'] = $__cnx->c_r->error;

				}
				$__cnx->_clsr($DtRg);
			}

			return _jEnc($Vl);

        }


	    public function _Mdl_Ls($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->atmt_enc)){

				$query_DtRg = sprintf("
										SELECT *,
											(	SELECT COUNT(*)
												FROM ".$this->bd.TB_MDL_ATMT."
													 INNER JOIN ".DBA.".".TB_ATMT." ON mdlatmt_atmt = id_atmt
												WHERE mdlatmt_mdl = id_mdl AND atmt_enc=%s
											) AS tot
										FROM ".$this->bd.TB_MDL."
											 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
											 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
										ORDER BY tot DESC, mdl_nm ASC",

										GtSQLVlStr(ctjTx($this->atmt_enc,'out'), "text")
					);

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						do{

							$Vl['ls'][$row_DtRg['mdl_enc']]['id'] = $row_DtRg['id_mdl'];
							$Vl['ls'][$row_DtRg['mdl_enc']]['enc'] = $row_DtRg['mdl_enc'];
							$Vl['ls'][$row_DtRg['mdl_enc']]['nm'] = ctjTx( '('.$row_DtRg['mdlstp_nm'].') '. $row_DtRg['mdl_nm'],'in');
							$Vl['ls'][$row_DtRg['mdl_enc']]['tot'] = $row_DtRg['tot'];

						}while($row_DtRg = $DtRg->fetch_assoc());
					}

				}else{

					$Vl['w'] = $__cnx->c_r->error;

				}

				$__cnx->_clsr($DtRg);
			}

			return _jEnc($Vl);

        }


		public function _Mdl_In($p=NULL){


			global $__cnx;


		    $_fl = "( SELECT id_mdl FROM ".$this->bd.TB_MDL." WHERE mdl_enc = '".$_POST['_mdl_enc']."' )";
		    $_fl1 = "( SELECT id_atmt FROM ".DBA.".".TB_ATMT." WHERE atmt_enc = '".$_POST['_atmt_enc']."' )";

			$query_DtRg =   sprintf("INSERT INTO ".$this->bd.TB_MDL_ATMT."
									(
										mdlatmt_mdl,
										mdlatmt_atmt
									)
									VALUES
									(
										$_fl,
										$_fl1
									)");

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


		public function _Mdl_Eli($p=NULL){

			global $__cnx;

			$query_DtRg =   sprintf("	DELETE FROM ".$this->bd.TB_MDL_ATMT."
										WHERE mdlatmt_mdl  IN

												( 	SELECT id_mdl
													FROM ".$this->bd.TB_MDL."
													WHERE mdl_enc = %s
												)

												AND mdlatmt_atmt  IN

												( 	SELECT id_atmt
													FROM ".DBA.".".TB_ATMT."
													WHERE atmt_enc = %s
												)",

								GtSQLVlStr(ctjTx($this->mdl_enc,'out'), "text"),
						        GtSQLVlStr(ctjTx($this->atmt_enc,'out'), "text"));

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



        public function _RgIn($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->atmtrg_tp.'-'.$this->atmtrg_atmt.'-'.$this->atmtrg_trgr.'-'.$this->atmtrg_act.'-'.$this->atmtrg_id.'-'.SISUS_ID);

			$query_DtRg =   sprintf("INSERT INTO ".DBA.".".TB_ATMT_RG." (atmtrg_enc, atmtrg_tp, atmtrg_atmt, atmtrg_trgr, atmtrg_act, atmtrg_id, atmtrg_exc, atmtrg_exc_w) VALUES (%s,%s,%s,%s,%s,%s,%s,%s)",
										GtSQLVlStr($__enc, "text"),
										GtSQLVlStr(ctjTx($this->atmtrg_tp,'out'), "text"),
										GtSQLVlStr($this->atmtrg_atmt, "int"),
										GtSQLVlStr($this->atmtrg_trgr, "int"),
										GtSQLVlStr($this->atmtrg_act, "int"),
										GtSQLVlStr(ctjTx($this->atmtrg_id,'out'), "text"),
										GtSQLVlStr($this->atmtrg_exc, "int"),
										GtSQLVlStr(ctjTx( implode(' | ', $this->atmtrg_exc_w) ,'out'), "text")
									); //echo compress_code($query_DtRg);

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
			}

			return _jEnc($rsp);

        }



		public function _Trgr_Upd($p=NULL){

			global $__cnx;

			if(!isN($p['enc'])){

				if(!isN($p['fa'])){ $_upd[] = sprintf('atmttrgr_fa=%s', GtSQLVlStr($p['fa'], "date")); }

				if(count($_upd) > 0){

					try {

						$updateSQL = "UPDATE ".DBA.".".TB_ATMT_TRGR." SET ".implode(',', $_upd)." WHERE atmttrgr_enc=".GtSQLVlStr( $p['enc'] , "text");
						$ResultUPD = $__cnx->_prc($updateSQL);

					} catch (Exception $e) {

						$rsp['w'] = $e->getMessage();

					}

				}

				if($ResultUPD){
					$rsp['e'] = 'ok';
				}else{
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['e'] = 'no';
				}

			}else{

				$rsp['e'] = 'no';
				$rsp['w'] = 'no all data';

			}

			return _jEnc($rsp);
		}


		public function AtmtPlcyChk($p=NULL){

	    	global $__cnx;

		    $_r['e']='no';

			if(!isN($p['atmt']) && !isN($p['plcy'])){

				$query_DtRg = sprintf('	SELECT *
										FROM '.DBA.'.'.TB_ATMT_PLCY.'
										WHERE atmtplcy_clplcy=%s AND atmtplcy_atmt=%s',
												GtSQLVlStr($p['plcy'], 'int'),
												GtSQLVlStr($p['atmt'], 'int'));

				$DtRg = $__cnx->_prc($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;


					if($Tot_DtRg==1){
						$_r['e']='ok';
						$_r['id']=$row_DtRg['id_atmtplcy'];
						$_r['enc']=$row_DtRg['atmtplcy_enc'];
					}
				}

			}

			return _jEnc($_r);

		}



		public function InAtmt_Plcy($p=NULL){

	    	global $__cnx;

	        if( !isN($this->plcy_id) && !isN($p['atmt']) ){

	            if(!isN($this->cnt_sndi)){ $__qry_sndi= $this->cnt_sndi; }else{ $__qry_sndi = 1; }

	            $__enc = Enc_Rnd($this->plcy_id.'-'.$p['cnt']);

	            $insertSQL = sprintf("INSERT INTO ".DBA.".".TB_ATMT_PLCY." (atmtplcy_enc, atmtplcy_clplcy, atmtplcy_atmt, atmtplcy_e) VALUES (%s, %s, %s, %s)",
	                       GtSQLVlStr($__enc, "text"),
	                       GtSQLVlStr($this->plcy_id, "int"),
	                       GtSQLVlStr($p['atmt'], "int"),
	                       GtSQLVlStr($__qry_sndi, "int"));

	            if(!isN($insertSQL)){
		            $_ntry = 0;
					do{ $Result = $__cnx->_prc($insertSQL); $_ntry++; if($Result){ break; } } while($_ntry == $this->n_try);
		        }

	            if($Result){
	                $_r['e'] = 'ok';
	                $_r['enc'] = $__enc;
	            }else{
		            $_r['w'] = $__cnx->c_p->error;
	            }

	        }else{

		        $_r['data'] = 'no';

	        }

	        return _jEnc($_r);
	    }



		public function UpdAtmt_Plcy($_p=NULL){

		    global $__cnx;

		    $_r['e'] = 'no';

	        if(!isN($_p['id'])){

	           	if(!isN($_p['e'])){ $_upd[] = sprintf('atmtplcy_e=%s', GtSQLVlStr($_p['e'], "int")); }

	           	if(count($_upd) > 0){

		            $updateSQL = sprintf("UPDATE ".DBA.".".TB_ATMT_PLCY." SET ".implode(',', $_upd)." WHERE id_atmtplcy=%s",
					                               GtSQLVlStr($_p['id'], "int"));

		            if(!isN($updateSQL)){
			            $_ntry = 0;
						do{ $Result = $__cnx->_prc($updateSQL); $_ntry++; if($Result){ break; } } while($_ntry == $this->n_try);
			        }

					if($Result){

			            $_r['e'] = 'ok';

			        }else{

			            $this->w_all .= $_r['w'] = $__cnx->c_p->error;

			        }

	            }

	        }

	        return _jEnc($_r);

	    }



    }
?>