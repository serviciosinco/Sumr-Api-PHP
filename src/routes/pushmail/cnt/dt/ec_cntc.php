<?php 
$__id_fm = 'FmTll';
	
if($__dtec->id != NULL){
	$c_Rlc = '1,2,3,4,5'; if($__dtec->fm != NULL){ $c_Rlc = $__dtec->fm; }
	$Ls_Qry = "SELECT * FROM sis_fm WHERE id_sisfm IN (".$c_Rlc.") ORDER BY sisfm_or ASC";
	$Fld_Fm = $__cnx->_qry($Ls_Qry); 
	
	if($Fld_Fm){
		$row_Fld_Fm = $Fld_Fm->fetch_assoc(); 
		$Tot_Fld_Fm = $Fld_Fm->num_rows; 
	}
}

?>

<div class="_fm"> 
        <div class="wrp">  
					<div class="_col1"> 
                        <h1>
                        	Más Información
                            <?php 
								list($_w, $_h, $_t, $_a) = getimagesize($__dtec->img_v->big);
								if ($_w < 400) { 
									$__mxhgimg = 'max-height:100px; max-width:100px;';
									$__mxwdimg = '';
								}else{
									$__mxhgimg = '';
									$__mxwdimg = '100%';
								}
							?>
							
							<?php if(!isN($__dtec->img_v->big)){ ?>
                            <div>
	                            <img src="<?php echo $__dtec->img_v->big ?>" width="<?php echo $__mxwdimg ?>" style="<?php echo $__mxhgimg ?>"/> 
	                        </div>
                            <?php } ?>
                            
                            <?php echo Spn($__dtec->tt); ?> 
                            
                        </h1> 
                        <p><?php echo $__dtec->cl->tag->txta->{'plcy-txt'}->v ?></p>
                        <h3><a href="<?php echo $__dtec->cl->tag->lnk->{'plcy-link'}->v ?>" target="_blank"><?php echo TT_PLCY ?></a></h3>  	
                    </div> 
                    <div class="_col2">
    					<div class="_logo"><img src="<?php echo $__dtec->cl->lgo->lght->big ?>" /></div>
                        <?php if($Tot_Fld_Fm > 0){ ?>
                        <form action="inc/prc/_gn.php?_t=cntc" method="POST" name="<?php echo $__id_fm ?>" id="<?php echo $__id_fm ?>">
                          <input name="SndUs" id="SndUs" type="hidden" value="On" />
                          <input name="SndEmad" id="SndEmad" type="hidden" value="On" />
                          <input name="_i" id="_i" type="hidden" value="<?php echo $__dtec->enc ?>" />
                          <input name="MM_Send" id="MM_Send" type="hidden" value="EcCntc" />
                          <div id="<?php echo $__id_fm ?>_ld" class="_ld"></div>
                          <div id="<?php echo $__id_fm ?>_rsl" class="_rsl"></div>
                          <div id="<?php echo $__id_fm ?>_flds"> 
                                  <ul>
                                    <?php do { ?>   
                                            <?php if($row_Fld_Fm['sisfm_tp'] == 'textarea'){ ?>
                                                <li><?php echo _HTML_Text($row_Fld_Fm['sisfm_cmp'], ctjTx($row_Fld_Fm['sisfm_nm'],"in")); ?></li>
                                            <?php } else{ ?>
                                            	 <li><?php echo _HTML_Input($row_Fld_Fm['sisfm_cmp'], ctjTx($row_Fld_Fm['sisfm_nm'],"in"), '', constant($row_Fld_Fm['sisfm_rq']), $row_Fld_Fm['sisfm_tp']); ?></li>
                                            <?php } ?>     
                                    <?php } while ($row_Fld_Fm = $Fld_Fm->fetch_assoc()); ?>
                                  	<li class="_snd">
                                      <input class="botonEnviar" type="submit" name="Submit"  value="<?php echo TX_SND ?>">
                                    </li>
                                  </ul> 
                          </div>
                        </form>
                        <?php } ?>
                        
                    </div>                   
		</div>
</div>
<?php 

if(!ismobile()){
	$_Qtp_Ps = 'top right';
}else{
	$_Qtp_Ps = 'bottom left';
}

$_CntJQ .= "
		
		var _ldr = $('#".$__id_fm."_ld');
        var _fm = $('#".$__id_fm."');
		var _fmflds = $('#".$__id_fm."_flds');
		var _fmrsl = $('#".$__id_fm."_rsl');
		var _u = '<h2 class=\'_okmsj\'>".TX_THX."<br><span>".TX_THX_MSG."</span></h2>';

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
		
		$('input[type=\"text\"], input[type=\"email\"]').each(function(){
			 $(this).qtip({
					content: $(this).attr('placeholder'),
					position: {
						at: '".$_Qtp_Ps."'
					},
					show: {
						effect: function(offset) {
							$(this).slideDown(100);
						}
					}
			});
		});	
		
		
		$('input').keyup(function() {
                var _i = $(this);
                if(_i.val() != '') { $(_i).addClass('_ok'); }else{ $(_i).removeClass('_ok'); }   
		});
		
		"; 
	
$__cnx->_clsr($Fld_Fm);	
?>