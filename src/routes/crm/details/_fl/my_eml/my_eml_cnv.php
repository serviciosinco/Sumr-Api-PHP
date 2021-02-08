<?php 

	
	//---------------------- VARIABLES GET ----------------------//
		
		$__cnv_id = Php_Ls_Cln($_GET['cnv_id']);
		$__mdlcnt = Php_Ls_Cln($_GET['mdlcnt']);
		$__tra = Php_Ls_Cln($_GET['tra']);
		$__Eml = new CRM_Eml();
		$__Cnt = new CRM_Cnt();
		

		//---------------------- GET MDLCNT ----------------------//		
		if(!isN($__mdlcnt)){ $__mdlcnt_dt = GtMdlCntDt([ 'id'=>$__mdlcnt, 't'=>'enc' ]); }
		//---------------------- GET MAINCVDT ----------------------//		
		if(!isN($__cnv_id)){ $__cnv_dt = GtMainCnvDt([ 'tp'=>'eml', 'enc'=>$__cnv_id, 'd'=>[ 'chnl'=>'ok' ] ]); }
		//---------------------- GET TRADT ----------------------//		
		if(!isN($__tra)){ $_tra_dt = GtTraDt([ 'id'=>$__tra, 't'=>'enc' ]); }


		if(!isN($__cnv_dt->id) && !isN($__mdlcnt_dt->id)){
			$__iscnvr = $__Cnt->MdlCntCnvChk([ 'mdlcnt'=>$__mdlcnt_dt->id, 'cnv'=>$__cnv_dt->id ]);
		}
		
		if(!isN($__cnv_dt)){ $__thrd = $__Eml->EmlMsgLs([ 't'=>'enc', 'id'=>$__cnv_dt->chnl->enc, 'd'=>[ 'addr'=>'ok', 'attch'=>'ok' ] ]); $_msg_tot = $__cnv_dt->chnl->tot->msg; }

	//---------------------- SELECCIONA CORREO ----------------------//		
	
	if(!isN($__iscnvr->id)){ $_cls_bdy=' cnv'; }
		
	echo '<div class="EmlCnvLs'.$_cls_bdy.'">';

	if(!isN($_tra_dt->id) && !isN($__mdlcnt_dt->id)){
		echo '<div class="sac-id" style="background-color:'.$_tra_dt->clr->vl.';"><span class="icn" style="background-image:url('.$_tra_dt->icn->slc->img.');"></span><span class="sb">Conversación relacionada a</span> Ticket <strong>#'.$__mdlcnt_dt->id.'</strong> ('.$_tra_dt->col->tt.')</div>';
	}elseif(!isN($__mdlcnt_dt->id)){
		echo '<div class="mdlcnt-id" style="background-color:var(--main-bg-color);"><span class="icn" style="background-image:url('.$__mdlcnt_dt->mdl->tp->img->big.');"></span><span class="sb">Conversación relacionada a</span> Oportunidad <strong>#'.$__mdlcnt_dt->id.'</strong> ('.$_tra_dt->col->tt.')</div>';
	}else{
		echo '<div class="sac-in">¿ES UN NUEVO TICKET? <button class="sac _anm" cnv-id="'.$__cnv_id.'" row-id="'.$__cnv_id.'" cls-pnl="ok">SI</button> <button class="no-sac _anm" row-id="'.$__cnv_id.'" cnv-id="'.$__cnv_id.'" cls-pnl="ok">NO</button></div>';		
	}

