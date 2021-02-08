<?php 
if(class_exists('CRM_Cnx')){

	$___Ls->cnx->cl = 'ok';
	$___Ls->tpr = 'act';
	$___Ls->sch->f = 'actup_nm';
	$___Ls->ino = 'id_actsup';
	$___Ls->ik = 'actup_enc';
	$___Ls->new->w = 400;
	$___Ls->new->h = 300;	 
	$___Ls->edit->w = 600;
	$___Ls->edit->h = 600;
	$___Ls->new->up = 'ok';
	
	$___Ls->_strt();
	
	
	if(_SbLs_ID('i')){
		 	
		$__fl .= " AND actup_act = ( 	SELECT id_act
											FROM "._BdStr(DBM).TB_ACT." 
											WHERE act_enc = ".GtSQLVlStr($___Ls->gt->isb, "text")."
										)"; 
	}



	if(!isN($___Ls->gt->i)){	 			 
 			 
		$___Ls->qrys = sprintf("SELECT * 
								FROM "._BdStr(DBM).TB_ACT_UP." 	 
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
	
	}elseif($___Ls->_show_ls == 'ok'){ 
		
		$Ls_TotLds = ", (SELECT COUNT(*) FROM ".DB_PRC.".".MDL_UP_COL_BD." WHERE upcol_up = actup_up) AS __tot_lds ";
		/*$Ls_TotLds_Ld = ", (SELECT COUNT(*) FROM ".TB_EC_LSTS_EML." WHERE acteml_up = id_actup) AS __tot_lds_ld ";*/
		$Ls_TotLds_W = ", (SELECT COUNT(*) FROM ".DB_PRC.".".MDL_UP_COL_BD." WHERE upcol_up = actup_up AND upcol_est = 3) AS __tot_lds_w ";
		$Ls_TotLds_P = ", (SELECT COUNT(*) FROM ".DB_PRC.".".MDL_UP_COL_BD." WHERE upcol_up = actup_up AND upcol_est = 2) AS __tot_lds_p ";
	
		$Ls_Whr = "	FROM "._BdStr(DBM).TB_ACT_UP." 
						 INNER JOIN "._BdStr(DB_PRC).TB_UP_BD." ON actup_up = id_up
						 INNER JOIN "._BdStr(DBM).TB_ACT." ON actup_act = id_act
						 INNER JOIN "._BdStr(DBM).TB_CL." ON act_cl = id_cl
						 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'up_est', 'als'=>'e' ])."
					WHERE id_actup != '' $_f_tp $__fl AND cl_enc = '".DB_CL_ENC."' 
					ORDER BY id_actup DESC";
					
		$___Ls->qrys = "SELECT *, 
							  (SELECT COUNT(*) $Ls_Whr) AS __rgtot, 
							  "._QrySisSlcF([ 'als'=>'e', 'als_n'=>'estado' ]).",
							  ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'estado', 'als'=>'e' ])."
							  $Ls_TotLds $Ls_TotLds_Ld $Ls_TotLds_W $Ls_TotLds_P 
						$Ls_Whr";		

	} 

	$___Ls->_bld();	
	
	$CntWb .= " SUMR_Main.cll_cbx({ _c: function(){ ".$___Ls->ls->rld." } }); ";

