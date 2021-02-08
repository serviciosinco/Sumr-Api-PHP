<?php
	
	$__scl = __LsDt([ 'k'=>'api_thrd', 'cl'=>$__dt_cl->id ]);
	$__emoji = __LsDt(['k'=>'emoji', 'rnd'=>'ok']);
	
?>
<div class="Dsh_Scl" id="Dsh_Scl" style="background-color:rgb(243, 248, 253);">
	
	<input id="Dsh_Scl_Cpy" class="_cpyinp" type="text">
	
	<div class="_ovr" id="Dsh_Scl_Pop">
		
		<div class="_c _anm">
			<div class="_wrp">
				<div class="_hdr">
					<nav>
						<div class="_left">
						</div>
						<div class="_right">	
							<div class="mn"></div>
							<div class="x"></div>
						</div>
					</nav>
				</div>
				<div class="cnt">
					
				</div>
			</div>	
		</div>
		
		<div id="Dsh_Scl_Pop_Ob" class="ob">
			
			<!-- Start - New Post -->
			<div class="nw_post __cblq">
				<div class="inp">
					<div class="_w">
						<div class="pic ib _anm"><figure class="_o _anm"></figure></div>
						<div class="txt ib">	
						<?php echo HTML_textarea('Post_Inp', '', '', '', '', '_anm ', '1', '600', '', 'onkeydown="if(event.keyCode == 13){ SUMR_Main.scl.f.txa({id:this}); return false; }"'); ?>
						</div>
						<nav class="moji">
							<div class="wrp">
								<div class="mn shdw _anm">	
									<div class="_c">
										<?php echo ul($__moji, 'bx_emoji'); ?>
									</div>
									<?php echo Tra_Tag_Html('a-up'); ?>
								</div>
							</div>
						</nav>
					</div>
				</div>						
				<div class="_w">
					<div class="ld"><span></span><?php echo TX_LDNG_PRV ?></div>
					<div class="img"></div>
					<div class="cpt">
						<h2 class="nm"></h2>
						<span class="dsc"></span>
					</div>
				</div>
				<div class="_opt">
					<ul><li><button><?php echo TX_PBLC ?></button></li></ul>
				</div>
			</div>
			<!-- End - New Post -->
			
		</div>
	</div>

	<div id="Cnv_Ob">	
		<div class="Dsh_Cnv" id="Dsh_Cnv">
			<div class="cnv ib">
				
				<!--- START - Lista de Conversaciones -->
				<div class="ls ib"> 
					<h2 class="hdr">
						<ul>							
							<li class="_anm rdy" cnv-mn-tp="rdy"><span class="ib icon"></span><?php echo TX_TRMNDA ?></li>
							<li class="_anm inbx on" cnv-mn-tp="inbx"><span class="ib icon"></span><?php echo TX_INBOX ?></li>
							<li class="_anm spm" cnv-mn-tp="spm"><span class="ib icon"></span><?php echo GA_SPAM ?></li>
						</ul>
					</h2>
					<div class="_wrp _anm">	
						<div class="_c">
							<grid class="g" id="Dsh_Cnv_Ls"></grid>
							<div class="_ldr_s"></div>
							<div class="_spc"></div>
							<div class="_empty"><h2><?php echo _Cns('SCL_MSG_NOLS'); ?></h2><p><?php echo _Cns('SCL_MSG_NOLS_DSC'); ?></p></div>
						</div>	
					</div>
					<div class="_ldr"></div>
				</div>
				<!--- END - Lista de Conversaciones -->
				
				
				<!--- START - Lista de Mensajes - Conversaciones -->
				<div class="dt ib">	
					<div class="us">
						<div class="pic ib off"><figure class="_o"></figure></div>	
						<div class="nm ib">
							<strong><?php echo TX_NM ?></strong><br>
							<div class="rsp off">
								<div class="nolink">Sin asignar</div>
								<div class="oklink">Asignado a CENTRO DE GESTION DE INFORMACION Y FINANZAS</div>
							</div>
						</div>
						<div class="opt ib">
							<ul>
								<li></li>
								<li></li>
								<li></li>
								<li class="chk_ok _anm"><button id="Dsh_Cnv_Ok" cnv-est="rdy"><?php echo TX_TRMNDA ?></button></li>
							</ul>
						</div>
					</div>
					<div class="_wrp _anm">
						<div class="_c">
							<grid class="_ls" id="Dsh_Cnv_Msg"></grid>
							<div class="_empty"></div>
							<div class="_spc"></div>
						</div>
					</div>	
					<div class="inp">
						<div class="_w">
							<div class="pic ib"><figure class="_o"></figure></div>
							<div class="txt ib">	
							<?php echo HTML_textarea('Cnv_Inp', '', '', '', '', '_anm ', '1', '200', '', 'onkeydown="if(event.keyCode == 13){ SUMR_Main.scl.f.txa({id:this}); return false; }"'); ?>
							</div>
							<nav class="opt"></nav>
						</div>
					</div>
					<div class="_ldr"></div>	
				</div>
				<!--- END - Lista de Mensajes - Conversaciones -->

			</div>

		</div>
		
	</div>	
	
</div>
<?php 
	
	if(_ChckMd("scl_acc_stup")){	
		$__scl_stup_e = "SUMR_Main.scl.scl_stup = 'ok';";
	}
	
	$CntJV .= " 
		
		SUMR_Main.ld.f.scl(function () {
				
			SUMR_Ld.f.css({
			    h:'scl',
			    c:function(){ 	

					SUMR_Main.scl.f.dom();
					
					$('#Dsh_Scl').show();	
					$__scl_stup_e
					SUMR_Main.scl.f.tnon({ 'id':'#s-menu-nav', t:'eml', e:'ldr' });
					
					SUMR_Main.scl.f.dom_rbld();
					SUMR_Main.scl.f.acc.bld();
					
				}
				
			}); 
		
		});	
				
		
	";
	
?>	