?>
<?php if(!isN($_tra_dt->id) || !isN($__mdlcnt_dt->id)){ 
	
	if(!isN($_tra_dt->id)){
		$_sbj = 'Ticket #'.$__mdlcnt_dt->id.' - Nueva Información Sobre Tu Solicitud';
	}else{
		$_sbj = '';
	}

	?>	

	<div class="status _anm"></div>

	<div class="snd_opt">
		<?php if($___Ls->gt->m == 'ec'){ echo 'EC template'; } ?>
		<div class="sndr">
			<ul>
				<li>
					<div class="tt">Para:</div>
					<div class="slc"><?php echo LsCntEml(['cnt'=>$__mdlcnt_dt->cnt->id, 'id'=>'emlsnd_eml', 'v'=>'cnteml_enc', 'va'=>$___Ls->dt->rw['ecsnd_eml']]); $CntWb .= JQ_Ls('emlsnd_eml', FM_LS_SLEML); ?></div> 
				</li>
				<?php if(isN($__iscnvr->id)){ ?>
				<li>
					<div class="tt">De:</div>
					<div class="slc"><?php echo LsUsEml([ 'id'=>'emlsnd_sndr', 'v'=>'eml_enc', 'va'=>$__t_s_i, 'lbl'=>TX_SLCEML, 'rq'=>2 ]); $CntWb .= JQ_Ls('emlsnd_sndr', 'Seleccione Sender');  ?></div>
				</li>
				<li class="fll">
					<div class="tt">Asunto:</div>
					<div class="slc"><?php echo HTML_inp_tx('emlsnd_sbj', 'Asunto', $_sbj, FMRQD,''); ?></div>
				</li> 
				<?php }else{ ?>
					<?php 
						echo HTML_inp_hd('emlsnd_sndr', $__cnv_dt->chnl->eml->enc);
						echo HTML_inp_hd('emlsnd_sbj', 'RE: '.$_sbj);
					?>
				<?php } ?>
			</ul>
		</div>
		<div class="wrt-us">
			<?php echo HTML_textarea('emlsnd_text', '', '', '', '', '_anm ', 200, '600'); ?>
			<?php if(!isN($__iscnvr->id)){ echo HTML_inp_hd('mdlcntcnv_enc',$__cnv_dt->enc); }else{ echo HTML_inp_hd('mdlcntcnv_mdlcnt', $__mdlcnt_dt->enc); } ?>
		</div>
		<div class="snd-act">
			<button id="btn-cnv-snd">Enviar</button>
		</div>
	</div>

<?php } ?>

