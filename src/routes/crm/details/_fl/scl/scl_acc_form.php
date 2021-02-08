<?php

	$__Form = new CRM_Thrd();
	$__Prc = $__Form->FormChk(['enc'=>$__i]);
	$__Attr = $__Form->SclFormAttrLs(['id'=>$__Prc->id]);
	$__Qus = $__Form->SclFormQusLs(['id'=>$__Prc->id]);

	echo h2(ctjTx($__Prc->nm,'in'),'tt_scl');

	if(!isN($__Prc->plcy_dt->id)){ $___cls_p = 'ok'; }else{  $___cls_p = 'no'; }

?>
<div class="scl-acc-form-slc">
	<div class="icns">
		<ul>
			<?php
				echo li('<span>'.TX_TT.'</span>'.$__Attr->ls->context_card_title->vl, 'tt_attr _tt');
				echo li('<span>'.TX_CRD.'</span>'.$__Attr->ls->creator_name->vl, 'tt_attr _aut');
				echo li('<span>'.TX_URL_FLL.'</span>'.$__Attr->ls->follow_up_action_url->vl, 'tt_attr _url');
				echo li('<span>'.TX_URL_PRV.'</span>'.$__Attr->ls->privacy_policy_url->vl, 'tt_attr _md');
				echo li('<span class="md_id md_id_nm">Medio: '.$__Prc->md_dt->nm.'</span>','tt_attr _id_md');
				echo li('<span class="mdl_id_nm">'.TX_MDL.': '.$__Prc->mdl_dt->tt.'</span>', 'tt_attr _id_mdl');
				echo li('<span class="plcy_id_nm">'.'Politica de datos'.': '.ctjTx($__Prc->plcy_dt->nm,'in').'</span>', 'tt_attr _id_plcy '.$___cls_p);
				echo li('<span class="est_id_nm">'.'Estado'.': '.ctjTx($__Prc->est_tt,'in').'</span>', 'tt_attr _id_est '.$___cls_p,'background-color:'.$__Prc->est_dt->clr->vl.'');
				echo li('<span class="leads_id_nm" rel="'.$__Prc->enc.'">Leads</span>', 'tt_attr _leads ');
			?>
		</ul>
	</div>

	<div class="_mdl_id no slct _anm">
		<?php echo LsMdl('scl_mdl', 'id_mdl', $__Prc->mdl, TX_SLCNMDL, 2, '', [ 'prfx'=>'mdlstp_nm' ]); $CntWb .= JQ_Ls('scl_mdl', TX_SLCNMDL); ?>
		<p class="mdl btn__d edi"> </p>
		<p class="mdl btn__d cal"> </p>
	</div>

	<div class="_plcy_id slct no _anm">
		<?php echo LsClPlcy([ 'id'=>'form_plcy', 'v'=>'clplcy_enc', 'va'=> $__Prc->plcy_dt->enc ]); $CntWb .= JQ_Ls('form_plcy', TX_FMSLCPLCY); ?>
		<p class="plcy btn__d edi"> </p>
		<p class="plcy btn__d cal"> </p>
	</div>

	<div class="_md_id slct no _anm">
		<?php echo LsSis_Md('form_md','sismd_enc', $__Prc->md_dt->enc, '', 1, ''); $CntWb .= JQ_Ls('form_md', FM_LS_SLFAC);  ?>
		<p class="md btn__d edi"> </p>
		<p class="md btn__d cal"> </p>
	</div>

	<div class="_est_id slct no _anm">
		<?php $l = __Ls(['k'=>'sis_est', 'id'=>'sisslc_enc', 'va'=>$__Prc->est , 'ph'=>TX_ETD]); echo $l->html; $CntWb .= $l->js;  ?>
		<p class="est btn__d edi"> </p>
		<p class="est btn__d cal"> </p>
	</div>




