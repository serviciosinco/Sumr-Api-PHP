<?php 
/*
    $_t2 = Php_Ls_Cln($_GET['_t2']);
    
    try{

        if( !isN($_t2) ){

            $_ls_dsp = GtEcDlvr_T_Ls([ 't'=>$_t2 ]);
            
            if($_t2 == "dsp"){

                foreach($_ls_dsp->ls as $_k => $_v){
                    $__grph_dsp[] = "{name: '".$_v->nm."', y:".$_v->tot." }";
                }

                $CntWb .= "
                    SUMR_Grph.f.g2({ 
                        id: '#_grph_3_glb',
                        g_h: 350,
                        g_mrg_t:0,
                        g_mrg_b:0,
                        d: [ ".implode(',', $__grph_dsp)." ],
                        tt: 'Aperturas',
                        tt_sb: 'Unicas por dispositivo',
                        dt_lbl: false,
                        lgnd:true,
                        dt_lbl_frmt: '{pint.percentage:.1f}%',
                        lgnd_frmt: function() {
                            return '<span>' + this.name +' </span> <span style=\"color:#727272;font-size:10px;\"> ' + this.percentage.toFixed(2) + ' %</span>';
                        },
                        i_s:'50%',
                        lgnd_lyt: 'horizontal',
                        lgnd_valgn: 'bottom',
                        lgnd_algn: 'center',
                        lgnd_y: 0
                    });
                ";

            }else if($_t2 == "os"){

                foreach($_ls_dsp->ls as $_k => $_v){
                    $__grph_os[] = "{name: '".$_v->nm."', y:".$_v->tot." }";
                }

                $CntWb .= " 
					SUMR_Grph.f.g2({ 
                        id: '#_grph_4_glb',
                        g_h: 350,
                        g_mrg_t:0,
                        g_mrg_b:0,
                        d: [ ".implode(',', $__grph_os)." ],
                        tt: 'Aperturas Movil',
                        tt_sb: 'Sistema Operativo',
                        dt_lbl: false,
                        lgnd:true,
                        lgnd_frmt: function() {
                                return '<span>' + this.name +' </span> <span style=\"color:#727272;font-size:10px;\"> ' + this.percentage.toFixed(2) + ' %</span>';
                        },
                        i_s:'50%',
                        lgnd_lyt: 'horizontal',
                        lgnd_valgn: 'bottom',
                        lgnd_algn: 'center',
                        lgnd_y: 0
                    });
                ";

            }else if($_t2 == "brws"){

                foreach($_ls_dsp->ls as $_k => $_v){
                    $__grph_brws[] = "{name: '".$_v->nm."', y:".$_v->tot." }";
                }

                $CntWb .= " 
					SUMR_Grph.f.g2({ 
                        id: '#_grph_5_glb',
                        g_h: 350,
                        g_mrg_t:0,
                        g_mrg_b:0,
                        g_spc_t:0,
                        d: [ ".implode(',', $__grph_brws)." ],
                        tt: 'Aperturas',
                        tt_sb: 'Navegador',
                        dt_lbl: false,
                        lgnd:true,
                        lgnd_frmt: function() {
                                return '<span>' + this.name +' </span> <span style=\"color:#727272;font-size:10px;\"> ' + this.percentage.toFixed(2) + ' %</span>';
                        },
                        i_s:'50%',
                        lgnd_lyt: 'horizontal',
                        lgnd_valgn: 'bottom',
                        lgnd_algn: 'center',
                        lgnd_y: 0
                    });
                ";

            }else if($_t2 == "clnt"){

                foreach($_ls_dsp->ls as $_k => $_v){
                    $__grph_clnt[$_v->nm] = $_v->tot;
			        $__grph_clnt_ctg[$_v->nm] = "'".$_v->nm."'";
                }

                $CntWb .= " 
					SUMR_Grph.f.g7({ 
                        id: '#_grph_6_glb',
                        g_spc_b: 80,
                        tt: 'Aperturas',
                        tt_sb: 'Cliente Email',
                        ctg: [ ".implode(',', $__grph_clnt_ctg)." ],
                        d: [{ name: 'Aperturas', data:[".implode(',', $__grph_clnt)."] }]	
                    });
                ";

            }else if($_t2 == "bnct"){

                foreach($_ls_dsp->ls as $_k => $_v){
                    $__grph_bnct[] = "{name: '".$_v->nm."', y:".$_v->tot." }";
                }

                $CntWb .= " 
                        SUMR_Grph.f.g2({ 
                            id: '#_grph_7_glb',
                            g_h: 350,
                            g_mrg_t:0,
                            g_mrg_b:0,
                            g_spc_t:0,
                            d: [ ".implode(',', $__grph_bnct)." ],
                            tt: 'Rebotes',
                            tt_sb: 'por tipologia',
                            dt_lbl: false,
                            lgnd:true,
                            lgnd_frmt: function() {
                                    return '<span>' + this.name +' </span> <span style=\"color:#727272;font-size:10px;\"> ' + this.percentage.toFixed(2) + ' %</span>';
                            },
                            i_s:'50%',
                            lgnd_lyt: 'horizontal',
                            lgnd_valgn: 'bottom',
                            lgnd_algn: 'center',
                            lgnd_y: 0
                        });
					"; 

            }

        }
    
    }catch(Exception $e){
        $rsp['e'] = 'no';
        $rsp['w'] = TX_NSPPCSR .$e->getMessage();
    }

    */

    
?>