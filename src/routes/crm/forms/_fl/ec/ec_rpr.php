<?php
	$__id_fm = 'FmRpr';
 	$_i = Php_Ls_Cln($_GET['__i']);
	$__dtec = GtEcDt($_i);
	$__url = DMN_FLE_EC_IMG.$__dtec->img;
?>
<style>
	._fm ._rsl{ border: 0 !important }
	._img{ background-image: url(<?php echo $__url ?>) !important ;width: 300px !important;
    height: 254px;
    background-size: contain !important;
    margin: 0 auto; }
</style>
<div class="_fm">
        <div class="wrp">
            <form action="includes/process/_gn.php?_t=ec_rpr" method="POST" target="_blank" name="<?php echo $__id_fm ?>" id="<?php echo $__id_fm ?>">
              <input name="SndUs" id="SndUs" type="hidden" value="On" />
              <input name="_i" id="_i" type="hidden" value="<?php echo $__dtec->id ?>" />
              <input name="MM_Send" id="MM_Send" type="hidden" value="EcRprt" />
              <div id="<?php echo $__id_fm ?>_ld" class="_ld"></div>
              <div id="<?php echo $__id_fm ?>_rsl" class="_rsl"></div>
              <div id="<?php echo $__id_fm ?>_flds">

	              		<?php    ?>
                      <div class="_img"></div>
                      <ul>
  						<li>
                            <div class="_ln">
                                <div class="_slc">
									<?php echo LsUs('us','id_us', '', '', 2); $CntWb .= JQ_Ls('us',''); ?>
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
		var _u = '<h2 class=\'_okmsj\'>".TX_MSJ."<br><span>".TX_ENVD."</span></h2>';

        function ShLodSndCnt() { _ldr.fadeIn('fast'); _fmflds.fadeOut('fast'); };

		function _getRsl(_r){
			 _ldr.fadeOut('slow', function(){
						if(_r.w != 'undefined' && _r.w != null){ alert(_r.w); }
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