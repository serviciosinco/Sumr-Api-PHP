<div class="container">
  <header>
  		<h1><?php echo '#'.$_hshtg; ?></h1>
  		<div class="pwrd"></div>
  </header> 
  
  <div class="col1">          		
        <div id="FlC_1" class="CollapsiblePanel">
            <div class="CollapsiblePanelTab" tabindex="0">Recibidos</div>
            <div class="CollapsiblePanelContent">
                        <div class="Bx_Msg_All">
                        <div id="Bx_Msg_Tt"> 
                              <h1>
                                    <div class="btn">
                                        <input name="Tw_Lst" type="hidden" id="Tw_Lst" />
                                        <input name="Tw_Frs" type="hidden" id="Tw_Frs" />  
                                        
                                        <input name="Igr_Lst" type="hidden" id="Igr_Lst" />
                                        <input name="Igr_Frs" type="hidden" id="Igr_Frs" />  
                                        
                                        <input type="button" name="BtnPsNw" id="BtnPsNw" value="">
                                        <input type="button" name="BtnPlyNw" id="BtnPlyNw" value="">
                                        <input type="button" name="BtnNw" id="BtnNw" value="">
                                    </div>
                                    <div class="ldr"></div>
                                    <div class="txx">Mensajes <span>Recibidos</span><br> <strong class="viv">[en vivo]</strong></div>
                              </h1>
                        </div>
                        <div id="TabbedPanels1" class="TabbedPanels">
                                <ul class="TabbedPanelsTabGroup">
                                              <li class="TabbedPanelsTab _tw" tabindex="0"><?php echo Spn('','','_btn _btn_tw') ?></li>
                                             <?php /* <li class="TabbedPanelsTab _igr" tabindex="0"><?php echo Spn('','','_btn _btn_igr') ?></li>*/ ?>
                                </ul>
                                <div class="TabbedPanelsContentGroup">
                                              <div class="TabbedPanelsContent">
                                                              <div class="Bx_Msg" id="Bx_Msg_Tw"> 
                                                                        <div id="Msg_Tw"></div> 
                                                                        <div class="btn_btm">
                                                                            <div class="ldr"></div>
                                                                            <input type="button" name="Tw_BtnPsOl" id="Tw_BtnPsOl" value="Anteriores" />
                                                                        </div>      
                                                              </div>         
                                              </div>            
                                              <div class="TabbedPanelsContent">
                                              				  <div class="Bx_Msg" id="Bx_Msg_Igr"> 
                                                                        <div id="Msg_Igr"></div> 
                                                                        <div class="btn_btm">
                                                                            <div class="ldr"></div>
                                                                            <input type="button" name="Igr_BtnPsOl" id="Igr_BtnPsOl" value="Anteriores" />
                                                                        </div>      
                                                              </div>
                                              </div>
                                </div>
                        </div>
                    </div>
                 </div>
            </div> 
            <?php $CntWb .= "var FlC_1 = new Spry.Widget.CollapsiblePanel('FlC_1', {contentIsOpen:true });"; ?>         
    </div>  
    
         
    <div class="col2">
    			
            <div id="FlC_2" class="CollapsiblePanel">
                <div class="CollapsiblePanelTab">Próximos</div>
                <div class="CollapsiblePanelContent"> 
                        <div id="Bx_Msg_Nxt_Tt">
                                <h1>
                                        <div class="btn">
                                            <form action="inc/prc/hsh_online.php" method="post" id="Action_Stop" name="Action_Stop">	
                                                <input name="MM_update" type="hidden" id="MM_update" value="EdHshEst_Off">
                                                <input name="id_hsh" type="hidden" id="id_hsh" value="<?php echo $_hshtg_svid ?>">
                                                <input type="submit" name="BtnPsNx" id="BtnPsNx" value="">
                                            </form>
                                            <script type="text/javascript">
                                                $(document).ready(function(){
                                                        $('#Action_Stop').validate();
                                                        $('#Action_Stop').ajaxForm({
                                                                dataType:'json', 
                                                                beforeSubmit: function(){ TwStrm_Ld_Stp(); },
                                                                success: function(data){ TwStrm_Stp('', data); }
                                                        });
                                                });	
                                            </script>
                                            
                                            
                                            <form action="inc/prc/hsh_online.php" method="post" id="Action_Play" name="Action_Play">
                                                <input name="MM_update" type="hidden" id="MM_update" value="EdHshEst_On">
                                                <input name="id_hsh" type="hidden" id="id_hsh" value="<?php echo $_hshtg_svid ?>">
                                                <input type="submit" name="BtnNx" id="BtnNx" value="">
                                            </form>
                                              <script type="text/javascript">
                                                    $(document).ready(function(){
                                                            $('#Action_Play').validate();
                                                            $('#Action_Play').ajaxForm({
                                                                    dataType:'json', 
                                                                    beforeSubmit: function(){ TwStrm_Ld_Ply('on'); },
                                                                    success: function(data){ TwStrm_Ply('', data); }
                                                            });
                                                    });	
                                                </script>                                                                          
                                  </div>
                                  <div class="ldr"></div>Próximos <span>Mensajes ()</span><br> <strong class="pse">[pausado]</strong>
                              </h1>
                      </div>
                      <div id="Bx_Msg_Nxt">
                            <div id="Msg_Nxt"></div>      
                      </div>
                  </div>
              </div>
              <?php $CntWb .= "var FlC_2 = new Spry.Widget.CollapsiblePanel('FlC_2', {contentIsOpen:false });"; ?>  
              
              
              <div id="FlC_3" class="CollapsiblePanel">
                <div class="CollapsiblePanelTab">Preguntas</div>
                <div class="CollapsiblePanelContent"> 
                      <div id="Bx_Msg_Qus_Tt">
                                <h1>
                                  <div class="btn">      
                                    <input type="button" name="BtnPsQus" id="BtnPsQus" value="">
                                    <input type="button" name="BtnPlyQus" id="BtnPlyQus" value="">
                                  </div>
                                  <div class="ldr"></div>
                                  Preguntas<span> Seleccionadas</span><br> <strong class="viv">[en vivo]</strong>
                              </h1>
                      </div>
                      <div id="Bx_Msg_Qus">
                            <div id="Msg_Qus"></div>      
                      </div>
                 </div>     
              </div>  
              <?php $CntWb .= "var FlC_3 = new Spry.Widget.CollapsiblePanel('FlC_3', {contentIsOpen:false });"; ?>  
              
                    
        </div>
    </div>  
