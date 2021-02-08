<?php echo HTML_inp_hd('Cnt_Mdl'.$__id_rnd, $__mdl_enc); ?>

<div class="_ln cx1 mdl">
	<div class="_blq _unq">
		<div class="_fd">
			<h2 class="___form_h2">Formulario de afiliación</h2>
		</div>
	</div>
</div>
<div class="_ln cx1 mdl">
	<div class="_blq _unq">
		<div class="_fd">
			<span class="___form_spn">Estimado egresado:para que su afiliación sea efectiva,debe diligenciar las 3 secciones del formulario por completo</span>
		</div>
	</div>
</div>

<div class="tab active" id="tab_1">
	<div class="_ln cx1"> 
		<div class="_blq _unq">
		    <div class="_fd">
		        <?php echo _HTML_Input('Cnt_Nm'.$__id_rnd, TT_FM_FLLNM, '', FMRQD, 'text', ['ac'=>'name']); ?>
		    </div> 
		</div>
	</div>
	<div class="_ln cx2">
	    <div class="_blq _c1"> 
	        <div class="_fd">
	            <?php 
	                
	                $l = __Ls([ 'k'=>'cnt_dc', 
	                			'id'=>'Cnt_DocTp'.$__id_rnd, 
	                			'opt_v'=>'itm-sg',
	                			'va'=>177, 
	                			'rq'=>1,
	                			'ph'=>_cns('FM_LS_TPDOC'),
	                			'slc'=>[ 
										'opt'=>[
												'attr'=>[
													'itm-sg'=>'sg'
												]	
											] 
										] 
	                		]); 
	                		
	                echo $l->html; $_CntJQ_S2 .= $l->js;
	            ?>
	        </div> 
	    </div>
	    <div class="_blq _c2">
	        <div class="_fd">
	            <?php echo _HTML_Input('Cnt_Doc'.$__id_rnd, TX_DCNMR, '', FMRQD_NM, 'text', ['ac'=>'off']); ?>
	        </div>
	    </div>
	</div>
	<div class="_ln cx1 mdl">
		<div class="_blq _unq">
			<div class="_fd">
				<?php 
	                		
					$l = __Ls(['k'=>'est_cvl', 'n'=>'____ext_'.$__id_rnd.'[cnt][estd_cvl]', 'id'=>'estd_cvl'.$__id_rnd, 'va'=>'' , 'ph'=>'Estado Civil']); 		
	                echo $l->html; $_CntJQ_S2 .= $l->js;
					
				?>
			</div>
		</div>
	</div>
	<div class="_ln cx1 mdl">
		<div class="_blq _unq">
			<div class="_fd">
				<?php 
					
					$l = SlDt([ 'a'=>'ok', 'id'=>'Cnt_Fn'.$__id_rnd, 'rq'=>'no', 'ph'=>'Fecha de Nacimiento', 'lmt'=>'no', 'yr'=>'ok', 'cls'=>CLS_CLND ]);
					echo $l->html; $_CntJQ_S2 .= $l->js;
					
				?>
			</div>
		</div>
	</div>
	<div class="_ln cx2 mdl">
		<div class="_blq _c _c1">
			<div class="_fd">
				<?php echo _HTML_Input('num_hjs'.$__id_rnd, 'Numero de hijos', '', 2, 'text', ['ac'=>'off', 'n'=>'____ext_'.$__id_rnd.'[cnt][num_hjs]']); ?>
			</div>
		</div>
		<div class="_blq _c _c2">
			<div class="_fd">
				<?php echo _HTML_Input('ed_hjs'.$__id_rnd, 'Edades de los hijos', '', 2, 'text', ['ac'=>'off', 'n'=>'____ext_'.$__id_rnd.'[cnt][ed_hjs]']); ?>
			</div>
		</div>
	</div>
	<div class="_ln cx1 mdl">
		<div class="_blq _unq">
			<div class="_fd">
				<?php echo _HTML_Input('Cnt_Dir'.$__id_rnd, 'Direccion', '', FMRQD, 'text', ['ac'=>'off']); ?>	
			</div>
		</div>
	</div>
	<div class="_ln cx2 mdl">
		<div class="_blq _c _c1">
			<div class="_fd">
				<?php echo _HTML_Input('Cnt_Cel'.$__id_rnd, TX_CEL, '', FMRQD_NM.' minlength="10" maxlength="10" ', 'text'); ?>	
			</div>
		</div>
		<div class="_blq _c _c2">
			<div class="_fd">
				<?php echo _HTML_Input('Cnt_Tel'.$__id_rnd, TX_TEL, '', FMRQD_NM.' minlength="7" maxlength="10" ', 'text'); ?>	
			</div>
		</div>
	</div>
	<div class="_ln cx2 mdl">
		<div class="_blq _c _c1">
	  		<div class="_fd">
	  			<?php 
	      			$__ps = 'ok';
	      			
	      			echo LsSis_PsOLD('Cnt_Ps'.$__id_rnd, 'id_sisps', '57', 'Pais', 1); 
	      			
	      			$_CntJQ_S2 .= JQ_Ls('Cnt_Ps'.$__id_rnd, '-', '', 'SUMR_Fm.f.ps.flg');
	      			
	      			$_CntJQ_S2 .= "
										
						function __ld_cd(p){
							SUMR_Main.ld.f.slc({
								i:p.id, 
								t:'sis_cd', 
								t_i:p.est_i, 
								t_e: '".$__id_rnd."',
								b:'sis_cd_bx', 
								_cl: function(){ 
									
								} 
							});
						}
	            		
	            		$('#Cnt_Ps".$__id_rnd."').change(function() {
							var _id = $(this).val();
							var _est_i = $(this).val();	
							__ld_cd({ id:_id, est_i:_est_i });			
	            		});
					";
	  			?>
	  		</div>
	  	</div>
		<div class="_blq _c _c2">
	  		<div class="_fd">
		  		<div id="sis_cd_bx" class="_sbls">
					<div id="bx_ls_1_<?php echo $__id_rnd; ?>" style="display:none;">
						<?php echo '<div class="_sl"><div class="styled-select-bx"><select id="Opc_Oth'.$__id_rnd.'" name="Opc_Oth'.$__id_rnd.'" class="required"></select> </div></div>'; ?>	
					</div>
					<div id="bx_ls_2_<?php echo $__id_rnd; ?>" style="display:none;">
						<?php echo _HTML_Input('OthWrt'.$__id_rnd, TT_FM_NM, '', FMRQD); ?>
					</div>			
					<div id="Cnt_Cd_Box_<?php echo $__id_rnd; ?>">
						<?php 
							
							if(!isN($__ps)){ $__ps = 57; }else{ $__ps = ''; }
							echo LsCdOld(['id'=>'Cnt_Cd'.$__id_rnd, 'v'=>'id_siscd', 'va'=>'', 'rq'=>1, 'flt_ps'=>$__ps, 'oth'=>'ok' ]); 				    			
							$_CntJQ_S2 .= JQ_Ls('Cnt_Cd'.$__id_rnd,FM_LS_SLCD);	
						?>	
					</div>
	
					<?php 
					   	$_CntJQ_S2 .= "
	
					   		function __clr".$__id_rnd."() { console.clear(); }
	
							$('#Cnt_Cd".$__id_rnd."').change(function() {
								var _t__v = $(this).val();
	
								if( _t__v == '-oth-'){ 
									$('#Cnt_Cd_Box_".$__id_rnd."').fadeOut();
									$('#bx_ls_1_".$__id_rnd."').fadeIn();		
								}
							});
							
							$('#Opc_Oth".$__id_rnd."').change(function() {
								var _t__v = $(this).val();
								if(_t__v == '-wrt-'){
									$('#bx_ls_1_".$__id_rnd."').fadeOut();
									$('#bx_ls_2_".$__id_rnd."').fadeIn();
								}
							});
							
							$('#Opc_Oth".$__id_rnd."').select2({
								placeholder: ' - escribe el nombre de la ciudad -',
								minimumInputLength: 3,
								ajax: {
									url:'/json/lista_o.json',
									dataType: 'json',
									delay: 250,
									method:'POST',
									data: function (params) {
								
										$('#OthWrt{$__id_rnd}').val(params.term);
									
										return {
											__t: 'prg',
											__q: params.term
										};
									},
									processResults: function (d) {
										__clr".$__id_rnd."();
										return { results: d.items };
									},
									cache: true
								}	
							});		
						"; 
					?>		
				</div>
	  		</div>	
		</div>
	</div>
	<div class="_ln cx1"> 
		<div class="_blq _unq">
		    <div class="_fd">
		        <?php echo _HTML_Input('Cnt_Eml'.$__id_rnd, 'Email', '', FMRQD, 'text', ['ac'=>'email']); ?>
		    </div> 
		</div>
	</div>
	<ul>
		<li class="next _anm" data-tp="1">Siguiente</li>
	</ul>
