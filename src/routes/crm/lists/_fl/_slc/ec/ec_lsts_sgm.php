<?php

	echo LsEcLstsSgm($__ts.$__t_s_e, 'eclstssgm_enc', $__i, '', 2, '', 'ok', [ 'lsts'=>$__t_s_i, 'wvar'=>'ok' ] );

	$CntWb .= JQ_Ls($__ts.$__t_s_e, FM_LS_SLPRC);

	$CntWb .= "

			$('#".$__ts.$__t_s_e."').change(function() {
				var tot_lsts = $('.__cont ._col_2 .count').attr('rel');
				_Rqu({
					t:'ec_lsts_dt',
					tp:'ec_lsts_sgm',
					enc: $(this).val(),
					lsts_tot: tot_lsts,
					_bs:function(){ $('.__cont ._col_2').addClass('__ld'); $('#ec_lsts_sgm_bx').addClass('__ld'); },
					_cm:function(){ $('.__cont ._col_2').removeClass('__ld'); $('#ec_lsts_sgm_bx').removeClass('__ld'); },
					_cl:function(_r){
						try{
							var tot = parseInt(_r.ec_sgm);
							$('.__cont ._col_2 .count').html(tot);
						}catch(e){
							console.log('err');
						}
					}
				});
			});
		";

?>