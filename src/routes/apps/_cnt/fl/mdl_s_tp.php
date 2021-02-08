<?php 
	
	if(!isN($__dt_app->tp->ls)){
		foreach($__dt_app->tp->ls as $_tp_k=>$_tp_v){
			$__mstp_i[] = $_tp_v->tp->id; 
			$__mstp_fm[ $_tp_v->tp->key ] = $_tp_v->fm; 
		}
		if(!isN($__mstp_i)){
			$__mstp_fl = ' AND id_mdlstp IN ('.implode(',', $__mstp_i).') '; 
		}
	}
		  	
  	$__mnu_o = GtMdlSTpLs([ 'cl'=>$__dt_cl->id, 'app'=>'ok', 'fl'=>$__mstp_fl ]);
		  
	foreach($__mnu_o->ls as $_mnucl_k=>$_mnucl_v){

		$__cl .= '	<li alt="'.ctjTx( $_mnucl_v->nm ,'in').'" 
						class="_anm item-opt" 
						data-rel="'.$_mnucl_v->id.'" 
						data-gen="'.$__mstp_fm[$_mnucl_v->tp].'"
						title="'.ctjTx( $_mnucl_v->nm ,'in').'">'.Spn('','','_icn _anm','background-image:url('.$_mnucl_v->img->big.');').ctjTx( $_mnucl_v->nm ,'in').'
					</li>' ;
		
	}			
	
	echo h1( 'Seleccione su interés' );
	echo ul( $__cl, 'ls_sty_1' );
	
	
	$CntWb .= "
	
		$('.app-cnt ._bxhtt ._bxhtt_cnt .item-opt').off('click').click(function() {	
			
			__rel = $(this).attr('data-rel');
			__mgen = $(this).attr('data-gen');

			SUMR_App.ld.lvl.l2 = __rel;

			var _send={_data:{}};

			_send._tp = 'mdl_gen';
			if(!isN(SUMR_App.md)){ _send._data.md = SUMR_App.md.vl; }
			if(!isN(SUMR_App.fnt)){ _send._data.fnt = SUMR_App.fnt.vl; }
			_send._data.mdl_gen = __mgen;
			_send._data.mdl_s_tp = __rel;

			SUMR_App.f.getJs(_send);

		});
		
	";
	
	
	
?>	
<?php /*
	
	$__mnu_o = GtMdlSTpLs([ 'cl'=>$__dt_cl->id, 'app'=>'ok' ]);
		  
	foreach($__mnu_o->ls as $_mnucl_k=>$_mnucl_v){ 
		
		$__nm = ctjTx( $_mnucl_v->nm ,'in');
		$__icn = $_mnucl_v->img->big;
		
	}
	
?>
<div class="col2x">
	<div class="col c1">
		<h1 class="tc1"><div class="icn" style="background-image: url(<?php echo $__icn; ?>);"></div><?php echo $__nm; ?></h1>
		<h2 class="tc2">Registre aquí sus datos</h2>
			
		<h3> <button class="_bck"></button>Volver</h3>	
	</div>
	<div class="col c2">
		<!-- Form - SUMR CRM --><iframe id='SUMR-FM-d2e42925b6d8b333659c3e2a09334cb15a51dd8c' width="100%"  border='0'></iframe> <script >(function(w,d,s,l){ var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:''; j.async=true; j.src= 'https://form.sumr.co/b.js?f=d2e42925b6d8b333659c3e2a09334cb15a51dd8c&id=1a179b6a03&app=ok&opaque=ok&icon=ok&w=100%25'; f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer');</script>		
	</div>
</div>

<?php */ ?>