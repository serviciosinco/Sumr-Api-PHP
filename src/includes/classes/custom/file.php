<?php

class CRM_Fle {
		
	function __construct() { 

		$this->_aws = new API_CRM_Aws();
		
		$this->_allow = 'no';
		
		$this->_prnpth = dirname(__FILE__, 5);	
		
		$this->ChkTmpFldr([ 
							DIR_FLE_EC_CMZ, 
							DIR_RD,
							DIR_FLE_EC_TH,
							DIR_BCO_TH, 
							DIR_BCO_FCE_TH, 
							DIR_FLE_US_TH, 
							DIR_FLE_ANX,
							DIR_FLE_PS,
							DIR_FLE_SIS,
							DIR_FLE_BD,
							DIR_FLE_TPC,
							DIR_FLE_CNTRC,
							DIR_FLE_SIS_SLC_TP,
							DIR_FLE_SIS_CNT_EST_TP,
							DIR_FLE_SIS_MD,
							DIR_FLE_SIS_EC_SGM,
							DIR_FLE_ORG,
							DIR_FLE_ORG_TH,
							DIR_FLE_CL_MNU,
							DIR_FLE_CL_TH,
							DIR_FLE_CL_BCK_APP_CSTM,
							DIR_FLE_CL_LGO_LGHT,
							DIR_FLE_CL_LGO_ICO,
							DIR_FLE_CL_LGO_RSLLR,
							DIR_FLE_APP
						]);
		
	}
	
	public function RndmFldr(){
		return Enc_Rnd(DIR_TMP_FLE);	
	}
	
	public function ChkTmpFldr($p=NULL){
		
		$rsp['e'] = 'no';
		
		if(!isN($p)){
			
			foreach($p as $p_k=>$p_v){
			
				//-------------- Basic Vars --------------//
					
					$pathp = $this->_prnpth.'/'; // Parent Path
		
				//-------------- Create Variables --------------//
				
				$folders = explode('/', $p_v);
				$folders_tot = count($folders);
				$_chk_fldr = '';
				$_chk_fldr_i = 1;

				foreach($folders as $folders_k=>$folders_v){
		
					$_chk_fldr .= $folders_v;
					
					if($_chk_fldr_i != $folders_tot){ $_chk_fldr .= '/'; }
					
					if ( !is_dir($pathp.$_chk_fldr)){
						
					    if( mkdir($pathp.$_chk_fldr,0777, true) ){ 
						    chmod($pathp.$_chk_fldr,0777); 
						    $rsp['ls'][]['e'] = 'ok'; 
						}
						
					}	
					
					$_chk_fldr_i++;
				}
			
			}
		
		}
		
		return _jEnc($rsp);
		
	}
	
	
	
