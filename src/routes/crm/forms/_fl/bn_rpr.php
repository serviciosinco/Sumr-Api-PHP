<?php

	$__id_fm = 'FmRpr';

 	$_i = Php_Ls_Cln($_GET['__i']);
	$__dtbn = json_decode(GtBnDt($_i));
?>

<div class="_fm">
        <div class="wrp">
            <form action="includes/process/_gn.php?_t=bn_rpr" method="POST" target="_self" name="<?php echo $__id_fm ?>" id="<?php echo $__id_fm ?>">
              <input name="SndUs" id="SndUs" type="hidden" value="On" />
              <input name="_i" id="_i" type="hidden" value="<?php echo $__dtbn->id ?>" />
              <input name="MM_Send" id="MM_Send" type="hidden" value="BnRprt" />
              <div id="<?php echo $__id_fm ?>_ld" class="_ld"></div>
              <div id="<?php echo $__id_fm ?>_rsl" class="_rsl"></div>
              <div id="<?php echo $__id_fm ?>_flds">
                      <div class="_img"><img src="<?php echo DMN_IMG_WB.'_ec/'.$__dtec->img; ?>" /></div>
                      <ul>
  						<li>
                            <div class="_ln">
                                <div class="_slc">
									<?php ?>
                                </div>
                                <div class="_snd">
                                	<input id="botonEnviar" type="submit" name="Submit"  value="<?php echo TX_SND ?>">
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
		var _u = '<h2 class=\'_okmsj\'>'".TX_MSJ."'<br><span>'".TX_ENVD.'"</span></h2>';

        function ShLodSndCnt() { _ldr.fadeIn('fast'); _fmflds.fadeOut('fast'); };

		function _getRsl(_r){
			 _ldr.fadeOut('slow', function(){
						if (_r.e == 'ok') {
							_fmrsl.fadeOut('fast', function(){
								$(this).append(_u).fadeIn('fast');
							})
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