<div class="cmnts_list">
	
	<ul> 
																		
	<?php 
	
			
			$ec_cmnt = GtSisEcCmnt([ "tp"=>"ec", "id"=>$_GET['__i'] ]);
			$_us = SISUS_ID;
			
			if($ec_cmnt != ''){
			
				foreach($ec_cmnt AS $_k => $_v){
					
					$_cls_rd = '';
						
					if(!isN($_v->cmnt)){

						$id = $_v->id;
	
				    	$date = new DateTime($_v->f);	
					    			
						$ecCmntRd = GtSisEcCmntRd([ "id_ec"=>$_v->id ]);
						$Rs_Qry = "INSERT INTO ".TB_EC_CMNT_RD." (eccmntrd_eccmnt, eccmntrd_us) VALUES (".$id." , ".$_us.")";
						
						if($ecCmntRd->id != '' && $ecCmntRd->e == 'ok'){
							
							$CntWb .= " $('.cmnt_r_".$id."').html('<a style=\"cursor:pointer;\" class=\"chk_cmnt\" id=\"".$_v->id."\" >".$ecCmntRd->tot." </a>'); ";
							
							$_cls_rd = 'read_ok';
							
							
							$ecCmntRdUs = GtSisEcCmntRd([ "id_ec"=>$_v->id, "us"=>$_us, "tp"=>"us" ]);
							
							if($ecCmntRdUs->us != $_us && $_v->user != $_us){
								$Rs_Rg = $__cnx->_prc($Rs_Qry);
							}
							
						}else{
							
							if($_v->user != $_us){
								$Rs_Rg = $__cnx->_prc($Rs_Qry);
							}
							
						}
						
						$li .= li('<div class="us" style="background-image:url('.(!isN($_v->us->img->sm_s)?$_v->us->img->sm_s:$_v->us->img).');"><div class="wrp"><div class="read"></div> <div style="" class="cmntbx cmnt_r_'.$id.' _anm"></div> </div></div>'. 
					    				'<div class="bx">'.
					    					Spn( FechaESP_OLD( $_v->f ).' - '.$date->format('H:i a'), '', '_f').
						    				$_v->us->nm.' dijo '. 
						    				'<div class="text">'.$_v->cmnt.'</div>'.
					    				'</div>'
					    			, $_cls_rd);
					    			
							
					}
				}
			 
			}
			$ecCmntRdTot = GtSisEcCmntRdTot(["id_ec"=>$_GET['__i']]);
			if($ecCmntRdTot->_tot == 0){
				$_tot = '';
			}else{
				$_tot = $ecCmntRdTot->_tot;
			}
			$CntWb .= "$('.cmnt_tb').html('".$_tot."');";
			
			$CntWb .= "
			
				$('.chk_cmnt').off('click').click(function (){ 

					var id_eccmnt = $(this).attr('id');

					_ldCnt({ 
						u:'".FL_FM_GN.__t('ec_cmnt_us',true)."&__i='+id_eccmnt,
						w:'98%',
						h:'98%',
						pop:'ok',
						pnl:{
							e:'ok',
							tp:'h'
						},
						cls:'_upl' 
					});	
				});
			
				
			";
			
			echo $li;
			
		?>
		
	</ul>

</div>