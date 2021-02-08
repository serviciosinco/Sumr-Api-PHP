<?php 
if(class_exists('CRM_Cnx')){
	
	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'smscmpgup_nm';
	$___Ls->_strt();
	
	$__tb = Php_Ls_Cln($_GET['Tb']);		
	
	$__lsgtin = '
		
		SUMR_Main.cll_cbx({  _c: function(){ '.$__lsgt.' } }); 
	 			 
		$.colorbox({
		 	href:"'.FL_FM_UP.__t($__bdtp, true)._SbLs_ID().TXGN_ING.$___Ls->ls->vrall.LNK_RND.Gn_Rnd(20).'", 
		 	trapFocus:false, width:"430", height:"255", overlayClose:false, escKey:false, 
			onClosed:function(){ 
				 
				if(!isN(SUMR_Main.cbxGo)){ 
					SUMR_Main.cbxGo(); 
					SUMR_Main.cll_cbx();
				}
			}		
		});
		
	';
	
	if(_SbLs_ID('i')){ $__fl .= _AndSql('smscmpgup_cmpg', _SbLs_ID('i')); }
	
	if(!isN($___Ls->gt->i)){	
 
		$___Ls->qrys = sprintf("SELECT * FROM ".MDL_TB_SMS_CMPG_UP_BD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){
		
		$Ls_TotLds = ", (SELECT COUNT(*) FROM ".DB_PRC.".".MDL_UP_COL_BD." WHERE upcol_up = smscmpgup_up) AS __tot_lds ";
		$Ls_TotLds_W = ", (SELECT COUNT(*) FROM ".DB_PRC.".".MDL_UP_COL_BD." WHERE upcol_up = smscmpgup_up AND upcol_est = 615) AS __tot_lds_w ";
		$Ls_TotLds_L = ", (SELECT COUNT(*) FROM ".DB_PRC.".".MDL_UP_COL_BD." WHERE upcol_up = smscmpgup_up AND upcol_est = 352) AS __tot_lds_l ";


		$Ls_Whr = "	FROM ".MDL_TB_SMS_CMPG_UP_BD.", 
						".DB_PRC.".".MDL_UP_BD.", 
						".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'up_est', 'als'=>'e' ])."
					WHERE ".$___Ls->ino." != '' AND smscmpgup_up = id_up $__fl ORDER BY ".$___Ls->ino." DESC";
		
		$___Ls->qrys = "SELECT *, 
						
						"._QrySisSlcF([ 'als'=>'e', 'als_n'=>'estado' ]).",
						".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'estado', 'als'=>'e' ])."
						
						(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_TotLds $Ls_TotLds_L $Ls_TotLds_W $Ls_Whr $Tot_Var"; 
		
		
	} 
	
	$___Ls->_bld(); 

?>
<?php if($___Ls->ls->chk=='ok'){ ?>

<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg LsRgNw">
	<tbody>
		<?php do { ?> 
		<?php 
		                
            $__DtUp = GtUpColTot([ 'id'=>$___Ls->ls->rw['smscmpgup_up'] ]);
		    $AvncId = Gn_Rnd(5).'_avnc';
                
            $___js_avnc = _Kn_Prcn([ 'id'=>$AvncId, 'l'=>'ok', 'v'=>0, 'w'=>'40', 'di'=>'ok' ]); 
            
	        $CntWb .= $___js_avnc->js."
	        	
	        	function f_{$AvncId}_js(){

					/*
		        	SUMR_Main.autop({ 
		        		t:'_auto', 
	        			d:{ 
		        			tp:'up_sms_cmpg',
	        				up:'".$___Ls->ls->rw['smscmpgup_up']."',
	        			},
	        			_c:function(r){
	        				
	        				if(r.e == 'ok' && r.p.n != undefined){
	        					$('#".$AvncId."').val(r.p.n).trigger('change');
	        					
	        					$('#n_l_".$AvncId." strong').html(r.d.l);
	        					$('#n_o_".$AvncId." strong').html(r.d.o);
	        					$('#n_w_".$AvncId." strong').html(r.d.w);
	        					
	        					if(r.p.n != '100'){ $('#bx_".$AvncId."').fadeIn(); }
							}
									        				
	        				if( $('#".$AvncId."').is(':visible') && !isN(r.p.n) && r.p.n != '100'){ 
		        				setTimeout(function(){ 
					        		f_{$AvncId}_js();
					        	}, 3000);
				        	}else if(!isN(r.p.n) && r.p.n == '100'){
					        	$('#bx_".$AvncId."').fadeOut();	
				        	}
        				}
	        		});

					*/
	        	}
	        	
				f_{$AvncId}_js();
	        	
	        ";    
	        
	        
	        $__div_l = '<div class="__avnc_l" id="bx_'.$AvncId.'" style="display:none;">'.$___js_avnc->html.'</div>';  

		              
        ?>  
		<tr>
            <td align="left" <?php echo $_clr_rw ?> width="40%" class="__up_ls">
	            	<?php echo h2(ctjTx($___Ls->ls->rw['up_fle'],'in')).
		            		   Strn(TX_FICR).' '.
		            		   Spn(_DteHTML(array('d'=>$___Ls->ls->rw['smscmpgup_fi'], 'nd'=>'ok')), '', '_f'); 
		           	?>
		    </td>
            <td align="center" width="5%" <?php echo NWRP.$_clr_rw ?>>
	            <?php  
		            echo '<a id="n_w_'.$AvncId.'" href="'.FL_UP_GN.__t('sms_cmpg_up',true).ADM_LNK_DT.$___Ls->ls->rw['id_up']._SbLs_ID().TXGN_POP.'&_w=ok" class="_dtl _nmb">'.
		            		Strn($___Ls->ls->rw['__tot_lds_w']).
		            	 '</a>'.HTML_BR.Spn(TX_ERS, '', '_adv'); 
		            
		        ?>
	        </td>
            <td id="<?php echo 'n_o_'.$AvncId; ?>" align="center" width="5%" <?php echo NWRP.$_clr_rw ?>><?php echo Strn($___Ls->ls->rw['__tot_lds_l']).HTML_BR.Spn(TX_CRGD, '', 'ok') ?></td>
            <td id="<?php echo 'n_l_'.$AvncId; ?>" align="center" width="5%" <?php echo NWRP.$_clr_rw ?>><?php echo Strn($___Ls->ls->rw['__tot_lds']).HTML_BR.Spn(TX_RCRDS) ?></td>
            
           
            <td width="1%" align="left" nowrap="nowrap">
                <?php 
	                //if($_lnktr_l != ''){
	                	echo HTML_Ls_Btn(  array('t'=>'edt', 'l'=>_Ls_Lnk_Rw(array('l'=>$_lnktr_l, 'js'=>'ok', 'sb'=>$__lssb, 'r'=>$___Ls->bx_rld, 'w'=>'95%', 'h'=>'95%')) )); 
					//}
	            ?>
            </td>
            <td align="left" <?php echo $_clr_rw ?> width="1%"><?php echo $__div_l; ?></td>

            <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
        </tr>
        <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
        <?php $CntWb .= '$("._dtl").colorbox({ scrolling:false, width:"95%", height:"95%", trapFocus:false, overlayClose:false, escKey:false, 

	          									 onClosed:function(){ 
	          									 	 
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