<section class="_wrp del" style="opacity:0; filter: alpha(opacity=0);">
		
	<div class="_cnt">
		
		<div class="_c1">
			<header class="_lgo"></header>
			<?php if($__dtcnt_sndi == 'ok'){ ?>
				<?php foreach($__dtcnt->plcy->ls as $_plcy_k=>$_plcy_v){ ?>	
					<?php if($_plcy_v->on == 'ok'){ ?>
						<ul>
							<li><a href="<?php echo $_plcy_v->lnk->url ?>"><?php echo TT_PLCY.HTML_BR.Spn($_plcy_v->nm,'','_nm'); ?></a></li>
						</ul>
					<?php } ?>
				<?php } ?>
				
				<ul>
					<li><a href="<?php echo DMN_EC.$_cl_dt->sbd.'/'.LNK_UPD.'/?_s='.$_s.'&_c='.$__c.'&_Rnd='.Gn_Rnd(5) ?>"><?php echo TX_UPDTDT; ?></a></li>
				</ul>
							
			<?php } ?>
		</div>
		
		<div class="_c2">
			
			<?php if(!isN($__dtcnt_sndi) && $__dtcnt_sndi != 'ok'){ ?>
			
				<div class="_msj_ok">
					<div class="_icn"></div>
					<h1>El estado de su <br>suscripción actual es:</h2>
					<h2>- cancelada -</h2>
				</div>	
				
			<?php }elseif(!isN($__dtsnd->enc) || !isN($__dtcnt->enc)){ ?>
			
				<div class="_dt_cnt">
					<div class="_icn"></div>
					<h2>Cancelar Suscripción</h2>
					<div class="pmain"><?php echo $__ec->_ctj([ 'v'=>$_cl_dt->tag->txta->{'plcy-eli-txt'}->v ]); ?></div>
					<?php /* <ul>
						<li><strong>Nombre: </strong><?php echo $__dtcnt->nm; ?></li>
						<li><strong>Apellido: </strong><?php echo $__dtcnt->ap; ?></li>
						<li><strong>Ciudad: </strong><?php //echo $__dtcnt->cd; ?></li>
					</ul> <?php */ ?>
				</div>
				
				<form id="Fm_del_ec">
					
					<div class="plcy">
						<?php 
							echo LsPlcy('_cnt_plcy', 'clplcy_enc', '', FM_LS_PLCY, 2, 'ok', [ 'cl'=>$_cl_dt->enc, 'shw'=>$__dtcnt_sndi_on ] );
							$_CntJQ_Spry .= JQ_Ls('_cnt_plcy', '');
							$_CntJQ_Slc2 .= " setTimeout(function(){ $('._wrp.del ._cnt .plcy').show(); }, 500); ";
						?>
					</div>
					
					<input type="hidden" id="_cnt" name="_cnt" value="<?php echo $__dtcnt->enc; ?>">
					<input type="hidden" id="_ec_snd" name="_ec_snd" value="<?php echo $__dtsnd->enc; ?>">
					<input type="hidden" id="_cnt_eml" name="_cnt_eml" value="<?php echo $__dtsnd->eml->enc; ?>">
					<input type="button" id="_unscr" name="_unscr" class="_anm _unscr" value="Cancelar suscripción">
				</form>
				
			<?php }else{ ?>
				
				
				<div class="_msj_ok">
					<div class="_icn"></div>
					<h2>Valida <br>tu ingreso</h2>
				</div>
				
				<?php include('cnt/dt/ec_getcnt.php'); ?>
				
			<?php } ?>
			
				
		</div>
		
	</div>	

</section>