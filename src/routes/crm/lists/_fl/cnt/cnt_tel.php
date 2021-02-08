<?php 
if(class_exists('CRM_Cnx')){
	
	$__tb = Php_Ls_Cln($_GET['Tb']);
	
	$___Ls->cnx->cl = 'ok';

	$___Ls->sch->m = ' || (
		EXISTS (SELECT * FROM '.TB_CNT_EML.' WHERE cnteml_cnt = id_cnt AND cnteml_eml LIKE \'%[-SCH-]%\' )  ||
		EXISTS (SELECT * FROM '.TB_CNT_DC.' WHERE cntdc_cnt = id_cnt AND cntdc_dc LIKE \'%[-SCH-]%\' ) ||
		EXISTS (SELECT * FROM '.TB_CNT_TEL.' WHERE cnttel_cnt = id_cnt AND cnttel_tel LIKE \'%[-SCH-]%\' ) 
	)';
	
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->isb)){ $__fl .= $___Ls->_andsql([ 'f'=>'cnt_enc', 'v'=>$___Ls->gt->isb ]); }
	
	if(!isN($___Ls->gt->i)){


		$___Ls->qrys = sprintf("SELECT * FROM ".TB_CNT_TEL.", ".TB_CNT.",  "._BdStr(DBM).TB_SIS_PS.", "._BdStr(DBM).MDL_SIS_TEL_BD."
						   WHERE cnttel_ps = id_sisps AND
						   		 cnttel_tp = id_sistel AND
						   		 cnttel_cnt = id_cnt AND 
								 ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));	
	}elseif($___Ls->_show_ls == 'ok'){

		$Ls_Whr = " FROM ".TB_CNT_TEL."
						 INNER JOIN ".TB_CNT." ON cnttel_cnt = id_cnt
						 INNER JOIN "._BdStr(DBM).TB_SIS_PS." ON cnttel_ps = id_sisps
						 INNER JOIN "._BdStr(DBM).MDL_SIS_TEL_BD." ON cnttel_tp = id_sistel

						 LEFT JOIN ".TB_CNT_PLCY." ON (cntplcy_cnt = cnttel_cnt AND cntplcy_sndi=1)
						 LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." ON (cntplcy_plcy = id_clplcy AND clplcy_e=1)

					WHERE id_cnttel != '' $__fl ".$___Ls->sch->cod." 
					ORDER BY cnttel_fi DESC";
		$___Ls->qrys = "SELECT id_cnttel, cnttel_enc, cnttel_tel, cnttel_fi, sistel_nm, cntplcy_sndi, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
		
	} 
	
	
	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ $__blq = 'off'; ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<style>
	.ls_plcy{list-style-type: none;margin: 5px 0;padding: 0; }
	.ls_plcy li{color: #a0a0a0;font-size: 11px;}
	.ls_plcy li.plcy_1 span,
	.ls_plcy li.plcy_2 span{ width: 15px;height: 15px;display: inline-block;vertical-align: middle;margin-right: 10px;margin-bottom: 5px; }
	.ls_plcy li.plcy_1 span{ background-image: url(<?php echo DMN_IMG_ESTR_SVG; ?>cnt_sndi_ok.svg);}
	.ls_plcy li.plcy_2 span{ background-image: url(<?php echo DMN_IMG_ESTR_SVG; ?>cnt_sndi_no.svg);}
	._img_ps {
	    background-position: center;
	    background-size: auto 100%;
	    border-radius: 50%;
	    width: 25px;
	    height: 25px;margin: 0 auto;
	}
</style>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
	<thead>
        <tr>
        	<th width="1%" <?php echo NWRP ?>></th>
            <th width="10%" <?php echo NWRP ?>><?php echo TX_TP; ?></th>
            <th width="10%" <?php echo NWRP ?>><?php echo TT_FM_PS; ?></th>
            <th width="78%" <?php echo NWRP ?>><?php echo TX_TEL; ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_FI; ?></th>
            <th width="1%" <?php echo NWRP ?>></th>
        </tr>
	</thead>
	<tbody>
		<?php do { $__ls_json[] = $___Ls->ls->rw['cnttel_enc']; ?>
		<?php 
			$img_th = _ImVrs(['img'=>$___Ls->ls->rw['sisps_img'], 'f'=>DMN_FLE_PS]);
			
			if($___Ls->ls->rw['cnttel_est'] != _CId('ID_SISTELEST_ACTV')){
				$__cls_del = 'del';
			}else{
				$__cls_del = '';
			}

			$__tel_nrml = 	_plcy_scre([ 
				'v'=>ctjTx($___Ls->ls->rw['cnttel_tel'],'in'),
				'plcy'=>[ 'e'=>$___Ls->ls->rw['cntplcy_sndi'] ]  
			]);
		?>
		<tr cnttel-id-no="<?php echo $___Ls->ls->rw['id_cnttel']; ?>" class="<?php echo $__cls_del; ?>">   
	             
            <td width="1%" align="left" nowrap="nowrap"><?php echo $___Ls->ls->rw[$__id]; ?></td>
            <td width="10%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sistel_nm'],'in'),50); ?></td>
			<td width="10%" align="left" nowrap="nowrap"><?php //print_r($img_th->th_50) ?>
            <div class="_img_ps" style="background-image:  url( <?php print_r($img_th->th_50);  ?>); "></div>
            </td>
            <td width="78%" align="left" nowrap="nowrap"><?php echo ShortTx($__tel_nrml,50); ?><?php echo bdiv([ 'cls'=>'bx_ul_plcy' ]) ?></td>

            <td width="1%" align="left" nowrap="nowrap"><?php echo Spn($___Ls->ls->rw['cnttel_fi'],'','_f'); ?></td>  
            <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td> 
        </tr>
        <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
        <?php $CntWb .= " $('#".TBGRP."_tel ._n').html('".$___Ls->qry->tot."'); "; ?>
  	</tbody>
</table>

<style>	
	
	.Ls_Rg tr.del{ background-color: #ffeaea; text-decoration: line-through; }
	
</style>

<?php 
	$CntJV .=	"

		function __getCntTel(){

			$.post('".Fl_Rnd(FL_JSON_GN.__t('cnt_tel_ext',true))."', { mdl_mdls:'".$___Ls->mdlstp->tp."', mdlcnt:'".implode(',', $__ls_json)."' },
            
            function(d, status){
               	if(d.e == 'ok'){
                    if( d.total > 0 ){
                        $.each(d.l, function(_k, _v) { 
                            if(!isN(_v.plcy)){
	                        	
		                        $('tr[cnttel-id-no='+_v.id+'] .bx_ul_plcy').html( '<ul class=\"ls_plcy\">'+_v.plcy+'</ul>' );	
	                        	
                            }
                        });
                    }  
                }
            }); 
        } 
	";
	
	$CntWb .= " setTimeout(function(){ __getCntTel(); ".$__grph_shw." }, 1000); ";
	
	
?>

<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>

<?php if($___Ls->fm->chk=='ok'){ 
	
	
	$____plcy = GtCntTelPlcyLs([ 'tel'=>$___Ls->dt->rw['id_cnttel'], 'e'=>'on' ]);
	
	
?>
<div class="FmTb">
  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
        <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >

		<?php $___Ls->_bld_f_hdr(); ?>

	  	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?> dsh_cnt_tel <?php if(($___Ls->dt->tot == 0)){ echo '_new'; } ?>">
        
			<div class="ln_1">
				
				<div class="col_1">
					
					<?php echo LsSis_Tel('cnttel_tp','id_sistel', $___Ls->dt->rw['cnttel_tp'], FM_LS_SLTEL, 2); $CntWb .= JQ_Ls('cnttel_tp', FM_LS_SLTEL); ?>	
					<?php echo HTML_inp_hd('cnttel_cnt', _SbLs_ID('i')); ?>
					
					<div class="_d">
						<div class="_d1">
						<?php 
							
							if($___Ls->dt->rw['cnttel_ps'] == ''){ $__ps_id = 57; }else{ $__ps_id = $___Ls->dt->rw['cnttel_ps']; }
							
							echo LsSis_PsOLD('cnttel_ps','id_sisps', $__ps_id, '-', 2, '', '', 'iso'); 
							
							$CntWb .= JQ_Ls('cnttel_ps', TX_SLCPS, '', 'psFlg'); 
							
							
							$CntWb .= "
																	
								$('#cnttel_tp').change(function() {
									
									__id_tp = $(this).val(); 
									__id_ext = $('#cnttel_ext');
									__id_tel = $('#cnttel_tel'); 
									__sl = $('#cnttel_tp option:selected');
									__sl_r = __sl.attr('rel');
									__sl_r_o = eval('('+__sl_r+')');
									
									if( __id_tp != 2 ){
									 	__id_ext.fadeOut();  
									}else{
								  		__id_ext.fadeIn();   
								  	}
								  	
								  	__id_tel.attr({
								       'maxlenght' : __sl_r_o._min,
								       'minlenght' : __sl_r_o._max 
								    });
								  
								});
	
							";
						?>
						</div>
						<div class="_d2">
							<?php echo HTML_inp_tx('cnttel_tel', TX_NMR, ctjTx($___Ls->dt->rw['cnttel_tel'],'in'),
								FMRQD_NMR, ' minlength="'.$___Ls->dt->rw['sistel_c_min'].'" maxlenght="'.$___Ls->dt->rw['sistel_c_max'].'" ');?>  
							<?php echo HTML_inp_hd('cnttel_tel_bfr',ctjTx($___Ls->dt->rw['cnttel_tel'],'in') ); ?>
						</div>	
					</div>
					
					<?php echo HTML_inp_tx('cnttel_ext', TX_EXT, ctjTx($___Ls->dt->rw['cnttel_ext'],'in'), FMRQD_NMR, ' style="display:none;" '); ?>
					
					<?php 
	                    	if(($___Ls->dt->tot == 0)){ 
	                    		echo LsPlcy('_cnt_plcy_tel', 'clplcy_enc', '', FM_LS_PLCY, 'ok', '', [ 'cl'=>CL_ENC ] ); $CntWb .= JQ_Ls('_cnt_plcy_tel', '');	
	                    	} 
	                ?>
					
				</div>
				<div class="col_2"> 
					
					<?php echo h2(MDL_HBSDTA); ?>
					<?php 
						
						if($____plcy->tot > 0){
							
							foreach($____plcy->ls as $plcy_k=>$plcy_v){ 
								
								if($plcy_v->sndi == 'ok'){ $cls_sndi='on'; }else{ $cls_sndi='off'; }
								if($plcy_v->sms == 'ok'){ $cls_sms='on'; }else{ $cls_sms='off'; }
								if($plcy_v->whtsp == 'ok'){ $cls_whtsp='on'; }else{ $cls_whtsp='off'; }
								
								$__dattr = ' data-cnttel="'.$___Ls->dt->rw['cnttel_enc'].'" data-plcy="'.$plcy_v->enc.'" ';
								
								$__plcy_li .= li(
												bdiv([
													'cls'=>'wrp',
													'c'=>
														bdiv([
															'c'=>$plcy_v->nm.Spn(TX_VRSN.' '.$plcy_v->v),
															'cls'=>'tt'
														]).
														bdiv([
															'c'=>'	<button class="'.$cls_sndi.' call _anm" '.$__dattr.' data-plcy-tp="sndi" >Llamada</button>
																	<button class="'.$cls_sms.' sms _anm" '.$__dattr.' data-plcy-tp="sms">SMS</button>
																	<button class="'.$cls_whtsp.' whtsp _anm" '.$__dattr.' data-plcy-tp="whtsp">Whatsapp</button>',
															'cls'=>'opt' 
														])
												]),
												$cls_sndi,
												'',
												'plcy_'.$___Ls->dt->rw['cnttel_enc'].'_'.$plcy_v->enc
											);
							}
							
							echo ul($__plcy_li, '_plcy_ls tel');
						}
						
					?>
					
					
				</div>   
	        </div>
		</div>   
	           
    </form>
  </div>
</div>


<?php
	        
	
	if(_ChckMd('chck_snd_i')){
		
		$CntWb .= " 
		
			$('.dsh_cnt_tel ._plcy_ls > li .opt button').off('click').click(function(e){
					
				e.preventDefault();
				
				if(e.target != this){ 
					
			    	e.stopPropagation(); return false;
			    	
				}else{
					
					if( $(this).hasClass('off') ){ 					
						var _tx='¿El usuario desea recibir nuestra información?'; 
						var _tp = 'info'; 
						var _clr = '#64b764';
						var _e = 1;
						var _e_c = 'on';
					}else{ 
						var _tx = '¿El usuario no desea recibir mas información?';
						var _tp = 'warning'; 
						var _clr = '#a12424';
						var _e = 2;
						var _e_c = 'off';
					}
					
					var _this = $(this);
					var _cnttel = $(this).attr('data-cnttel');
					var _plcy = $(this).attr('data-plcy');
					var _plcy_tp = $(this).attr('data-plcy-tp');
					
						
					swal({
						title: '".TX_HBSACCPT."',
						text: _tx,
						type: _tp,
						showCancelButton: true,
						confirmButtonColor: _clr,
						confirmButtonText:'".TX_ACPT."',
						cancelButtonText:'".TX_CNCLR."',
						showLoaderOnConfirm: true,
						closeOnConfirm: false
					},
					function(){
						
						_Rqu({ 
							t:'cnt_tel_sndi', 
							plcy:_plcy,
							plcy_tp:_plcy_tp,
							cnttel:_cnttel,
							est:_e,
							_bs:function(){  },
							_cm:function(){  },
							_cl:function(_r){ 
								if(!isN(_r)){ 
									if(!isN(_r.e) && _r.e=='ok'){
	
										swal('Cambio Exitoso', '".TX_APROEXT."', 'success');	
										
										console.log(' _plcy_tp ->'+_plcy_tp );
										if(_plcy_tp == 'sndi'){
											$('#plcy_'+_cnttel+'_'+_plcy).removeClass('on off').addClass(_e_c);
										}
										
										_this.removeClass('on off').addClass(_e_c);
										
									}else{
										swal('Error', '".TX_NSAPRB."','error');		
									}									
								}
							} 
						});	
						
					});
					
				}
				
			});	
			
				
		";
	
	
	}else{
					
					
		$CntWb .= " 

			$('.dsh_cnt_tel ._plcy_ls > li .opt button').off('click').click(function(e){
					
				e.preventDefault();
				
				if(e.target != this){ 	
			    		e.stopPropagation(); return false;
				}else{	
					swal({
						title: '".TX_HBSACCPT."',
						text: 'No cuenta con este permiso',
						type: 'warning',
						confirmButtonColor: '#a12424',
						confirmButtonText: 'Entendido',
						closeOnConfirm: true
					});	
				}	
			});	
			
				
		";
		
		
	}
											
    
?>



<style>
	
	.dsh_cnt_tel{ }
	
	.dsh_cnt_tel .ln_1{ display: flex; }
	.dsh_cnt_tel .ln_1 .col_1{ width: 55%; }
	.dsh_cnt_tel .ln_1 .col_2{ width: 45%; }
	
	.dsh_cnt_tel ._d{ display: flex; }
	.dsh_cnt_tel ._d ._d1{ width: 45%; padding-top: 2px; }
	.dsh_cnt_tel ._d ._d2{ width: 55%; padding-left: 10px; }
	
	.dsh_cnt_tel._new .col_1{ display: block; width: 70%; border: none; margin-left: auto; margin-right: auto; padding-top: 60px; }
	.dsh_cnt_tel._new .col_2{ display: none; }
	
</style>
<?php } ?>
<?php } ?>
