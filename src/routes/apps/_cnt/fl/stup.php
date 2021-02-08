<?php 
	
	if(!SUMR_Ld.f.isN($__dt_app->tp->ls)){
		foreach($__dt_app->tp->ls as $_tp_k=>$_tp_v){
			$__mstp_i[] = $_tp_v->tp->id;
		}
		if(!SUMR_Ld.f.isN($__mstp_i)){
			$__mstp_fl = implode(',', $__mstp_i); 
		}
	}
?>
<div class="stup-opt" id="stup-opt">
	<h1>Settings</h1>
	<ul>
		<li class="md">
			<button id="btn-set-md" class="set">Establecer Medio</button>
			<div class="mod">
				<?php echo LsSis_Md('stup_md','id_sismd','','',2,'', [ 'cl'=>$__dt_cl->enc ]); $CntWb .= JQ_Ls('stup_md', FM_LS_SLTP); ?>
				<button class="del" id="btn-del-md"></button>
			</div>	
		</li>
		<li class="fnt">
			<button id="btn-set-fnt" class="set">Establecer Fuente</button>
			<div class="mod">
				<?php echo LsCntFnt('stup_fnt','id_sisfnt', '', '', '', '', [ 'cl'=>$__dt_cl->enc ]); $CntWb .= JQ_Ls('stup_fnt',FM_LS_CNTFNT); ?>
				<button class="del" id="btn-del-fnt"></button>
			</div>
		</li>
		<li class="form">
			<button id="btn-set-form" class="set">Set Form</button>
			<div class="mod">
				<?php echo LsMdlSTp('stup_mdlstp', 'id_mdlstp', '', FM_LS_SLTP, '', '', $__mstp_fl, [ 'cl'=>$__dt_cl->enc, 'all'=>'ok' ]); $CntWb .= JQ_Ls('stup_mdlstp', FM_LS_SLTP); ?>
				<button class="del" id="btn-del-mdlstp"></button>
			</div>
			<div class="mod">
				<?php echo LsMdlGen([ 'id'=>'stup_mdlgen', 'v'=>'id_mdlgen', 'rq'=>2, 'bd'=>$__dt_cl->bd, 'prfx'=>'id_mdlgen', 'fl'=>$__mstp_fl ]); $CntWb .= JQ_Ls('stup_mdlgen');  ?>
				<button class="del" id="btn-del-mdlgen"></button>
			</div>
			
			<?php if($__dt_app->stup->act == 'ok'){ ?>
			<div class="mod">
				<?php echo LsAct([ 'id'=>'stup_act', 'v'=>'id_act', 'rq'=>2, 'cl'=>$__dt_cl->id, 'prfx'=>'id_act', 'est'=>_CId('ID_ACTEST_ACT') ]); $CntWb .= JQ_Ls('stup_act');  ?>
				<button class="del" id="btn-del-act"></button>
			</div>
			<?php } ?>	
		</li>
		
		<li class="_bck"><button id="btn-set-bck" class="set">Volver</button></li>
		
	</ul>
</div>
<?php 
	
	$CntWb .= " 
	
		
		if(!SUMR_Ld.f.isN(SUMR_App)){
			if(!SUMR_Ld.f.isN(SUMR_App.md) && !SUMR_Ld.f.isN(SUMR_App.md.vl)){ $('#stup_md').val( SUMR_App.md.vl ).trigger('change'); }
			if(!SUMR_Ld.f.isN(SUMR_App.fnt) && !SUMR_Ld.f.isN(SUMR_App.fnt.vl)){ $('#stup_fnt').val( SUMR_App.fnt.vl ).trigger('change'); }
			if(!SUMR_Ld.f.isN(SUMR_App.form)){ 
				if(!SUMR_Ld.f.isN(SUMR_App.form.mdlstp) && !SUMR_Ld.f.isN(SUMR_App.form.mdlstp.vl)){  $('#stup_mdlstp').val( SUMR_App.form.mdlstp.vl ).trigger('change'); }
				if(!SUMR_Ld.f.isN(SUMR_App.form.mdlgen) && !SUMR_Ld.f.isN(SUMR_App.form.mdlgen.vl)){  $('#stup_mdlgen').val( SUMR_App.form.mdlgen.vl ).trigger('change'); }
				if(!SUMR_Ld.f.isN(SUMR_App.form.act) && !SUMR_Ld.f.isN(SUMR_App.form.act.vl)){  $('#stup_act').val( SUMR_App.form.act.vl ).trigger('change'); }
			}
		}	
		
		SUMR_App.f.dom(); 
	
	";
	
?>