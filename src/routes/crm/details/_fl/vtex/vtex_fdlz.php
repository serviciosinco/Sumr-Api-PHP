<div class="vtex">

    <div class="details"> 
        <div class="row_1">
            <div id="VtexFdlzSles" class="grph"></div>
            <div class="vlogo"></div>
        </div>
        <div class="row_2">

            <div class="col col1">

                <div class="wdg ordr">

                    <?php echo $___Dt->_fl->f1;
						
						$__tab = [
									['n'=>'sndd', 't'=>'snd_ec_snd', 'l'=>TX_SNTCMP],
									['n'=>'lst',  't'=>'snd_ec_lsts_rel', 'l'=>'Listas']
								];
						
						$___Dt->_dvlsfl_all($__tab,[ 'idb'=>'ok' ]);
							
					?>	
					<div id="<?php echo $___Dt->tab->id ?>" class="TabbedPanels">
			            <ul class="TabbedPanelsTabGroup">
				            <li class="TabbedPanelsTab ord">Ordenes</li>
				            <li class="TabbedPanelsTab coup">Cupones</li>
			            </ul>
				        <div class="TabbedPanelsContentGroup _anm">
					        <div class="TabbedPanelsContent _anm">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg" id="VtexFdlzOrdr">
                                    <!--<tr>
                                        <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
                                        <th width="33%" <?php echo NWRP ?>><?php echo TT_FM_NM ?></th>
                                        <th width="1%" <?php echo NWRP ?>><?php echo ''; ?></th>
                                    </tr>-->
                                </table>
                            </div>   
							<div class="TabbedPanelsContent _anm">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg" id="VtexFdlzCoup">
                                    <!--<tr>
                                        <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
                                        <th width="33%" <?php echo NWRP ?>><?php echo TT_FM_NM ?></th>
                                        <th width="1%" <?php echo NWRP ?>><?php echo ''; ?></th>
                                    </tr>-->
                                </table>
							</div>
			            </div>
                    </div>
                </div>

                <div class="wdg ordr">
                    
                    <?php echo h2('Ordenes '.Spn('/','','dv').Spn(' Pendiente Pago','','pay'), 'nopay'); ?>

                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg" id="VtexFdlzNoPay">
                        <!--<tr>
                            <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
                            <th width="33%" <?php echo NWRP ?>><?php echo TT_FM_NM ?></th>
                            <th width="1%" <?php echo NWRP ?>><?php echo ''; ?></th>
                        </tr>-->
                    </table>

                </div>
            </div>

            <div class="col col2">

                <div class="wdg ordr">
                    <?php echo h2('Porcentaje de Clientes '.Spn(' en ','','dv').Spn(' programa de fidelización','','pay'), 'cin'); ?>
                    <span>Clientes Vinculados a Campaña / Total Clientes</span>
                </div>

                <div class="wdg ordr">
                    <?php echo h2('CPS'.Spn(' / ','','dv').Spn(' (Customer Profiability Score)','','pay'), 'cps'); ?>
                    <span>Suma (Ingresos – Gastos) / Suma (Gastos)</span>
                </div> 

                <div class="wdg ordr">
                    <?php echo h2('LTV'.Spn(' / ','','dv').Spn(' (Life Time Value)','','pay'), 'ltv'); ?>
                    <span>Valor venta media X repeticiones al mes o al año X vida media del cliente</span>
                </div> 

            </div>

            <div class="col col3">

                <div class="wdg cmpg">
                    <div class="list"> 
                        <div class="items">
                            <button class="_anm new btn" data='ing'></button>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg LsRgNw" id="VtexFdlzCmpg">
                            </table>
                        </div>
                    </div>
                </div>

                <div class="wdg ordr">
                    <?php echo h2('Clientes'.Spn(' / ','','dv').Spn(' Redimidos','','pay'), 'crdm'); ?>
                </div> 

                <div class="wdg ordr">
                    <?php echo h2('Clientes'.Spn(' / ','','dv').Spn(' Fidelizados','','pay'), 'cfdlz'); ?>
                </div> 

                <div class="wdg ordr">
                    <?php echo h2('CCR'.Spn(' / ','','dv').Spn(' (Customer Churn Rate)','','pay'), 'ccr'); ?>
                    <span>
                        Este indicador muestra aquellos clientes que han dejado de tener una actividad habitual en nuestra web. De manera que puedas conocer el abandono de los clientes y los motivos. <br>Para sacar este resultado deberás determinar un periodo de tiempo específico y dividir aquellos clientes que no hayan hecho una operación o se hayan dado de baja entre el resto.
                    </span>
                </div>

            </div>
        </div> 
    </div>
</div>

<?php 

    $CntWb .= "      
        SUMR_Ld.f.js({ 
            t:'c',
            u:'js_vtex.js',
            c:function(){
                SUMR_Main.vtex.rnd = '".$___Dt->id_rnd."';
                SUMR_Main.vtex.bld();
            }
        });
    ";
    
?>

<style>

.vtex{ display:block; width: 100%; padding-bottom:50px; position:relative; }
.vtex .details{ width: 100%; min-height: 500px; }
.vtex .details .vlogo{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>vtex_h.svg); width:100%; height:50px; background-position:top right; background-repeat:no-repeat; background-size:auto 50%; margin-bottom:20px; filter: grayscale(100%); opacity:0.7; position:absolute; right:10px; top:10px; }


