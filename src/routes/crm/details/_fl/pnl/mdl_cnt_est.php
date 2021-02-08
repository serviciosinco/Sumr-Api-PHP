<?php 
if(class_exists('CRM_Cnx')){
		
	$__id_prfx = '_'.Gn_Rnd(10);
	$__id = $__prfx->prfx2.'_'.$___Dt->mdlstp->tp;
	$_vl = Php_Ls_Cln($_GET['___i']); if($_vl != ''){ $__f_id = ' AND '.$__id.' = '.$_vl; }
	
	$Ls_Cnt_Qry = "SELECT siscntest_tt, COUNT(*)AS __tot_rst1 FROM ".TB_MDL_CNT.", "._BdStr(DBM).TB_MDL_S_TP.", ".TB_MDL.", ".TB_SIS_CNT_EST."
		WHERE mdlcnt_mdl = id_mdl AND mdlcnt_est = id_siscntest AND mdl_mdls = id_mdlstp AND id_mdlcnt != ''
		GROUP BY mdlcnt_est";
	$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry); /*ECHO $Ls_Cnt_Qry.' er -> '.$__cnx->c_r->error;π*/ $row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); $Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
	do {
		if($row_Ls_Cnt_Rg['__tot_rst1'] < 1){ $_prnt = 0; }else{ $_prnt = $row_Ls_Cnt_Rg['__tot_rst1']; }
		$_medio[] = "{ name:'".ctjTx(str_replace("'", "",$row_Ls_Cnt_Rg['siscntest_tt']),'in')."',   data:[". number_format($_prnt, 2, '.', '') ."] } "; 
		$_tabla .= '<tr><td>'.ctjTx($row_Ls_Cnt_Rg['siscntest_tt'],'in').'</td><td>'. number_format($_prnt, 2, '.', '') .'</td></tr>';  
		                    
	} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc()); 
	$_grf_tag = implode(",", $_medio);
	if($__f == 'prnt'){ echo h2(TX_LDS_EST); } 
?> 
	<div id="Grph_bx_dt_3_1<?php echo $__id_prfx ?>" class="_grp" style="width:100% !important;height:250px; "></div>
	 <?php if($__f == 'prnt'){ ?>  
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="Ls_Rg">
	        <tr>
	            <th><?php echo MDL_SIS_MD ?></th>
	            <th><?php echo TX_LEADS ?></th>
	        </tr>
	        <?php echo $_tabla ?>     
	    </table>
	<?php } ?>
	<script type="text/javascript">
				
				$(function () {
					
						$('#Grph_bx_dt_3_1<?php echo $__id_prfx ?>').highcharts({
	            					chart: {type: 'column', margin: 0, marginLeft: 0, spacingLeft: 0, spacingRight: 0},
									title: {text: '<?php echo TX_LDS_EST ?>' , align: 'right', style: {color: '#000',fontSize: '12px',fontWeight: 'normal'} },
									subtitle: {text: '<?php echo $__grf_sbtt ?>', align: 'right', style: {color: '#CCC',fontSize: '11px',fontWeight: 'normal'}},
									xAxis: {
										categories: [<?php echo $_grf_tag ?>],
										labels: {enabled:false}
									},
									yAxis: {
										min: 0,
										title: {text: ''}, 
										labels: {enabled:false}
									},
									tooltip: {
										useHtml:true,	
										style: {padding: 10,textAlign: 'center'},
										formatter: function() {
											return '<b>'+ this.series.name +'</b><br><span style="font-size: 11px; color: blue; ">Leads </span>: '+ this.y; }
									},
									legend: { 
										enabled: false,
										width:'10px'
									},
									plotOptions: {
										column: {
											pointPadding: 0.2,
											borderWidth: 0
										}, 
										series: {<?php if($__f == 'prnt'){ echo HGHC_LBLDT; } ?>}
									},
									credits: {enabled: false},
									series: [<?php echo $_grf_tag; ?>]
								}).show("slide", { direction: "up" }, 1000);
								
				});
	</script>		   
<?php } 
 ?>