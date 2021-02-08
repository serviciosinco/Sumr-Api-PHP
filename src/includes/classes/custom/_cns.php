<?php

	class AUTO_Cns extends API_CRM_Auto{



		private $___f_sis = '/includes/system/';
		private $___s_sis = '_sis';
		private $___s_sis_slc = '_sis_slc';
		private $___s_sis_ec = '_sis_ec';
		private $___s_sis_sms = '_sis_sms';
		private $___s_sis_md = '_sis_md';
		private $___s_sis_mdlstp = '_sis_mdlstp';

		private $__lng = 'es';
		private $__TS = ["'"];
		private $__TC = '';


		function __construct() {

			global $__cnx;
			global $__argv;

			$__cnx->_chkcnx();
			$this->_auto = new API_CRM_Auto([ 'argv'=>$__argv ]);
			$this->_aws = new API_CRM_Aws();

		}

		function __destruct() {

		}


		//-------------------- SAVE FILES --------------------//


			public function _svef($p=NULL){

				global $__cnx;

				$r['e'] = 'no';

				$__sis_dir = dirname( dirname( dirname( dirname(__FILE__) ) ) ).$this->___f_sis;
				$__sis_tt = $__sis_dir.$p['nm'].'.php';

				$r['fle'] = $__sis_tt;

				if(!isN($this->___f_sis) && !isN($__sis_tt) && substr_count($__sis_tt, 'system/') ){

					try {

						if( !isN($p['c']) || $p['frc']=='ok'){

							$__sis_tt_f = fopen($__sis_tt, 'w') or die("Unable to open file ".$__sis_tt." -> ".print_r(error_get_last(), true));

							if(fwrite($__sis_tt_f, compress_code( '<?php '. $p['c'] ) )){
								$r['e'] = 'ok';
							}

							fclose($__sis_tt_f);

						}

					} catch (Exception $e) {

					    echo $this->_auto->err($e->getMessage());

					}

				}else{

					$r['op'] = 'Can not open file';

				}

				return( _jEnc($r) );

			}


		//-------------------- INICIA CLIENTES --------------------//


			public function _cl(){

				global $__cnx;

				if(defined('TB_CL')){

					$Cl_Qry = "SELECT * FROM "._BdStr(DBM).TB_CL." WHERE cl_on = '1' ";
					$Ls_Cl = $__cnx->_qry($Cl_Qry);

					if($Ls_Cl){

						$row_Ls_Cl = $Ls_Cl->fetch_assoc();
						$Tot_Ls_Cl = $Ls_Cl->num_rows;

						$r['tot'] = $Tot_Ls_Cl;

						if($Tot_Ls_Cl > 0){
							do {

								$r['ls'][ $row_Ls_Cl['id_cl'] ] = [
																	'id'=>$row_Ls_Cl['id_cl'],
																	'bd'=>!isN($row_Ls_Cl['cl_sbd'])?DB_PRFX_CL.$row_Ls_Cl['cl_sbd']:'',
																	'enc'=>$row_Ls_Cl['cl_enc'],
																	'nm'=>ctjTx($row_Ls_Cl['cl_nm'],'in')
																];

							} while ($row_Ls_Cl = $Ls_Cl->fetch_assoc());
						}

					}

					$__cnx->_clsr($Ls_Cl);

				}

				return( _jEnc($r) );

			}


		//-------------------- INICIA IDIOMAS --------------------//


			public function _lng(){

				global $__cnx;

				if(defined('TB_SIS_LNG')){

					$Lng_Qry = "SELECT * FROM "._BdStr(DBM).TB_SIS_LNG."";
					$Ls_Lng = $__cnx->_qry($Lng_Qry);

					if($Ls_Lng){

						$row_Ls_Lng = $Ls_Lng->fetch_assoc();
						$Tot_Ls_Lng = $Ls_Lng->num_rows;

						$r['tot'] = $Tot_Ls_Lng;

						if($Tot_Ls_Lng > 0){
							do {

								$r['php'] .= ' $__lngall['.$row_Ls_Lng['id_sislng'].'] = ["id"=>"'.$row_Ls_Lng['lng_cod'].'",
																"tt"=>"'.ctjTx($row_Ls_Lng['sislng_tt_es'],'in').'",
																"flg"=>"'.ctjTx($row_Ls_Lng['sislng_flg'],'in').'",
																"img"=>_ImVrs(["img"=>"'.$row_Ls_Lng['sislng_img'].'", "f"=>URL_IMG_WEB_LNG])
															];';
								$r['o'][] = $row_Ls_Lng['sislng_cod'];

							} while ($row_Ls_Lng = $Ls_Lng->fetch_assoc());

						}
					}

					$__cnx->_clsr($Ls_Lng);


				}


				return( _jEnc($r) );
			}


		//-------------------- INICIA IDIOMAS - CLIENTES --------------------//


			public function _cl_lng(){

				global $__cnx;

				$r['prc'] = 'Sistema - Cliente - Idiomas ';

				$__lng = $this->_lng();
				$__cl = $this->_cl();

				if($__cl->tot > 0){

					foreach($__cl->ls as $__c){

		                $_tt_p = [];

		                if($__c->enc != NULL){

	                        $Tx_Qry = "SELECT * FROM ".$__c->bd.".sis_tx";

	                        $Ls_Tx = $__cnx->_qry($Tx_Qry);

	                        if($Ls_Tx){

		                        $row_Ls_Tx = $Ls_Tx->fetch_assoc();
		                        $Tot_Ls_Tx = $Ls_Tx->num_rows;

		                        if($Tot_Ls_Tx > 0){
		                            do {

		                                foreach($__lng->o as $_k => $_v){
		                                    $_tt_p[$_v] .= "define('".$row_Ls_Tx['sistex_var']."','". addslashes( ctjTx($row_Ls_Tx['sistex_vl_'.$_v],'in') )."');";
		                                }

		                            } while ($row_Ls_Tx = $Ls_Tx->fetch_assoc());
		                        }

		                        foreach($__lng->o as $_k => $_v){
		                            $_tt_p[$_v] .= $_tt_l;
		                        }


		                        foreach($__lng->o as $_k => $_v){
		                            $r['e']='no';
		                            $_sve = $this->_svef([ 'nm'=>'_tt_'.$__c->enc.'_'.$_v, 'c'=>$_tt_p[$_v] ]);
									if($_sve->e == 'ok'){ $r['e']='ok'; }
		                        }

	                        }

	                        $__cnx->_clsr($Ls_Tx);

		                }



		            }
				}

				return( _jEnc($r) );

			}



		//-------------------- TEXTOS CONSTANTES - SISTEMA --------------------//


            public function _sis_lng(){

                global $__cnx;

                if(defined('TB_SIS_TEX')){

	                $__lng = $this->_lng();
	                $r['prc'] = 'Sistema - Constantes Textos';

		            $Tx_Qry = "SELECT * FROM "._BdStr(DBM).TB_SIS_TEX;


		            $Ls_Tx = $__cnx->_qry($Tx_Qry);

		            if($Ls_Tx){

			            $row_Ls_Tx = $Ls_Tx->fetch_assoc();
			            $Tot_Ls_Tx = $Ls_Tx->num_rows;

			            if($Tot_Ls_Tx > 0){

			                do {

			                    foreach($__lng->o as $_k => $_v){
									$_tt_sis_p[$_v] .= "define('".$row_Ls_Tx['sistex_var']."','". addslashes( ctjTx($row_Ls_Tx['sistex_vl_'.$_v],'in') )."');";
									$_cns_sis_a[ $row_Ls_Tx['sistex_var'] ][ $_v ] = ctjTx($row_Ls_Tx['sistex_vl_'.$_v],'in');
			                    }

			                } while ($row_Ls_Tx = $Ls_Tx->fetch_assoc());
			            }

			            foreach($__lng->o as $_k => $_v){
			                $_tt_sis_p[$_v] .= $_tt_l;
			            }


			            foreach($__lng->o as $_k => $_v){
			                $r['e']='no';
		                    $_sve = $this->_svef([ 'nm'=>'_tt_'.$_v, 'c'=>$_tt_sis_p[$_v] ]);
							if($_sve->e == 'ok'){ $r['e']='ok'; }
			            }

						foreach($_cns_sis_a as $_k=>$_v){
							$_lng_a=[];
							foreach($__lng->o as $_k_l=>$_v_l){ $_lng_a[] = " '".$_v_l."'=>'".addslashes( ctjTx($_v[ $_v_l ],'in') )."' "; }
							$_cns_sis_s .= "define('G_".$_k."', [".implode(',', $_lng_a)."]);";
						}

						$_sve = $this->_svef([ 'nm'=>'_tt_all', 'c'=>$_cns_sis_s ]); // Save Constant Array
						if($_sve->e == 'ok'){ $r['e']='ok'; }

		            }

		            $__cnx->_clsr($Ls_Tx);


	            }

            }



		//-------------------- ELEMENTOS - MENU --------------------//


			public function _mnu(){

				global $__cnx;

				$Mnu_Qry = "SELECT *
							FROM "._BdStr(DBM).TB_CL_MNU."
								 LEFT JOIN "._BdStr(DBM).TB_CL_MNU_R." ON clmnur_clmnu = id_clmnu
								 INNER JOIN "._BdStr(DBM).TB_SIS_MNU_TP." ON clmnu_tp = id_sismnutp
							ORDER BY clmnur_cl ASC, clmnu_ord ASC";

				$Mnu = $__cnx->_qry($Mnu_Qry);

				if($Mnu){

					$row_Mnu = $Mnu->fetch_assoc();
					$Tot_Mnu = $Mnu->num_rows;

					$r['tot'] = $Tot_Mnu;

					if($Tot_Mnu > 0){

						do {

							$___id = $row_Mnu['id_clmnu'];
							$___cl = $row_Mnu['clmnur_cl'];

							if(!isN($row_Mnu['clmnu_img'])){ $t_img = DMN_FLE_CL_MNU.ctjTx($row_Mnu['clmnu_img'],'in'); }else{ $t_img = ''; }

							$__o = [
										'id'=>$___id,
										'nm'=>$row_Mnu['clmnu_tt'],
										'cns'=>$row_Mnu['clmnu_cns'],
										'cls'=>ctjTx($row_Mnu['clmnu_cls'],'in'),
										'cls_l'=>$row_Mnu['sismnutp_cls'],
										'cls_i'=>$row_Mnu['clmnur_cl'],
										'chckmd'=>mBln($row_Mnu['clmnu_chckmd']),
										'chckmd_v'=>$row_Mnu['clmnu_chckmd_v'],
										'shct'=>mBln($row_Mnu['clmnu_shct']),
										'spradmn'=>mBln($row_Mnu['clmnu_spradmn']),
										'main'=>mBln($row_Mnu['clmnu_main']),
										'clr_bck'=>ctjTx($row_Mnu['clmnur_clr_bck'],'in'),
										'clr_fnt'=>ctjTx($row_Mnu['clmnur_clr_fnt'],'in'),
										'rel'=>$row_Mnu['clmnu_rel'],
										'rel_sub'=>$row_Mnu['clmnu_rel_sub'],
										'rel_tp'=>$row_Mnu['clmnu_rel_tp'],
										'rel_data'=>$row_Mnu['clmnu_rel_data'],

										'pop'=>mBln($row_Mnu['clmnu_pop']),
										'pop_w'=>ctjTx($row_Mnu['clmnu_pop_w'],'in'),
										'pop_h'=>ctjTx($row_Mnu['clmnu_pop_h'],'in'),

										'cche'=>mBln($row_Mnu['clmnu_cche']),

										'img'=>$t_img,
										'ord'=>$row_Mnu['clmnu_ord'],
										'lnk'=>$row_Mnu['clmnu_lnk'],
										'prnt'=>$row_Mnu['clmnu_prnt']
									];

							if(mBln($row_Mnu['clmnu_sis'])=='ok' && mBln($row_Mnu['main'])=='no'){
								$___grp = 'sis';
								$r['ls'][$___grp][$___id] = $__o;
							}elseif(mBln($row_Mnu['clmnu_main'])=='ok'){
								$___grp = 'main';
								$r['ls'][$___grp][$___cl][$___id] = $__o;
							}else{
								$___grp = 'bar';
								$r['ls'][$___grp][$___cl][$___id] = $__o;
							}

						} while ($row_Mnu = $Mnu->fetch_assoc());

					}


				}

				$__cnx->_clsr($Mnu);

				return( $r );

			}


		//-------------------- ELEMENTOS - MENU - CLIENTES --------------------//

			public function _cl_mnu(){

				global $__cnx;

				$r['e']='no';
				$r['prc']= 'Sistema - Cliente - Menu ';

				$__cl = $this->_cl();
				$_mnu = $this->_mnu();

				$r['sve'] = [];

				/*---------------------------- BUILD CUSTOMER MERNU ----------------------------*/

					if($__cl->tot > 0){

						foreach($__cl->ls as $__c){

							$r['e']='no';
							$_mnu_s = '';

							if(!isN($__c->enc) && !isN($_mnu)){

								$r['e']='no';

								$__phpcnt_bar = _bTree( $_mnu['ls']['bar'][$__c->id] );
								$__phpcnt_sis = _bTree( $_mnu['ls']['sis'] );
								$__phpcnt_main = _bTree( $_mnu['ls']['main'][$__c->id] );


								$_mnu_s .= '/* MENU - '.$__c->nm." */ \n";
								$_mnu_s .= ' $_mnu_bar = \'['. stripslashes( $__phpcnt_bar ) .']\'; ';
								$_mnu_s .= ' $_mnu_sis = \'['. stripslashes( $__phpcnt_sis ) .']\'; ';
								$_mnu_s .= ' $_mnu_main = \'['. stripslashes( $__phpcnt_main ) .']\'; ';


				                 $_sve = $this->_svef([ 'nm'=>'_mnu_'.$__c->enc, 'c'=>$_mnu_s ]);
								if($_sve->e == 'ok'){ $r['e']='ok'; }

								$r['sve'][] = [
									'f'=>$_sve->fle,
									'prc'=>[
										'wrt'=>$_wrt,
										'cls'=>$__cls
									]
								];

	                        	$_sve = $this->_svef([ 'nm'=>'_mnu_'.$__c->enc, 'c'=>$_mnu_s ]);
								if($_sve->e == 'ok'){ $r['e']='ok'; }

							}

						}
					}


				return( _jEnc($r) );
			}


		//-------------------- SISTEMA CONSTANTES - CLIENTES --------------------//


			public function _sis(){

				global $__cnx;

				$r['e']='no';

				if(defined('TB_SIS') && !isN(TB_SIS)){
					$Sis_Qry = "SELECT * FROM "._BdStr(DBM).TB_SIS."";
				}else{
					$Sis_Qry = "SELECT * FROM ".DBM."._sis";
				}

				if(!isN($Sis_Qry)){

					$Ls_Tx = $__cnx->_qry($Sis_Qry);

					if($Ls_Tx){

						$row_Ls_Tx = $Ls_Tx->fetch_assoc();
						$Tot_Ls_Tx = $Ls_Tx->num_rows;

					}else{

						echo $this->_auto->err( 'Error Function _sis() '.$Sis_Qry.' ->'.$__cnx->c_r->error );
						echo $this->_auto->err( 'Data Connection?' );
						echo $this->_auto->err( print_r($__cnx, true) );

					}

					if($Tot_Ls_Tx > 0){
						do {
							$_tt_sis_s .= "define('".str_replace($this->__TS, $this->__TC, $row_Ls_Tx['sis_var'])."','". addslashes( ctjTx($row_Ls_Tx['sis_vl'],'in') )."');";
						} while ($row_Ls_Tx = $Ls_Tx->fetch_assoc());
					}


					$__cnx->_clsr($Ls_Tx);

	                if(!isN($_tt_sis_s)){ $_sve = $this->_svef([ 'nm'=>$this->___s_sis, 'c'=>$_tt_sis_s ]); }

					if($_sve->e == 'ok'){
						$r['e']='ok';
						echo $this->_auto->scss('Saved OK');
					}else{
						echo $this->_auto->err('Not saved!');
					}

				}



				return( _jEnc($r) );
			}



		//-------------------- VARIABLES CONSTANTES - SISTEMA --------------------//


			public function _cl_sis(){

				global $__cnx;

				$__cl = $this->_cl();

				if($__cl->tot > 0){

					foreach($__cl->ls as $__c){

						$r['e']='no';

						$_tt_cl_s = '';

						if(!isN($__c->enc) && !isN($__c->bd)){

							echo $this->_auto->li( 'Build _cl_sis() to '. strtolower($__c->bd) );

							$Sis_Qry = "SELECT * FROM ".strtolower($__c->bd).".sis";
							$Ls_Tx = $__cnx->_qry($Sis_Qry);

							if($Ls_Tx){

								$row_Ls_Tx = $Ls_Tx->fetch_assoc();
								$Tot_Ls_Tx = $Ls_Tx->num_rows;

								if($Tot_Ls_Tx > 0){
									do {
										$_tt_cl_s .= "define('".str_replace($this->__TS, $this->__TC, $row_Ls_Tx['sis_var'])."','". addslashes( ctjTx( str_replace($this->__TS, $this->__TC, $row_Ls_Tx['sis_vl'] ),'in') )."');";
									} while ($row_Ls_Tx = $Ls_Tx->fetch_assoc());
								}

								$_sve = $this->_svef([ 'nm'=>'_sis_'.$__c->enc, 'c'=>$_tt_cl_s, 'frc'=>'ok' ]);

								if($_sve->e == 'ok'){
									$r['e']='ok';
									echo $this->_auto->scss('Saved OK');
								}else{
									echo $this->_auto->err('Not saved!');
								}

							}

							$__cnx->_clsr($Ls_Tx);

						}
					}

				}

			}

		//-------------------- SISTEMA ID - CLIENTES --------------------//

			public function _cl_id(){

				global $__cnx;

				$r['e']='no';

				if(defined('TB_CL')){

					$Sis_Qry = "SELECT * FROM "._BdStr(DBM).TB_CL." WHERE id_cl IS NOT NULL";
					$Ls_Tx = $__cnx->_qry($Sis_Qry);

					if($Ls_Tx){

						$row_Ls_Tx = $Ls_Tx->fetch_assoc();
						$Tot_Ls_Tx = $Ls_Tx->num_rows;

						if($Tot_Ls_Tx > 0){
							do {
								$_cl_id .= "define('".strtoupper( 'CL_'.ctjTx($row_Ls_Tx['cl_sbd'],'in') )."','". ctjTx($row_Ls_Tx['cl_enc'],'in') ."');";
							} while ($row_Ls_Tx = $Ls_Tx->fetch_assoc());
						}


		                $_sve = $this->_svef([ 'nm'=>'_cl_id', 'c'=>$_cl_id ]);
						if($_sve->e == 'ok'){ $r['e']='ok'; }

					}

					$__cnx->_clsr($Ls_Tx);

				}

				return( _jEnc($r) );
			}

		//-------------------- SISTEMA ID - CLIENTES --------------------//

			public function _cl_data_a($p=null){

				$k = $p['k'];
				$d = $p['d'];
				$lv = !isN($p['l'])?$p['l']:1;

				if(!isN($d) || $d==0){
					if(is_array($d) || is_object($d)){
						foreach($d as $dk=>$dd){
							if(!isN($dd) || $dd==0){
								$o[] = $this->_cl_data_a([ 'k'=>$dk, 'd'=>$dd, 'l'=>$lv++ ]);
							}
						}
						if(!isN($o)){
							if($lv==1 || isN($k)){
								$r = '['.implode(',', $o).']';
							}else{
								$r = '"'.$k.'"=>['.implode(',', $o).']';
							}
						}
					}else{
						if(!isN($k)){
							if($lv==1){
								$r = '"'.$k.'"=>"'.$d.'"';
							}else{
								$r = '"'.$k.'"=>"'.$d.'"';
							}
						}
					}
				}

				if(!isN($r)){ return $r; }

			}

			public function _cl_data(){

				global $__cnx;

				$r['e']='no';

				if(defined('TB_CL')){

					$Sis_Qry = "SELECT *
								FROM "._BdStr(DBM).TB_CL."
								WHERE id_cl IS NOT NULL";

					$LsData = $__cnx->_qry($Sis_Qry);

					if($LsData){

						$row_LsData = $LsData->fetch_assoc();
						$Tot_LsData = $LsData->num_rows;

						if($Tot_LsData > 0){

							do {

								echo $this->h1( 'Data for '.ctjTx($row_LsData['cl_nm'],'in') );

								$_c=[];

								$_c[] = '"on"=>"'.mBln($row_LsData['cl_on']).'"';
								$_c[] = '"id"=>'.$row_LsData['id_cl'];
								$_c[] = '"nm"=>"'.ctjTx($row_LsData['cl_nm'],'in').'"';

								$_c[] = '"sbd"=>"'.ctjTx($row_LsData['cl_sbd'],'in').'"';
								$_c[] = '"enc"=>"'.ctjTx($row_LsData['cl_enc'],'in').'"';
								$_c[] = '"prfl"=>"'.ctjTx($row_LsData['cl_prfl'],'in').'"';
								$_c[] = '"bd"=>"'.PRFX_SERV.'_c_'.$row_LsData['cl_sbd'].'"';


								//---------- Now Get Account System Tags ----------//

									$_tag = $this->_cl_data_a([ 'd'=>GtClTagLs([ 'id'=>$row_LsData['id_cl'] ]) ]);
									if(!isN($_tag)){ $_c[] = '"tag"=>'.$_tag.''; }

								//---------- Now Get Domain and Subdomains ----------//

									$_dmn = $this->_cl_data_a([ 'd'=>GtClDmnLs([ 'id'=>$row_LsData['id_cl'] ]) ]);
									if(!isN($_dmn)){ $_c[] = '"dmn"=>'.$_dmn.''; }

								//---------- Now Get Email Accounts ----------//

									$_eml = $this->_cl_data_a([ 'd'=>GtClEmlLs([ 'id'=>$row_LsData['id_cl'] ]) ]);
									if(!isN($_eml)){ $_c[] = '"eml"=>'.$_eml.''; }

								//---------- Now Get Domain and Subdomains ----------//

									$_mdlstp = $this->_cl_data_a([ 'd'=>GtClMdlSTpLs([ 'id'=>$row_LsData['id_cl'] ]) ]);
									if(!isN($_mdlstp)){ $_c[] = '"mdlstp"=>'.$_mdlstp.''; }

								//---------- Now get images ----------//

									$_img = $this->_cl_data_a([ 'd'=>_ImVrs([ 'img'=>$row_LsData['cl_img'], 'f'=>DMN_FLE_CL ]) ]);
									if(!isN($_img)){ $_c[] = '"img"=>'.$_img.''; }

									$_img_bck['main'] = _ImVrs([ 'img'=>$row_LsData['cl_img'], 'f'=>DMN_FLE_CL_BCK ]);
									$_img_bck['app'] = _ImVrs([ 'img'=>$row_LsData['cl_img'], 'f'=>DMN_FLE_CL_BCK_APP ]);
									if(!isN($_img_bck)){ $_c[] = '"bck"=>'.$this->_cl_data_a([ 'd'=>$_img_bck ]).''; }

									$_img_logo['main'] = _ImVrs([ 'img'=>$row_LsData['cl_enc'].'.svg', 'f'=>DMN_FLE_CL_LGO ]);
									$_img_logo['lght'] = _ImVrs([ 'img'=>$row_LsData['cl_enc'].'.svg', 'f'=>DMN_FLE_CL_LGO_LGHT ]);
									$_img_logo['ico'] = _ImVrs([ 'img'=>$row_LsData['cl_enc'].'.ico', 'f'=>DMN_FLE_CL_LGO_ICO ]);
									$_img_logo['rsllr'] = _ImVrs([ 'img'=>$row_LsData['cl_enc'].'.svg', 'f'=>DMN_FLE_CL_LGO_RSLLR ]);
									if(!isN($_img_bck)){ $_c[] = '"lgo"=>'.$this->_cl_data_a([ 'd'=>$_img_logo ]).''; }

								//---------- Chat Status ----------//

									$_c[] = '"chat"=>"'.mBln($row_LsData['cl_chat']).'"';

								//---------- Save Data On ----------//

									$_cl_data .= "define('".strtoupper( 'CL_DATA_'.ctjTx($row_LsData['cl_sbd'],'in') )."', [".compress_code( implode(',',$_c) )."] );";
									$_cl_data .= "define('".strtoupper( 'CL_DATAID_'.ctjTx($row_LsData['cl_prfl'],'in') )."', [".compress_code( implode(',',$_c) )."] );";


							} while ($row_LsData = $LsData->fetch_assoc());

						}

		                $_sve = $this->_svef([ 'nm'=>'_cl_data', 'c'=>$_cl_data ]);
						if($_sve->e == 'ok'){ $r['e']='ok'; }

					}

					$__cnx->_clsr($LsData);

				}

				return( _jEnc($r) );
			}

		//-------------------- SISTEMA CONSTANTES - LISTAS SISTEMA --------------------//


			public function _sis_slc(){

				global $__cnx;

				$r['e']='no';

				if(defined('TB_SIS_SLC')){

					$Sis_Qry = "SELECT * FROM "._BdStr(DBM).TB_SIS_SLC." INNER JOIN "._BdStr(DBM).TB_SIS_SLC_TP." ON sisslc_tp = id_sisslctp WHERE sisslc_cns IS NOT NULL";
					$Ls_Tx = $__cnx->_qry($Sis_Qry);

					if($Ls_Tx){

						$row_Ls_Tx = $Ls_Tx->fetch_assoc();
						$Tot_Ls_Tx = $Ls_Tx->num_rows;

						if($Tot_Ls_Tx > 0){
							do {
								$_tt_sis_s .= "define('".strtoupper( 'ID_'.str_replace('_','',ctjTx($row_Ls_Tx['sisslctp_key'],'in')).'_'.ctjTx($row_Ls_Tx['sisslc_cns'],'in') )."','". addslashes( ctjTx($row_Ls_Tx['id_sisslc'],'in') )."');";
							} while ($row_Ls_Tx = $Ls_Tx->fetch_assoc());
						}


		                $_sve = $this->_svef([ 'nm'=>$this->___s_sis_slc, 'c'=>$_tt_sis_s ]);
						if($_sve->e == 'ok'){ $r['e']='ok'; }

					}

					$__cnx->_clsr($Ls_Tx);

				}

				return( _jEnc($r) );
			}


		//-------------------- SISTEMA CONSTANTES - PUSHMAIL --------------------//


			public function _sis_ec(){

				global $__cnx;

				$r['e']='no';

				if(defined('TB_EC')){

					$Sis_Qry = "SELECT * FROM "._BdStr(DBM).TB_EC." WHERE ec_key IS NOT NULL";
					$Ls_Tx = $__cnx->_qry($Sis_Qry);

					if($Ls_Tx){

						$row_Ls_Tx = $Ls_Tx->fetch_assoc();
						$Tot_Ls_Tx = $Ls_Tx->num_rows;

						if($Tot_Ls_Tx > 0){
							do {
								$_tt_sis_s .= "define('".strtoupper( 'EC_'.str_replace('_','',ctjTx($row_Ls_Tx['ec_key'],'in')) )."','". addslashes( ctjTx($row_Ls_Tx['id_ec'],'in') )."');";
							} while ($row_Ls_Tx = $Ls_Tx->fetch_assoc());
						}


		                $_sve = $this->_svef([ 'nm'=>$this->___s_sis_ec, 'c'=>$_tt_sis_s ]);
						if($_sve->e == 'ok'){ $r['e']='ok'; }

					}

					$__cnx->_clsr($Ls_Tx);

				}

				return( _jEnc($r) );
			}


			public function _sis_md(){

				global $__cnx;

				$r['e']='no';

				if(defined('TB_SIS_MD')){

					$Sis_Qry = "SELECT * FROM "._BdStr(DBM).TB_SIS_MD." WHERE sismd_key IS NOT NULL";
					$Ls_Tx = $__cnx->_qry($Sis_Qry);

					if($Ls_Tx){

						$row_Ls_Tx = $Ls_Tx->fetch_assoc();
						$Tot_Ls_Tx = $Ls_Tx->num_rows;

						if($Tot_Ls_Tx > 0){
							do {
								$_tt_sis_s .= "define('".strtoupper( 'SIS_MD_'.str_replace('_','',ctjTx($row_Ls_Tx['sismd_key'],'in')) )."','". addslashes( ctjTx($row_Ls_Tx['id_sismd'],'in') )."');";
							} while ($row_Ls_Tx = $Ls_Tx->fetch_assoc());
						}


		                $_sve = $this->_svef([ 'nm'=>$this->___s_sis_md, 'c'=>$_tt_sis_s ]);
						if($_sve->e == 'ok'){ $r['e']='ok'; }

					}

					$__cnx->_clsr($Ls_Tx);

				}

				return( _jEnc($r) );
			}


			public function _sis_mdls_tp(){

				global $__cnx;

				$r['e']='no';

				if(defined('TB_MDL_S_TP')){

					$Sis_Qry = "SELECT * FROM "._BdStr(DBM).TB_MDL_S_TP." WHERE mdlstp_tp IS NOT NULL";
					$Ls_Tx = $__cnx->_qry($Sis_Qry);

					if($Ls_Tx){

						$row_Ls_Tx = $Ls_Tx->fetch_assoc();
						$Tot_Ls_Tx = $Ls_Tx->num_rows;

						if($Tot_Ls_Tx > 0){
							do {
								$_tt_sis_mdlstp .= "define('".strtoupper( 'SIS_MDLSTP_'.str_replace('_','',ctjTx($row_Ls_Tx['mdlstp_tp'],'in')) )."','". addslashes( ctjTx($row_Ls_Tx['id_mdlstp'],'in') )."');";
							} while ($row_Ls_Tx = $Ls_Tx->fetch_assoc());
						}


		                $_sve = $this->_svef([ 'nm'=>$this->___s_sis_mdlstp, 'c'=>$_tt_sis_mdlstp ]);
						if($_sve->e == 'ok'){ $r['e']='ok'; }

					}

					$__cnx->_clsr($Ls_Tx);

				}

				return( _jEnc($r) );
			}


			public function _sis_sms(){

				global $__cnx;

				$r['e']='no';

				if(defined('TB_SMS')){

					$Sis_Qry = "SELECT * FROM "._BdStr(DBM).TB_SMS." WHERE sms_key IS NOT NULL";
					$Ls_Tx = $__cnx->_qry($Sis_Qry);

					if($Ls_Tx){

						$row_Ls_Tx = $Ls_Tx->fetch_assoc();
						$Tot_Ls_Tx = $Ls_Tx->num_rows;

						if($Tot_Ls_Tx > 0){
							do {
								$_tt_sis_s .= "define('".strtoupper( 'SMS_'.str_replace('_','',ctjTx($row_Ls_Tx['sms_key'],'in')) )."','". addslashes( ctjTx($row_Ls_Tx['id_sms'],'in') )."');";
							} while ($row_Ls_Tx = $Ls_Tx->fetch_assoc());
						}


		                $_sve = $this->_svef([ 'nm'=>$this->___s_sis_sms, 'c'=>$_tt_sis_s ]);
						if($_sve->e == 'ok'){ $r['e']='ok'; }

					}

					$__cnx->_clsr($Ls_Tx);

				}

				return( _jEnc($r) );
			}


			public function _sis_ps(){

				global $__cnx;

				$r['e']='no';

				if(defined('TB_SIS_PS')){

					$Sis_Ps = "SELECT * FROM "._BdStr(DBM).TB_SIS_PS." ORDER BY sisps_tt ASC";
					$Ls_Ps = $__cnx->_qry($Sis_Ps);

					if($Ls_Ps){

						$row_Ls_Ps = $Ls_Ps->fetch_assoc();
						$Tot_Ls_Ps = $Ls_Ps->num_rows;

						$_tt_sis_ps['tot'] = $Tot_Ls_Ps;

						if($Tot_Ls_Ps > 0){
							do {
								$_tt_sis_ps['ls'][] = [
									'id'=>ctjTx($row_Ls_Ps['id_sisps'],'in'),
									'tt'=>ctjTx($row_Ls_Ps['sisps_tt'],'in'),
									'tel'=>ctjTx($row_Ls_Ps['sisps_tel'],'in'),
									'iso2'=>ctjTx($row_Ls_Ps['sisps_iso2'],'in')
								];
							} while ($row_Ls_Ps = $Ls_Ps->fetch_assoc());
						}

						$_data = _jEnc( $_tt_sis_ps );
						$_json = 'sumrJsonPs('.cmpr_fm( json_encode($_data) ).')';
						$_sve_json = $this->_aws->_s3_put([ 'b'=>'js', 'fle'=>'sis/ps.json', 'cbdy'=>$_json, 'ctp'=>'application/json' ]);
						if($_sve_json->e == 'ok'){ $r['e']='ok'; }

					}

					$__cnx->_clsr($Ls_Ps);

				}

				return( _jEnc($r) );
			}


			public function _sis_cd(){

				global $__cnx;

				$r['e']='no';

				if(defined('TB_SIS_CD')){

					$Sis_Cd = "	SELECT *
								FROM "._BdStr(DBM).TB_SIS_CD."
									 INNER JOIN "._BdStr(DBM).TB_SIS_CD_DP." ON siscd_dp = id_siscddp
									 INNER JOIN "._BdStr(DBM).TB_SIS_PS." ON siscddp_ps = id_sisps
								WHERE siscd_vrf = 1
								ORDER BY siscd_tt ASC";

					$Ls_Cd = $__cnx->_qry($Sis_Cd);

					if($Ls_Cd){

						$row_Ls_Cd = $Ls_Cd->fetch_assoc();
						$Tot_Ls_Cd = $Ls_Cd->num_rows;

						$_tt_sis_cd['tot'] = $Tot_Ls_Cd;

						if($Tot_Ls_Cd > 0){
							do {

								$_id_ps = $row_Ls_Cd['id_sisps'];
								$_id_dp = $row_Ls_Cd['id_siscddp'];
								$_id_cd = $row_Ls_Cd['id_siscd'];

								$_tt_sis_cd['ls'][ $_id_ps ]['dp'][$_id_dp]['id'] = ctjTx($row_Ls_Cd['id_siscddp'],'in');
								$_tt_sis_cd['ls'][ $_id_ps ]['dp'][$_id_dp]['tt'] = ctjTx($row_Ls_Cd['siscddp_tt'],'in');
								$_tt_sis_cd['ls'][ $_id_ps ]['dp'][$_id_dp]['cd']['ls'][ $_id_cd ]['id'] = ctjTx($row_Ls_Cd['id_siscd'],'in');
								$_tt_sis_cd['ls'][ $_id_ps ]['dp'][$_id_dp]['cd']['ls'][ $_id_cd ]['tt'] = ctjTx($row_Ls_Cd['siscd_tt'],'in');
								$_tt_sis_cd['ls'][ $_id_ps ]['dp'][$_id_dp]['cd']['ls'][ $_id_cd ]['tt'] = ctjTx($row_Ls_Cd['siscd_tt'],'in');

							} while ($row_Ls_Cd = $Ls_Cd->fetch_assoc());
						}

						$_data = _jEnc( $_tt_sis_cd );
						$_json = 'sumrJsonCd('.cmpr_fm( json_encode($_data) ).')';
						$_sve_json = $this->_aws->_s3_put([ 'b'=>'js', 'fle'=>'sis/cd/all.json', 'cbdy'=>$_json, 'ctp'=>'application/json' ]);
						if($_sve_json->e == 'ok'){ $r['e']='ok'; }

					}

					$__cnx->_clsr($Ls_Cd);

				}

				return( _jEnc($r) );
			}

	}


?>