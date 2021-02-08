<?php

	class CRM_Ws{

		function __construct() {

	    }

	    function __destruct() {

	    }

		public function DvcChk($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->usdvc_us) && !isN($this->usdvc_id)){

				$query_DtRg = sprintf('
								SELECT *
								FROM '._BdStr(DBM).TB_US_DVC.'
									 INNER JOIN '._BdStr(DBM).TB_US.' ON usdvc_us=id_us
								WHERE id_usdvc != "" AND usdvc_us=%s AND usdvc_id=%s
								LIMIT 1',
								GtSQLVlStr($this->usdvc_us, 'text'),
								GtSQLVlStr($this->usdvc_id, 'text')
							);

				//$rsp['q'] = compress_code( $query_DtRg );
				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg == 1){
						$rsp['e'] = 'ok';
						$rsp['id'] = $row_DtRg['id_usdvc'];
					}

				}else{

					$rsp['w'] = $__cnx->c_r->error;

				}

				$__cnx->_clsr($DtRg);

			}else{

				$rsp['w'] = 'No data on P';

			}

			return _jEnc($rsp);
		}


		public function Dvc($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->usdvc_us) && !isN($this->usdvc_id)){

				$__chk = $this->DvcChk();

				//$rsp['chk'] = $__chk;

				if($__chk->e != 'ok' && isN($__chk->id)){

					$usdvc_enc = Enc_Rnd($this->usdvc_us.'-'.$this->usdvc_id);

					if($this->usdvc_web == 'ok'){
						$_tp_f = 'usdvc_web';
					}elseif($this->usdvc_ios == 'ok'){
						$_tp_f = 'usdvc_ios';
					}elseif($this->usdvc_android == 'ok'){
						$_tp_f = 'usdvc_android';
					}

					$_sql_s = sprintf("INSERT INTO "._BdStr(DBM).TB_US_DVC." (usdvc_enc, usdvc_cl, usdvc_us, usdvc_id, ".$_tp_f.") VALUES (%s, %s, %s, %s, %s)",
												GtSQLVlStr($usdvc_enc, "text"),
												GtSQLVlStr($this->usdvc_cl, "int"),
												GtSQLVlStr($this->usdvc_us, "int"),
												GtSQLVlStr($this->usdvc_id, "text"),
												GtSQLVlStr(1, "int"));

					$rsp['q'] = compress_code( $_sql_s );

					if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }

					if($Result_RLC){
						$rsp['e'] = 'ok';
						$rsp['id'] = $__cnx->c_p->insert_id;
					}else{
						$rsp['w'] = 'No result:'.$__cnx->c_p->error;
					}

				}else{

					$rsp['e'] = 'ok';
					$rsp['id'] = $__chk->id;
					$rsp['m'] = 'Device Exists';

				}

			}else{

				$rsp['w'] = TX_FLTDTINC;
				$rsp['usdvc_us'] = $this->usdvc_us;
				$rsp['usdvc_id'] = $this->usdvc_id;

			}

			return _jEnc($rsp);
		}

		public function Send($p=NULL){

			$__r['e'] = 'no';

			if(!isN($p['to']) && !isN($p['srv']) && !isN($p['act'])){

				$msg = [
							'type'=>'ws',
							'service'=>$p['srv'],
							'action'=>$p['act'],
							'tp'=>'snd',
							'to'=>$p['to'], // Recibe
							'from'=>( !isN($p['from'])?$p['from']:'crm' ), // Transmite
							'sadmin'=>$p['sadmin'] // Incluye todos los superadmin
						];

				if(!isN( $p['data'] )){ // More data to send - Extend
					foreach($p['data'] as $_data_k=>$_data_v){
						$msg[ $_data_k ] = $_data_v;
					}
				}

				$exc = 	__AutoRUN([
							'__e'=>'no',
							'exec'=>'no',
							'ssh'=>'no',
							'rndm'=>'no',
							'twrk'=>'njs',
							'msg'=>$msg
						]);

				if(!isN($exc->rsl)){
					$__r['rsl'] = json_decode($exc->rsl);
					$__r['code'] = $exc->code;
					if(Dvlpr()){ $__r['exc'] = $exc; }
				}else{
					$__r['w'] = 'no execute';
					$__r['d'] = $exc;
				}

			}else{

				$__r['w'] = 'no all data';
				$__r['to'] = $p['to'];
				$__r['srv'] = $p['srv'];
				$__r['act'] = $p['act'];

				$__r = print_r( $__r, true );
			}

			return _jEnc($__r);

		}

		public function UpdF($p=NULL){

            global $__cnx;

            $rsp['e'] = 'no';

            if(!isN($p)){

                if($p['t']=='dvc'){ $tb=TB_US_DVC; $fld=$p['f']; $id='id_usdvc'; }

                if(!isN($p['f'])){
                    foreach($p['f'] as $_f_k=>$_f_v){
                        if(!isN($_f_v) || $_f_v == NULL){
                            $_upd[] = sprintf($_f_k.'=%s', GtSQLVlStr($_f_v, "text"));
                        }
                    }
                }

                if(!isN($tb) && !isN( $p['id'] )){

                    $updateSQL = sprintf("UPDATE "._BdStr(DBM).$tb." SET ".implode(',', $_upd)."  WHERE ".$id."=%s",
                                       GtSQLVlStr($p['id'], "int"));

                    $Result = $__cnx->_prc($updateSQL);

                    if($Result){
                        $rsp['e'] = 'ok';
                    }else{
                        $rsp['w'] = $__cnx->c_p->error;
                        $rsp['q'] = $updateSQL;
                    }

                } else{

                    $rsp['w'] = 'No tb/id data';

                }

            }else{

                $rsp['w'] = 'No p data';

            }

            return _jEnc($rsp);
		}


	}

?>