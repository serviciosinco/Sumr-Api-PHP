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

	$__cl = __Cl([ 'id'=>$__t_s_i, 't'=>'enc' ]);


	if(!isN($__cl->sbd)){
		_StDbCl([ 'sbd'=>$__cl->sbd, 'enc'=>$__cl->enc, 'mre'=>$__dt_cl ]); _Cl_Lb([ 'sb'=>$__cl->sbd ]);
	}

	define('GL_FLE', $__ts.'.php');

	if($__ts == 'sis_cd'){ ?>

			<div id="bx_ls_1_<?php echo $__t_s_e; ?>" style="display:none;">
				<?php echo '<div class="_sl"><div class="styled-select-bx"><select id="Opc_Oth'.$__t_s_e.'" name="Opc_Oth'.$__t_s_e.'" class="required"></select> </div></div>'; ?>
			</div>
			<div id="bx_ls_2_<?php echo $__t_s_e; ?>" style="display:none;">
				<?php echo _HTML_Input('OthWrt'.$__t_s_e, TT_FM_NM, '', FMRQD); ?>
			</div>
			<div id="Cnt_Cd_Box_<?php echo $__t_s_e; ?>">
				<?php
					echo LsCdOld(['id'=>'Cnt_Cd'.$__t_s_e, 'v'=>'id_siscd', 'va'=>'', 'rq'=>1, 'flt_ps'=>$__i, 'oth'=>'ok' ]);
					$CntWb .= JQ_Ls('Cnt_Cd'.$__t_s_e,FM_LS_SLCD);
				?>
			</div>

		<?php

		$CntWb .= "
				function __clr".$__t_s_e."() { console.clear(); }

					$('#Cnt_Cd".$__t_s_e."').change(function() {
						var _t__v = $(this).val();

						if( _t__v == '-oth-'){
							$('#Cnt_Cd_Box_".$__t_s_e."').fadeOut();
							$('#bx_ls_1_".$__t_s_e."').fadeIn();
						}
					});

					$('#Opc_Oth".$__t_s_e."').change(function() {
						var _t__v = $(this).val();
						if(_t__v == '-wrt-'){
							$('#bx_ls_1_".$__t_s_e."').fadeOut();
							$('#bx_ls_2_".$__t_s_e."').fadeIn();
						}
					});

					$('#Opc_Oth".$__t_s_e."').select2({
						placeholder: ' - escribe el nombre de la ciudad -',
						minimumInputLength: 3,
						ajax: {
							url:'/json/lista_o.json',
							dataType: 'json',
							delay: 250,
							method:'POST',
							data: function (params) {

								$('#OthWrt{$__t_s_e}').val(params.term);

								return {
									__t: 'prg',
									__q: params.term
								};
							},
							processResults: function (d) {
								__clr".$__t_s_e."();
								return { results: d.items };
							},
							cache: true
						}
					});
			";

	}elseif($__ts == 'cl_are'){

		echo LsClAre([
				        'id'=>'cnt_are'.$__id_rnd,
				        'v'=>'id_clare',
				        'va'=>$___Ls->dt->rw['rd_are'],
				        'rq'=>1,
				        'mlt'=>'no',
						'flt' => 'ok',
						'flt_n' => '514',
				        'ph' => 'Seleccione facultad'
			        ]);

		$CntWb .= JQ_Ls('cnt_are'.$__id_rnd,MDL_CL_ARE);

		$CntWb .= "$('#cnt_are".$__id_rnd."').change(function() {

						var __id = $(this).val();
						if(__id == 4){
							var __dre = 1;
						}else{
							var __dre = 2;
						}
						SUMR_Main.ld.f.slc({i:__id, t:'".$__t_s_e."', b:'".$__t_s_e."_bx', t_i:'".$__cl->enc."', t_p: __dre, t_e : '".$__t_s_p."' });

					});";

		?>

		<div class="_ln cx1 mdl">
			<div class="_blq _unq">
				<div class="_fd">
					<div class="_fm_spc _c1 <?php echo $__t_s_e; ?> <?php echo $__t_s_e; ?>_ing">
						<div class="_d1"><div id="<?php echo $__t_s_e; ?>_bx" class="_sbls"></div></div>
					</div>
				</div>
			</div>
		</div>


		<?php

	}elseif($__ts == '___mdl_pre'){

		echo LsMdl('Cnt_Mdl_Pre'.$__t_s_e, 'mdl_enc', '', '-Selecione el programa-', 1, '', [ 'mdl_are'=>[$__i], 'tp' => '9', 'n'=> 'Cnt_Mdl_Pre'.$__t_s_e.'[mdl]' ]);
		$CntWb .= JQ_Ls('Cnt_Mdl_Pre'.$__t_s_e, _MdlTx('-Selecione el programa-'));

		if($__t_s_p == 1){ $cl1 = 'cx2'; $cl2 = '_c _c1'; }else{ $cl1 = 'cx1'; $cl2 = '_unq'; }
		echo HTML_inp_hd('CntTp_Pre'.$__t_s_p, '2', '' , [ 'n' => 'Cnt_Mdl_Pre'.$__t_s_e.'[tp]' ] );
		?>
			<div class="_ln <?php echo $cl1; ?> mdl">
				<div class="_blq <?php echo $cl2; ?>">
					<div class="_fd">
						<?php echo _HTML_Input('año_grd_pre'.$__t_s_e, 'Año de graduación', '', FMRQD_NM, 'text', [ 'n' => 'Cnt_Mdl_Pre'.$__t_s_e.'[grd]' ]); ?>
					</div>
				</div>
				<?php if($__t_s_p == 1){ ?>
					<div class="_blq _c _c2">
						<div class="_fd">
							<?php echo _HTML_Input('año_pro_pre'.$__t_s_e, 'Año de promoción', '', FMRQD_NM, 'text', [ 'n' => 'Cnt_Mdl_Pre'.$__t_s_e.'[pro]' ]); ?>
						</div>
					</div>
				<?php } ?>
			</div>
		<?php

	}elseif($__ts == '___mdl_psg'){

		echo LsMdl('Cnt_Mdl_Pos'.$__t_s_e, 'mdl_enc', '', '-Selecione el programa-', 1, '', [ 'mdl_are'=>[$__i], 'tp' => '12', 'n'=> 'Cnt_Mdl_Pos'.$__t_s_e.'[mdl]' ]);
		$CntWb .= JQ_Ls('Cnt_Mdl_Pos'.$__t_s_e, _MdlTx('-Selecione el programa-'));

		echo _HTML_Input('año_grd_pos'.$__t_s_e, 'Año de graduación', '', FMRQD_NM, 'text', [ 'n' => 'Cnt_Mdl_Pos'.$__t_s_e.'[grd]' ]);

		echo HTML_inp_hd('CntTp_Pos'.$__t_s_p, '1', '' , [ 'n' => 'Cnt_Mdl_Pos'.$__t_s_e.'[tp]' ] );

	}elseif($__ts == 'org_scec'){ ?>
			<div class="_ln cx2 mdl tb3">
				<div class="_blq _unq">
			  		<div class="_fd">
						<?php $l = __Ls(['k'=>'emp_scec', 'id'=>'Org_Scec'.$__t_s_p , 'v' => 'sisslc_enc', 'ph'=>'Sector economico']); echo $l->html; $CntWb .= $l->js; ?>
					</div>
				</div>
			</div>
			<div class="_ln cx2 mdl tb3">
				<div class="_blq _c _c1">
			  		<div class="_fd">
			  			<?php
			      			$__ps = 'ok';
			      			echo LsSis_PsOLD('Cnt_Ps_Org'.$__t_s_p, 'id_sisps', '57', 'Pais', 2);
			      			$CntWb .= JQ_Ls('Cnt_Ps_Org'.$__t_s_p, '-', '', '__psFlgOrg_'.$__t_s_p);

				  			$CntWb .= "

								function __psFlgOrg_".$__t_s_p."(_s) {
								  if (!_s.id) { return _s.text; }
								  var _s = $('<div class=\"img-flag-bx\"><span class=\"img-flag\" style=\"background-image:url(\'".DMN_FLE_PS_TH."sis_ps_' + _s.id + 'x50.jpg\');\"></span><strong>'+ _s.text + '</strong></div>' );
								  return _s;
								};

								function __ld_cd_org(p){
									SUMR_Main.ld.f.slc({
										i:p.id,
										t:'sis_cd_org',
										t_i:p.est_i,
										enc: '".$__t_s_p."',
										t_e: '".$__t_s_p."',
										b:'sis_cd_org_bx',
										_cl: function(){
										}
									});
								}

			            		$('#Cnt_Ps_Org".$__t_s_p."').change(function() {
									var _id = $(this).val();
									var _est_i = $(this).val();
									__ld_cd_org({ id:_id, est_i:_est_i });
			            		});


							";




			  			?>
			  		</div>
			  	</div>
				<div class="_blq _c _c2">
			  		<div class="_fd">
				  		<div id="sis_cd_org_bx" class="_sbls">
							<div id="bx_ls_org_1_<?php echo $__t_s_p; ?>" style="display:none;">
								<?php echo '<div class="_sl"><div class="styled-select-bx"><select id="Opc_Oth_Org'.$__t_s_p.'" name="Opc_Oth_Org'.$__t_s_p.'" class="required"></select> </div></div>'; ?>
							</div>
							<div id="bx_ls_org_2_<?php echo $__t_s_p; ?>" style="display:none;">
								<?php echo _HTML_Input('OthWrtOrg'.$__t_s_p, TT_FM_NM, '', FMRQD); ?>
							</div>
							<div id="Cnt_Cd_Org_Box_<?php echo $__t_s_p; ?>">
								<?php

									if(!isN($__ps)){ $__ps = 57; }else{ $__ps = ''; }
									echo LsCdOld(['id'=>'Cnt_Cd_Org'.$__t_s_p, 'v'=>'id_siscd', 'va'=>'', 'rq'=>1, 'flt_ps'=>$__ps, 'oth'=>'ok' ]);
									$CntWb .= JQ_Ls('Cnt_Cd_Org'.$__t_s_p,FM_LS_SLCD);
								?>
							</div>

							<?php
								$CntWb .= "
									function __clr".$__t_s_p."() { console.clear(); }

									$('#Cnt_Cd_Org".$__t_s_p."').change(function() {
										var _t__v = $(this).val();

										if( _t__v == '-oth-'){

											$('#Cnt_Cd_Org_Box_".$__t_s_p."').fadeOut();
											$('#bx_ls_org_1_".$__t_s_p."').fadeIn();
											$('#bx_ls_org_2_".$__t_s_p." select').html('');
										}
									});

									$('#Opc_Oth_Org".$__t_s_p."').change(function() {
										var _t__v = $(this).val();
										if(_t__v == '-wrt-'){
											$('#bx_ls_org_1_".$__t_s_p."').fadeOut();
											$('#bx_ls_org_2_".$__t_s_p."').fadeIn();
										}
									});

									$('#Opc_Oth_Org".$__t_s_p."').select2({
										placeholder: ' - escribe el nombre de la ciudad -',
										minimumInputLength: 3,
										ajax: {
											url:'/json/lista_o.json',
											dataType: 'json',
											delay: 250,
											method:'POST',
											data: function (params) {

												$('#OthWrtOrg{$__t_s_p}').val(params.term);

												return {
													__t: 'prg',
													__q: params.term
												};
											},
											processResults: function (d) {
												__clr".$__t_s_p."();
												return { results: d.items };
											},
											cache: true
										}
									});
								";

							?>

						</div>
			  		</div>
				</div>
			</div>
			<div class="_ln cx1 tb3">
				<div class="_blq _unq">
				    <div class="_fd">
				        <?php echo _HTML_Input('Cnt_Eml_Org'.$__t_s_p, 'Email', '', FMRQD, 'text', ['ac'=>'email']); ?>
				    </div>
				</div>
			</div>
			<div class="_ln cx1 tb3">
				<div class="_blq _unq">
				    <div class="_fd">
				        <?php echo _HTML_Input('Cnt_OrgEmpCrg'.$__t_s_p, 'Cargo', '', FMRQD, 'text'); ?>
				    </div>
				</div>
			</div>
			<div class="_ln cx1">
				<div class="_blq _unq">
				    <div class="_fd">
				        <div style="display: block !important;" class="_sch step1 _anm">
					  		<div class="_cblq">
								<?php echo _HTML_Input('Clg_Sch'.$__t_s_p, 'Escribe el nombre de la empresa', '', FMRQD, 'text', ['ac'=>'off']); ?>
								<span class="_org _sch_go _anm" id="Clg_Sch_Btn<?php echo $__t_s_p ?>"></span>
								<?php echo HTML_inp_hd('Cnt_OrgEmp'.$__t_s_p, ''); ?>
								<?php echo HTML_inp_hd('OthWrtemp', ''); ?>
							</div>
							<div class="_lst" style="display: none;" id="Clg_Ls<?php echo $__t_s_p ?>">
							</div>
							<?php
								$__tpr = _CId('ID_ORGCNTRTP_TRB_PRST');
								$__tpr_o = _CId('ID_ORGTP_EMP');

								echo HTML_inp_hd('Cnt_OrgEmpTpr'.$__t_s_p, $__tpr);
								echo HTML_inp_hd('Cnt_OrgEmpTprO'.$__t_s_p, $__tpr_o);

							?>
				  		</div>
				    </div>
				</div>
			</div>
			<div class="_ln cx1 tb3">
				<div class="_blq _unq">
				    <div class="_fd">
						<?php $l = __Ls([ 'k'=>'emp_ars', 'id'=>'Cnt_OrgEmpAre'.$__t_s_p ,'rq'=>2,  'ph'=>TX_SLCAR ]); echo $l->html; $CntWb .= $l->js; ?>
					</div>
				</div>
			</div>
			<style>
				#Cnt_Emp<?php echo $__t_s_p ?>{ width: 90%; }
				.ls_org{ height: auto; }
			</style>

		<?php
		$CntWb .= "

			SUMR_RquClg = {
				rnd:'',
				snd:{},
				_utt: 'Envio Exitoso',
				_utx: 'Tus datos fueron enviados.'
			};

			SUMR_RquClg.rnd = '".$__t_s_p."';
			SUMR_Dom();

			function SUMR_Dom(){


				SUMR_RquClg.bdy = $('.SUMR_Form');
				SUMR_RquClg.fm = $('#Fm'+SUMR_RquClg.rnd);
				SUMR_RquClg.fmflds = $('#Fm'+SUMR_RquClg.rnd+'_flds');
				SUMR_RquClg.fmrsl = $('#Fm'+SUMR_RquClg.rnd+'_rsl');
				SUMR_RquClg.fmbtn = $('#FmBtn'+SUMR_RquClg.rnd);
				SUMR_RquClg.fmrsl_tt = $('#FmBx'+SUMR_RquClg.rnd+' .success_ok ._tt');
				SUMR_RquClg.fmrsl_tx = $('#FmBx'+SUMR_RquClg.rnd+' .success_ok ._tx');
				SUMR_RquClg.fmrsl_msj = $('#FmBx'+SUMR_RquClg.rnd+' ._msjrs');
				SUMR_RquClg.clg_ls = $('#Clg_Ls'+SUMR_RquClg.rnd);
				SUMR_RquClg.clg_ls_itm = $('#Clg_Ls'+SUMR_RquClg.rnd+' li.item');


				$('#FmBtn'+SUMR_RquClg.rnd).off('click').click(function(event){
					event.preventDefault();
					_sndData();
				});

				$('#Clg_Sch_Btn'+SUMR_RquClg.rnd).off('click').click(function(e){

					e.preventDefault();

					if(e.target != this){
				       e.stopPropagation();
					   return;
					}else{

						var _vl_sch = $('#Clg_Sch'+SUMR_RquClg.rnd).val();
						var _this = $(this);

						if(!isN(_vl_sch) && _vl_sch.length > 5){

							__snd({
								p:'sch',
								t:'cnt',
								d:{
									sch:_vl_sch,
									tp: '_sch'
								},
								_bs:function(){ _this.addClass('on'); },
								_cl:function(r){
									if(!isN(r)){

										var _el='';
										SUMR_RquClg.clg_ls.hide().html('');

										if(!isN(r.ls)){

											$.each(r.ls, function(k, v) {

												if(!isN(v.img) && !isN(v.img.th_100)){
													var _img = 'background-image:url('+v.img.th_100+');';
													var _cls = '';
												}else{
													var _img = '';
													var _cls = 'empty';
												}

												_el = _el+'<li class=\"_anm item\" data-id=\"'+v.id+'\"><figure	style=\"'+_img+'\" class=\"'+_cls+' _anm\"></figure><div class=\"_tx _anm\">'+v.nm+'<span>'+v.cd.tt+'</span></div>	</li>';

											});

											$('.tb3').addClass('__hd');

											SUMR_RquClg.clg_ls.html('<ul class=\"ls_org\">'+_el+'</ul>').show();
											SUMR_Dom();
										}
									}
								},
								_cm:function(r){ _this.removeClass('on'); },
								_w:function(r){
									if(!isN(r)){

									}
								}
							});

						}

					}

				});


				SUMR_RquClg.clg_ls_itm.off('click').click(function(e){


					e.preventDefault();

					var id = $(this).attr('data-id');

					var itm_slc = $(this).html();
					$('#Clg_Ls".$__t_s_p." ul').html('<li class=\"anm selc\">'+itm_slc+'</li>');

					if(!isN(id)){

						if(id == '-new-'){
							$('#OthWrtemp').val( $('#Clg_Sch".$__t_s_p."').val() );
						}else{
							$('#Cnt_OrgEmp".$__t_s_p."').val( id );
						}

						$('#Clg_Sch".$__t_s_p."').hide();
						$('.tb3.__hd').removeClass('__hd');
						$('._sch_go._org').hide();

					}

				});
			}
		";

	}elseif($__ts == 'sis_cd_org'){

		?>

			<div id="bx_ls_org_1_<?php echo $__t_s_e; ?>" style="display:none;">
				<?php echo '<div class="_sl"><div class="styled-select-bx"><select id="Opc_Oth_Org'.$__t_s_e.'" name="Opc_Oth_Org'.$__t_s_e.'" class="required"></select> </div></div>'; ?>
			</div>
			<div id="bx_ls_org_2_<?php echo $__t_s_e; ?>" style="display:none;">
				<?php echo _HTML_Input('OthWrtOrg'.$__t_s_e, TT_FM_NM, '', FMRQD); ?>
			</div>
			<div id="Cnt_Cd_Org_Box_<?php echo $__t_s_e; ?>">
				<?php
					echo LsCdOld(['id'=>'Cnt_Cd_Org'.$__t_s_e, 'v'=>'id_siscd', 'rq'=>1, 'flt_ps'=>$__i, 'oth'=>'ok' ]);
					$CntWb .= JQ_Ls('Cnt_Cd_Org'.$__t_s_e,FM_LS_SLCD);
				?>
			</div>

		<?php

		$CntWb .= "

			function __clr".$__t_s_e."() { console.clear(); }

				alert('#Cnt_Cd_Org_Box_".$__t_s_e."');

				$('#Cnt_Cd_Org".$__t_s_e."').change(function() {
					var _t__v = $(this).val();

					if( _t__v == '-oth-'){
						$('#Cnt_Cd_Org_Box_".$__t_s_e."').fadeOut();
						$('#bx_ls_org_1_".$__t_s_e."').fadeIn();
						$('#bx_ls_org_2_".$__t_s_e." select').html('');
					}
				});

				$('#Opc_Oth_Org".$__t_s_e."').change(function() {
					var _t__v = $(this).val();
					if(_t__v == '-wrt-'){
						$('#bx_ls_org_1_".$__t_s_e."').fadeOut();
						$('#bx_ls_org_2_".$__t_s_e."').fadeIn();
					}
				});

				$('#Opc_Oth_Org".$__t_s_e."').select2({
					placeholder: ' - escribe el nombre de la ciudad -',
					minimumInputLength: 3,
					ajax: {
						url:'/json/lista_o.json',
						dataType: 'json',
						delay: 250,
						method:'POST',
						data: function (params) {

							$('#OthWrtOrg{$__t_s_e}').val(params.term);

							return {
								__t: 'prg',
								__q: params.term
							};
						},
						processResults: function (d) {
							__clr".$__t_s_e."();
							return { results: d.items };
						},
						cache: true
					}
				});
			";

	}elseif($__ts == 'ls_org'){ ?>

		<div class="_sch step1 _anm">
		  		<div class="_cblq">
					<?php echo _HTML_Input('Clg_Sch'.$__id_rnd, 'Escribe el nombre de tu colegio', '', FMRQD, 'text', ['ac'=>'off']); ?>
					<button class="org _sch_go _anm" id="Clg_Sch_Btn<?php echo $__id_rnd ?>"></button>
				</div>
				<div class="_lst" style="display: none;" id="Clg_Ls<?php echo $__id_rnd ?>">
				</div>
	  		</div>
	<?php }else{

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