</div>

<div class="tab incatv" id="tab_2">
 	<div class="_ln cx1 mdl">
     	<div class="_blq _unq">
	     	<div class="_fd">
		     	<p class="___form_p">Realizó estudios de pregrado en la Universidad Externado:</p>
		     </div>
		</div>
	</div>
	<div class="_ln cx1 mdl">
    	<div class="_blq _unq">
	    	<div class="_fd">
		    	<?php $l = __Ls(['k'=>'Sis_SiNo','id'=>'Sis_SiNo_prg','ph'=>FM_LS_SLGN,'f'=>'rto','lbl'=>'ok','ord'=> 'ok', 'ord_tp' => 'DESC', 'attr' =>[ 'required' =>'true' ] ]); echo $l->html; $_CntJQ_S2 .= $l->js; ?>	
		     </div>
		</div>
	</div>
	<div class="_ln cx1 mdl">
		<div class="_blq _unq">
			<div class="_fd">
				<div class="_fm_spc _c1 cl_are cl_are_prg_ing">
					<div class="_d1"><div id="cl_are_prg_bx" class="_sbls"></div></div>
				</div>
			</div>
		</div>
	</div>	
	<div class="_ln cx1 mdl">
    	<div class="_blq _unq">
	    	<div class="_fd">
		    	<p class="___form_p">Realizó estudios de posgrado en la Universidad Externado:</p>
		    </div>
		</div>
	</div>  
	<div class="_ln cx1 mdl">
    	<div class="_blq _unq">
	    	<div class="_fd">
		    	<?php $l = __Ls(['k'=>'Sis_SiNo','id'=>'Sis_SiNo_psg','ph'=>FM_LS_SLGN,'f'=>'rto','lbl'=>'ok','ord'=> 'ok', 'ord_tp' => 'DESC','attr' =>[ 'required' =>'true' ] ]); echo $l->html; $_CntJQ_S2 .= $l->js; ?>	
		     </div>
		</div>
	</div>  
	<div class="_ln cx1 mdl">
		<div class="_blq _unq">
			<div class="_fd">
				<div class="_fm_spc _c1 cl_are cl_are_psg_ing">
					<div class="_d1"><div id="cl_are_psg_bx" class="_sbls"></div></div>
				</div>
			</div>
		</div>
	</div>
	<ul>
		<li class="prev" data-tp="2">Atras</li>
		<li class="next" data-tp="2">Siguiente</li>
	</ul>