<?php if(!isN($__Qus->ls)){	?>
	<div class="items"> <?php
		foreach($__Qus->ls as $_k => $v){

			$val_e = $__Form->SclFormQusOptLs(['id'=>$v->id,'tp'=>$v->upfld_vl]);

			if($val_e->e == 'ok'){

				$__id_clpp = 'Flc_'.Gn_Rnd(20);
				$CntWb .= "var ".$__id_clpp." = new Spry.Widget.CollapsiblePanel('".$__id_clpp."', {contentIsOpen:false }); ";
				?>
					<div tp-ls="<?php echo $v->upfld_vl; ?>" id="<?php echo $__id_clpp ?>" class="CollapsiblePanel">
						<?php if($v->est > 0){ $_cls = 'ok'; }else{ $_cls = 'no'; } ?>
						<div class="CollapsiblePanelTab" tabindex="0"><div rel="<?php echo $v->key ?>" tp="qus" data="<?php echo $v->fm->id; ?>" id="_id_<?php echo $v->id ?>" data_enc="<?php echo $v->enc ?>" class="inpt_colp inpt_colp_tt fld inpt fld <?php echo $_cls ?>"><?php echo $v->vl.' ⌄ ' ?><span class="_anm"></span></div></div>
		                <div class="CollapsiblePanelContent">
			                <div class="inpt_colp">
			                	<?php

					                foreach($val_e->ls as $__k=>$__v){
						                if($__v->est > 0){ $__cls = 'ok'; }else{ $__cls = 'no'; }
										echo '<div rel="'.$__v->key.'" tp="qus_opt" data="'.$__v->rlc.'" id="_id_k_'.$__v->id.'" data_enc="'.$__v->enc.'" class="fld fld_opt '.$__cls.'">'.$__v->vl.'</div>';
									}

				                ?>
			                </div>
		                </div>
					</div>
				<?php
			}else{
				if($v->est > 0){ $_cls = 'ok'; }else{ $_cls = 'no'; }
				echo '<div rel="'.$v->key.'" tp="qus" data="'.$v->fm->id.'" id="_id_'.$v->id.'" data_enc="'.$v->enc.'" class="inpt fld '.$_cls.'">'.$v->vl.'<span class="_anm"></span></div>';
			}
		}
	?> </div> <?php
}

	$CntJV .= "

		var __sclacc_bx_form_id_mdl = $('.tt_attr._id_mdl');

		__sclacc_bx_form_id_mdl.off('click').click(function(e){
			$('.slct').removeClass('ok');
			$('._mdl_id').toggleClass( 'ok' );
			if($('._mdl_id').hasClass('ok')){ $('.items').addClass('dsb'); }else{ $('.items').removeClass('dsb'); }
		});

		var __sclacc_bx_form_id_plcy = $('.tt_attr._id_plcy');

		__sclacc_bx_form_id_plcy.off('click').click(function(e){
			$('.slct').removeClass('ok');
			$('._plcy_id').toggleClass( 'ok' );
			if($('._plcy_id').hasClass('ok')){ $('.items').addClass('dsb'); }else{ $('.items').removeClass('dsb'); }
		});

		var __sclacc_bx_form_id_md = $('.tt_attr._id_md');

		__sclacc_bx_form_id_md.off('click').click(function(e){

			$('.slct').removeClass('ok');
			$('._md_id').toggleClass( 'ok' );
			if($('._md_id').hasClass('ok')){ $('.items').addClass('dsb'); }else{ $('.items').removeClass('dsb'); }
		});

		var __sclacc_bx_form_id_est = $('.tt_attr._id_est');

		__sclacc_bx_form_id_est.off('click').click(function(e){

			$('.slct').removeClass('ok');
			$('._est_id').toggleClass( 'ok' );
			if($('._est_id').hasClass('ok')){ $('.items').addClass('dsb'); }else{ $('.items').removeClass('dsb'); }
		});

		var __sclacc_bx_form_btn_cal = $('.btn__d.cal');

		__sclacc_bx_form_btn_cal.off('click').click(function(e){
			$('.slct').removeClass( 'ok' );
			$('.items').removeClass( 'dsb' );
		});

		var __sclacc_bx_form_btn_upd = $('.btn__d.edi');

		__sclacc_bx_form_btn_upd.off('click').click(function(e){

			if($(this).hasClass('mdl')){
				var intb = $('#scl_mdl').val();
				var tp = 'mdl_id';
			}else if($(this).hasClass('plcy')){
				var intb = $('#form_plcy').val();
				var tp = 'plcy_id';
			}else if($(this).hasClass('est')){
				var intb = $('#sisslc_enc').val();
				var tp = 'est_id';
			}else{
				var intb = $('#form_md').val();
				var tp = 'md_id';
			}

			if(!isN(intb)){
				swal({
					title: '".TX_ETSGR."',
					text: '".TX_SWAL_SVE."!',
					type: 'warning',
					showCancelButton: true,
					confirmButtonClass: 'btn-danger',
					confirmButtonText: '".TX_YSV."',
					confirmButtonColor: '#E1544A',
					cancelButtonText: '".TX_CNCLR."',
					closeOnConfirm: true
				},
				function(){
					_Rqu({
						t:'scl_acc_attr',
						tp: tp,
						_id_fm : '".$__Prc->id."',
						_enc_fm : '".$__Prc->enc."',
						_nm_fm : '".$__Prc->nm."',
						_id_mdl : intb,
						_cl:function(_r){
							if(!isN(_r)){
								if(_r.e == 'ok'){

									if(tp == 'mdl_id'){
										$('._mdl_id').removeClass( 'ok' );
										$('.mdl_id_nm').html('".TX_MDL.": '+_r.e1.mdl_dt.tt".");
										$('li[rel=\'".$__Prc->enc."\']').addClass( '_mdl_t_on' );
										$('li[rel=\'".$__Prc->enc."\'] .mdl').removeClass( 'off' ).addClass( 'on' );

									}else if(tp == 'plcy_id'){
										$('._plcy_id').removeClass( 'ok' );
										$('.plcy_id_nm').html('Politica de datos: '+_r.e1.plcy_dt.nm".");
										$('li.tt_attr._id_plcy').addClass( 'ok' );
									}else if(tp == 'est_id'){
										$('._est_id').removeClass( 'ok' );
										$('.est_id_nm').html('Estado: '+_r.e1.est_tt".");
										$('li.tt_attr._id_est').addClass( 'ok' );

										if(_r.e1.est_dt.id != "._CId('ID_SISEST_OK')."){
											$('._c._c5._scrl._anm._rdy').removeClass('ok');
											$('.Dsh_Scl').removeClass('_form_r');
											$('li[rel=\'".$__Prc->enc."\']').remove();
										}

									}else{
										$('._md_id').removeClass( 'ok' );
										$('.md_id_nm').html('Medio: '+_r.e1.md_dt.nm".");
										$('li.tt_attr._id_md').addClass( 'ok' );
										$('li[rel=\'".$__Prc->enc."\'] figure._md').attr('style','background-image: url('+_r.e1.md_dt.img+')');

									}

									$('.items').removeClass( 'dsb' );
									swal('Proceso Exitoso', '', 'success');
								}
							}
						}
					});
				});
			}else{
				swal('Alerta!', '".'Campo Vacio seleccione un valor'."', 'error');
			}
		});

		var __sclacc_bx_form_itm = $('.fld span');

		__sclacc_bx_form_itm.off('click').click(function(e){

			var __vl = $(this).parent().attr('rel');
			var __rlc = $(this).parent().attr('data');
			var __enc = $(this).parent().attr('data_enc');
			var __tp = $(this).parent().attr('tp');
			var __i = '$__i';

			_ldCnt({
				u:'".FL_FM_GN.__t('scl_acc_form',true).ADM_LNK_DT."' + __vl+'&rlc='+__rlc+'&_enc='+__enc+'&_tp='+__tp+'&___i='+__i+'&Rnd='+Math.random(),
				pop:'ok',
				trs:true,
				pnl:{
					e:'ok',
					s: 'l',
					tp:'h'
				}
			});

		});

		var _sclacc_bx_form_itm_opt = $('.fld_opt');

		_sclacc_bx_form_itm_opt.off('click').click(function(e){

			var __vl = $(this).attr('rel');
			var __rlc = $(this).attr('data');
			var __enc = $(this).attr('data_enc');
			var __tp = $(this).attr('tp');
			var __tp_ls = $(this).parent().parent().parent().attr('tp-ls');

			if(!isN(__tp_ls)){ var __ls = '&__tp_ls='+__tp_ls; }else{ var __ls = ''; }

			_ldCnt({
				u:'".FL_FM_GN.__t('scl_acc_form',true).ADM_LNK_DT."' + __vl+'&rlc='+__rlc+'&_enc='+__enc+'&_tp='+__tp+'&Rnd='+Math.random()+__ls,
				pop:'ok',
				trs:true,
				pnl:{
					e:'ok',
					s:'l',
					tp:'h'
				}
			});
		});

		var _sclacc_bx_form_leads = $('._leads');
		_sclacc_bx_form_leads.off('click').click(function(e){
			var __vl = $('._leads span').attr('rel');

			_ldCnt({
				u:'".FL_LS_GN.__t('scl_acc_form_leads',true)."&__i=' + __vl+'&Rnd='+Math.random()+'&Pr=Ls',
				pop:'ok',
				trs:true,
				pnl:{
					e:'ok',
					s: 'l',
					tp:'h'
				}
			});

		});
	";
