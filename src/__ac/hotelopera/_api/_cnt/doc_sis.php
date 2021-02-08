<?php Hdr_HTML(); 

	function __bl_Ls($p){
		
		global $__cnx;
			
		if(is_array($p)){	
			if($p['bd']!=NULL && $p['i']!=NULL){	
				
				$Ls_Qry = "SELECT * FROM ".$p['bd']." ORDER BY ".$p['t']." ASC";
				$Ls = $__cnx->_qry($Ls_Qry);
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				
				
					$LsBld .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr><th>Id</th><th>'.TX_NM.'</th>'. ($p['c'] != NULL ? '<th>Color</th>' : '').($p['con'] != NULL ? '<th>Educon</th>' : '').($p['prg'] != NULL ? '<th>Pregrado</th>' : '').($p['psg'] != NULL ? '<th>Posgrado</th>' : '').'</tr>';
					do {
						$LsBld .= '<tr><td>'.$row_Ls[$p['i']].'</td><td>'.ctjTx($row_Ls[$p['t']],'in').'</td> '.  ($p['c'] != NULL ? '<td>'. Spn('','', '_clr_icn','background-color:'.$row_Ls[$p['c']].'; ') . $row_Ls[$p['c']].'</td>' : '') . ($p['con'] != NULL ? '<td>'. _sino($row_Ls[$p['con']]) .'</td>' : '') . ($p['prg'] != NULL ? '<td>'. _sino($row_Ls[$p['prg']]) .'</td>' : '') . ($p['psg'] != NULL ? '<td>'. _sino($row_Ls[$p['psg']]) .'</td>' : '') .'</tr>';
					} while ($row_Ls = $Ls->fetch_assoc());
					$LsBld .= '</table>';
					
				$__cnx->_clsr($Ls);

				return($LsBld);
			}
			
			
		}
			
	}
	function __bl_Ls1($p){
		
		global $__cnx;
			
		if(is_array($p)){	
			if($p['bd']!=NULL && $p['i']!=NULL){	
				$Ls_Qry = "SELECT * FROM ".$p['bd']." ORDER BY ".$p['t']." ASC";
				$Ls = $__cnx->_qry($Ls_Qry);
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
					$LsBld .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr><th>Id</th><th>'.TX_NM.'</th></tr>';
					do {
						$LsBld .= '<tr><td>'.$row_Ls[$p['i']].'</td><td>'.ctjTx($row_Ls[$p['t']],'in').'</td></tr>';
					} while ($row_Ls = $Ls->fetch_assoc());
					$LsBld .= '</table>';
					
				$__cnx->_clsr($Ls);
					
				return($LsBld);
			}
			
			
		}
		
	}

	function __bl_Ls2($p){
		
		global $__cnx;
			
		if(is_array($p)){	
			if($p['bd']!=NULL && $p['i']!=NULL){	
				$Ls_Qry = "SELECT * from ".$p['bd']." where protp_tp = ".$p['tp']." AND id_protp = pro_tp ORDER BY ".$p['t']." ASC";
				$Ls = $__cnx->_qry($Ls_Qry);
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
					$LsBld .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr><th>Id</th><th>'.TX_NM.'</th></tr>';
					do {
						$LsBld .= '<tr><td>'.$row_Ls[$p['i']].'</td><td>'.ctjTx($row_Ls[$p['t']],'in').'</td></tr>';
					} while ($row_Ls = $Ls->fetch_assoc());
					$LsBld .= '</table>';
					
				$__cnx->_clsr($Ls);
				
				return($LsBld);
			}
			
		}

	}

	$__f_docs = 'docs/';
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CRM Api</title>
        <base href="<?php echo DMN_API ?>" target="_self">
        <script src="<?php echo DMN_JS ?>jquery.js" type="text/javascript"></script>
		<script src="<?php echo DMN_JS ?>SpryTabbedPanels.js" type="text/javascript"></script>
        <script src="<?php echo DMN_JS ?>SpryUtils.js" type="text/javascript"></script>
        <link href="css/all.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container" >
            <header>
            </header>
                <section class="__cnt">
                    <div id="TabbedPanels1" class="VTabbedPanels">
                        <ul class="TabbedPanelsTabGroup">
                            <li class="TabbedPanelsTab" tabindex="0" id="medios"><?php echo Spn('','','_tt_icn _tt_icn_md').MDL_SIS_MD ?></li>
                            <li class="TabbedPanelsTab" tabindex="1" id="estados"><?php echo Spn('','','_tt_icn _tt_icn_bsc').TX_CNT ?></li>
                            <li class="TabbedPanelsTab" tabindex="6" id="modulos"><?php echo Spn('','','_tt_icn _tt_icn_bnch').TX_PRGS ?></li>
							<li class="TabbedPanelsTab" tabindex="7" id="universidades"><?php echo Spn('','','_tt_icn _tt_icn_scec').MDL_UNI ?></li>
                            <li class="TabbedPanelsTab" tabindex="10" id="listaexcel"><?php echo Spn('','','_tt_icn _tt_icn_frmt').TX_LSTEXCL ?></li>
                            <li class="TabbedPanelsTab" tabindex="11" id="colegios"><?php echo Spn('','','_tt_icn _tt_icn_cod').TX_SCHLS ?></li>
                            <li class="TabbedPanelsTab" tabindex="25" id="idioma"><?php echo Spn('','','_tt_icn _tt_icn_bnch').TX_CHNLNG ?></li>
                            
                            
                        </ul>
                        <div class="TabbedPanelsContentGroup">
                            <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>TB_SIS_MD, 'i'=>'id_sismd', 't'=>'sismd_tt', 'c'=>'sismd_clr']); ?></div>
                            <div class="TabbedPanelsContent"><?php include($__f_docs.'sis_cnt.php'); ?></div>
                            <div class="TabbedPanelsContent"><?php include($__f_docs.'sis_prg.php'); ?></div>
                            
                            
                            <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>MDL_SIM_UNI_BD, 'i'=>'id_uni', 't'=>'uni_tt', 'c'=>'uni_clr']); ?></div>
                            
                            <div class="TabbedPanelsContent"><?php echo __bl_Ls1(['d'=>'prc', 'bd'=>'up_fld', 'i'=>'id_upfld', 't'=>'upfld_tt']); ?></div>
                            
                            <div class="TabbedPanelsContent"><?php include($__f_docs.'sis_clg.php'); ?></div>
                            
                            
                            <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>'lng', 'i'=>'id_lng', 't'=>'lng_nm']); ?></div>
                            
                            
                        </div>
                    </div>
                </section>
            <footer>
            </footer>
        </div>
        <script type="text/javascript">
			
			var __goto_h = window.location.hash;
			var __cnt_tb = $('.TabbedPanelsContentGroup');
			
			if(__goto_h){
				var _goto = $(__goto_h).attr('tabindex');
			}else{
				var _goto = 0;
			}

			$(window).on('load',function(){
				
				SUMR_Main.bxajx.TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
				
				<?php echo $CntWb ?>
				
				
				var tabButtonsArray = TabbedPanels1.getTabs();
				var tabButton = tabButtonsArray[_goto];
				
				SUMR_Main.bxajx.TabbedPanels1.showPanel(tabButton);
				__cnt_tb.fadeIn('fast');
				
			});
			
			
			$('.TabbedPanelsTab').click(function() {  
				var _tb_c = $(this); 
				__cnt_tb.fadeOut('fast', function(){
					var _nw_h = $(_tb_c).attr('id');
					window.location.hash = _nw_h;
				});  
			});
			
			$(window).on('hashchange', function () {
				__cnt_tb.fadeIn('fast');
			});
					
        </script>