<?php
if(class_exists('CRM_Cnx')){

	$___Ls->ino = 'id_ofrfle';
	$___Ls->ik = 'ofrfle_enc';
	$___Ls->sch->f = 'ofrfle_tt, ofrfle_tp, ofrfle_dsc, ofrfle_fle';
	$___Ls->_strt();
		
	$__idtp_fle_fm = DV_LSFL.'_fle_fm';
	
	if(_SbLs_ID('i')){ $__fl .= _AndSql('ofrfle_ofr', _SbLs_ID('i')); }
	

	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".$__bd." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
		
		$Ls_Whr = "FROM ".MDL_EMP_OFR_FLE_BD."
				   		LEFT JOIN ".MDL_EMP_OFR_BD." ON ofrfle_ofr = id_ofr
				   WHERE ".$___Ls->ino." != '' $__fl ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
				   
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";  
		
	} 

?>
<?php if($___Ls->ls->chk=='ok'){ ?>

<div class="ln_1">

        <div class="col_1">
      			<div id="UplFleNw" class="UplFleNw">
                    <form id="UplNwB" class="UplNwB" method="post" action="<?php echo PRC_UPLD_GN.'?'.TXGN_UPLFLE ?>" enctype="multipart/form-data">
                        <div id="drop" class="_drop">
                        	<div class="_bar"></div>
                            <?php echo TX_ARRTRAQ ?><br><?php echo Spn('Archivos soportados (PDF)');  ?>
                            <a><?php echo TX_EXPLR ?></a>
                            <input type="file" name="upl" multiple />
                            <input ide="_tp" name="_tp" type="hidden" value="<?php echo $__bdtp ?>" />
                            <input ide="_id" name="_id" type="hidden" value="<?php echo _SbLs_ID('i') ?>" />
                            <input name="MM_update" type="hidden" value="FleUplNw" />
                        </div>
                        <ul></ul>
                    </form>
                </div> 
        </div>
        <div class="col_2">
          	<?php if(($___Ls->qry->tot > 0)){ ?>

	            <div id="<?php echo $__idtp_fle_fm ?>">
	            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
	              	<thead>
	                      <tr>
	                        <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
	                        <th width="0%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
	                        <th width="1%" <?php echo NWRP ?>><?php echo TX_FFENV ?></th>
	                        <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
	                        <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
	                      </tr>
	              	</thead>
				  	<tbody>
						<?php do { ?>
                          	<tr
                                <?php      
                                    if($___Ls->ls->rw['ofrfle_fe'] != '' && $___Ls->ls->rw['ofrfle_dsc'] != ''){ $__rw_clr = '000'; $__rw_adv = ''; }else{ $__rw_clr = 'C00'; $__rw_adv = HTML_BR.Spn(TX_ADVCHNG, '', '_adv'); } $_clr_rw = ' style="color:#'.$__rw_clr.';" ';
                                ?>
	                        >
	                            <td align="left" ><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
	                            <td align="left" <?php echo $_clr_rw ?>><a href="__fle/ofr/<? echo $___Ls->ls->rw['ofrfle_fle']; ?>" style="text-decoration: none" target="_blank"><?php echo ctjTx($___Ls->ls->rw['ofrfle_tt'],'in').$__rw_adv; ?></a></td>
	                            <td align="left"><?php echo Spn($___Ls->ls->rw['ofrfle_fe']); ?></td>  
	                            <td width="1%" align="left" nowrap="nowrap" class="_btn">
	                                 <?php if(_ChckMd('con_mod')){ ?>
	                                        <?php echo $___Ls->_btn([ 't'=>'mod' ]); ?>
	                                 <?php } ?>
	                                 
	                                 <td width="1%" align="left" nowrap="nowrap" class="_btn">
										<?php echo $___Ls->_btn([ 't'=>'mod' ]); ?>
									</td>
	                                 
	                            </td>
							</tr>
	                    <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
	                </tbody>
	            </table>
	            <?php   $CntWb .= '$("._fle_dt").colorbox({ width:"90%", height:"90%", iframe:true, trapFocus:false, overlayClose:false, escKey:false  }); ';  ?>
	            <?php $___Ls->_bld_l_pgs(); ?>
	            
	            </div>
			<?php } ?>
       
       <?php $___Ls->_h_ls_nr(); ?>
        </div>

</div>
          
       
        <?php $CntWb .= "
										
				var e = $('#UplNwB ul');

				$('#drop a').off('click').click(function() {
					$(this).parent().find('input').click()
				});
				
				SUMR_Main.ld.f.upl( function(){

					if(jQuery().fileupload){

						$('#UplNwB').fileupload({
							dataType: 'json',
							sequentialUploads: true,
							dropZone: $('#drop'),
							add: 
							
								function(n, r) {
									var i = $('<li class=\"working\"><input type=\"text\" value=\"0\" data-width=\"48\" data-height=\"48\"' + ' data-fgColor=\"#0788a5\" data-readOnly=\"1\" data-bgColor=\"#3e4043\" /><p></p><span></span></li>');
									i.find('p').text(r.files[0].name).append('<i>' + SUMR_Ld.f.nSz(r.files[0].size) + '</i>');
									r.context = i.appendTo(e);
									i.find('input').knob();
									i.find('span').click(function() {
										if (i.hasClass('working')) {
											s.abort()
										}
										i.fadeOut(function() {
											i.remove()
										})
								});
								var s = r.submit()
							},
							progress: function(e, t) {
								var n = parseInt(t.loaded / t.total * 100, 10);
								t.context.find('input').val(n).change();								
							},
							progressall: function (e, data) {
								var n = parseInt(data.loaded / data.total * 100, 10);
								$('#UplNwB ._bar').fadeIn('fast').css(
									'width',n + '%'
								);
							},
							fail: function(e, t) {
								t.context.addClass('error')
							},
							done: function (e, t) {
								var n = parseInt(t.loaded / t.total * 100, 10);
								if (n == 100 && t.result.status == 'success') {	
									t.context.removeClass('working').delay(1000).fadeOut('fast');
								}else{
									t.context.addClass('error');
									if(t.result.w != 'undefined' && t.result.w != undefined){ swal('Error', t.result.w, 'error'); }
								}
							},
							stop: function (e) {
								$('#UplNwB ._bar').fadeOut('slow', function(){
									"._DvLsFl(['i'=>'_fle', 't'=>'s'])."
								});	
							}
						});

					}
						
				});
				
				/*$(document).on('drop dragover', function(e) {
					e.preventDefault();
				});*/
		"; ?>

<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>


<div class="FmTb">
  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
      <?php $___Ls->_bld_f_hdr(); ?>

      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
    <div class="ln_1">
       			<?php echo SlDt([ 'id'=>'ofrfle_fe', 'va'=>$___Ls->dt->rw['ofrfle_fe'], 'rq'=>'no', 'ph'=>TX_FFENV, 'lmt'=>'no', 'cls'=>CLS_CLND ]); ?>
                <?php echo HTML_textarea('ofrfle_dsc', '', ctjTx($___Ls->dt->rw['ofrfle_dsc'],'in'), '', 'ok'); ?>
          
        </div>
      </div>
    </form>
  </div>

</div>
<?php } ?>

<?php } ?>