?>
</div>
<style>
	.scl-acc-form-slc.inpt_colp .fld_opt{margin: 0 auto;border-bottom: 1px solid #dacdcd;width: 90%;padding: 3px 0;}
	.scl-acc-form-slc .inpt,
	.scl-acc-form-slc .inpt_colp{border: 1px solid;width: 45%;margin: 7px auto;border-radius: 6px;padding: 6px !important;cursor: pointer;position: relative}
	.scl-acc-form-slc .CollapsiblePanelContent .inpt_colp{ border: none;background-color: #f3f3f3;padding: 10px 15px; }
	.scl-acc-form-slc .inpt_colp_tt{cursor:pointer}
	.scl-acc-form-slc .tt_attr{position:relative;z-index:0;width:30px;height:30px;border-radius:50%;display:inline-block;font-size:0;border:none;margin: 5px 0px 10px 15px; cursor: pointer; background-color: #d9ddde; }
	.scl-acc-form-slc .tt_attr span{border: 1px solid var(--main-bg-color);padding: 5px;position: absolute;width: 6em;text-align: center;visibility: hidden;font-size: 12px;line-height: 10px;color: black; border-radius:8px;-moz-border-radius:8px;-webkit-border-radius:8px; background-color:white; }
	.scl-acc-form-slc .tt_attr:hover{background-color:transparent;z-index:1}
	.scl-acc-form-slc .tt_attr:hover span{visibility:visible;top:-15px;left:25px}
	.scl-acc-form-slc .inpt{position: relative;}
	.scl-acc-form-slc .fld.ok{ border: 1px solid #00c778;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;}
	.scl-acc-form-slc .fld span{background-repeat:no-repeat; width: 30px;height: 26px;position: absolute;background-size: 22px auto;background-position:center;top: 0;right: 0;}
	.scl-acc-form-slc .fld.ok span{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>scl_chk_ok.svg);}
	.scl-acc-form-slc .fld span{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>scl_chk_no.svg);}
	.scl-acc-form-slc .inpt.fld span:hover{background-size: 25px auto; }
	.scl-acc-form-slc .icns ul{ margin: 0; padding: 0; list-style: none;display: flex;justify-content: center; }
	.scl-acc-form-slc .icns{ width: 100%; background-color: #eff3f4; margin: 20px auto; border-radius: 10px; }
	.scl-acc-form-slc .icns .tt_attr{background-size: 60% auto;background-position:center;vertical-align: bottom;background-repeat: no-repeat;}
	.scl-acc-form-slc .icns .tt_attr._tt{background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>acc_cnct.svg);}
	.scl-acc-form-slc .icns .tt_attr._aut{background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>mail_social.svg);}
	.scl-acc-form-slc .icns .tt_attr._url{background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>chk_ner.svg);}
	.scl-acc-form-slc .icns .tt_attr._md{background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>ls_md.svg);}
	.scl-acc-form-slc .icns .tt_attr._id_mdl{background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>landing-page.svg);}
	.scl-acc-form-slc .icns .tt_attr._id_plcy{background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>politicas.svg);}
	.scl-acc-form-slc .icns .tt_attr._leads{background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>act_rsp.svg);}
	.scl-acc-form-slc .icns .tt_attr._id_md{background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>medio.svg);}
	.scl-acc-form-slc .icns .tt_attr._id_est{background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lrn_vd_play.svg);}
	.scl-acc-form-slc .fld.fld_opt {padding: 3px;cursor: pointer;width: 95%;margin: 5px auto;border-radius: 4px;background-repeat: no-repeat;}
	.scl-acc-form-slc .fld.fld_opt:hover {background-color: #e8e8e8;}
	.scl-acc-form-slc .fld_opt.ok{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>scl_chk_ok.svg);background-size: 16px;background-position:center right 3px;}

	.slct.ok{ height: 60px !important; padding-top: 12px ; }
	.slct.no{ height: 0; overflow: hidden; }

	.slct.ok .styled-select-bx{ width: 80%; display: inline-block; }
	.slct.ok p.edi{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>diskette.svg'); }
	.slct.ok p.cal{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>scl_mn_chkno.svg'); }

	.dsb{ pointer-events: none; }

	p.btn__d{width: 35px;height: 35px;margin: 0; vertical-align: top;display: inline-block;background-position: center;background-repeat: no-repeat;background-size: 70%;cursor: pointer; }

	.scl-acc-form-slc .tt_attr._id_mdl span{ width: 25em !important; top: 30px !important;left: -186px !important; }
	.tt_attr._id_plcy.ok{background-color: #5edc9c;}
	.tt_scl{position: sticky;
    left: 0;
    top: 0;
    width: 80%;
    margin: 15px auto;
    text-align: center;
    z-index: 10;
    background-color: white;
    font-family: Economica;
    text-transform: uppercase;
    border-bottom: 3px solid var(--main-bg-color);
    font-weight: 300;
    padding: 5px 0;
    font-size: 20px;}

	.slct .styled-select-bx{margin: 0 auto;
    display: block;}

</style>