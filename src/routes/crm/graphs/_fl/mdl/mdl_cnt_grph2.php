<?php 
if(class_exists('CRM_Cnx')){
		
	$__id_prfx = '_'.Gn_Rnd(10);
	
	
	$Ls_Cnt_Qry = "	SELECT siscntest_tt, siscntest_clr_bck, 
						  COUNT(*) AS __tot_mdl 
					FROM ".TB_MDL_CNT."
						 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
						 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
						 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
						 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST."
						 INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
					WHERE mdlstp_tp = '".$__t2."'
	
					GROUP BY mdlcnt_est 
					ORDER BY id_mdlcnt DESC, mdlcnt_fa DESC";
					
					
	$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
	
	if($Ls_Cnt_Rg){
		
		$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
		$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
		
		if($Tot_Ls_Cnt_Rg > 0){
			do {
				if($row_Ls_Cnt_Rg['__tot_mdl'] < 1){ $_prnt = 0; }else{ $_prnt = $row_Ls_Cnt_Rg['__tot_mdl']; }
				$_medio[] = "{ color:'".$row_Ls_Cnt_Rg['siscntest_clr_bck']."', name:'".ctjTx(str_replace("'", "",$row_Ls_Cnt_Rg['siscntest_tt']),'in')."',   data:[". number_format($_prnt, 2, '.', '') ."] } "; 
				$_tabla .= '<tr><td>'.ctjTx($row_Ls_Cnt_Rg['siscntest_tt'],'in').'</td><td>'. number_format($_prnt, 2, '.', '') .'</td></tr>';  
				                    
			} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc()); 
		}
	}
	
	$_grf_tag = implode(",", $_medio);
	
?>

<?php if($__f == 'prnt'){ echo h2(TX_LDS_EST); } ?> 
<div id="Grph_bx_dt_3_1<?php echo $__id_prfx ?>" class="_grp" style="width:100% !important;height:<?php echo $__h ?>; overflow:hidden; position: relative; "></div>
 
<?php if($__f == 'prnt'){ ?>  
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="Ls_Rg">
        <tr>
            <th><?php echo MDL_SIS_MD; ?></th>
            <th><?php echo TX_LEADS; ?></th>
        </tr>
        <?php echo $_tabla ?>     
    </table>
<?php } ?>

<script type="text/javascript">
			
			$(function () {
				
					$('#Grph_bx_dt_3_1<?php echo $__id_prfx ?>').highcharts({
            					chart: {type: 'column', margin: 0, marginLeft: 0, spacingLeft: 0, spacingRight: 0},
								title: {text: '<?php echo LDS_EST ?>', align: 'right', style: {color: '#000',fontSize: '12px',fontWeight: 'normal'} },
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

<?php } ?>
<?php  ?>