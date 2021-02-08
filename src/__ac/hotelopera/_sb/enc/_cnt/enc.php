<?php $_enc_dt = GtEncDt(['id'=>$__i]); if($_GET['_lng'] || $_GET['_lng'] != ''){ $_lng =  $_GET['_lng']; }else{ $_lng = 'es'; } $_txt = GtClTexLng($_GET['_lng']);  ?>
<div class="enc_wrp">
	<form method="post" class="_fm" id="_fm_enc" action='inc/process/_gn.php'>
		<input type="hidden" name="_t" value="enc">
		<input type="hidden" name="enc_id" value="<?php echo $__i; ?>">
		<input type="hidden" name="ENC_insert" value="EdEncCnt">
		<div class="enc_flds">
			<?php

				$__f_p = '<div class="_ln cx1" id="blq_0">
							<div class="_c1 oadon">
								<input type="text" name="cnt_nm" id="cnt_nm" class="required" placeholder="'.TX_NM.'" value="">
							</div>
							<div class="_c2">
								<input type="email" name="cnt_eml" id="cnt_eml" placeholder="'.TX_EML.'" value="">
							</div>
						  </div>

						  ';

				if($_enc_dt->fld != NULL){

					$_f = _Fm_Fld_B(['a'=>$_enc_dt->fld, 'p'=>$__f_p, 'lng'=>$_lng]);
					echo $_f->html;

					$_CntJQ_Vld .= $_f->js;

				}

			?>
		</div>

		<div class="btn_enc_dv" >
			<input type="hidden" id="blq_go" name="blq_go" value="0">

			<input type="button" value="<?php echo TX_SIG; ?>" class="_btn_nxt" >
			<input type="button" value="<?php echo TX_SND; ?>" class="_btn_enc" style="display:none;">


			<p class="conex"><?php echo TX_CONEX; ?></p>

		</div>

		<div class="__ok_enc">
			<h2><?php echo TX_GRC; ?></h2>
			<span><?php echo TX_PSA; ?></span>
		</div>

		<div class="scrl_space"></div>

	</form>
</div>
<?php
	$CntWb .=	"


		_fm  = $('#_fm_enc');
		_bgo  = $('#blq_go');

		_fm.validate();

		$('._btn_enc').click(function() {
			if(_fm.valid()){
				_snd_prc();
			}
		});

		$('._btn_nxt').click(function() {
			_nxt_blq();
		});


		function _ldAbrt(d){
			if(d != undefined && d.p != undefined){
				if (!isN(SUMR_Main.ibx[d.p])){ SUMR_Main.ibx[d.p].abort(); }
			}
		}

		function _snd_prc(){
			var form = $('#_fm_enc');
			_ldAbrt({ p:'enc' });

			SUMR_Main.ibx['enc'] =$.ajax( {
							    type: 'post',
							    url: form.attr( 'action' ),
							    data: form.serialize(),
							    dataType: 'json',
							    success: function( d, status ) {
									$('._ldr').fadeOut();

								    if(d.e == 'ok'){
									    $('.enc_flds, .btn_enc_dv').hide();
										$('.__ok_enc').fadeIn();
							        }else{

							        }
								},
							    beforeSend: function( xhr ) {
									$('._ldr').fadeIn();
								}
						    });
		}

		function _nxt_blq(){
			if(_fm.valid()){
				now_b = parseFloat( _bgo.val() );

				if(now_b == 0){ _sum = 2; $('#blq_1').fadeOut(); }else{ _sum = 1; }
				nxt_b = now_b + _sum;
				lst_b = parseFloat(".$_f->row.") - 1;

				/*alert( '".$_f->row."' + ' -> Hide: '+ now_b + ' -> Show: '+ nxt_b );*/

				$('#blq_'+now_b).fadeOut('fast', function(){
					$('#blq_'+nxt_b).fadeIn('slow', function(){
						_bgo.val( nxt_b );
					});
				});

				if(nxt_b == lst_b){
					$('._btn_nxt').fadeOut();
					$('._btn_enc').fadeIn();
				}

			}

		}

";

		echo CntJQ($CntJV, 'ok').CntJQ($CntWb);

?>

