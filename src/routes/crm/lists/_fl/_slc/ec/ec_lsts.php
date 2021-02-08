<?php 	


	
	$__tp = Php_Ls_Cln($_POST['_tp']);
	$__sndr = Php_Ls_Cln($_POST['_sndr']);

	if(!isN($__sndr)){ $__siseml = __LsDt([ 'k'=>'sis_eml', 'id'=>$__sndr, 'tp'=>'enc' ]); }

	if($__siseml->d->key->vl == 'sumr'){
		$CntWb .= "
			$('.__mysl').addClass('__sumr');
		";

		$CntWb .= "
			$('#eccmpg_lsts').change(function() {
				_Rqu({ 
					t:'ec_lsts_dt',
					tp:'ec_lsts',
					enc: $(this).val(),
					_bs:function(){ $('.__cont ._col_2').addClass('__ld'); },
					_cm:function(){ $('.__cont ._col_2').removeClass('__ld'); },
					_cl:function(_r){
						try{
							$('.__cont ._col_2 .count').html(_r.ec.tot_eml);
							$('.__cont ._col_2 .count').attr({ 'rel':_r.ec.tot_eml });
						}catch(e){
							console.log('err');
						}
					} 
				});	
			});
		";
	}
	
	if($__siseml->d->key->vl == 'icomkt'){
		
		//echo HTML_inp_tx('eccmpg_out_lsts', TX_NM.' de Lista', ctjTx($___Ls->dt->rw['eccmpg_out_lsts'],'in'), FMRQD);

		$__siseml = __LsDt([ 'k'=>'sis_eml', 'id'=>_CId('ID_SISEML_SUMR') ]);
		echo $__i.LsEcLsts('eccmpg_lsts','eclsts_enc', $__i, '', 1, ['tp'=>$__tp], '', [/*'u'=>$_us_flt,*/ 'ord'=>'i', 'sndr'=>$__siseml->d->id ] ); 
		
	}else{	
	
		echo LsEcLsts('eccmpg_lsts','eclsts_enc', $__i, '', 1, ['tp'=>$__tp], '', [/*'u'=>$_us_flt,*/ 'ord'=>'i', 'sndr'=>$__siseml->d->id ] ); 
	
	}
	
	$CntWb .= JQ_Ls('eccmpg_lsts',FM_LS_SLCD); 

?>	