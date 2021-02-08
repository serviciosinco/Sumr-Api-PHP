<?php


	$__id_ecdsgn = Php_Ls_Cln($_POST['id_ecdsgn']);
	$__id_mdl = Php_Ls_Cln($_POST['_mdl']);
	$__crt_all = GtSisEcCrt_Ls();
	$__dtec = GtEcDt($__id_ecdsgn, 'enc');


	if($_POST['chr'] == 'ok'){

		$_id_div = $_POST['sgm'];
		$_chk_sgm = ChkEcEdtSgm([ 'sgm'=>$_id_div, 'ec'=>$__dtec->id, 'mdl'=>$__id_mdl ]);
		$rsp['e'] = 'ok';

	}else{

		$__ec = new API_CRM_ec();
		$__ec->id = $__id_ecdsgn;
		$__ec->id_t = 'enc';

		$rsp['mdl'] = $__id_mdl;

		if(!isN($__id_mdl)){
			$__ec->mdli = $__id_mdl;
		}

		$_id_rnd = '_'.Gn_Rnd(20);

		$__ec->frm = 'Ml';
		$__ec->html = 'ok';
		$__ec->edit = 'ok';
		$__ec->sve_url = 'ok';
		$__ec->rndm = $_id_rnd;
		$__ec->if_hde = 'ok';
		$_cdg_f = $__ec->_bld();

		foreach($__crt_all as $_k=>$_v){

			$_id_div = $_v->id;
			$_dv_k = "_dv_k".$_v->id.$_id_rnd;


			if($_v->tp == 1){

				$___act = "	__edtr = '".HTML_textarea('ecdsgnsgm_vle', '', '', '', 'ok', '')."';

							$('.html_editor').html( __edtr );

							".JV_HtmlEd('jqte')."

							$('.jqte').jqteVal(_vle_to); ";

			}elseif($_v->tp == 2){

				$___act = "	__edtr = '".HTML_inp_tx('ecdsgnsgm_vle', TX_URL, '', FMRQD_URL).HTML_inp_tx('ecdsgnsgm_tag', TX_TAG, '')."';";

				$___act .= '
							$(".html_editor").html( __edtr );
							$("#ecdsgnsgm_vle").val(_vle_to);
							$("#ecdsgnsgm_tag").val(_tag_to);

						  ';
			}

			$rsp['j'] .= '



					$("#'.$_dv_k.'").off("click").click(function (){

						_obj_id = this;
						SUMR_Ec.f.edt_op_pnl({ ldr_s:_obj_id });

						SUMR_Ec.f.dsgn_crt({
							d:{
								ec_id:"'.$__dtec->enc.'",
								mdl_id:"'.$__id_mdl.'",
								s_id:"'.$_v->id.'"
							},
							s:function(d){

								if(d.e == "ok"){ var _vle_to = d.cod; }else{ var _vle_to = ""; }
								if(d.e == "ok"){ var _tag_to = d.tag; }else{ var _tag_to = ""; }

								_vle_mdl = $("#_mdl").val();

				    			if(!isN(_vle_mdl)){

					    			$("#ecdsgnsgm_sgm").val("'.$_id_div.'");

					    			SUMR_Ec.f.edt_reset({ id:this });
									SUMR_Ec.f.edt_op_pnl({ _op:"ok", ldr_s:_obj_id });

									'.$___act.'

				    				SUMR_Ec.f.edt_ld({
					    				_t:"'.$__t.'",
				    					_d:{
				    						sgm:"'.$_id_div.'",
											id_ecdsgn:"'.$__id_ecdsgn.'",
											chr:"ok",
											_mdl:"'.$__id_mdl.'"
										},
										_dv:"_chr",
										_dvs:"_chr",
										_c:function(){
											SUMR_Ec.f.edt_op_pnl({ _op:"ok", ldr_s:_obj_id });
										}
									});

								}else{

									swal({
									  title: "'.TX_WRNSLC.'",
									  text: "Selecciona un modulo para editar",
									  timer: 10000,
									  type: "warning"
									});

								}

							}
						});

					});


			';


			$rsp['j'] .= "



				_sgmedt={};


				$('#__txt_his_".$_dv_k."').off('click').click(function(){
					_ldCnt({
						u:'".FL_FM_GN."?_t=ecdsgn_sgm_his&iddv=".$_dv_k."&eccmzsgm_sgm=".$_id_div."&id_eccmz=".$_id_eccmz."&Rd='+Math.random(),
						pop:'ok',
						pnl:{
							e:'ok',
							tp:'h'
						},
						cls:'_upl'
					});
				});


				$('#__sgm_del_".$_dv_k."').off('click').click(function (){

					SUMR_Ec.f.edt_load({
						id:'#{$_dv_k}',
						e:'on',
						c:function(){

							SUMR_Ec.f.edt_sve({
								_nr:'ok',
								'_p':'j',
								_t:'ec_dsgn',
								_d:{
									'MM_Delete_sgm':'EdEcDsgn',
									'eccmzsgm_sgm':'".$_id_div."',
									'id_eccmz':'".$_id_eccmz."',
								},
								_c:function(d){
									SUMR_Ec.f.edt_load({ 'id':'#{$_dv_k}' });
									if(d.e == 'ok'){
										$('#".$_dv_k." .__c').summernote('destroy');
										$('#".$_dv_k."').removeClass('__nosve').removeClass('on_edit');
										SUMR_Ec.cmz.edit.lss();
										$('#".$_dv_k."').addClass('_nouse');
										$('#".$_dv_k." .__c').hide();
									}
								},
								_cw:function(){
									SUMR_Ec.f.edt_load({ 'id':'#{$_dv_k}' });
								}
							});
						}
					});

				});


				$('#__txt_sve_".$_dv_k."').off('click').click(function (){

					SUMR_Ec.f.edt_load({

						id:'#{$_dv_k}',
						e:'on',
						c:function(){

							_vle = $('#".$_dv_k." .__c').summernote('code');

							SUMR_Ec.f.edt_sve({
								/*'_nr':'ok',*/
								'_t':'ec_dsgn',
								'_p':'j',
								'_t2':'".$___Ls->mdlstp->tp."',
								'_d':{
									'MM_insert_sgm':'EdEcCmz',
									'eccmzsgm_sgm': '".$_id_div."',
									'eccmzsgm_vle': _vle,
									'id_eccmz': '".$_id_eccmz."'
								},
								_c:function(d){

									SUMR_Ec.f.edt_load({ 'id':'#{$_dv_k}' });

									if(!isN(d) && !isN(d.wrdt) && d.wrdt == 'ok'){

										swal('Error', 'Su texto contiene etiquetas de Word', 'error');

									}else if(d.e == 'ok'){

										if(!isN(_sgmedt) && !isN(_sgmedt[$_dv_k])){
											_sgmedt[$_dv_k] = '';
										}

										if(!isN(d) && !isN(d.html) && !isN(d.html.h)){
											$('#".$_dv_k." .__c').html(d.html.h).fadeIn('fast');
										}

										$('#".$_dv_k." .__c').summernote('destroy');
										$('#".$_dv_k." .note-editor').remove();
										$('#".$_dv_k."').removeClass('__nosve').removeClass('on_edit');
										SUMR_Ec.cmz.edit.lss();

										_summr_{$_dv_k}();
										_summr_on{$_dv_k}();
									}
								},
								_cw:function(){
									SUMR_Ec.f.edt_load({ 'id':'#{$_dv_k}' });
								}
							});
						}
					});
				});



				/*function _summr_{$_dv_k}(){

					var keys = {};

					$('#".$_dv_k." .__c').summernote({
						placeholder: 'Ingrese su contenido aquí...',
						height: 200,
						tabsize: 1,
						/*airMode: true,*/
						dialogsInBody: true,
						enterHtml: '<br><br>',
						emptyPara: '<div style=\'border:1px solid red\'></div>',
						formatPara: '<br>',
						lang: 'es-ES',

						toolbar: [
							['color', ['color']],
							['fontsize', ['fontsize']],
							['font', ['bold', 'italic', 'underline', 'clear']],
							['para', ['ul', 'ol', 'paragraph', 'height']],
							['insert', ['hr', 'link', 'unlink', 'table']]
						],

						/*
						cleaner:{
							notTime:2400,
							action:'both',
							newline:'</br></br></br>',
							keepHtml: true,
							keepOnlyTags:[ '<br>','<ul>','<li>','<b>','<strong>','<i>','<a>','<table>','<tr>','<td>','<span>'],
							keepClasses:false,
							badTags:['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'],
							badAttributes:[ 'start', 'lang' ]
						},
						*/

						fontSizes: ['8', '10', '11', '12', '14', '16', '18', '20', '22', '24', '26', '28', '30', '32', '34', '36'],

						popover: {
							air: [
								['color', ['color']],
								['fontsize', ['fontsize']],
								['font', ['bold', 'italic', 'underline', 'clear']],
								['para', ['ul', 'ol', 'paragraph', 'height']],
								['insert', ['hr', 'link', 'unlink', 'table']]
							]
						},

						insertTableMaxSize: {
							col: 20,
							row: 20
						},

						callbacks: {
							onBlur: function(e) {
								if(!isN(_sgmedt) && !isN(_sgmedt[$_dv_k]) && _sgmedt[$_dv_k] == 'ok'){
									$('#".$_dv_k."').addClass('__nosve');
									/*$('#".$_dv_k." .__c').summernote('disable');*/
								}
							},
							onPaste: function(e) {

								SUMR_Ec.f.cpyhtml_snd({
									id:'#".$_dv_k." .__c',
									s:function(d){
										if(d.e == 'ok'){
											$('#".$_dv_k." .__c').summernote('code', '');
											$('#".$_dv_k." .__c').summernote('code', d.html_b);
										}
									},
									sw:function(d){

									}
								});


							},
							onChange: function(e) {
								if(!isN(_sgmedt) && !isN(_sgmedt[$_dv_k] )){
									_sgmedt[$_dv_k] = 'ok';
									$('#".$_dv_k."').addClass('__nosve');
								}
							},
							onKeyup: function(e) {

								keys['key'+e.keyCode] = 'no';

							},
							onKeydown: function(e) {

								keys['key'+e.keyCode] = 'ok';

								var _k13 = keys['key'+13];
								var _k16 = keys['key'+16];

								if( _k13 == 'ok' && _k16 == 'ok' ){


								}else if( _k13 == 'ok'){

									swal( '¡Recuerda!', 'Utiliza (Shift+Enter) para insertar saltos de línea', 'info');

								}

							}
						}
					});

					$('#".$_dv_k." .__c').summernote('formatPara');

				}*/



				function _summr_on{$_dv_k}(){


					$('#__txt_edt_".$_dv_k.", #".$_dv_k."').off('click').click(function (){


							if( $(this).hasClass('_nouse') ){
								$('#".$_dv_k."').removeClass('_nouse');
							}

							_vle_to = $('#".$_dv_k." .__c').html();
			    			_obj_id = $('#".$_dv_k."');
			    			_summr_{$_dv_k}();

			    			var myw = $('#".$_dv_k."').parent().width();

							SUMR_Ec.f.edt_reset({ id:_obj_id });

					});
				}


				/*
				_summr_on{$_dv_k}();
				*/

			";

		}

		$__sch_f = ['[FTR]'];
		$__chg_f = ['<a href=""><img style="margin:auto; display:block;" src="'.DMN_EC.'fl/cmz/footer.jpg?_rdm='.Gn_Rnd(10).'"></a>'];
		$_cdg_f = str_replace($__sch_f, $__chg_f, $_cdg_f);
		$rsp['e'] = 'ok';
	}

	$__cmprss = 'no';

	if(!isN($_cdg_f)){ $rsp['m'] = $_cdg_f; }
?>