<?php

if(class_exists('CRM_Cnx')){

	//-------------------- REQUEST GET --------------------//



	//-------------------- CONSTANTES --------------------//


	class AUTO_Fnc {


		private $___f_cls = '../includes/classes/custom/';
		private	$___s_cls = '_slc';
		private $__lng = 'es';

		function __construct() {

	    }

		function __destruct() {

	   	}


		//-------------------- SAVE FILES --------------------//

			public function _svef($p=NULL){



				$r['e'] = 'no';
				$__cls_tt = $this->___f_cls.$p['nm'].'.php';

				$r['fle'] = $__cls_tt;
				if(!isN($this->___f_cls) && !isN($__cls_tt) && substr_count($__cls_tt, 'custom/') ){

					$__cls_tt_f = fopen($__cls_tt, "w") or die("Unable to open file ".$__cls_tt);
					fwrite($__cls_tt_f, compress_code($p['c']) );
					fclose($__cls_tt_f);
					$r['e'] = 'ok';

				}else{
					$r['op'] = 'Can not open file';
				}
				return( _jEnc($r) );

			}

		//-------------------- CONSULTA FUNCIONES SLC --------------------//


			public function _sis_fnc_slc(){

				$r['e']='no';

				$_tt_sis_s .= '<?php


					class CRM_Slc extends CRM_Cl{

					    function __construct() {
							parent::__construct();
					    }

					    function __destruct() {
					       parent::__destruct();
					   	}


						public function _attr($p=NULL){
							if(!isN($p["a"])){
								foreach($p["a"] as $_attr_k=>$_attr_v){ $html_attr .= " ".$_attr_k."=\'".$_attr_v."\' "; }
							}
							return $html_attr;
						}

						public function _slcbx($p=NULL){
							if($p["rq"]=="ok"){$Rq="";}else{$Rq=FMRQD;}
							if($p["m"]=="ok"||$p["m"]=="sch"){
								$__m = " size=\'7\' multiple=\'multiple\' ";
								$__nm = $p["id"]."[]";
							}else{
								$__m = ""; $__nm = $p["id"];
							}
							$_lb = Lb($p["ph"]);
							$_r = $_lb."<select name=\'".$__nm."\' data-placeholder=\'".$p["ph"]."\' id=\'".$p["id"]."\' ".$__m." ".$this->_attr([ "a"=>$p["attr"] ])." ".$Rq." autocomplete=\'off\' >";
							$_r .= $p["c"];
							$_r .= "</select>";
							return($_r);

						}

						public function _ovlu($p=NULL){
							if($p["c"] != ""){ $__c = " class=\'".$p["c"]."\' "; }
							if($p["s"] == "ok"){ $__sl = HTML_SLCT; }
							if($p["ct"] != "off"){ $__t = ctjTx($p["t"],"in"); }else{ $__t = $p["t"]; }

							if(!isN($p["attr"])){
								foreach($p["attr"] as $_attr_k=>$_attr_v){
									$__attr .= " ".$_attr_k."=\'".$_attr_v."\' ";
								}
							}

							$_r = "<option value=\'".$p["v"]."\' ".$__sl." ".$__c." ".$__attr.">".$__t."</option>"; return($_r);
						}



						public function _js($p=NULL){

							if(!isN($p) && !isN($p["id"])){
								if($p["tk"]){ $__tkn = \', tokenSeparators: [",", " "] \'; }
								if($p["tr"]){ $__trs = \', templateResult: \'.$p["tr"].\', templateSelection: \'.$p["tr"].\' \'; }

								if($p["ac"]!="no"){ $__clr = \'true\'; }else{ $__clr = \'false\'; }
								if(!isN($p["thm"])){ $__thm = " theme:\'".$p["thm"]."\', "; }
								$_r = \'$("#\'.$p["id"].\' ").select2({ \'.$__thm.\' allowClear: \'.$__clr.\', placeholder: "\'.$p["ph"].\'" \'.$__tkn.\' \'.$__trs.\' });\';
								return($_r);
							}

						}


						public function _bld($p=NULL){

							global $__cnx;

							if(!isN($p) && !isN($p["q"])){

					            $Qry = $p["q"];
					            $Ls = $__cnx->_qry($Qry);

					            if($Ls){

						            $rLs = $Ls->fetch_assoc();
						            $TLs = $Ls->num_rows;
						            $lbld .= $this->_ovlu([ "ct"=>"off" ]);

						                do {
						                    if (!(strcmp($rLs[$p["v"]], $p["va"]))){$_slc="ok";}else{$_slc = "no";}
						                    $lbld .= $this->_ovlu([ "t"=>$rLs[$p["nm"]], "v"=>$rLs[$p["v"]], "s"=>$_slc ]);
						                } while ($rLs = $Ls->fetch_assoc());

						                if($TLs>0){ $Ls->data_seek(0); $rLs=$Ls->fetch_assoc(); }
						                if($p["mlt"]=="ok"){ $cls = DV_CLSS_SLCT_MLT; }else{ $cls = DV_CLSS_SLCT_BX; }

						                $_bxc = $this->_slcbx([ "id"=>$p["id"],"ph"=>$p["ph"],"rq"=>$p["rq"],"c"=>$lbld, "m"=>$p["mlt"] ]);
						                $html = bdiv([ "c"=>$_bxc, "cls"=>$cls ]);

						            $Ls->free;

						            $this->js .= $this->_js([ "id"=>$p["id"], "ph"=>$p["ph"] ]);

									return $html;
					            }

					            $__cnx->_clsr($Ls);

					        }
						}


				';

				$__clrs = __LsDt([ 'k'=>'sis_slct_cod']);

				$_fcount = 0;

				$__f_created = [];

				foreach($__clrs->ls->sis_slct_cod as $k=>$v){


					if (!in_array($v->fnm->vl, $__f_created)) {

						$Rplc_1 = str_replace("[", "\".", $v->q->vl);
						$Rplc_2 = str_replace("]", ".\"", $Rplc_1);

						$_tt_sis_s .= 'public function '.$v->fnm->vl.'($p=NULL){

											global $__cnx;

											$_r = $this->_bld([
												"id"=>(!isN($p["id"])?$p["id"]:"'.$v->va->vl.'"),
												"q"=>"'.$Rplc_2.'",
												"v"=>(!isN($p["v"])?$p["v"]:"'.$v->v->vl.'"),
												"va"=>(!isN($p["va"])?$p["va"]:"'.$v->va->vl.'"),
												"nm"=>"'.$v->nm->vl.'",
												"rq"=>"ok",
												"ph"=>FM_LS_SLNVL
											]);

											return $_r;
										}

									';

						array_push($__f_created, $v->fnm->vl);

						$_fcount++;

					}

				}

				$_tt_sis_s .= ' }?>';

                $_sve = $this->_svef([ 'nm'=>$this->___s_cls, 'c'=>$_tt_sis_s ]);
				if($_sve->e == 'ok'){ $r['e']='ok'; $r['tot']=$_fcount; }


				return( _jEnc($r) );
			}



	}

	$__AutoFnc = new AUTO_Fnc();


	if(!isN($_bd)){

		$__p = $__AutoFnc->{$_bd}();
	}else{
		$__p = $__AutoFnc->_sis_fnc_slc();
		echo $this->h1($__p->tot.' '.TX_FNCCRT);
	}

}


?>