?>
<?php if($___Ls->ls->chk == 'ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>

<?php $CntJV .= "var __up={};"; ?>


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg LsRgNw">
  <tbody>
		  <?php do { ?>
		  
		  <tr <?php 
     
	            $__DtUp = GtUpColTot(['id'=>$___Ls->ls->rw['actup_up']]);       
		      			    
				$AvncId = $___Ls->ls->rw['up_enc'];  


		        $CntJV .= "
								
		        	function f_{$AvncId}_js(r){
									        	
			        	try{ 
				        	
				        	if(!isN(r)){
					        	
					        	if(!isN(r.p) && !isN(r.p.n)){	
		        					$('#".$AvncId."').val(r.p.n).trigger('change');
		        				}	
		        				
		        				if(!isN(r.d)){ 
		        					if(!isN(r.d.l)){ $('#n_l_".$AvncId." strong').html(r.d.l); }
		        					if(!isN(r.d.o)){ $('#n_o_".$AvncId." strong').html(r.d.o); }
		        					if(!isN(r.d.w)){ $('#n_w_".$AvncId." strong').html(r.d.w); }
		        				}	
		        				
		        				if(!isN(r.p) && !isN(r.p.n) && r.p.n != '100'){ $('#bx_".$AvncId."').fadeIn(); }
								
								
								$('#__rw_".$AvncId."').removeClass().addClass(r.up.d.est_cls);
								
								
								if(!isN(r) && !isN(r.p) && !isN(r.p.n) && r.p.n == '100'){		
						        	$('#bx_".$AvncId."').fadeOut();			
					        	}else{
						        	if(!isN(r.up) && !isN(r.up.b) && !isN(r.up.b.html)){
						        		f_{$AvncId}_knob(r.up.b);
						        		$('#bx_".$AvncId."').fadeIn();
									}
					        	}
			        		
			        		}
			        		
			        		return true;
			        		
		        		}catch(e) {
			        		
							SUMR_Main.log.f({ t:'".TX_ERROR."', m:e });
							
						}
		        	}
		        	
		        	function f_{$AvncId}_knob(r){
			        	if(!isN(r)){
				        	if(!isN(r.html)){ var html = r.html; }
				        	$('#bx_".$AvncId."').html(html);
				        	if(!isN(r.js)){ eval(r.js); }
			        	}
			        	
		        	}										        	
		        	
		        		
		        ";
				
				$CntJV .= "
							    		
		    		__up['{$AvncId}'] = { id:'".$___Ls->ls->rw['up_enc']."', f:'{$AvncId}', t:'".$___Ls->ls->rw['up_est']."' };
			    		
					f_{$AvncId}_knob();
					
		    	"; 
		        
		        
		        $__div_l = '<div class="__avnc_l" id="bx_'.$AvncId.'" style="display:none;"></div>';
			            
          ?>>
            <td align="left" <?php echo $_clr_rw ?> width="84%" class="__up_ls">
	            	<?php echo h2( 'Carga '.$___Ls->ls->rw['id_up'] /*ctjTx($___Ls->ls->rw['up_fle'],'in')*/ ).
		            		   Spn( ctjTx($___Ls->ls->rw['estado_sisslc_tt'],'in') ).HTML_BR.
		            		   Strn(TX_FICR).' '.
		            		   Spn(_DteHTML(['d'=>$___Ls->ls->rw['actup_fi'], 'nd'=>'ok']), '', '_f');
		           	?>
		    </td>
		    
		    
		    <?php if($___Ls->ls->rw['up_fle'] != ''){ ?>
	            <td align="center" width="5%" <?php echo NWRP.$_clr_rw ?>>
		            <?php  
			            echo '<button id="n_w_'.$AvncId.'" class="_dtl _nmb ___upshowdtl" data-id="'.$___Ls->ls->rw['up_enc'].'">'.
			            		Strn($___Ls->ls->rw['__tot_lds_w']).
			            	 '</button>'.HTML_BR.Spn('Errores', '', '_adv'); 
			            
			        ?>
		        </td>
	            <td id="<?php echo 'n_o_'.$AvncId; ?>" align="center" width="5%" <?php echo NWRP.$_clr_rw ?>>
		            <?php echo Strn($___Ls->ls->rw['__tot_lds_ld']).HTML_BR.Spn('Cargados', '', 'ok') ?>
		        </td>
	            <td id="<?php echo 'n_l_'.$AvncId; ?>" align="center" width="5%" <?php echo NWRP.$_clr_rw ?>>
		            <?php echo Strn($___Ls->ls->rw['__tot_lds']).HTML_BR.Spn('Registros') ?>
		        </td>
	            <td width="1%" align="left" nowrap="nowrap">
	                <?php 
		                if($_lnktr_l != ''){
		                	echo HTML_Ls_Btn(  ['t'=>'edt', 'l'=>_Ls_Lnk_Rw(['l'=>$_lnktr_l, 'js'=>'ok', 'sb'=>$__lssb, 'r'=>$___Ls->bx_rld, 'w'=>'95%', 'h'=>'95%']) ]); 
						}
		            ?>
	            </td>
	            <td width="1%" align="left" nowrap="nowrap" class="_btn">
		            <?php echo HTML_Ls_Btn(  ['t'=>'up', 'l'=>Fl_Rnd(FL_FM_UP.__t('pro_cnt',true).ADM_LNK_DT.$___Ls->ls->rw['id_up']), 'cls'=>'FmUpBd' ]); ?>
		        </td>
	            
	            <td align="left" <?php echo $_clr_rw ?> width="1%"><?php echo $__div_l; ?></td>
            <?php } ?>
                        
          </tr>
          <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
          
          
          <?php 
		                  
              	$CntJV .= "
              			
              		function f_up_updt(){
			        	/*
			        	try{ 
				        	
				        	SUMR_Main.autop({ 
				        		t:'_auto', 
			        			d:{ 
				        			tp:'up',
				        			tp2:'ec_act',
				        			lmt:1000,
			        				up:__up,
			        			},
			        			_c:function(r){	
				        			if(!isN(r)){							  
					        			if(!isN(r.ls)){
						        			$.each(r.ls, function(k, v) { 
							        			if(!isN(v.f)){
						        					window['f_'+v.f+'_js'](v);
						        					f_up_updt_domrbld();
						        				}
						        			});
					        			}	
					        		}		        				
		        				},
		        				_cm:function(e){
			        				setTimeout(function(){ 
						        		f_up_updt();
						        	}, 10000);		
		        				}
			        		}); 
			        		
			        		return true;
			        		
		        		}catch(e) {
			        		
							SUMR_Main.log.f({ t:'".TX_ERROR."', m:e });
							
						}*/
						
		        	}	
              		
              		
              		function f_up_updt_domrbld(){
              		
              			$('.___upshowdtl').off('click').click(function(e){
									
							e.preventDefault();

							var __id = $(this).attr('data-id');
							
							_ldCnt({ 
								u:'".FL_UP_GN.__t('snd_ec_act_up', true).ADM_LNK_DT."'+__id+'"._SbLs_ID()."&_w=ok', 
								pop:'ok',
								pnl:{
									e:'ok',
									s:'l',
									tp:'h',
								},
								cls:'_ls_upl', 
								_cl:function(){
								
								}
							});
	
						});
					
					}
							
              		
              		f_up_updt();
              		f_up_updt_domrbld();
              	
			  	";

			  		
			  	$CntWb .= "	
			  				
			  				
							
						";

	          
	         	$CntWb .= '$(".FmUpBd").colorbox({width:"400", height:"255", overlayClose:false, escKey:false, onLoad:function(){ $("#colorbox").removeAttr("tabindex");}, onClosed:function(){ SUMR_Main.anm.h_cmpct();} });'; 
	          
	          	$CntWb .= '$("._dtl").colorbox({ scrolling:false, width:"95%", height:"95%", trapFocus:false, overlayClose:false, escKey:false, 
	          									 onClosed:function(){ 
	          									 	SUMR_Main.anm.h_cmpct(); 
	          									 	'.$__lsgt.'
	          									 }  
	          								  }); ';  
	        ?>								
  </tbody>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php } ?>
