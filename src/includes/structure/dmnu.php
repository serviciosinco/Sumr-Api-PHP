<?php if(_ChckMd('call') || _ChckClChat()){ ?>

<div class="bx_cht" id="bx_cht" style="display: none;">

	<ul>
		
		<?php if(_ChckMd('call')){ ?>
		
		<li>
			
			<div class="bx_call _anm tool_flt" id="bx_call" style="display: none;">
				
				<ul class="bx_call_ul">
					<li class="_nm _anm"></li>
				</ul> 
				
				<?php 
					$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20);
					$CntWb .= " 
					
						SUMR_Main.ld.f.call(function(){ 
							if(SUMR_Main.is_f('SUMR_Call.f.tab_set')){
								SUMR_Call.f.tab_set({ id:'".$_id_tbpnl."' }); 
								SUMR_Call.f.dom();
							}
						});
						
					";
					
				?>
				
				<div id="call_ls_load" class="call_ls_load" style="display: none"></div>
				
				<div id="bx_call_inf" class="bx_call_inf _anm">
					<button id="inf_btn_vlvr" class="inf_btn_vlvr _anm" style="text-align: center; display: block;"></button>
					<div id="bx_call_inf_c" class="_c"></div>
				</div>
				
				<div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels mny bx_call_tabs">
				    <ul class="TabbedPanelsTabGroup">
				        <li class="TabbedPanelsTab <?php echo $_cls_tb ?>"><?php echo Spn('','','_tt_icn _tt_icn_call_rcnt') ?></li>
				        <li class="TabbedPanelsTab CllTabDt <?php echo $_cls_tb ?>"><?php echo Spn('','','_tt_icn _tt_icn_call_cnt') ?></li>
				        <li class="TabbedPanelsTab CllTabKey <?php echo $_cls_tb ?>"><?php echo Spn('','','_tt_icn _tt_icn_call_dig') ?></li>	
				    </ul>
				    <div class="TabbedPanelsContentGroup">
				        <div class="TabbedPanelsContent">
				            <div id="bx_call_rcnt" class="bx_rcnt">  
				            </div>   
				        </div>
				        <div class="TabbedPanelsContent">
							<div  class="bx_call_tools">							
								<div class="bx_options">
									<ul>
										<li><button id="_add_fl" class="_add_fl _cls_fl" style="text-align: center; display: block;"></button></li>
										<li></li>
										<li>
											<div class="pag">
												<button class="prev"></button>
												<button class="next"></button>
											</div>
										</li>
									</ul>	
								</div>
								<div class="bx_call_slc">
									<div class="bx_call_fl">
										<div class="_c1">
											<?php echo LsMdlSTp('_sis_tp','id_mdlstp', $row_Dt_Rg['_sis_tp'], TX_SLCTP); ?>
											<?php echo HTML_inp_tx('call_sch', TX_SEARCH , '', '', '', 'bx_sch'); ?>
										</div>
										<div class="_c2">
											<button id="btn_sch" class="btn_sch"></button>
										</div>	
									</div>
								</div>
							</div>
							<div id="bx_call_cnt_dt" class="bx_call_cnt_dt _anm">
								<button id="call_btn_vlvr" class="call_btn_vlvr _anm" style="text-align: center; display: block;"></button>
								<div id="bx_call_cnt_dt_c"></div>
							</div>
							<div class="bx_call_cnt">
								<div id="bx_call_ls" class="bx_ls"></div>
								<div class="bx_call_num" ></div>
							</div> 			 
				        </div>
				        
				        <div class="TabbedPanelsContent">
				                <div class="_key">
					                <div class=""><?php echo HTML_inp_tx('call_dgts', '' , '', '', ' disabled ', 'bx_dgts'); ?></div>
					                <ul>
						                <li rel="1">1</li>
						                <li rel="2">2</li>
						                <li rel="3">3</li>
					                </ul>
					                <ul>
						                <li rel="4">4</li>
						                <li rel="5">5</li>
						                <li rel="6">6</li>
					                </ul>
					                <ul>
						                <li rel="7">7</li>
						                <li rel="8">8</li>
						                <li rel="9">9</li>
					                </ul>
					                <ul>
						                <li rel="*">*</li>
						                <li rel="0">0</li>
						                <li rel="#">#</li>
					                </ul>
				                </div>  	 			 
				        </div>
				    </div>							  
				</div>	
			</div>
		</li>
		<?php } ?>
		
		
		<?php if(_ChckClChat()){ ?>
		
		
		<li class="onl _anm __clp _off" id="__shw_onl">
			<h3 href="<?php echo Void(); ?>" class="_anm _mn _onl" id="onl_no"><?php echo Strn('Usuarios '.Spn('', '')) ?></h3>
			<div class="onl_oth_bx">
				<ul>
					<ul id="cht_usrs_oth"></ul>
				</ul>
			</div>
			<div class="onl_bx __scrll_us _anm">
				<ul id="cht_usrs"></ul>
			</div>
			<?php echo HTML_inp_tx('srch_usr', TX_SEARCH , ''); ?>
		</li>
		<?php } ?>
		
		<li class="_anm">
			<ul class="shrt_usr" id="shrt_usr">
				<li><button class="_anm _mn _lopt" id="bx_lead_opt"></button></li>
				<li><button class="_anm _mn _main" id="bx_cht_mn"></button></li>
			</ul>
		</li>					
	</ul>	
	
</div>

<?php } ?>