</div>
<script type="text/javascript">
	$(document).ready(function(){
		
		 GtNw('<?php echo $_hshtg ?>','tw');
		 upd__nwtw = window.setInterval(function() { GtNw('<?php echo $_hshtg ?>', 'tw'); }, 10000); 
		 
		 GtNw('<?php echo $_hshtg ?>','igr');
		 upd__nwigr = window.setInterval(function() { GtNw('<?php echo $_hshtg ?>', 'igr'); }, 10000); 
		 
		 __GtTw_Nxt('<?php echo $_hshtg ?>');		 
		 upd__nxt = window.setInterval(function(){ __GtTw_Nxt('<?php echo $_hshtg ?>'); }, 6000);
		 
		 __GtTw_Qus('<?php echo $_hshtg ?>');
		 upd__qus = window.setInterval(function() { __GtTw_Qus('<?php echo $_hshtg ?>'); }, 30000);
		 
		 $("#BtnPsNw").off("click").click(function() {
			
			console.info('Pausa Carga Automatica'+upd__nwtw+upd__nwigr);
			 
			window.clearInterval(upd__nwtw);
			window.clearInterval(upd__nwigr);
			
			NwBx_Est('ps');
			$(this).hide('fast', function(){
				$("#BtnPlyNw").show('fast');
				$("#BtnNw").show('fast');
			});
         });
		 
		 $("#BtnPlyNw").off("click").click(function() {
			GtNw('<?php echo $_hshtg ?>', 'tw');
			upd__nwtw = window.setInterval(function() { GtNw('<?php echo $_hshtg ?>', 'tw'); }, 10000); 
			upd__nwigr = window.setInterval(function() { GtNw('<?php echo $_hshtg ?>', 'igr'); }, 10000); 
			
			NwBx_Est();
			$(this).hide('fast', function(){
				$("#BtnNw").hide('fast', function(){
					$("#BtnPsNw").show('fast');
				});
			});
         });
		 
		 $("#BtnNw").off("click").click(function() {
			GtNw('<?php echo $_hshtg ?>', 'tw', 'min');
			NwBx_Est('mn');
         });
		 
		 $("#BtnPsNx").off("click").click(function() {
			NwBx_Est('ps', 2);
			$(this).hide('fast', function(){
				$("#BtnNx").show('fast');
			});	
         });
		 
		 $("#Tw_BtnPsOl").off("click").click(function() {
			 	clearInterval(upd__nwtw);
				NwBx_Est('mn');
					$("#BtnPsNw").hide('fast');
					$("#BtnPlyNw").show('fast');
					$("#BtnNw").show('fast');
				GtNw('<?php echo $_hshtg ?>', 'tw', 'max');
         });
		 
		 $("#Igr_BtnPsOl").off("click").click(function() {
			 	clearInterval(upd__nwigr);
				NwBx_Est('mn');
					$("#BtnPsNw").hide('fast');
					$("#BtnPlyNw").show('fast');
					$("#BtnNw").show('fast');
				GtNw('<?php echo $_hshtg ?>', 'igr', 'max');
         });	 		 
		 
		 $("#BtnPsQus").off("click").click(function() {
			clearInterval(upd__qus);
			NwBx_Est('ps',3);
			$(this).hide('fast', function(){
				$("#BtnPlyQus").show('fast');
			});
         });
		 
		 $("#BtnPlyQus").off("click").click(function() {
			upd__qus = window.setInterval(function() { __GtTw_Qus('<?php echo $_hshtg ?>'); }, 10000); 
			NwBx_Est('',3);
			$(this).hide('fast', function(){
				$("#BtnPsQus").show('fast');
			});
         });
		 
		 <?php echo $CntWb; ?>
	});	
	
	var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
</script>