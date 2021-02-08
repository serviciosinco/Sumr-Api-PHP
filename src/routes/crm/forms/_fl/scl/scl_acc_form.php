<style>
	.ls_scl{ padding: 0;list-style-type: none; }
	li.itm_fld {border: 1px solid;width: 100%;display: inline-block;margin: 3px 0px;padding: 5px 18px;border-radius: 3px;cursor: pointer;}
	li.itm_fld.no{ background-color: transparent; }
	li.itm_fld.ok{ background-color: var(--main-bg-color); color: white; }
	li.itm_fld:hover{background-color: var(--main-bg-color);color: white;}
	h2.tt_scl{position: sticky;left: 0;top: 0;width: 100%; margin: 0;padding: 0; z-index: 10;background-color: white;font-family: Economica;text-transform: uppercase;border-bottom: 3px solid var(--main-bg-color);font-weight: 300; padding: 30px 5px 5px 5px;font-size: 20px; margin-bottom: 30px;}
	.sch_scl input{ width: 100%; border: 1px solid #dcdcdc; }
</style>
<?php

	$__Rnd = Gn_Rnd(20);

	$__rlc = Php_Ls_Cln($_GET['rlc']);
	$__enc = Php_Ls_Cln($_GET['_enc']);
	$__tp = Php_Ls_Cln($_GET['_tp']);
	$__tp_ls = Php_Ls_Cln($_GET['__tp_ls']);
	$___i = Php_Ls_Cln($_GET['___i']);

	$__Form = new CRM_Thrd();

	if( $__tp == 'qus' ){
		$__Attr = $__Form->SclFormQusDt([ 'enc'=>$__enc, 'form'=>$__rlc ]);
	}elseif( $__tp == 'qus_opt' ){
		$__Attr = $__Form->SclFormQusOptDt([ 'enc'=>$__enc, 'id'=>$__rlc ]);
	}

	echo h2(ctjTx($__Attr->lbl,'in'),'tt_scl');

?>
	<ul id="bx_scl_<?php echo $__Rnd; ?>" class="_ls _anm dls ls_scl"></ul>
<?php

	$CntWb .= "

		var Scl = {
			e: '',
			st: ''
		};

		var __siscnt_bx_scl = $('#bx_scl_".$__Rnd."');
		var Scl = {
			e: '',
			st: ''
		};

		function Dom_Rbld(){

			var __sclacc_bx_form_fld_itm = $('.itm_fld');

			__sclacc_bx_form_fld_itm.off('click').click(function(e){

				var __fld = $(this).attr('id');

				if($(this).hasClass('ok')){ var _est = 'del'; }else{ var _est = 'in'; }

				_Rqu({
					t:'scl_acc_attr',
					id_fld: __fld,
					prc: 'ok',
					est: _est,
					tp: '".$__tp."',
					__tp_ls: '".$__tp_ls."',
					id_qus: '".$__Attr->id."',
					_bs:function(){ __siscnt_bx_scl.addClass('_ld'); },
					_cm:function(){ __siscnt_bx_scl.removeClass('_ld'); },
					_cl:function(_r){
						if(!isN(_r)){

							if(!isN(_r.e) && _r.e == 'ok'){
								Scl.e = 'ok';
								if(!isN(_r.st)){
									Scl.st = _r.st;
								}
							}

							if(!isN(_r.scl)){
								ClSet(_r.scl);
							}
						}
					}
				});
			});

			SUMR_Main.LsSch({ str:'#scl_sch_".$__Rnd."', ls:__sclacc_bx_form_fld_itm });
		}

		function SclAccAttrFld_Html(){
			__siscnt_bx_scl.html('');
			__siscnt_bx_scl.append('<li class=\"sch sch_scl\">".HTML_inp_tx('scl_sch_'.$__Rnd, TX_SEARCH, '')."</li>');

			var __tp = '".$__tp."';

			if(__tp == 'qus'){

				if(Scl.e == 'ok'){
					var tot_qus_slc = parseInt( $('#_form_$___i .tot_qus_slc').html() );
					if(Scl.st == 'in'){
						$('#_form_$___i .tot_qus_slc').html(tot_qus_slc+1);

					}else if(Scl.st == 'out'){
						$('#_form_$___i .tot_qus_slc').html(tot_qus_slc-1);
					}

					var tot_q = $('#_form_$___i').attr('rel');

					if( $('#_form_$___i .tot_qus_slc').html() == tot_q ){
						$('#_form_$___i').removeClass('off').addClass('on');
					}else{
						$('#_form_$___i').removeClass('on').addClass('off');
					}
				}

			}else if(__tp == 'qus_opt'){
				$('#_id_k_'+'".$__Attr->id."').removeClass('ok');
			}

			$.each(sclattr['ls'], function(k, v) {
				if(v.est > 0){ Chek('".$__Attr->id."','".$__tp."'); }
				if(v.est > 0){ var _cls = 'ok'; }else{ var _cls = 'no'; }
				__siscnt_bx_scl.append('<li class=\"_anm itm itm_fld '+_cls+'\" id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><span>'+v.tt+'</span></li>');
			});

			Dom_Rbld();
		}

		function Chek(p, v){

			if(v == 'qus'){
				$('#_id_'+p).addClass('ok');
			}else if(v == 'qus_opt'){
				$('#_id_k_'+p).addClass('ok');
			}

		}

		function ClSet(p){
			if( !isN(p) ){
				sclattr = {};
				if( !isN(p.ls) ){ sclattr['ls'] = p.ls; sclattr['tot'] = p.tot; }
				SclAccAttrFld_Html();
			}
		}

		_Rqu({
			t:'scl_acc_attr',
			id_qus:'".$__Attr->id."',
			tp: '".$__tp."',
			__tp_ls: '".$__tp_ls."',
			_cl:function(_r){ if(!isN(_r)){ ClSet(_r.scl); } }
		});

	";

?>