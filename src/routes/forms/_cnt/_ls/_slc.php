<?php $Rt = '../../../../includes/'; $__pbc='ok'; $__https_off = 'off';

	include($Rt.'inc.php'); header('Access-Control-Allow-Origin: *');

	$__id_rnd = '_'.Gn_Rnd(20);

	if(!isN($_GET['_i'])){ $__i = Php_Ls_Cln($_GET['_i']); }
	if(!isN($_GET['_ts'])){ $__ts = Php_Ls_Cln($_GET['_ts']); }
	if(!isN($_GET['_ts_i'])){ $__t_s_i = Php_Ls_Cln($_GET['_ts_i']); }
	if(!isN($_GET['_ts_e'])){ $__t_s_e = Php_Ls_Cln($_GET['_ts_e']); }
	if(!isN($_GET['_ts_p'])){ $__t_s_p = Php_Ls_Cln($_GET['_ts_p']); }elseif($__i_p != ''){ $__t_s_p = $__i_p; }
	if(!isN($_GET['_ts_f'])){ $__t_s_f = Php_Ls_Cln($_GET['_ts_f']); }else{ $__t_s_f = ''; }
	if(!isN($_GET['_ts_stot'])){ $__t_s_tot = Php_Ls_Cln($_GET['_ts_stot']); }
	if(!isN($_GET['_ts_trgr'])){ $__t_s_trgr = Php_Ls_Cln($_GET['_ts_trgr']); }
	if(!isN($_POST['_are'])){ $__t_s_are = Php_Ls_Cln($_POST['_are']); }
	if(!isN($_GET['__enc'])){ $__enc = Php_Ls_Cln($_GET['__enc']); }

	if($__ts != ''){ $__prfx = _Fx_Prx([ 'v'=>$__ts ]); }

	define('GL_FLE', $__ts.'.php');

	if($_GET['Test4']=='ok'){
		$__nm = __NmFx('Helena Fabiola Amórtegui Beltrán');


		echo '<pre>';
		print_r($__nm);
		echo '</pre>';

	}

	if($__ts == 'sis_cd'){

		echo LsCdOld(['id'=>'Cnt_Cd'.$__enc, 'v'=>'id_siscd', 'rq'=>1, 'flt_ps'=>$__i, 'oth'=>'ok' ]);
		$CntWb .= JQ_Ls('Cnt_Cd'.$__enc,FM_LS_SLCD);

		$CntWb .= "
				function __clr".$__enc."() { console.clear(); }

				$('#Cnt_Cd".$__enc."').change(function() {
					var _t__v = $(this).val();

					if( _t__v == '-oth-'){
						$('#Cnt_Cd_Box_".$__enc."').fadeOut();
						$('#bx_ls_1_".$__enc."').fadeIn();
						$('#bx_ls_1_".$__enc." select').html('');
					}
				});

				$('#Opc_Oth".$__enc."').change(function() {
					var _t__v = $(this).val();
					if(_t__v == '-wrt-'){
						$('#bx_ls_1_".$__enc."').fadeOut();
						$('#bx_ls_2_".$__enc."').fadeIn();
					}
				});

				$('#Opc_Oth".$__enc."').select2({
					placeholder: ' - escribe el nombre de la ciudad -',
					minimumInputLength: 3,
					ajax: {
						url:'/json/lista_o.json',
						dataType: 'json',
						delay: 250,
						method:'POST',
						data: function (params) {

							$('#OthWrt{$__enc}').val(params.term);

							return {
								__t: 'prg',
								__q: params.term
							};
						},
						processResults: function (d) {
							__clr".$__enc."();
							return { results: d.items };
						},
						cache: true
					}
				});
			";

	}else{

		$__fle_cl = '../../'.DR_AC.DMN_SB.'/'.FL_SLC_GN;

		if(file_exists($__fle_cl)){
			include($__fle_cl);
		}
	}
?>
	<script type="text/javascript">
		<?php echo $CntJV ?>
		$(document).ready(function() {
			<?php echo $CntWb ?>
		});
    </script>