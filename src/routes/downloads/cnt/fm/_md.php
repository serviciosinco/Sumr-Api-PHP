<?php $pth = '../../../../includes/'; include($pth .'__inc.php'); ob_start("compress_code");



	$__id_fm = 'FmRpr';
 	$_vl = Php_Ls_Cln($_GET['__i']);
	$__t = Php_Ls_Cln($_GET['__t']);

	if($__t == 'prg_md'){
		$__dt = json_decode(GtPrgDt($_vl));
		$__dt_pml = DMN_HTTP.SBD_ADMIS.'.'.DMN.PrmLnk('bld', LNK_PRG).PrmLnk('bld', $__dt->pml);
	}elseif($__t == 'psg_md'){
		$__dt = json_decode(GtPsgDt($_vl));
		$__dt_pml = DMN_HTTP.  (($__dt->fac_pml != NULL) ? $__dt->fac_pml.'.' : '')  .DMN.PrmLnk('bld', LNK_PSG).PrmLnk('bld', $__dt->pml);
	}elseif($__t == 'con_md'){
		$__dt = json_decode(GtConDt($_vl));
		$__dt_pml = DMN_HTTP. (($__dt->fac_pml != null) ? $__dt->fac_pml.'.' : '')  .DMN.PrmLnk('bld', LNK_CON).PrmLnk('bld', $__dt->pml);
	}elseif($__t == 'psg_gen_md'){
		$__dt = json_decode(GtPsgGenDt($_vl));
		$__dt_pml = DMN_HTTP. (($__dt->fac_pml != null) ? $__dt->fac_pml.'.' : '')  .DMN.PrmLnk('bld', LNK_PSG).PrmLnk('bld', LNK_G).PrmLnk('bld', $__dt->pml);
	}elseif($__t == 'evn_md'){
		$__dt = json_decode(GtEvnDt($_vl));
		$__dt_pml = DMN_HTTP. (($__dt->fac_pml != null) ? $__dt->fac_pml.'.' : '') .DMN.PrmLnk('bld', LNK_EVN).PrmLnk('bld', $__dt->pml);
	}elseif($__t == 'actv_md'){
		$__dt = json_decode(GtActvDt($_vl));
		$__dt_pml = DMN_HTTP.SBD_ADMIS. (($__dt->fac_pml != null) ? $__dt->fac_pml.'.' : '') .DMN.PrmLnk('bld', LNK_ACTV).PrmLnk('bld', $__dt->pml);
	}

?>

<div class="_fm">
        <div class="wrp">
            <form action="<?php echo $__dt_pml ?>" method="get" target="_blank" name="<?php echo $__id_fm ?>" id="<?php echo $__id_fm ?>">
              <div id="<?php echo $__id_fm ?>_ld" class="_ld"></div>
              <div id="<?php echo $__id_fm ?>_rsl" class="_rsl"></div>
              <div id="<?php echo $__id_fm ?>_flds">
                      <div class="_img" id="__url_end"><img src="<?php echo DMN_IMG_ESTR ?>hdr_cdf.jpg"/></div>

                            <div class="_ln">
                                <div class="_slc">
									<?php echo LsSis_Md('_md','id_sismd', '', '', '', FM_LS_MD); ?>
                                </div>
                                <div class="_snd">
                               	  <input id="Snd_CodeUrl" name="Snd_CodeUrl" type="button" value="<?php echo TX_SND ?>">
                                </div>
                            </div>
                            <div class="_ln _nwrp">
                            	<?php echo h2(TX_TRCKN);  ?>
                                <div class="col_1">
                                    <ul class="_opt">
                                        <?php echo li(_HTML_Input('_ky', TX_MDKYW,'','','checkbox')); ?>
                                        <?php echo li(_HTML_Input('_kyc', TX_MDKYWCNC,'','','checkbox')); ?>
                                        <?php echo li(_HTML_Input('_nt', TX_TRCNET,'','','checkbox')); ?>
                                        <?php echo li(_HTML_Input('_crt', TX_TRCCRTV,'','','checkbox')); ?>
                                    </ul>
                                </div>
                                <div class="col_2">
                                    <ul class="_opt">
                                        <?php echo li(_HTML_Input('_plc', TX_TRCPLC,'','','checkbox')); ?>
                                        <?php echo li(_HTML_Input('_trg', TX_TRCTRG,'','','checkbox')); ?>
                                        <?php echo li(_HTML_Input('_pst', TX_TRCADPST,'','','checkbox')); ?>
                                    </ul>
                                </div>
                            </div>

              </div>
              <script type="text/javascript">

							<?php echo JQ_Ls('_md',FM_LS_MD); ?>


							$('#Snd_CodeUrl').click(function(){


								var __md_v = $('#_md').val();

								if ($('#_ky').is(':checked')){ var __md_ky_q = '&__k={keyword}'; }else{ var __md_ky_q = ''; }
								if ($('#_kyc').is(':checked')){ var __md_kyc_q = '&__kc={matchtype}'; }else{ var __md_kyc_q = ''; }
								if ($('#_nt').is(':checked')){ var __md_nt_q = '&__nt={network}'; }else{ var __md_nt_q = ''; }
								if ($('#_crt').is(':checked')){ var __md_crt_q = '&__crt={creative}'; }else{ var __md_crt_q = ''; }
								if ($('#_plc').is(':checked')){ var __md_plc_q = '&__plc={placement}'; }else{ var __md_plc_q = ''; }
								if ($('#_trg').is(':checked')){ var __md_trg_q = '&__trg={target}'; }else{ var __md_trg_q = ''; }
								if ($('#_pst').is(':checked')){ var __md_pst_q = '&__pst={adposition}'; }else{ var __md_pst_q = ''; }


								if((__md_v != '') && (__md_v != 'undefined')){
									var __md_v_q = '_md='+__md_v;
									var __url = '<?php echo $__dt_pml; ?>?'+__md_v_q + __md_ky_q + __md_kyc_q + __md_nt_q + __md_crt_q + __md_plc_q + __md_trg_q + __md_pst_q;

									$('#__url_end').html('<div class=\"__url\"><a href=\"'+__url+'\" target=\"_blank\">'+__url+'</a></div>');

								}

							});
			</script>
            </form>
    </div>
</div>
<?php echo ob_end_flush(); ?>