.vtex .details .row_1{ width: 100%; margin: 10px 0; position:relative; }
.vtex .details .row_1 .grph{ position:relative; display:block; min-height:200px; max-height:200px; overflow:hidden; }

.vtex .details .row_2{ width: 100%; display:flex; position:relative; }
.vtex .details .row_2 .col{ min-height: 250px; }
.vtex .details .row_2 .col.col1,
.vtex .details .row_2 .col.col3{ width:37.5%; }
.vtex .details .row_2 .col.col2{ width:25%; margin-left:10px; margin-right:10px; }
.vtex .details .row_2 .col .wdg{ overflow:hidden; padding:5px; min-height:150px; border-radius: 20px; background-color: #f1f1f1; width:100%; margin-bottom:10px; display:block; }
.vtex .details .row_2 .col .wdg h2{ color: var(--second-bg-color); font-family: 'Economica'; font-size: 16px; font-weight:500; padding-left:10px; }
.vtex .details .row_2 .col .wdg h2::before{ display:inline-block; width:20px; height:20px; margin-right:5px; margin-bottom:-4px; background-position:center center; background-size: auto 100%; background-repeat:no-repeat; }
.vtex .details .row_2 .col .wdg h2 span.dv{ color:#000; }
.vtex .details .row_2 .col .wdg h2 span.pay{ color:#a5a5a5; font-weight:700; }


.vtex .details .row_2 .col .wdg h2.nopay::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>dsh_vtex_nopay.svg); }
.vtex .details .row_2 .col .wdg h2.cin::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>dsh_vtex_cin.svg); }
.vtex .details .row_2 .col .wdg h2.cps::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>dsh_vtex_cps.svg); }
.vtex .details .row_2 .col .wdg h2.ltv::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>dsh_vtex_ltv.svg); }
.vtex .details .row_2 .col .wdg h2.crdm::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>dsh_vtex_crdm.svg); }
.vtex .details .row_2 .col .wdg h2.cfdlz::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>dsh_vtex_cfdlz.svg); }
.vtex .details .row_2 .col .wdg h2.ccr::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>dsh_vtex_ccr.svg); }


.vtex .details .row_2 .TabbedPanels{ overflow: hidden; padding: 0px; clear: none; width: 100%; }
.vtex .details .row_2 .TabbedPanelsTabGroup{ margin: 0px; padding: 0px; border-bottom: 1px solid #c7c7c7; display:flex; width:100%; position:relative; }
.vtex .details .row_2 .TabbedPanelsTabGroup .TabbedPanelsTab{ position: relative; list-style: none; -moz-user-select: none; -khtml-user-select: none; cursor: pointer; font-family: 'Economica'; font-size: 16px; font-weight:400; margin-top: 0px; margin-right: 1px; margin-bottom: 0px; margin-left: 0px; padding: 5px 15px; }
.vtex .details .row_2 .TabbedPanelsTabGroup .TabbedPanelsTab::before{ width:20px; height:20px; display:inline-block; margin-right:5px; margin-bottom:-4px; background-position:center center; background-size: auto 100%; background-repeat:no-repeat; }
.vtex .details .row_2 .TabbedPanelsTabGroup .TabbedPanelsTab.ord::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>dsh_vtex_ord.svg); }
.vtex .details .row_2 .TabbedPanelsTabGroup .TabbedPanelsTab.coup::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>dsh_vtex_coup.svg); }

.vtex .details .row_2 .TabbedPanelsTabHover { }
.vtex .details .row_2 .TabbedPanelsTabSelected { border-bottom-width: 4px; border-bottom-style: solid; color: var(--second-bg-color); border-bottom-color: var(--second-bg-color); }
.vtex .details .row_2 .TabbedPanelsTab a { color: black; text-decoration: none; }
.vtex .details .row_2 .TabbedPanelsContentGroup { clear: both; }
.vtex .details .row_2 .TabbedPanelsContent{ overflow: visible; padding:15px; }
.vtex .details .row_2 .TabbedPanelsContentVisible{ }


.vtex .details .list{ width: 100%; margin-top:15px; }
.vtex .details .list .items{ position:relative; border-radius: 20px;background-color: #f1f1f1; width:100%; }
.vtex .details table .status{ width:100%; display:block; }
.vtex .details table .date{ width:100%; display:block; }


.vtex .details table .btn,
.vtex .details .list .items .btn{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>atmt_act.svg); width: 30px;height: 30px;background-position: center;background-repeat: no-repeat;background-size: 60% auto;border: 1px solid #c5c5c5;border-radius: 15px;opacity: 0.4; }

.vtex .details table .btn:hover,
.vtex .details .list .items .btn:hover{ background-color: #dadada;background-size: 65% auto;opacity: 1; }

.vtex .details .list .items .btn.new{ background-image: url(<?php echo DMN_IMG_ESTR ?>vtex/add_vtex.svg) !important;background-size: 100% auto !important;position: absolute;right: 0;opacity: 1 !important;top: -15px;}


.vtex .details .Ls_Rg tr:nth-child(odd){ background-color:transparent; }

</style>