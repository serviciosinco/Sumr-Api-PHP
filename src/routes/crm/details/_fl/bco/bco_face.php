<?php 
	
	$__Aws = new API_CRM_Aws();	
	$__FceDt = GtBcoFceDt([ 'cnx'=>$___Dt->c_r, 'enc'=>$___Dt->gt->i ]);
	$__FceAttr = GtBcoFceAttrLs([ 'cnx'=>$___Dt->c_r, 'bco_fce'=>$__FceDt->id ]);
	
?>
<div class="BcoFceDt">
	<?php 
		
		echo bdiv([
				'c'=>bdiv([
					'c'=>'',
					'cls'=>'_main',
					'sty'=>'background-image:url('.$__FceDt->img->main.');'
				])
			]);
		
	?>
	<div class="_col">
		
		<div class="_c1">
			
			<?php 
	
				if($__FceAttr->tot > 0){
					
					echo '<ul class="_attr">';
					
					foreach($__FceAttr->ls as $_attr_k=>$_attr_v){
						
						if($_attr_v->key != 'Landmarks' && $_attr_v->key != 'BoundingBox' && $_attr_v->key != 'Confidence' && $_attr_v->key != 'Pose' && $_attr_v->key != 'Quality'){
							
							if(is_array($_attr_v->vl) || is_object($_attr_v->vl)){
								
								echo '<li>'.Strn($_attr_v->key).'<ul>';
								
								foreach($_attr_v->vl as $__o_k=>$__o_v){
									
									if(is_array($__o_v) || is_object($__o_v)){
										
										echo li(Strn($__o_v->Type.':'). number_format($__o_v->Confidence,0,'.','').'%' );
										
									}else{
										
										if($__o_k == 'Value' && ($__o_v=='1'||isN($__o_v))){ $__vshow = mBln($__o_v); }
										elseif($__o_k == 'Confidence'){ $__vshow = number_format($__o_v,0,'.','').'%'; }
										else{ $__vshow=$__o_v; }
										
										
										echo li(Strn($__o_k.' ').$__vshow);
									}
									
								}
								
								echo '</li></ul>';
								
							}else{
								
								echo li(Strn($_attr_v->key.' ').$_attr_v->vl);
								
							}
						
						}
						
					}
					
					echo '</ul>';
					
				}
				
			?>
			
		</div>
		
		<div class="_c2">
			<?php 
				$__othbco = $__Aws->_cllc_sch([ 'cid'=>$__FceDt->cid ]);
				
				if($__othbco->tot > 0){
					foreach($__othbco->ls as $_oth_k=>$_oth_v){
						if($_oth_v->Face->ExternalImageId != $__FceDt->id){
							$__othbco_idm[] = $_oth_v->Face->ExternalImageId;
						}
					}	
				}
				
				if(!isN($__othbco_idm)){
					$__othbco_bd = GtBcoLs([ 'idm'=>$__othbco_idm ]);	
				}
				
			?>
			<h2>Otras Fotos (<?php echo $__othbco_bd->tot; ?>) </h2>
			<h3>Donde aparece esta persona</h3>
			<div class="_GrdImg">
				<?php 
					
					foreach($__othbco_bd->ls as $__img_k=>$__img_v){
						echo bdiv([
							'c'=>'',
							'cls'=>'_img',
							'sty'=>'background-image:url('.DMN_FLE_BCO_TH.'th_'.$__img_v->img.');'
						]);
					}
				
				?>
			</div>
		</div>		
	</div>
	
</div>
<style>

	.BcoFceDt{  }
	.BcoFceDt ._col{ display: flex; }
	.BcoFceDt ._col ._c1{ width: 40%; display: inline-block; border-right: 1px dotted #d3d5d6; padding-right: 40px; text-align: right; }
	.BcoFceDt ._col ._c2{ width: 60%; display: inline-block; }
	
	.BcoFceDt ._main{ width:200px; height:200px; margin-left: auto; margin-right: auto; background-repeat: no-repeat; background-position: center center; background-size: cover; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; border: 6px solid var(--second-bg-color); overflow: hidden; position: relative; }
	.BcoFceDt ._main::before{ width: 188px; height: 188px; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; border: 4px solid white; position: absolute; left: 0px; top: 0px; }
	
	.BcoFceDt ._attr{ list-style: none; padding: 0; margin: 50px 0 0 0; }
	.BcoFceDt ._attr > li{ text-align: right; padding-bottom: 30px; }
	.BcoFceDt ._attr > li > strong{ font-family: Economica; text-transform: uppercase; font-size: 25px; font-weight: 300; color: #9da3a6; }
	
	
	.BcoFceDt ._attr > li > ul{ padding: 0; margin: 0; list-style: none; }
	.BcoFceDt ._attr > li > ul > li{ font-size: 13px; color: #171818; }
	.BcoFceDt ._attr > li > ul > li strong{ text-transform: lowercase; font-size: 12px; font-weight: 300; color: #838587; margin-right: 5px; }
	
	
	
	
	.BcoFceDt ._col ._c2 h2{ font-family: Economica; text-transform: uppercase; font-size: 35px; text-align: center; color: var(--main-bg-color); display: block; width: 100%; margin:30px 0 0 0; padding: 0; }
	.BcoFceDt ._col ._c2 h3{ font-family: Economica; text-transform: uppercase; font-size: 17px; text-align: center; font-weight: 100; display: block; color: #b7b7b7; width: 100%; margin:0; padding: 0; }
	
	
	.BcoFceDt ._col ._c2 ._GrdImg{ display: block; padding: 30px; width: 100%; text-align: center; }
	.BcoFceDt ._col ._c2 ._GrdImg ._img{ width: 100px; height: 80px; display: inline-block; vertical-align: top; margin: 0 3px 3px 0; background-repeat:no-repeat; background-position: center center; background-size: cover; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; }
	
	

</style>	