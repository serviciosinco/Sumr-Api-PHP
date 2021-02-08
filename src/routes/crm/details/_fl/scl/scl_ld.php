<?php 
	
if(class_exists('CRM_Cnx')){

	$_enc = $___Dt->gt->i;
	        
?>

<div class="Dsh_Tra<?php //if(!ChckSESS_superadm()){ echo ' nusr'; } ?>" id="Dsh_Tra" us-ses-id="<?php echo SISUS_ENC; ?>">
	
	
	<?php				
		$__idtp_cmpg = '_cmpg';	
        $__idtp_tmpl = '_tmpl';	   
					
		$___Dt->_dvlsfl_all([
			['n'=>'dsh', 'l'=>TX_DSH ],
			['n'=>'lists', 't'=>'mdl_cnt', 't2'=>$___Dt->gt->tsb, 'wrp'=>'ok', 'l'=>'Listado' ]
		],[
			'idb'=>'ok'
		]);
	?>

	<div id="<?php echo $___Dt->tab->id ?>" class="VTabbedPanels mny ignr DhsTraTab">
		<ul class="TabbedPanelsTabGroup">	
			<?php echo $___Dt->tab->dsh->l; ?>
			<?php echo $___Dt->tab->lists->l; ?>
		</ul>
		<div class="TabbedPanelsContentGroup">
			
				<div class="TabbedPanelsContent">
					<?php echo 'graficas'; //include('tra_dsh.php'); ?>
				</div>
			
			
				<div class="TabbedPanelsContent" style="background-color:#fff; min-height:7000px;">
					<?php echo 'listado'; ?>
				</div>
			
		</div>
	</div>    
</div>
<style>
	.Dsh_Tra .VTabbedPanels .TabbedPanelsTab._dsh{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>tra_dsh.svg); }
	.Dsh_Tra .VTabbedPanels .TabbedPanelsTab._lists{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>tra_list.svg); }
</style>
<?php include('tra_js.php'); ?>
<?php } ?>