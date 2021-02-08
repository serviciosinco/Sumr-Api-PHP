<div class="Dsh_News _non" id="Dsh_News">
	<!--<h1>No hay novedades por el momento</h1>-->
	<div id="container_news"></div>
</div>
<?php
	
	$__tmp_p = '_sm_us_2cc9e0a92964f3462173a3ac5447f1e1ccce9dfb.jpg';
	$__tmp_c = '_sm_us_f796eb5e6a029bc3b52431e8e5cab5036ec1f1ec.jpg';
	$__tmp_l = '_sm_us_111edd69b753fabf90257abdec3121fecb8bbeab.jpg';
	$__tmp_j = '_sm_us_11a3b6e5be933c17fa5643bfb42ff415effbead7.jpg';
	
	
	$CntWb .= " 
	
		SUMR_Main.ld.f.gantt(function(){ 
			
			setTimeout(function(){	
			
				var today = new Date(),
				    dateFormat = Highcharts.dateFormat,
				    defined = Highcharts.defined,
				    isObject = Highcharts.isObject,
				    reduce = Highcharts.reduce;
				    
				Highcharts.ganttChart('container_news', {
				    
					chart: { backgroundColor: null },
					/*colors: ['#b6babd', '#b6babd', '#b6babd'],*/
				    title: { text: '' },
				    
				    credits: { enabled: false },
				    
				    xAxis: [{
					    minPadding: 0.05,
						maxPadding: 0.05,
				        min: ".(strtotime('2019-01-01 12:00')*1000).",
				        max: ".(strtotime('2019-12-31 12:00')*1000).",
				        className:'_grp_gantt_hdr'
				    }],
				    
				    plotOptions: {
				        series: {
					        cursor: 'pointer',
					        shadow: false,
					        borderWidth: 0,
				            borderColor: '',
				            dataLabels: {
				                color: 'white',
				                style: {
									textOutline: 0
								}
				            },
				            point: {
					            events: {
					                click: function (event) {
						                
						                var point = this,
						                	options = point.options;
	
					                    alert( options.owner );
					                }
					            }
				            }
				        }
				    },
					
				    series: [
				    
					    {
					        name: 'Desarrollos',
					        data: 
					        	[
									
									{
							            name: 'Envios Masivos',
							            id: 'snd_ec',
							            owner: 'Camilo',
							            /*collapsed: true,*/
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							                fill: '#00506b'
							            }
							        }, 
							        {
							            name: 'Setup',
							            id: 'snd_ec_stup',
							            parent: 'snd_ec',
							            start: ".(strtotime('2019-01-01 12:00')*1000).",
							            end: ".(strtotime('2019-01-31 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							                fill: '#e80'
							            },
							            owner: 'Susan'
							        }, 
							        {
							            name: 'Piloto',
							            id: 'snd_ec_plto',
							            dependency: 'snd_ec_stup',
							            parent: 'snd_ec',
							            start: ".(strtotime('2019-02-01 12:00')*1000).",
							            end: ".(strtotime('2019-03-31 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            owner: 'Camilo'
							        },
							        {
							            name: 'Atributos Automáticos',
							            id: 'snd_ec_lsts_auto',
							            dependency: 'snd_ec_plto',
							            parent: 'snd_ec',
							            start: ".(strtotime('2019-03-25 12:00')*1000).",
							            end: ".(strtotime('2019-03-29 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            owner: 'Camilo'
							        }, 
							        {
							            name: 'Reglas de Envio',
							            id: 'snd_ec_rles',
							            dependency: 'snd_ec_lsts_auto',
							            parent: 'snd_ec',
							            start: ".(strtotime('2019-03-25 12:00')*1000).",
							            end: ".(strtotime('2019-03-29 12:00')*1000).",
							            assignee: '".$__tmp_c."'
							        }, 
							        {
							            name: 'Cargas de BD iComm',
							            parent: 'snd_ec',
							            start: ".(strtotime('2019-03-25 12:00')*1000).",
							            end: ".(strtotime('2019-03-29 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            owner: 'Camilo'
							        }, 
							        {
							            name: 'Cargas de BD Internas',
							            parent: 'snd_ec',
							            start: ".(strtotime('2019-04-01 12:00')*1000).",
							            end: ".(strtotime('2019-04-10 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            owner: 'Camilo'
							        },
							        
							        
							        
							        
							        
							        
							        
							        
							        {
							            name: 'Integraciones API',
							            id: 'api',
							            owner: 'Camilo',
							            /*collapsed: true,*/
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            }
							        }, 
							        {
							            name: 'Emagister',
							            parent: 'api',
							            start: ".(strtotime('2019-01-15 12:00')*1000).",
							            end: ".(strtotime('2019-01-31 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            },
							            owner: 'Susan'
							        },
							        {
							            name: 'Universia',
							            parent: 'api',
							            start: ".(strtotime('2019-01-01 12:00')*1000).",
							            end: ".(strtotime('2019-01-15 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            },
							            owner: 'Susan'
							        },
							        {
							            name: 'LinkedIn Ad',
							            parent: 'api',
							            start: ".(strtotime('2019-05-01 12:00')*1000).",
							            end: ".(strtotime('2019-05-31 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            },
							            owner: 'Susan'
							        },
							        
							        
							        
							        
							        
							        
							        
							        {
							            name: 'Organizaciones',
							            id: 'org',
							            owner: 'Camilo',
							            /*collapsed: true,*/
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            }
							        }, 
							        {
							            name: 'Colegios',
							            parent: 'org',
							            id: 'org_clg',
							            start: ".(strtotime('2019-01-01 12:00')*1000).",
							            end: ".(strtotime('2019-07-30 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            },
							            owner: 'Susan'
							        },
							        {
							            name: 'Carga BD',
							            id: 'org_load',
							            parent: 'org_clg',
							            dependency: 'org_clg',
							            start: ".(strtotime('2019-03-10 12:00')*1000).",
							            end: ".(strtotime('2019-07-30 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            },
							            owner: 'Susan'
							        },
							        {
							            name: 'Actividades',
							            parent: 'org_clg',
							            dependency: 'org_load',
							            start: ".(strtotime('2019-05-15 12:00')*1000).",
							            end: ".(strtotime('2019-07-15 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            },
							            owner: 'Susan'
							        },
							        {
							            name: 'Puesta a Punto',
							            parent: 'org_clg',
							            start: ".(strtotime('2019-06-15 12:00')*1000).",
							            end: ".(strtotime('2019-07-30 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            },
							            owner: 'Susan'
							        },
							        
							        
							        
							        
							        
							        {
							            name: 'Admisiones',
							            id: 'adm',
							            owner: 'Camilo',
							            /*collapsed: true,*/
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            }
							        }, 
							        {
							            name: 'Flow Automation',
							            parent: 'adm',
							            id: 'adm_flow',
							            start: ".(strtotime('2019-03-01 12:00')*1000).",
							            end: ".(strtotime('2019-07-30 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            },
							            owner: 'Susan'
							        },
							        
							        
							        
							        
							        
							        {
							            name: 'Habeas Data',
							            id: 'hbs',
							            owner: 'Camilo',
							            /*collapsed: true,*/
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            }
							        }, 
							        {
							            name: 'Reestructuración BD',
							            parent: 'hbs',
							            id: 'hbs_rstr',
							            start: ".(strtotime('2019-03-01 12:00')*1000).",
							            end: ".(strtotime('2019-03-31 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            },
							            owner: 'Susan'
							        },
							        {
							            name: 'Migración Datos',
							            parent: 'hbs',
							            id: 'hbs_mgr',
							            dependency: 'hbs_rstr',
							            start: ".(strtotime('2019-04-01 12:00')*1000).",
							            end: ".(strtotime('2019-04-15 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            },
							            owner: 'Susan'
							        },
							        {
							            name: 'Desuscripción avanzada Egresados',
							            parent: 'hbs',
							            id: 'hbs_mgr_ext',
							            dependency: 'hbs_rstr',
							            start: ".(strtotime('2019-06-20 12:00')*1000).",
							            end: ".(strtotime('2019-07-20 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            },
							            owner: 'Susan'
							        },
							        
							        
							        
							        
							        
							        
							        
							        {
							            name: 'Web App CISE',
							            id: 'wbappcise',
							            owner: 'Camilo',
							            /*collapsed: true,*/
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            }
							        }, 
							        {
							            name: 'Generación de Interface',
							            parent: 'wbappcise',
							            id: 'wbappcise_itfce',
							            start: ".(strtotime('2019-06-18 12:00')*1000).",
							            end: ".(strtotime('2019-06-25 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            },
							            owner: 'Susan'
							        },
							        {
							            name: 'Generación de Formularios',
							            parent: 'wbappcise',
							            id: 'wbappcise_fm',
							            dependency: 'wbappcise_itfce',
							            start: ".(strtotime('2019-06-25 12:00')*1000).",
							            end: ".(strtotime('2019-07-02 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            },
							            owner: 'Susan'
							        },
							        {
							            name: 'Instalación en Tablets',
							            parent: 'wbappcise',
							            id: 'wbappcise_tbl',
							            dependency: 'wbappcise_fm',
							            start: ".(strtotime('2019-07-02 12:00')*1000).",
							            end: ".(strtotime('2019-07-15 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            },
							            owner: 'Susan'
							        },
							        
									
									
									
									{
							            name: 'Integración Whatsapp',
							            id: 'whtsppapi',
							            owner: 'Camilo',
							            /*collapsed: true,*/
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            }
							        }, 
							        {
							            name: 'Generación de Api',
							            parent: 'whtsppapi',
							            id: 'whtsppapi_bld',
							            start: ".(strtotime('2019-07-02 12:00')*1000).",
							            end: ".(strtotime('2019-07-30 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.1,
							            },
							            owner: 'Susan'
							        },
							        {
							            name: 'Lectura y Cargue de Datos',
							            parent: 'whtsppapi',
							            id: 'whtsppapi_load',
							            start: ".(strtotime('2019-08-01 12:00')*1000).",
							            end: ".(strtotime('2019-08-15 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            },
							            owner: 'Susan'
							        },
							        {
							            name: 'Mostrar Datos en Timeline',
							            parent: 'whtsppapi',
							            id: 'whtsppapi_showdata',
							            start: ".(strtotime('2019-08-15 12:00')*1000).",
							            end: ".(strtotime('2019-08-30 12:00')*1000).",
							            assignee: '".$__tmp_c."',
							            completed: {
							                amount: 0.6,
							            },
							            owner: 'Susan'
							        }
						        
							        
						    ],
						    
						    dataLabels: [{
					            enabled: true,
					            format: '<div style=\"width: 25px; height: 25px; overflow: hidden; border-radius: 200px; margin-left:-25px; border:2px solid white; z-index:1; \">' +
					                	'<img src=\"https://fle.sumr.cloud/us/{point.assignee}\" ' +
										'style=\"width: 30px; margin-left: -5px; margin-top: -2px; background-size:cover; z-index:0; \"></div>',
					            useHTML: true,
					            align: 'left'
					        }, {
					            enabled: true,
					            format: '<i class=\"fa fa-{point.fontSymbol}\" style=\"font-size: 1.5em\"></i>',
					            useHTML: true,
					            align: 'right'
					        }]  
					    }, 
					    
			        
				    ],
				    
				    tooltip: {
					    
				        pointFormatter: function () {
				            var point = this,
				                format = '%e. %b',
				                options = point.options,
				                completed = options.completed,
				                amount = isObject(completed) ? completed.amount : completed,
				                status = ((amount || 0) * 100) + '%',
				                lines;
				
				            lines = [{
				                value: point.name,
				                style: 'font-weight: bold;'
				            }, {
				                title: 'Inicia',
				                value: dateFormat(format, point.start)
				            }, {
				                visible: !options.milestone,
				                title: 'Finaliza',
				                value: dateFormat(format, point.end)
				            }, {
				                title: 'Completado',
				                value: status
				            }, {
				                title: 'Responsable',
				                value: options.owner || 'unassigned'
				            }];
				
				            return reduce(lines, function (str, line) {
				                var s = '',
				                    style = (
				                        defined(line.style) ? line.style : 'font-size: 0.8em;'
				                    );
				                if (line.visible !== false) {
				                    s = (
				                        '<span style=\"' + style + '\">' +
				                        (defined(line.title) ? line.title + ': ' : '') +
				                        (defined(line.value) ? line.value : '') +
				                        '</span><br/>'
				                    );
				                }
				                return str + s;
				            }, '');
				        }
				    },
				    
				    
				   
			        
			        
					
				});
							
			}, 500);
			
		}); 
	
	";
	
?>

<style>
	
	.Dsh_News{ width: 100%; min-height: 800px; position: relative; padding: 50px 100px 400px 100px; }
	.Dsh_News._non::before{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>news_cvr_empty.svg'); background-repeat: no-repeat; background-position: center bottom; background-size: 50% auto; background-color: #EFF2F7; position: absolute; bottom: 0; left: 0; z-index: 0; width: 100%; height: 100%; }
	.Dsh_News._non h1{ display: block; width: 100%; text-align: center; font-size: 25px; margin-bottom: 50px; font-family: 'Source Sans Pro'; font-weight: 400; position: absolute; top: 150px; z-index: 2; }	
	
	
	
	.Dsh_News ._grp_gantt_hdr{ font-family: Economica; text-transform: uppercase; }	










</style>