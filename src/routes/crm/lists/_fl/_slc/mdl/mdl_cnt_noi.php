<?php 
	
	if($__t_s_f != ''){
		$__fl = " siscntnoi_prnt = ".Php_Ls_Cln($__t_s_f);
	}else{
		$__fl = " (siscntnoi_prnt IS NULL || siscntnoi_prnt = '') "; 
	}
  

    	
	if($__ts == 'mdlcnt_noi_op1'){ $_idbx_nx = 2; $_idbx_add = 'ok'; }
	elseif($__ts == 'mdlcnt_noi_op2'){ $_idbx_nx = 3; }
	elseif($__ts == 'mdlcnt_noi_op3'){ $_idbx_nx = 4; }
	elseif($__ts == 'mdlcnt_noi_op4'){ $_idbx_nx = 5; }
	elseif($__ts == 'mdlcnt_noi_op5'){ $_idbx_nx = 6; }
	elseif($__ts == 'mdlcnt_noi_op6'){ $_idbx_nx = 7; }

	//echo LsSis_Noi($__ts,'id_siscntnoi', $__t_s_i, '', 1, '', ['tp'=>$__t_s_p, 'fl'=>$__fl]); $CntWb .= JQ_Ls($__ts, FM_LS_NOI.' '.$_idbx_nx);
	echo LsSisCntNoiAre($__ts,'id_siscntnoi', $__t_s_i, TX_CNTNOI, 2,'', ['tp'=>$__t_s_p, 'fl'=>$__fl, 'are'=> $__t_s_are] );
	$CntWb .= JQ_Ls($__ts, TX_CNTNOI);

	
	if(!isN($_idbx_nx)){
        
		$CntWb .= " 
			if( $('#noi_bx_$_idbx_nx').length == 0) {
				$('#noi_bx').append('<div id=\"noi_bx_$_idbx_nx\" class=\"_sbls _noi_sb _noi_sb_$_idbx_nx\"></div>'); 
			}
        ";
        			
       /* $CntWb .= " 
        			if(__noi_id != ''){ __noi_f = __noi_id; }else{ __noi_f = '{$__t_s_f}'; }
        			SUMR_Main.ld.f.slc({  
					    i:__noi_id, 
						t:'mdlcnt_noi_op$_idbx_nx', 
						t_i:__noi_id, 
						t_f:__noi_f, 
						b:'noi_bx_$_idbx_nx',
						s_t:'$__t_s_tot',
						d: { _are : '".$__t_s_are."' }		
        			}); ";  */
	}
	
	$__now_i = $_idbx_nx - 1;
	
	if($__t_s_tot != ''){
		$__dl_nxt = "for(var _i=$_idbx_nx, limit=$__t_s_tot; _i<=limit; _i++){
						$('#noi_bx_'+_i).empty();
					 }";
	}else{
		$__dl_nxt = '';	
	}
					
	$CntWb .= "
				$('#$__ts').change(function() {
				
					__noi_id = $(this).val();
					
					__noi_1 = $('#mdlcnt_noi_op1').val();
					__noi_2 = $('#mdlcnt_noi_op2').val();
					__noi_3 = $('#mdlcnt_noi_op3').val();
					__noi_4 = $('#mdlcnt_noi_op4').val();
					__noi_5 = $('#mdlcnt_noi_op5').val();
					__noi_6 = $('#mdlcnt_noi_op6').val();
					
					
					$('#mdlcnt_noi').val( __noi_id );

					if(__noi_id != ''){ __noi_f = __noi_id; }else{ __noi_f = '{$__t_s_f}'; }
        			SUMR_Main.ld.f.slc({  
					    i:__noi_id, 
						t:'mdlcnt_noi_op$_idbx_nx', 
						t_i:__noi_id, 
						t_f:__noi_f, 
						b:'noi_bx_$_idbx_nx',
						s_t:'$__t_s_tot',
						d: { _are : '".$__t_s_are."' }		
        			});
					
					$__dl_nxt
					
					if(__noi_1 == 2 || __noi_2 == 2){	
						SUMR_Main.ld.f.slc({i:__noi_id, t:'mdlcnt_noi_otc', b:'noi_otu_bx', d: { _are : '".$__t_s_are."' } });
					}else{	
						$('#noi_otu_bx').empty();									
					}

					$CntWb;
        		});
            		
            "; 	
	
	
?>