</div>  

<div class="tab incatv" id="tab_3">
	<div class="_ln cx1 mdl tb3"><div class="_blq _unq"><div class="_fd"><p class="___form_p">Actualmente trabaja:</p></div></div></div>
	<div class="_ln cx1 mdl tb3">
    	<div class="_blq _unq">
	    	<div class="_fd">
		    	<?php $l = __Ls(['k'=>'Sis_SiNo','id'=>'Sis_SiNo_trd','ph'=>FM_LS_SLGN,'f'=>'rto','lbl'=>'ok','ord'=> 'ok', 'ord_tp' => 'DESC', 'attr' =>[ 'required' =>'true'] ]); echo $l->html; $_CntJQ_S2 .= $l->js; ?>	
		     </div>
		</div>
	</div>
	<div class="_ln cx1 mdl">
		<div class="_blq _unq">
			<div class="_fd">
				<div class="_fm_spc _c1 org_scec org_scec_ing">
					<div class="_d1"><div id="org_scec_bx" class="_sbls"></div></div>
				</div>
			</div>
		</div>
	</div>
 	<div class="_ln cx1 mdl tb3"><div class="_blq _unq"><div class="_fd"><p class="___form_p">¿Desea obtener el carné de egresado? <b>Valor $50.000</b></p></div></div></div>
 	<div class="_ln cx1 mdl tb3">
    	<div class="_blq _unq">
	    	<div class="_fd">
		    	<?php $l = __Ls(['k'=>'Sis_SiNo','id'=>'Sis_SiNo_vlr', 'n' => '____ext_'.$__id_rnd.'[mdl_cnt][vlr]',  'ph'=>FM_LS_SLGN,'f'=>'rto','lbl'=>'ok','ord'=> 'ok', 'ord_tp' => 'DESC', 'attr' =>[ 'required' =>'true'] ]); echo $l->html; $_CntJQ_S2 .= $l->js; ?>	
		     </div>
		</div>
	</div> 
 	<div class="cmnt" id="__cmnt_chk" >
		<button id="cmnt_on<?php echo $__id_rnd; ?>"><?php echo TX_LVCMNT ?></button>
		</div>
		<div id="__cmnt_li<?php echo $__id_rnd; ?>" style="display:none;" class="_ln">
			<?php echo _HTML_Text('Cnt_Cmnt'.$__id_rnd, TT_FM_CMN,'',2); ?>
		</div>
		<ul>
			<li class="prev" data-tp="3">Atras</li>
		</ul> 
		<?php 
		
		if(!isN($__fm->plcy)){
			
			$__lnk_p = $__fm->plcy->lnk->url;
			$__lnk_p_t = $__fm->plcy->tx;
			if(!isN($__fm->plcy->lnk->tt)){ $___plcy_tt = $__fm->plcy->lnk->tt; }else{ $___plcy_tt = TX_PLTCDTA_TT; }
			
			echo HTML_inp_hd('Plcy_Id'.$__id_rnd, $__fm->plcy->enc);	
			
		}else{
			
			$__plcy = GtClPlcyDflt([ 'cl'=>$__cl->id ]);
			
			if(!isN($__plcy->id)){
				
				$__lnk_p = $__plcy->lnk->url;
				$__lnk_p_t = $__plcy->tx;
				if(!isN($__plcy->lnk->tt)){ $___plcy_tt = $__plcy->lnk->tt; }else{ $___plcy_tt = TX_PLTCDTA_TT; }
			
				echo HTML_inp_hd('Plcy_Id'.$__id_rnd, $__plcy->enc);	

			}
			
		}	
	?>	
	
	<?php if(!isN($__lnk_p_t)){ ?><div class="_plcy_txt"><?php echo $__lnk_p_t ?></div> <?php } ?>
	
	<?php if(!isN($__fm->plcy->enc) || !isN($__plcy->enc)){ ?>
	<div class="_plcy_lnk" id="_plcy_lnk<?php echo $__id_rnd; ?>">
		<?php echo _HTML_Input('Plcy_Chck'.$__id_rnd, '<a href="'.$__lnk_p.'" target="_blank">'.$___plcy_tt.'</a>','','_chk','checkbox'); ?>	
	</div> 
	<?php } ?>
				
	<div class="_btn_snd">	
		<button class="pin" id="<?php echo $__id_fm_btn ?>" name="<?php echo $__id_fm_btn ?>"><?php echo TX_SND; ?></button>
	</div>
 	   
