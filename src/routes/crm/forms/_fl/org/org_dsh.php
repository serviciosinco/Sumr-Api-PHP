<?php
	$__id_fm = 'FmRpr';
    $_i = Php_Ls_Cln($_GET['__i']);
    $_id = Php_Ls_Cln($_GET['_id']);
    $_t3 = Php_Ls_Cln($_GET['_t3']);
    $_tp = Php_Ls_Cln($_GET['_tp']);
    $_bx = Php_Ls_Cln($_GET['_box']);
    $_tp_o = Php_Ls_Cln($_GET['_tpo']);
    $tpo = Php_Ls_Cln($_GET['tpo']);

    $__org_tp = __LsDt([ 'k'=>'org_tp' ]);

	foreach($__org_tp->ls->org_tp as $k => $v){
		if($v->key->vl == $__t2){
			$_tp_org = $v->id;
		}
	}

    $_mdlstp_dt = GtMdlSTpDt(['tp'=>$_t3]);
    $_dt_orgdsh = GtOrgDshDt([ 'cl'=>DB_CL_ID, 'tp'=>$_tp_org, 'id'=>$_id ]);

?>
<style>
	._fm ._rsl{ border: 0 !important }
	._img{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>grph_hide.svg) !important ;width: 300px !important;height: 300px; background-repeat: no-repeat !important; background-position: center !important;background-size: 60% auto !important;margin: 0 auto; border: 0 !important; }
    ._snd{ display: block; }
    ._slc, ._snd{ margin: 0 auto;display: block !important; }
    .org_dsh_fm ._snd input[type=submit]{ width:100% !important;margin-top: 20px; }
</style>
<div class="_fm org_dsh_fm">
    <div class="wrp">
            <form action="includes/process/_gn.php?_t=org_dsh" method="POST" target="_blank" name="<?php echo $__id_fm ?>" id="<?php echo $__id_fm ?>">
              <input name="SndUs" id="SndUs" type="hidden" value="On" />
              <input name="MM_Send" id="MM_Send" type="hidden" value="OrgDsh" />
              <div id="<?php echo $__id_fm ?>_ld" class="_ld"></div>
              <div id="<?php echo $__id_fm ?>_rsl" class="_rsl"></div>
              <div id="<?php echo $__id_fm ?>_flds">
                      <div class="_img"></div>
                      <ul>
  						<li>
                            <div class="_ln">
                                <div class="_slc">

                                    <?php
                                        echo HTML_inp_hd('id_orgdsh', $_id);
                                        echo HTML_inp_hd('orgdsh_tp', $_tp);

                                        if(isN($_id)){

                                            $l = __Ls([ 'k'=>'org_dsh_otp', 'id'=>'orgdsh_otp', 'va'=>'', 'ph'=>'Tipo de dato', 'fcl'=>'ok' ]);
                                            echo $l->html; $CntWb .= $l->js;

                                            echo HTML_inp_hd('orgdshrowcolfld_orgdshrowcol', $_bx);

                                            $CntWb .= "
                                                $('#orgdsh_otp').change(function(){

                                                    var ls_i = $(this).val();

                                                    SUMR_Main.ld.f.slc({
                                                        i:1,
                                                        t:'org_dsh',
                                                        b:'org_dsh_bx',
                                                        d:{
                                                            _ls_i : ls_i,
                                                            _tp : '".$_mdlstp_dt->id."',
                                                        }
                                                    });

                                                });
                                            ";

                                        }else{
                                            $CntWb .= "

                                                SUMR_Main.ld.f.slc({
                                                    t:'org_dsh',
                                                    b:'org_dsh_bx',
                                                    d:{
                                                        _ls : '".$_dt_orgdsh->dt->obj->lst."',
                                                        _tp : '".$_mdlstp_dt->id."',
                                                        _vl : '".$_dt_orgdsh->dt->vl."',
                                                        _tpo : '".$tpo."'
                                                    }
                                                });


                                            ";
                                        }


                                    ?>

                                    <div id="org_dsh_bx" class="_sbls"></div>
                                </div>
                                <div class="_snd">
                                	<input id="botonEnviar" type="submit" name="Submit"  value="<?php echo TXBT_GRDR ?>">
                                </div>
                            </div>
                        </li>
                      </ul>
              </div>
            </form>
    </div>
</div>
<?php

$CntWb .= "

		var _ldr = $('#".$__id_fm."_ld');
        var _fm = $('#".$__id_fm."');
		var _fmflds = $('#".$__id_fm."_flds');
		var _fmrsl = $('#".$__id_fm."_rsl');

        function ShLodSndCnt() { _ldr.fadeIn('fast'); _fmflds.fadeOut('fast'); };

		function _getRsl(_r){
			 _ldr.fadeOut('slow', function(){
                if(_r.w != 'undefined' && _r.w != null){ alert(_r.w); }
                if (_r.e == 'ok') {

                    SUMR_Main.pnl.f.shw();

                    SUMR_Org.f.rqu({
                        t: 'org_dsh',
                        tp: '".$_tp."',
                        dt: 'ls',
                        d:{
                            _i: '".$_i."',
                            _t2: '".$_t3."'
                        },
                        _bs:function(){  },
                        _cm:function(){  },
                        _cl:function(_r){
                            if(!SUMR_Ld.f.isN(_r) && _r.e == 'ok'){
                                if(!SUMR_Ld.f.isN(_r.dash)){
                                    SUMR_Org.f.set(_r.dash);
                                }
                            }
                        }
                    });

                } else if (_r.e == 'no_send') {
                    _fmflds.fadeIn('fast');
                } else {
                    _fmflds.fadeIn('fast');
                }
            });
		}

        var _OpcSnd = {
            type: 'POST',
			dataType: 'json',
            beforeSubmit: ShLodSndCnt,
			async: false,
            success: function(_r){
						_getRsl(_r);
				     },
			error: function (xhr, ajaxOptions, thrownError) {
				_getRsl();
			}
        };

        _fm.ajaxForm(_OpcSnd);
        _fm.validate({
  			errorPlacement: function(error,element) {return true;}
		});
    ";
?>