<?php 
	if($___Ls->gt->pnl->e == 'ok'){
		echo h2( Spn('','','_tt_icn _tt_icn_fnl'). 'Status', '__funnel');
	} 
?>
<div class="fnl" id="my-funnel" style="min-height: 200px; width: 100%; display: block;"></div>
			                
<?php 
    
    $__cntest = GtCntEstTpLs([ 'mdl'=>$___Ls->dt->rw['mdlcnt_mdl'], 'mdlstp'=>$___Ls->dt->rw['id_mdlstp'] ]);
    
    foreach($__cntest->ls as $__cntest_k=>$__cntest_v){
        if($___Ls->dt->rw['siscntest_tp'] != $__cntest_v->id){ $__cls = 'fnl-off'; }else{ $__cls = 'fnl-on'; }
        $__grph_est[] = "{ name:'".$__cntest_v->nm."', y:1, color:'".$__cntest_v->clr."', className:'".$__cls."' }";
    }
    
    $CntWb .= "							
		
		
		setTimeout(function(){ 
			
			Highcharts.chart('my-funnel', {
			    chart: { type: 'funnel' },
			    title:{ text: null },
			    plotOptions: {
				    funnel: {
			            borderWidth: 4
			        },
			        series: {
			            dataLabels: {
			                enabled: true,
			                format: '<b>{point.name}</b>',
			                color: 'black',
			                shadow: false,
			                distance: -30,
			                softConnector: true,
			                style:{
				                color: 'black',
				                fontSize: '11px',
				                fontWeight: 'lighter',
				                textOutline: null
			                }
			            },
			            center: ['40%', '50%'],
			            neckWidth: '30%',
			            neckHeight: '25%',
			            width: '80%'
			        }
			    },
			    tooltip: {
				    formatter: function() {
				        return this.point.name;
				    }
				},
			    legend: {
			        enabled: false
			    },
			    credits: { enabled: false },
			    series: [{
			        data: [".(!isN($__grph_est)?implode(",", $__grph_est):'')."]
			    }]
			});
		
		}, 500);
    
    "; 
    
?>	