</div> 
  	  
<style>
	.incatv{ display: none; }
	.___form_h2{font: bold 20px Arial, Times New Roman, Times, serif;text-decoration: none;letter-spacing: 0px;color: #00492C;}
	.___form_spn{font: bold 17px Arial, Helvetica, sans-serif;color: #660000;margin-bottom: 12px;display: block;}
	.___form_p{ font-size: 12px;color: #949494; }
	.SUMR_Form .__rtio label{display: inline-block;width: 50%;text-align: left;}
	.SUMR_Form .__rtio label .chkmk:after{width: 10px;height: 10px;}
	
	._fm_spc.cl_are_prg_ing,
	._fm_spc.cl_are_psg_ing,
	._fm_spc.org_scec_ing{ display: none; }
	._fm_spc.cl_are_prg_ing._shw,
	._fm_spc.cl_are_psg_ing._shw,
	._fm_spc.org_scec_ing._shw{ display: block!important; }
	ul{ist-style-type: none;
    position: relative;
    height: 60px;}
    .next, .prev{ width: 140px;
    background-color: #045131c4;
    text-align: center;
    padding: 12px 0;
    border-radius: 8px;
    position: absolute;
    color: white;  cursor: pointer}
    
    .next{right: 0;} 
    .prev{left: 0;}
    
    .next:hover,
    .prev:hover{ background-color: #005431; }

	.SUMR_Form ._lst ul{list-style:none;margin:0;padding:0}
	.SUMR_Form ._lst ul li{text-align:center;width:100%;border-bottom:1px solid #e6ebec;padding-top:20px;padding-bottom:20px;text-align:center;align-items:center;justify-content:center;cursor:pointer;position:relative}
	.SUMR_Form ._lst ul li figure{margin:0;padding:0;width:40px;height:40px;border-radius:200px;-moz-border-radius:200px;-webkit-border-radius:200px;border:2px solid #abb1b3;background-size:cover;background-position:center center;background-repeat:no-repeat;margin-right:10px;display:inline-block;position:relative;margin-bottom:-6px}
	.SUMR_Form ._lst ul li figure.empty:before {content: '';background-image: url(https://colegios.uexternado.co/_img/estr/none.svg);background-size: auto 60%;background-repeat: no-repeat;background-position: center center;width: 30px;height: 30px;background-color: #c8cbcc;border-radius: 200px;-moz-border-radius: 200px;-webkit-border-radius: 200px;opacity: 0.3;position: absolute;left: 3px;top: 3px;}
	.SUMR_Form ._lst ul li ._tx{display:inline-block;font-family:Economica;text-transform:uppercase;font-size:16px}
	.SUMR_Form ._lst ul li ._tx span{color:#bbbebf;font-weight:300;font-family:Economica;font-size:14px;display:block;width:100%}
	.SUMR_Form ._lst ul li:not(.selc):hover{background-color:#e2e5e7;padding-right:30px}
	.SUMR_Form ._lst ul li:not(.selc):hover::after{content:'';width:30px;height:30px;position:absolute;right:5px;top:21px;background-image:url(https://colegios.uexternado.co/_img/estr/list_right.svg);background-position:center center;background-repeat:no-repeat;opacity:.5}							
	.__sch_org{position:absolute;right:6px;top:6px;background-color:#a2aaae;border-radius:200px;-moz-border-radius:200px;-webkit-border-radius:200px;width:30px;height:30px;background-image:url(/_img/estr/search.svg);background-repeat:no-repeat;background-position:center center;background-size:60% auto;opacity:.6;cursor:pointer;}
	
	.blck{display:none;}
	.clg_chs.ok .ls_org{width:390px;background-color:#fff;}
	.__sch_org.on {background-image: url(/_img/estr/loader_black.svg);pointer-events: none;}

</style>	

<?php  $_CntJQ_S2 .= "

			$('.next').off('click').click(function(){
				var tp = $(this).attr('data-tp');

				if(!_fm.valid()){
					$('.active select.error').each(function(){
		        	    var _err = $(this).attr('id');
		        	    $('#select2-'+_err+'-container').parent().css( 'border', '1px solid #f09001' );
		        	});
		        	
		        	$('.active select').change(function(){
		        	    var _err = $(this).attr('id');
		        	    $('#select2-'+_err+'-container').parent().css( 'border', '1px solid #999' );
					});
		        	
		        	$('.active input:radio.error').each(function(){
		        	   $(this).parent().parent().addClass('_err'); 
		        	});
		        	
		        	$('.active input:radio').click(function(){
		        	   $(this).parent().parent().removeClass('_err'); 
					});
					
		        }else if( $('#tab_2.active input[name=\"Sis_SiNo_prg\"]:checked').val() == '"._CId('ID_SISSINO_NO')."' && $('#tab_2.active input[name=\"Sis_SiNo_psg\"]:checked').val() == '"._CId('ID_SISSINO_NO')."' ){

					swal('Recuerda!', 'Debes seleccionar al menos un programa' ,'info');

				}else{
			        var num = parseInt(tp);
			        
		        	$('#tab_'+tp).removeClass('active').addClass('incatv');
		        	$('#tab_'+(num+1)).addClass('active').removeClass('incatv');
	            } 
				
			});
			
			$('.prev').off('click').click(function(){
				
				var tp = $(this).attr('data-tp');
				var num = parseInt(tp);
			        
		        $('#tab_'+tp).removeClass('active').addClass('incatv');
		        $('#tab_'+(num-1)).addClass('active').removeClass('incatv');
				
			});
	
			$('input[name=\"Sis_SiNo_prg\"]').click(function() {
				if($(this).val() == "._CId('ID_SISSINO_SI')." ){
					SUMR_Main.ld.f.slc({i:123, t:'cl_are', b:'cl_are_prg_bx', t_i:'".$__cl->enc."', t_e: '___mdl_pre', t_p: '".$__id_rnd."' });
					$('._fm_spc.cl_are_prg_ing').addClass('_shw');
				}else{
					$('._fm_spc.cl_are_prg_ing').removeClass('_shw');	
				}
			});
			
			$('input[name=\"Sis_SiNo_psg\"]').click(function() {
				if($(this).val() == "._CId('ID_SISSINO_SI')." ){
					SUMR_Main.ld.f.slc({i:123, t:'cl_are', b:'cl_are_psg_bx', t_i:'".$__cl->enc."', t_e: '___mdl_psg', t_p: '".$__id_rnd."' });
					$('._fm_spc.cl_are_psg_ing').addClass('_shw');
				}else{
					$('._fm_spc.cl_are_psg_ing').removeClass('_shw');	
				}
			});
			
			$('input[name=\"Sis_SiNo_trd\"]').click(function() {
				if($(this).val() == "._CId('ID_SISSINO_SI')." ){
					SUMR_Main.ld.f.slc({i:123, t:'org_scec', b:'org_scec_bx', t_i:'".$__cl->enc."', t_p: '".$__id_rnd."' });
					$('._fm_spc.org_scec_ing').addClass('_shw'); 
				}else{
					$('._fm_spc.org_scec_ing').removeClass('_shw');	
				}
			});
			
			
		"; 
?>