<?php if(!isN($__thrd) && $_msg_tot > 0){ ?>

	<?php

		foreach($__thrd->ls as $_thrd_k=>$_thrd_v){

			$__i=0;
			$__id_cnt = $_thrd_v->enc.'_'.Gn_Rnd(20);
			$_from_eml_shw = '';
			$_from_nm_shw = '';
			$_to_eml_shw = '';
			$_to_nm_shw = '';
			
			//if(isN($_thrd_v->attr->fromaddress) || isN($_to_v->dt->eml)){
			$__addr = $__Eml->_gt_ls_addr([ 'id'=>$_thrd_v->id ]);
			//}

			$_to_eml_a=[];
			
			if(!isN($__addr->ls->to)){

				foreach($__addr->ls->to as $_to_k=>$_to_v){
					$_to_eml_a[] = '<div class="_blck"><div title="'.$_to_v->dt->eml.'">'.$_to_v->dt->nm.'</div></div>';
				}

				$_to_eml_shw = $__addr->to[0]->dt->eml;
				$_to_nm_shw = $__addr->to[0]->dt->nm;

			}

			if(!isN($__addr->ls->from)){
				foreach($__addr->ls->from as $_from_k=>$_from_v){
					if($_from_v->dt->nm == $_from_v->dt->eml){
						$_from_eml_shw = $_from_v->dt->nm;
						$_from_nm_shw = $_from_v->dt->nm;
						$_from_nm_sg = $_from_v->dt->sg;
					}else{
						$_from_eml_shw = $_from_v->dt->eml;
						$_from_nm_shw = $_from_v->dt->nm;
						$_from_nm_sg = $_from_v->dt->sg;
					}
				}
			}


			if($_msg_tot > 2){ $_msg_cls='cmpct'; }else{ $_msg_cls=''; }
	?>	
		
		<?php if($__i==0){ echo HTML_inp_hd('mdlcntcnv_rply_to', $_thrd_v->enc); } ?>

		<div class="msg-cnt _anm <?php echo $_msg_cls; ?>" id="msg-cnt-<?php echo $__id_cnt ?>">
			<div class="_hdr" msg-id="<?php echo $__id_cnt; ?>">
				<div class="thumb">
					<div class="_c _c1">
						<div class="_dte">
							<?php echo FechaESP_OLD($_thrd_v->f); ?>
							<span><?php echo _DteHTML(['d'=>$_thrd_v->f, 'nd'=>'no']); ?></span>
						</div>
					</div>
					<div class="_c _c2">
						<div class="_img <?php if(isN($_from_img)){ echo '_empty'; } ?>">
							<div class="_sg"><?php echo $_from_nm_sg; ?></div>
						</div>
					</div>
				</div>
				<h1 title="<?php echo $_from_eml_shw; ?>"><?php echo $_from_nm_shw; ?><span><?php echo $_from_eml_shw ?></span></h1>
				<h2><?php echo $_thrd_v->attr->subject; ?></h2>
				<div class="cnt">
					<?php 
						if(isN($_to_eml_a) && !isN($_thrd_v->addr->ls->to)){
							foreach($_thrd_v->addr->ls->to as $_to_addr_k=>$_to_addr_v){
								$_to_eml_a[] = '<div class="_blck"><div title="'.$_to_addr_v->dt->eml.'">'.$_to_addr_v->dt->nm.'</div></div>';
							}
						}
					?>
					<div class="_shw to"><?php echo Strn(TX_MAIL_TO.':').implode(',',$_to_eml_a); ?></div>

					<?php if(!isN($__cc)){ ?><div class="_shw cc"><?php echo Strn(TX_MAIL_CC.':').'<div class="_blck">'.$__cc.'</div>'; ?></div><?php } ?>
				</div>
			</div>
			<?php if($_thrd_v->attch->tot > 3){ ?>
				<div class="_attch">
					<div class="owl-carousel" id="my_eml_cnv_attch">
						<?php foreach($_thrd_v->attch->ls as $_attch_k=>$_attch_v){ ?>
							<?php if(!isN($_attch_v->url->uri)){ ?>
								<div class="item">
									<div class="wrp">
										<a href="<?php echo $_attch_v->url->uri; ?>" target="_blank"><div class="img-bck" style="background-image:url(<?php echo $_attch_v->url->uri; ?>);"></div></a>
									</div>
								</div>
							<?php } ?>
						<?php } ?>
					</div>
				</div>
				<?php
					$CntWb .= 'SUMR_Main.eml.attch.crsl();';
				?>
			<?php } ?>

			<div class="_body">
				<iframe id="msg-cnt-ifr-<?php echo $__id_cnt ?>" msg-id="<?php echo $__id_cnt; ?>" frameborder="0" class="_anm" src="<?php echo Fl_Rnd(FL_DT_GN.__t('my_eml_msg_dt',true).'&cnvmsg_id='.$_thrd_v->enc); ?>" scrolling="no" ></iframe>
				<div class="ldr"></div>
			</div>
		</div>
		<?php 
			
			/*$CntJV .= '	
			
				$("#msg-cnt-'.$__id_cnt.' iframe").on("load", function(){

					var _ths = $(this);
					_ths.addClass("_rdy");
					$("#msg-cnt-'.$__id_cnt.'").addClass("_show");

					setTimeout(function(){

						if(	!isN( _ths.contents() ) && 
							!isN( _ths.contents().find("html") ) && 
							!isN( _ths.contents().find("html").height() )
						){
							_ths.height( _ths.contents().find("html").height() );
						}

					},1000);

				}); 

			';*/
				
			$CntJV .= " $(document).find('[thrd-id=".$__cnv_id."]').removeClass('_noread'); ";

		?>
		<?php $__i++; ?>
	<?php } ?>

<?php } ?>	

<?php 

	$CntWb .= "SUMR_Main.eml.dom();";

	if(!isN($_tra_dt->id) || !isN($__mdlcnt_dt->id)){
		$CntWb .= "SUMR_Main.eml.wrt.edtr();";
	}

?>
</div>