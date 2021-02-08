<?php 
	
	//-------------- VARIABLES GENERALES - START --------------//
		
		
		$__e = Php_Ls_Cln($_GET['_e']);
		$_____md_3 = Php_Ls_Cln($_GET['_md']);
		$_____md_rfr = Php_Ls_Cln($_GET['rfr']);
		$_____fnt_uid = Php_Ls_Cln($_GET['_fnt']);
		$_____md_key = Php_Ls_Cln($_GET['__k']);

		 
		if(!isN($_____md_1)){ 
			$_____md_uid = $_____md_1; 
		}elseif(!isN($_____md_2)){ 
			$_____md_uid = $_____md_2; 
		}elseif(!isN($_____md_3)){ 
			$_____md_uid = $_____md_3; 
		}else{
			
			$_____md_url = URL_Data( $_____md_rfr );
			$_____md_schw = unserialize(SIS_SCHWBS);
			
			if (in_array($_____md_url['host'], $_____md_schw)){ 
				$_____md_uid = SIS_MD_SCHORG; 
			}
			
		}
		
		if(isN($_____md_key) && $_____md_key == '{keyword}'){ $_____md_key = ''; }
		
		$__id_rnd = '_'.Gn_Rnd(20);
		$__id_bx = 'FmBx'.$__id_rnd;
		$__id_fm = 'Fm'.$__id_rnd;
		$__id_fm_btn = 'FmBtn'.$__id_rnd;
			
		$__hro = LsMdlSch('Cnt_Sch'.$__id_rnd, 'id_mdlssch', ' ', 'Horario', 2,'', ['id_mdl'=>$__mdl->id]); 

	
	//-------------- CLASS FORM --------------//
		
		$__Forms = new CRM_Forms();
		$__Forms->_rnd = $__id_rnd;
	
	//-------------- TARGET FORM --------------//
	
		
		
		if(!_isFm()){ $__trg_a = "_self"; }else{ $__trg_a = "_parent"; }
		
	
?> 
	<div class="__fm _anm" style="opacity:0;" id="<?php echo $__id_bx ?>">	
		
		<div class="intro _anm" id="Intro_Tx_<?php echo $__id_rnd ?>">
			<span>Agéndate con nosotros</span>
			Te apoyamos el proceso de orientación de tus estudiantes. 
		</div>
		
		<div class="rsz_wrp _anm">
			
			<div class="_sch step1 _anm">
		  		<div class="_cblq">
					<?php echo _HTML_Input('Clg_Sch'.$__id_rnd, 'Escribe el nombre de tu colegio', '', FMRQD, 'text', ['ac'=>'off']); ?>
					<button class="_sch_go _anm" id="Clg_Sch_Btn<?php echo $__id_rnd ?>"></button>
				</div>
				<div class="_lst" style="display: none;" id="Clg_Ls<?php echo $__id_rnd ?>">
				</div>
	  		</div>		

		    <form action="<?php echo VoId(); ?>" id="<?php echo $__id_fm ?>" autocomplete="off" class="step2 _anm <?php if($__fm->shw->sch=='ok'){ echo '__sch'; } ?>">
		    	
		    	<?php echo HTML_inp_hd('____key', $__id_rnd); ?>
		    	<?php echo HTML_inp_hd('MMSend'.$__id_rnd, 'WebLndg'); ?>
		    	<?php echo HTML_inp_hd('Org_Sds'.$__id_rnd, ''); ?>
		    	
		    	<?php if(!isN($_____fnt_uid)){ echo HTML_inp_hd('SndFnt'.$__id_rnd, $_____fnt_uid); } ?>
		    	<?php if(!isN($_____md_uid)){ echo HTML_inp_hd('SndMed'.$__id_rnd, $_____md_uid); } ?>
		    	<?php if(!isN($_____md_key)){ echo HTML_inp_hd('KeyMed'.$__id_rnd, $_____md_key); } ?>
		    	<?php if(!isN($_____md_lat)){ echo HTML_inp_hd('Lat'.$__id_rnd, $_____md_lat); } ?>
		    	<?php if(!isN($_____md_lon)){ echo HTML_inp_hd('Lon'.$__id_rnd, $_____md_lon); } ?>
			  	<?php echo $__Forms->_fields()->hdn; ?>
		      
			  	<div id="<?php echo $__id_fm ?>_ld" class="_ld"></div>
			  	<div id="<?php echo $__id_fm ?>_rsl" class="_rsl"></div>
			  	
			  	<!------------- SEARCH BY KEY - START ------------->
			  		
				  	
			  	<div id="<?php echo $__id_fm ?>_flds" class="_flds">
				  	
			  		<section id="Clg_Logo<?php echo $__id_rnd ?>" class="_logo">
				  		
			  		</section>
			  		
			  		<div class="_ln cx1"> 
					    <div class="_fd">
					        <?php echo _HTML_Input('Cnt_Nm'.$__id_rnd, TT_FM_FLLNM, '', FMRQD, 'text', ['ac'=>'name']); ?>
					    </div> 
					</div>
					<div class="_ln cx2 mdl">
						<div class="_blq _c _c1">
					    	<div class="_fd">
					    		<?php echo _HTML_Input('Cnt_Eml'.$__id_rnd, TT_FM_EML, '', FMRQD_EM, 'email', ['ac'=>'email']); ?>
					    	</div>
					    </div>
						<div class="_blq _c _c2">
					    	<div class="_fd">
					        	<?php echo _HTML_Input('Cnt_Tel'.$__id_rnd, TX_CEL, '', FMRQD_NM.' minlength="10" maxlength="10" ', 'text'); ?>
					        </div>
					    </div>          
					</div>
					
					<div class="_ln cx1"> 
					    <div class="_fd">
					        <?php echo _HTML_Input('Cnt_Crg'.$__id_rnd, TT_FM_CRG, '', FMRQD, 'text', ['ac'=>'name']); ?>
					    </div> 
					</div>
					
					<?php 
							
						$__plcy = GtClPlcyDflt([ 'cl'=>$__dt_cl->id ]);
						
						if(!isN($__plcy->id)){
							
							$__lnk_p = $__plcy->lnk->url;
							$__lnk_p_t = $__plcy->tx;
							if(!isN($__plcy->lnk->tt)){ $___plcy_tt = $__plcy->lnk->tt; }else{ $___plcy_tt = TX_PLTCDTA_TT; }
						
							echo HTML_inp_hd('Plcy_Id'.$__id_rnd, $__plcy->enc);	

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
		    </form> 
			
			<div class="success_ok">
				<figure></figure>
				<h1 class="_tt"></h1>  
				<div class="_tx"></div> 
		    </div>
	    
	    </div>
	    
	</div>
	
<?php	
	
	if($_GET['Sv'] == 'ok'){ $_CntJQ .= "_gOk(); "; }	
	if($__e == 'ok'){ $_CntJQ_Vld .= " _gOk(); "; }	
	
	
	//$_CntJQ .= " if(!isN(SUMR_RquClg)){ SUMR_Dom(); } ";
	
	
	
?>