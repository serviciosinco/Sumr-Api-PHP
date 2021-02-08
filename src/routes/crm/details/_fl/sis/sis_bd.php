<?php 
if(class_exists('CRM_Cnx')){
	
	//--------------------- Base de Datos ---------------------// 
 
		
		$Ls_Qry = " SELECT *
				    FROM "._BdStr(DBM).TB_SIS_BD." 
					WHERE id_sisbd != ''
					ORDER BY sisbd_nm ASC 
				";
		$Ls = $__cnx->_qry($Ls_Qry); 
		$row_Ls = $Ls->fetch_assoc(); 
		$Tot_Ls = $Ls->num_rows;
	
	//--------------------- Base de Datos ---------------------// 
?>
<div class="Cvr_Bd">
	<div class="_cvr"></div>
    <div class="_ln">
	    
            <?php
	       		
				
				if($Tot_Ls > 0){
		
					do{
			
			       		$___mn_tpu[] = ['tt'=>ctjTx($row_Ls['sisbd_nm'],'in'), 
			       		 				  	 'id'=>$row_Ls['sisbd_enc'], 
			       		 				  	 'icn'=>'up', 
			       		 				  	 'tcnt'=>'inf',
			       		 				  	 'lm'=>'&_f=scrn',
			       		 				  	 'tp'=>'sis_bd',
				   		 				  	 'tb'=>'bd_d_'.$row_Ls['id_sisbd'],
				   		 				  	 'tbs'=>'bd_d_'.$row_Ls['id_sisbd'],
				   		 				  	 'tbs_go'=>'bd_d_'.$row_Ls['id_sisbd'],
				   		 				  	 
				       	];
				       	

                	} while ($row_Ls = $Ls->fetch_assoc()); $Ls->free;
	
				}                                           
                
                
                $___mn[] = ['tt'=>'Bases', 
		       					  'tbs'=>'bd',
		       					  'icn'=>'up',
		       					  'tbs_go'=>'sis_bd',
		       					  'sb'=>$___mn_tpu
		       	];
		       	      
                                                            
	       		$__d1 = __b_tbd( $___mn_tpu, [ 'frst'=>'ok', 'mny'=>'ok'  ] );
	       		
	       		echo $__d1->html;
	       		
	       		$CntJV .= $__d1->js;
			?>
    </div>						
</div>                                                                  
<style>
var(--main-bg-color)
	.Cvr_Bd{ }
	.Cvr_Bd h2{  }
	.Cvr_Bd h2 span{ color: #999; }
	.Cvr_Bd h3{ font-family: "Roboto", Verdana !important; font-size: 10px; font-weight: normal; white-space: normal !important; text-align: right; background-color: #F0EDF2; margin: 0px; padding-top: 15px; padding-right: 10px; padding-bottom: 15px; padding-left: 10px; color: #999; }
	.Cvr_Bd ._cvr{ margin-top: -50px; width: 100%; 
		background: url(<?php echo DIR_IMG_ESTR.'cvr_bd.jpg' ?>) no-repeat center center fixed; 
		background-size: auto 400px !important;
		background-position: center top !important;
		height: 250px;
		max-height: 250px;
		position: relative;
		display: block; 
	}
	
	.Cvr_Bd ._cvr img{ width: 100%; }
	.Cvr_Bd .Tt_Tb{ text-align: left; }
	
	.Cvr_Bd ._ln{ width: 100%; position: relative; display: inline-table; text-align: center; vertical-align: top; white-space: nowrap; }
	.Cvr_Bd ._ln ._c1{ display: inline-table; min-width: 30%; width: 30%; padding: 1%; vertical-align: top; margin-top: 1%; margin-right: 1%; margin-bottom: 1%; margin-left: 0%; }
	.Cvr_Bd ._ln ._c2{ display: inline-table; min-width: 30%; width: 30%; padding: 1%; margin: 1%; vertical-align: top; }
	.Cvr_Bd ._ln ._c3{ display: inline-table; min-width: 30%; width: 30%; padding: 1%; vertical-align: top; margin-top: 1%; margin-right: 0%; margin-bottom: 1%; margin-left: 1%; }
	
	
	.Cvr_Bd ._ln p{ font-size:11px; }
	.Cvr_Bd ._ln .ls_2{ margin: 0px; padding: 0px; }
	.Cvr_Bd ._ln .ls_2 li{ font-family: "Roboto", Verdana; color: #333; border-bottom-width: 1px; border-bottom-style: dotted; border-bottom-color: #CCC; list-style-type: none; font-size: 10px; text-align: left !important; width: 100% !important; display: block !important; padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; }
	.Cvr_Bd ._ln .ls_2 li strong{ color: #CDCBCF; font-weight: bolder; font-family: 'Economica'; }
	.Cvr_Bd ._ln .ls_2 li span{ color: #999; }
	
	
	
	.Cvr_Bd .VTabbedPanels { overflow: hidden; zoom: 1; width: 100%; }
	.Cvr_Bd .VTabbedPanels .TabbedPanelsTabGroup { float: left; width: 20%; height: 250em !important; position: relative; border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-top-style: none; border-right-style: none; border-bottom-style: none; border-left-style: none; padding: 0px; margin: 0px; }
	
	.Cvr_Bd .VTabbedPanels > ul.TabbedPanelsTabGroup { background-color: #1e1f20 !important; height: 250em !important; }
	
	
	.Cvr_Bd .VTabbedPanels .TabbedPanelsTabGroup ._hd{ display: none; }
	.Cvr_Bd .VTabbedPanels .TabbedPanelsTab { background-image: url(<?php echo _iEtg(DMN_IMG_ESTR.'v_tbd.png') ?>); background-repeat: no-repeat; background-position: 1000px center; position: relative; float: none; list-style: none; cursor: pointer; font-family: Economica; font-size: 1.1em; font-weight: 300; margin-top: 0px; margin-right: 1px; margin-bottom: 0px; margin-left: 0px; padding-top: 7px; padding-right: 20px; padding-bottom: 14px; padding-left: 0px; /*background-color: #FFF;*/ border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #D3D1D5; -webkit-transition: all 0.3s ease 0s; -moz-transition: all 0.3s ease 0s; -ms-transition: all 0.3s ease 0s; -o-transition: all 0.3s ease 0s; transition: all 0.3s ease 0s; color: #ffffff; text-align: left; }
	.Cvr_Bd .VTabbedPanels .TabbedPanelsTabSelected { border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #333; background-position: 150px center; background-color: #282828; }
	
	
	.Cvr_Bd .VTabbedPanels .TabbedPanelsTab h2{ font-size: 13px; display: inline-block; font-weight: 300; }
	.Cvr_Bd .VTabbedPanels .TabbedPanelsTab h2 .ok{ font-size: 16px;  }
	
	
	.Cvr_Bd .VTabbedPanels .TabbedPanelsContentGroup { clear: none; float: left; padding: 0px; width: 80%; height: 250em; }
	.Cvr_Bd .VTabbedPanels .TabbedPanelsContent{ width: 99%; padding-left: 1%; padding-right: 0% !important; }
	.Cvr_Bd .VTabbedPanels .TabbedPanelsContent .ln_1 h2,
	.Cvr_Bd .VTabbedPanels .TabbedPanelsContent > h2{ font-family: Economica; color: #CCC; font-weight: 300; margin-bottom: 15px; border-bottom-width: 1px; border-bottom-style: dotted; border-bottom-color: #CCC; padding-bottom: 15px; }
	.Cvr_Bd .VTabbedPanels .TabbedPanelsTab ._tt_icn{ margin-left: 10px; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>bd.svg) !important; background-position:center center; background-size:80% auto; }
	
	
	
	
	
	.Cvr_Bd .VTabbedPanels.mny > div.TabbedPanelsContentGroup ul.TabbedPanelsTabGroup{ width: 25% !important; }
	.Cvr_Bd .VTabbedPanels.mny > div.TabbedPanelsContentGroup .VTabbedPanels > div.TabbedPanelsContentGroup{ width: 75% !important; } 
	
	.Cvr_Bd .VTabbedPanels.mny ._sbls{ padding-top: 0; }
	.Cvr_Bd .VTabbedPanels.mny .VTabbedPanels .TabbedPanelsTabSelected{ background-color: #282828; border-left: 10px solid #97eedb !important; background-image: none; } 
	.Cvr_Bd .VTabbedPanels.mny .VTabbedPanels .TabbedPanelsTab ._tx{ text-transform: uppercase; font-size: 13px; color: #fff; }
	.Cvr_Bd .VTabbedPanels.mny .VTabbedPanels .TabbedPanelsTabGroup{ background-color: #282828 !important; }
	.Cvr_Bd .VTabbedPanels.mny .VTabbedPanels .TabbedPanelsTabSelected ._tx{ color:#64d9be; }
	
	
	
	.Cvr_Bd .VTabbedPanels.mny .VTabbedPanels .VTabbedPanels .TabbedPanelsTabSelected{ background-color: #484848; border-left: 10px solid #282828 !important; }
	.Cvr_Bd .VTabbedPanels.mny .VTabbedPanels .VTabbedPanels .TabbedPanelsTab ._tx{ color: #818181; }
	.Cvr_Bd .VTabbedPanels.mny .VTabbedPanels .VTabbedPanels .TabbedPanelsTabGroup{ background-color: #484848; }
	.Cvr_Bd .VTabbedPanels.mny .VTabbedPanels .VTabbedPanels .TabbedPanelsTabSelected ._tx{ color: #64d9be; }
	
	
	
	
	.Cvr_Bd .TabbedPanelsContent .VTabbedPanels { margin-left: -1000px; }
	.Cvr_Bd .TabbedPanelsContent.TabbedPanelsContentVisible .VTabbedPanels{ margin-left: 0px; }
	

	
</style>

<?php $CntWb .= JV_Blq().JV_HtmlEd($__jqte); ?>
<?php $Ls->free;  } ?>