<?php

	$__Rdr_Api = __LsDt([ 'k'=>'api_thrd', 'id'=>430 ]);
	$__Rdr_TmeDct = DMN_OAUTH.'timedoctor/?_api='.$__Rdr_Api->d->enc.'&_us='.SISUS_ENC.'&_cl='.DB_CL_ENC;
	
	$__Ins_TmeDct = 'https://webapi.timedoctor.com/oauth/v2/auth?client_id='._TIMEDOCTOR_CLIENT_ID.'&response_type=code&redirect_uri='.urlencode($__Rdr_TmeDct).'';		    
	
	
	if( !isN($_enc) ){
		$_enc_tra = " SUMR_Tra.pre.tra_opn = '".$_enc."'; ";
	}else{
		$_enc_tra = " SUMR_Tra.pre.tra_opn = null; ";
	}

	$FrstCll .= "
		
		SUMR_Main.ld.f.tra(function(){

			SUMR_Tra.f.scrm.get({
				_cl:function(){
					SUMR_Tra.t = '".$___Ls->gt->t."';
					SUMR_Tra.t2 = '".$___Ls->gt->tsb."';
					".$_enc_tra."	
				}	
			});

			".$TraJs."
			
			SUMR_Tra.a.cid = {
				est:{
					cmpl:'"._CId('ID_TRAEST_CMPL')."',
					archv:'"._CId('ID_TRAEST_ARCHV')."',
					prc:'"._CId('ID_TRAEST_PRC')."',
					eli:'"._CId('ID_TRAEST_ELI')."'	
				},
				rsp:{
					obsrv:'"._CId('ID_USROL_OBS')."',
					rsp:'"._CId('ID_USROL_RSP')."'
				},
				col:{
					tp:{
						tra:'"._CId('ID_TRACOLTP_TRA')."',
						sac:'"._CId('ID_TRACOLTP_TCKT_PQR')."',
						pqr_sumr:'"._CId('ID_TRACOLTP_TCKT_PQR_SUMR')."'	
					}
				}
			};

		});
		
	";
	
	if(_ChckMd('tra_dsh')){
		$CntWb .= "
			SUMR_Tra.grph.dom({
				c:function(){
					".$FrstCll."
				}
			});
		";
	}else{
		$CntWb .= $FrstCll;
	}

?>