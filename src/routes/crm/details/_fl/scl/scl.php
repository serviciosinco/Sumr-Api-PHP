<?php 
	
	$__scl = __LsDt([ 'k'=>'api_thrd', 'cl'=>$__dt_cl->id ]);
	$__emoji = __LsDt(['k'=>'emoji', 'rnd'=>'ok']);
	
	foreach($__emoji->ls->emoji as $k=>$v){ 
		$__moji .= '<li rel="'._mJi($v->cdg->vl).'" class="_emoji">'._mJi($v->cdg->vl).'</li>';
	}	
	
?>
<div class="Dsh_Scl" id="Dsh_Scl" style="display: none;">
	
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
	
	<nav class="prfl">
		<ul>
			<li id="s-menu-nav" scl-name="Email" s-mnu="eml" class="_anm _o _eml on __main_nv"><div class="_spnr _o _anm"></div></li>
			
			<?php foreach($__scl->ls->api_thrd as $k=>$v){ ?>
				<?php if(mBln($v->mnu_on->vl) == 'ok'){ ?>
				<li id="<?php echo $v->enc ?>" scl-name="<?php echo $v->tt; ?>" s-mnu-id="<?php echo $v->enc ?>" s-mnu="<?php echo $v->rel->vl ?>" s-mnu-sub="<?php echo mBln($v->mnu_sub_on->vl) ?>" class="_anm _o _<?php echo $v->rel->vl ?> __main_nv __scndbtn"><div class="_spnr _o _anm"></div></li>
				<?php } ?>
			<?php } ?>
			
		</ul>
	</nav>
	
	
	<div class="_c ib _anm">	
		<div class="_wrp _anm">
			<nav class="acc _anm">
				<ul class="ls"></ul>
				<ul class="stup _anm">
					<li scl-name="Configuración" s-mnu="scl_stup" s-mnu-t="" class="_anm _stup"></li>
				</ul>
			</nav>
			<div class="btn_top" id="Dsh_top"></div>
			<div class="_cnt" id="Dsh_lcnt"></div>
		</div>
	</div>
	
	<div class="_ob" id="Cnv_Ob">	
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
			
			<!--- START - Lista de Post -->
			
			
				<div class="post ib">
					<h2 class="hdr">
						<ul>	
							<li class="_anm post_cmn" post-mn-tp="cmn"><span class="ib icon"></span><?php echo TX_CMTN ?></li>
							<li class="_anm post_trsh" post-mn-tp="trsh"><span class="ib icon"></span><?php echo GA_TRASH ?></li>
							<li class="_anm post_msg on" post-mn-tp="post"><span class="ib icon"></span><?php echo TX_ADS_PST ?></li>
						</ul>
					</h2>
					<div class="_wrp _anm">	
						<div class="_c">	
							<grid class="g" id="Dsh_Post_Ls"></grid>
							<div class="_ldr"></div>
							<div class="_empty"><h2><?php echo _Cns('SCL_POST_NOLS'); ?></h2><p><?php echo _Cns('SCL_POST_NOLS_DSC'); ?></p></div>
							<div class="_spc"></div>
						</div>
					</div>
					<div class="inp">
						<div class="_w">
							<ul>
								<li><button id="Dsh_Post_New"><?php echo TX_PBLC ?></button></li>
							</ul>
							<nav class="opt"></nav>
						</div>
					</div>
						
				</div>
				
			<!--- END - Lista de Post -->
			
		</div>	
		
		<div id="Cnv_Eml"></div>
		<div id="Cnv_Set" class="Cnv_Set"></div>
		<div id="Cnv_Whtsp"></div>
		
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
				
					SUMR_Main.scl.f.lcnt({ 
						id:'Cnv_Eml', 
						f:'d', 
						t:'my_eml',
						cll:function(){
							
							SUMR_Main.eml.rqu({
								_tp:'eml',	
								_cl:function(__r){
									
									if(!isN(__r)){
										
										if(!isN(__r.eml)){
											
											SUMR_Main.scl.f.SclEmlS({ o:'eml', v:__r.eml });
											
											if(!isN(__r.eml) && !isN(__r.eml.dfl)){ 
												__eml_ac({ eml:__r.eml.dfl }); 
											}else{
												__eml_gt_acc();
											}
											
											SUMR_Main.scl.f.dob({ t:'dsh_eml' });
											
											$('#Dsh_Scl').addClass('_rdy');
											
											".$_eml_show."
											
										}
										
										if(!isN(__r.scl)){
											SUMR_Main.scl.f.set({ t:'scl', v:__r.scl });	
										}
			
									}
									
							    }
							});
							
						}
					});
					
					SUMR_Main.scl.f.dom_rbld();
					SUMR_Main.scl.f.acc.bld();
					
				}
				
			}); 
		
		});	
				
		
	";
	
?>	