	public function _SumrToFle($p=NULL){
		
		$r['e']='no';
		
		if(!isN($this->_nw_fld)){
		
		//-------------- Basic Vars --------------//
			
			$pathp = $this->_prnpth.'/'; // Parent Path
		
		//-------------- Create Variables --------------//	
			
			$this->_nw_fld_th = $this->_nw_fld.'th/';
									
			$r['fle']['nm'] = $__fl_nm = $this->_srce['upl']['name'];
			$r['fle']['tmp'] = $__tmp_nm = $this->_srce['upl']['tmp_name'];
			$r['fle']['ext'] = $extension = pathinfo($this->_srce['upl']['name'], PATHINFO_EXTENSION);
			$r['fle']['tp'] = mime_content_type($__tmp_nm);
			
			$r['name']['new'] = $name = $this->_tt.'.'.$extension;	
			
			$r['from'] = $from = $__tmp_nm;
			$r['to'] = $to = $this->_nw_fld.$name;
			$r['s'] = $s = $p['s'];
			
			
			$r['sze']['main']['src'] = $pathp.$to;
			$r['sze']['main']['sve'] = _TmpFixDir($this->_nw_fld.$name);
			
			$r['sze']['th']['src'] = $pathp.$this->_nw_fld_th.$name;
			$r['sze']['th']['sve'] = _TmpFixDir($this->_nw_fld_th.$name);
			
			$r['sze']['gry']['src'] = $pathp.$this->_nw_fld.'gry_'.$name;
			$r['sze']['gry']['sve'] = _TmpFixDir($this->_nw_fld.'gry_'.$name);
			
			$r['sze']['sm']['src'] = $pathp.$this->_nw_fld.'_sm_'.$name;
			$r['sze']['sm']['sve'] = _TmpFixDir($this->_nw_fld.'_sm_'.$name);
			
			$r['sze']['md']['src'] = $pathp.$this->_nw_fld.'_md_'.$name;
			$r['sze']['md']['sve'] = _TmpFixDir($this->_nw_fld.'_md_'.$name);
			
			$r['sze']['bg']['src'] = $pathp.$this->_nw_fld.'_bg_'.$name;
			$r['sze']['bg']['sve'] = _TmpFixDir($this->_nw_fld.'_bg_'.$name);
		
		
		//-------------- 50 Pxls Size --------------//
		
			
			$r['sze']['t50']['src'] = $pathp.$this->_nw_fld_th.$this->_tt.'x50.jpg';
			$r['sze']['t50']['sve'] = _TmpFixDir($this->_nw_fld_th.$this->_tt.'x50.jpg');
			$r['sze']['t50']['tp'] = mime_content_type($r['sze']['t50']['src']);
			
			$r['sze']['tc50']['src'] = $pathp.$this->_nw_fld_th.$this->_tt.'_c_x50.jpg';
			$r['sze']['tc50']['sve'] = _TmpFixDir($this->_nw_fld_th.$this->_tt.'_c_x50.jpg');
			$r['sze']['tc50']['tp'] = mime_content_type($r['sze']['tc50']['src']);
			
			$r['sze']['tc50p']['src'] = $pathp.$this->_nw_fld_th.$this->_tt.'_c_x50.png';
			$r['sze']['tc50p']['sve'] = _TmpFixDir($this->_nw_fld_th.$this->_tt.'_c_x50.png');
			$r['sze']['tc50p']['tp'] = mime_content_type($r['sze']['tc50p']['src']);
		
		//-------------- 100 Pxls Size --------------//	
			
			$r['sze']['t100']['src'] = $pathp.$this->_nw_fld_th.$this->_tt.'x100.jpg';
			$r['sze']['t100']['sve'] = _TmpFixDir($this->_nw_fld_th.$this->_tt.'x100.jpg');
			$r['sze']['t100']['tp'] = mime_content_type($r['sze']['t100']['src']);
			
			$r['sze']['tc100']['src'] = $pathp.$this->_nw_fld_th.$this->_tt.'_c_x100.jpg';
			$r['sze']['tc100']['sve'] = _TmpFixDir($this->_nw_fld_th.$this->_tt.'_c_x100.jpg');
			$r['sze']['tc100']['tp'] = mime_content_type($r['sze']['tc100']['src']);
			
			$r['sze']['tc100p']['src'] = $pathp.$this->_nw_fld_th.$this->_tt.'_c_x100.png';
			$r['sze']['tc100p']['sve'] = _TmpFixDir($this->_nw_fld_th.$this->_tt.'_c_x100.png');
			$r['sze']['tc100p']['tp'] = mime_content_type($r['sze']['tc100p']['src']);
			
		//-------------- 200 Pxls Size --------------//
		
			
			$r['sze']['t200']['src'] = $pathp.$this->_nw_fld_th.$this->_tt.'x200.jpg';
			$r['sze']['t200']['sve'] = _TmpFixDir($this->_nw_fld_th.$this->_tt.'x200.jpg');
			$r['sze']['t200']['tp'] = mime_content_type($r['sze']['t200']['src']);
			
			$r['sze']['tc200']['src'] = $pathp.$this->_nw_fld_th.$this->_tt.'_c_x200.jpg';
			$r['sze']['tc200']['sve'] = _TmpFixDir($this->_nw_fld_th.$this->_tt.'_c_x200.jpg');
			$r['sze']['tc200']['tp'] = mime_content_type($r['sze']['tc200']['src']);
			
			$r['sze']['tc200p']['src'] = $pathp.$this->_nw_fld_th.$this->_tt.'_c_x200.png';
			$r['sze']['tc200p']['sve'] = _TmpFixDir($this->_nw_fld_th.$this->_tt.'_c_x200.png');
			$r['sze']['tc200p']['tp'] = mime_content_type($r['sze']['tc200p']['src']);
			
		
		//-------------- 400 Pxls Size --------------//
			
			$r['sze']['t400']['src'] = $pathp.$this->_nw_fld_th.$this->_tt.'x400.jpg';
			$r['sze']['t400']['sve'] = _TmpFixDir($this->_nw_fld_th.$this->_tt.'x400.jpg');
			$r['sze']['t400']['tp'] = mime_content_type($r['sze']['t400']['src']);
			
			$r['sze']['tc400']['src'] = $pathp.$this->_nw_fld_th.$this->_tt.'_c_x400.jpg';
			$r['sze']['tc400']['sve'] = _TmpFixDir($this->_nw_fld_th.$this->_tt.'_c_x400.jpg');
			$r['sze']['tc400']['tp'] = mime_content_type($r['sze']['tc400']['src']);
			
			$r['sze']['tc400p']['src'] = $pathp.$this->_nw_fld_th.$this->_tt.'_c_x50.png';
			$r['sze']['tc400p']['sve'] = _TmpFixDir($this->_nw_fld_th.$this->_tt.'_c_x400.png');
			$r['sze']['tc400p']['tp'] = mime_content_type($r['sze']['tc400p']['src']);
		
		//-------------- Create Folder If Not Exists --------------//
			
			
			$folders = explode('/', $this->_nw_fld_th);
			$folders_tot = count($folders);
			$_chk_fldr = '';
			$_chk_fldr_i = 1;
			$this->_allow='no';
			
			
			foreach($folders as $folders_k=>$folders_v){
				
				$_allow='no';

				$_chk_fldr .= $folders_v;
				if($_chk_fldr_i != $folders_tot){ $_chk_fldr .= '/'; }
				
				if ( !is_dir($pathp.$_chk_fldr)){
					
					$r['tocreate'][] = $pathp.$_chk_fldr;
					
				    if( mkdir($pathp.$_chk_fldr,0777, true) ){ 
					    chmod($pathp.$_chk_fldr,0777);
					    $this->_allow='ok';
					    $r['created'][] = $pathp.$_chk_fldr; 
					}else{
						$this->_allow='no';	
					}
				}else{
					$r['exists'][] = $pathp.$_chk_fldr;
					$this->_allow='ok';
				}	
				
				$_chk_fldr_i++;
			}
			
			$r['folders'] = $_chk_fldr;
			$r['allow'] = $this->_allow;
			
		//----------------------- Move Files ---------------------//
		
			$r['rpth'] = $pathp.$to;
			
			if($this->_allow=='ok'){
			
				if(move_uploaded_file($from, $pathp.$to)){ $r['e']='ok'; }else{ $r['w']=error_get_last(); }
				
			}
		
		}
			
		return _jEnc($r);
		
	}
	
	
	function _ExstO($p=NULL){
		
		$r['e'] = 'no';
		
			
		$_sch = ['../', '/'.DIR_TMP_FLE, DIR_TMP_FLE];
		
		$_rlpth = $r['rpth_sve'] = str_replace($_sch,'',$p['path']);	
		$_rlpth_o = $r['rpth_sve_o'] = str_replace($_sch,'',$p['path_o']);	
		
		
		$_rlpth_f = $r['rpth'] = $this->_prnpth.'/'.DIR_TMP_FLE.$_rlpth;
		$_rlpth_o_f = $r['rpth_o'] = $this->_prnpth.'/'.DIR_TMP_FLE.$_rlpth_o;
		
		
		if($p['lcl_u']=='ok'){ // Update Local File
			$_get = $r['get'] = $this->_aws->_s3_get([ 'b'=>'fle', 'lcl'=>'ok', 'upd'=>'ok', 'fle'=>$_rlpth_o ]);
		}
		
		if(file_exists($_rlpth_o_f)){
			$r['e'] = 'ok';
		}
		
		
		return _jEnc($r);
	}
	
	
	
	
	
	function _ExstBco($p=NULL){
		
		$r['e'] = 'no';	
			
		$_sch = ['../', '/'.DIR_TMP_BCO, DIR_TMP_BCO];
		
		$_rlpth = $r['rpth_sve'] = str_replace($_sch,'',$p['path']);
		$_rlpth_f = $r['rpth'] = $this->_prnpth.'/'.DIR_TMP_BCO.$_rlpth;
		
		if($p['lcl_u']=='ok'){ // Update Local File
			$_get = $r['get'] = $this->_aws->_s3_get([ 'b'=>'bco', 'lcl'=>'ok', 'upd'=>'ok', 'fle'=>$_rlpth ]);
		}
		
		if(file_exists($_rlpth_f)){
			$r['e'] = 'ok';
		}
		
		
		return _jEnc($r);
	}
	

}

	
	
?>