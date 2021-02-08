<?php /*

    $___gcl = $_POST['gcl'];
    $___gtb = $_POST['gtb'];


    $this->_s_cl = GtClLs();

    echo $this->h1( 'Query Clients'.$this->_s_cl->qry );

    //print_r( $this->_s_cl );

	if(class_exists('CRM_Cnx')){

        define('DB_TO_PRC', 'sumr_c_uexternado');
        define('TB_TO_PRC', 'cnt');
        define('DB_CHRST', 'utf8mb4');
        define('TAB_CHRST', 'utf8mb4_unicode_520_ci');
        define('COL_CHRST', 'utf8mb4');

        function sch_chr(){

            $_sch = [

                // Strange Block

                [ 'l'=>'á', 'sch'=>'ÃƒÂ¡', 'chn'=>'á' ],

                [ 'l'=>'é', 'sch'=>'ÃƒÂ©', 'chn'=>'é' ],
                [ 'l'=>'é', 'sch'=>'í©', 'chn'=>'é' ],
                [ 'l'=>'é', 'sch'=>'á‰', 'chn'=>'é' ],
                [ 'l'=>'é', 'sch'=>'Ã©', 'chn'=>'é' ],

                [ 'l'=>'í', 'sch'=>'ÃƒÂ', 'chn'=>'í' ],
                [ 'l'=>'i', 'sch'=>'Ã­­', 'chn'=>'í' ],
                [ 'l'=>'i', 'sch'=>'Ã­¬', 'chn'=>'í' ],
                [ 'l'=>'i', 'sch'=>'Ã', 'chn'=>'í' ],

                [ 'l'=>'ó', 'sch'=>'ÃƒÂ³', 'chn'=>'ó' ],
                [ 'l'=>'ó', 'sch'=>'Ã­³', 'chn'=>'ó' ],
                [ 'l'=>'ó', 'sch'=>'??Ã‚Â³', 'chn'=>'ó' ],
                [ 'l'=>'ó', 'sch'=>'í³', 'chn'=>'ó' ],
                [ 'l'=>'ó', 'sch'=>'Ã³', 'chn'=>'ó' ],

                [ 'l'=>'ñ', 'sch'=>'ÃƒÂ±', 'chn'=>'ñ' ],
                [ 'l'=>'ñ', 'sch'=>'ÃƒÂ±', 'chn'=>'ñ' ],
                [ 'l'=>'ñ', 'sch'=>'Ã­±', 'chn'=>'ñ' ],
                [ 'l'=>'ñ', 'sch'=>'Ã­²', 'chn'=>'ñ' ],
                [ 'l'=>'ñ', 'sch'=>'Ã±', 'chn'=>'ñ' ],
                [ 'l'=>'ñ', 'sch'=>'í±', 'chn'=>'ñ' ],
                [ 'l'=>'ñ', 'sch'=>'&ntilde;', 'chn'=>'ñ' ],

                [ 'l'=>'ú', 'sch'=>'ÃƒÂº', 'chn'=>'ú' ],
                [ 'l'=>'ú', 'sch'=>'Ã­º', 'chn'=>'ú' ],
                [ 'l'=>'ú', 'sch'=>'íº', 'chn'=>'ú' ],
                [ 'l'=>'ú', 'sch'=>'Ãº', 'chn'=>'ú' ],

                [ 'l'=>'¿', 'sch'=>'Ã‚Â¿', 'chn'=>'¿' ],
                [ 'l'=>'¿', 'sch'=>'Â¿', 'chn'=>'¿' ],

                //Normal Block

                [ 'l'=>'Á', 'sch'=>'ÃƒÂ', 'chn'=>'Á' ],
                [ 'l'=>'Ó', 'sch'=>'Ã¡“', 'chn'=>'Ó' ],
                [ 'l'=>'Ú', 'sch'=>'Ã¡š', 'chn'=>'Ú' ],

                //Another

                [ 'l'=>'', 'sch'=>'Ã¢Â€Âœ', 'chn'=>'"' ],
                [ 'l'=>'', 'sch'=>'Ã¢Â€Â', 'chn'=>'"' ],


                [ 'l'=>'ó', 'sch'=>'ÃŒÂ', 'chn'=>'ó' ],

                [ 'l'=>'', 'sch'=>'Maestráa', 'chn'=>'Maestría' ],
                [ 'l'=>'', 'sch'=>'Polático', 'chn'=>'Político' ],
                [ 'l'=>'', 'sch'=>'tecnologáas', 'chn'=>'tecnologías' ],
                [ 'l'=>'', 'sch'=>'Veháculo', 'chn'=>'Vehículo' ],
                [ 'l'=>'', 'sch'=>'VehÃ¡culo', 'chn'=>'Vehículo' ],

                [ 'l'=>'', 'sch'=>'PolÃ¡tica', 'chn'=>'Política' ],
                [ 'l'=>'', 'sch'=>'AquÃ¡', 'chn'=>'Aquí' ],
                [ 'l'=>'', 'sch'=>'aquÃ¡', 'chn'=>'aquí' ],
                [ 'l'=>'', 'sch'=>'AlemÃ¡n', 'chn'=>'Alemán' ],
                [ 'l'=>'', 'sch'=>'envÃ¡o', 'chn'=>'envío' ],
                [ 'l'=>'', 'sch'=>'EnvÃ¡o', 'chn'=>'Envío' ],

                [ 'l'=>'', 'sch'=>'Ã¡rea', 'chn'=>'Área' ],
                [ 'l'=>'', 'sch'=>'Ã¡rea', 'chn'=>'Área' ],
                [ 'l'=>'', 'sch'=>'TÃ¡tulo', 'chn'=>'Título' ],
                [ 'l'=>'', 'sch'=>'SubtÃ¡tulo', 'chn'=>'Subtítulo' ],
                [ 'l'=>'', 'sch'=>'CaracterÃ¡sticas', 'chn'=>'Características' ],

                [ 'l'=>'', 'sch'=>'PaÃ¡s', 'chn'=>'País' ],
                [ 'l'=>'', 'sch'=>'grÃ¡fica', 'chn'=>'gráfica' ],
                [ 'l'=>'', 'sch'=>'GrÃ¡fica', 'chn'=>'Gráfica' ],

                [ 'l'=>'', 'sch'=>'MÃ¡s ', 'chn'=>'Más ' ],
                [ 'l'=>'', 'sch'=>'BÃ¡sico', 'chn'=>'Básico' ],
                [ 'l'=>'', 'sch'=>'estÃ¡ ', 'chn'=>'está ' ],
                [ 'l'=>'', 'sch'=>'estarÃ¡', 'chn'=>'estará' ],
                [ 'l'=>'', 'sch'=>'EstadÃ¡stica', 'chn'=>'Estadística' ],
                [ 'l'=>'', 'sch'=>'estadÃ¡stica', 'chn'=>'estadística' ],
                [ 'l'=>'', 'sch'=>'CategorÃ¡as', 'chn'=>'Categorías' ],
                [ 'l'=>'', 'sch'=>'VÃ¡nculo', 'chn'=>'Vínculo' ],
                [ 'l'=>'', 'sch'=>'LÃ¡nea', 'chn'=>'Línea' ],

                [ 'l'=>'', 'sch'=>'PerÃ¡odo', 'chn'=>'Período' ],
                [ 'l'=>'', 'sch'=>'ImÃ¡gen', 'chn'=>'Imágen' ],

                [ 'l'=>'', 'sch'=>'GeogrÃ¡fico', 'chn'=>'Geográfico' ],
                [ 'l'=>'', 'sch'=>'AuditorÃ¡a', 'chn'=>'Auditoría' ],
                [ 'l'=>'', 'sch'=>'carÃ¡cter', 'chn'=>'carácter' ],

                [ 'l'=>'', 'sch'=>'vacÃ¡o', 'chn'=>'vacío' ],
                [ 'l'=>'', 'sch'=>'vÃ¡lido', 'chn'=>'válido' ],

                [ 'l'=>'', 'sch'=>'logÃ¡a', 'chn'=>'logía' ],
                [ 'l'=>'', 'sch'=>'EconomÃ¡ca', 'chn'=>'Economíca' ],
                [ 'l'=>'', 'sch'=>'PÃ¡gina', 'chn'=>'Página' ],
                [ 'l'=>'', 'sch'=>'enviarÃ¡', 'chn'=>'enviará' ],
                [ 'l'=>'', 'sch'=>'RecibirÃ¡', 'chn'=>'Recibirá' ],
                [ 'l'=>'', 'sch'=>'ArtÃ¡culo', 'chn'=>'Artículo' ],

                [ 'l'=>'', 'sch'=>'Ã¡tem', 'chn'=>'ítem' ],
                [ 'l'=>'', 'sch'=>'SÃ¡bado', 'chn'=>'Sábado' ],
                [ 'l'=>'', 'sch'=>'VÃ¡deo', 'chn'=>'Vídeo' ],
                [ 'l'=>'', 'sch'=>'SanguÃ¡neo', 'chn'=>'Sanguíneo' ],

                [ '-'=>'', 'sch'=>'Ã¢Â€Â“', 'chn'=>'-' ],
                [ ''=>'º', 'sch'=>'Ã‚Âº', 'chn'=>'º' ],
                [ ''=>'º', 'sch'=>'Ã­', 'chn'=>'í' ],
                [ 'l'=>'á', 'sch'=>'á¨', 'chn'=>'é' ]

            ];

            return $_sch;

        }


        function ignre(){
            $_ig = ['__FIXCHARTAB', '__SNDTEST', '____RQ', '_api_rq', '_api_c', '_cl_gtwy_pay', 'aws_acc', '_cl_ftp', '_cl_vtex', 'eml'];
            return $_ig;
        }

        function toinc(){
            $_ig = ['_cl'];
            return $_ig;
        }


        /* $qry = "select * from sumr_bd._sis_tx where id_sistex = '2789'";
        $rs = $__cnx->_qry($qry);
        $rw = $rs->fetch_assoc();


        echo $rw['sistex_tt'].PHP_EOL;

        //echo PHP_EOL.PHP_EOL.'-->>Coded'.PHP_EOL.PHP_EOL;
        //echo utf8_encode('¿').PHP_EOL.PHP_EOL.PHP_EOL;
        exit();  *//*

        function DB_TabsCol($p=NULL){

            global $__cnx;

            $qry = "SELECT
                        COLUMN_NAME AS col_id,
                        COLUMN_KEY AS col_key,
                        DATA_TYPE AS col_tp,
                        CHARACTER_SET_NAME as col_chrs,
                        COLLATION_NAME AS col_cllnm,
                        DATA_TYPE AS col_dtpe,
                        CHARACTER_MAXIMUM_LENGTH AS col_dtpe_max

                    FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE TABLE_NAME = '".$p['t']."' AND TABLE_SCHEMA = '".$p['d']."'";

            $rs = $__cnx->_qry($qry);

            if($rs){

                $rw = $rs->fetch_assoc();
                $tot = $rs->num_rows;

                do{

                    try{

                        $_r[] = [
                            'id'=>$rw['col_id'],
                            'tp'=>$rw['col_tp'],
                            'key'=>$rw['col_key'],
                            'chrs'=>$rw['col_chrs'],
                            'cllnm'=>$rw['col_cllnm'],
                            'dtpe'=>$rw['col_dtpe'],
                            'dtpe_max'=>$rw['col_dtpe_max']
                        ];

                    }catch(Exception $e){
                        echo $this->err($e->getMessage());
                    }

                }while($rw = $rs->fetch_assoc());

            }else{

                echo $__cnx->c_r->error;

            }

            $__cnx->_clsr($Ls_Rg);
            return _jEnc( $_r );

        }


        function DB_Tabs($p=NULL){

            global $__cnx;

            $__ignr = ignre();

            foreach($__ignr as $__ignr_k=>$__ignr_v){
                $_qry_exc[] = "'".$__ignr_v."'";
            }

            if(!isN($p['tb'])){
                $_whre = ' TABLE_NAME="'.$p['tb'].'" ';
            }else{
                $_whre = " NOT EXISTS (SELECT * FROM sumr_bd.__FIXCHARTAB WHERE fixtab_tab=CONCAT(TABLE_SCHEMA,'.',TABLE_NAME) ) ";
            }

            if($p['t']=='sis'){ $_lmt='5'; }else{ $_lmt='10'; }

            $qry = "SELECT TABLE_NAME AS tab_id, TABLE_COLLATION AS tab_cll
                    FROM INFORMATION_SCHEMA.TABLES
                    WHERE TABLE_SCHEMA = '".$p['d']."' AND
                          TABLE_NAME NOT IN (".implode(',', $_qry_exc).") AND
                          {$_whre}
                    ORDER BY RAND()
                    /*LIMIT {$_lmt}*//*";

            //echo compress_code($qry); exit();

            $rs = $__cnx->_qry($qry);

            if($rs){

                $rw = $rs->fetch_assoc();
                $tot = $rs->num_rows;

                do{

                    try{

                        $_r[] = [
                            'id'=>$rw['tab_id'],
                            'col'=>DB_TabsCol([ 'd'=>$p['d'], 't'=>$rw['tab_id'] ]),
                            'cll'=>$rw['tab_cll'],
                        ];

                    }catch(Exception $e){
                        echo $this->err($e->getMessage());
                    }

                }while($rw = $rs->fetch_assoc());

            }else{

                echo $__cnx->c_r->error;

            }

            $__cnx->_clsr($Ls_Rg);
            return _jEnc( $_r );

        }

        function DB_TabDt($p=NULL){

            global $__cnx;

            $qry = " SELECT * FROM sumr_bd.__FIXCHARTAB WHERE fixtab_tab='".$p['tab']."' ";
            $rs = $__cnx->_qry($qry);

            if($rs){

                $rw = $rs->fetch_assoc();
                $tot = $rs->num_rows;

                $_r['e'] = 'ok';

                if($tot > 0){
                    do{
                        try{
                            $_r['id'] = $rw['id_fixtab'];
                        }catch(Exception $e){
                            echo $this->err($e->getMessage());
                        }
                    }while($rw = $rs->fetch_assoc());
                }

            }else{

                echo $__cnx->c_r->error;

            }

            $__cnx->_clsr($Ls_Rg);
            return _jEnc( $_r );

        }


        function tab_didit($p=null){

            global $_AUTOP;
            global $__cnx;

            $in = "INSERT INTO sumr_bd.__FIXCHARTAB (fixtab_tab) VALUES ('".$p['tb']."')";
            $rs = $__cnx->_prc($in);
            if($rs){
                $_r['e']='ok';
                echo $_AUTOP->scss(' Inserted Did It Success');
            }

            return _jEnc( $_r );
        }


        function tab_err($p=null){

            global $_AUTOP;
            global $__cnx;

            if(!isN($p['w']) && !isN($p['tab'])){

                $upd = "UPDATE sumr_bd.__FIXCHARTAB SET fixtab_w=CONCAT(fixtab_w, ".GtSQLVlStr(' | '.$p['w'], "text")." ) WHERE fixtab_tab='".$p['tab']."' ";
                $rs = $__cnx->_prc($upd);

                $_r['q']=$upd;

                if($rs){
                    $_r['e']='ok';
                    echo $_AUTOP->scss(' Inserted Did It Success');
                }else{
                    $_r['w']=$__cnx->c_p->error;
                }

            }

            return _jEnc( $_r );
        }

        function SchRplc($p=null){

            global $_AUTOP;
            global $__cnx;

            if(!isN( $p['bd'] )){

                $__tabs = DB_Tabs([ 'd'=>$p['bd'], 't'=>$p['t'], 'tb'=>$p['tb'] ]);
                $__sch = sch_chr();
                $__incl = toinc();

                foreach($__tabs as $__tabs_k=>$__tabs_v){

                    if(!isN( $__tabs_v->id )){

                        $__didit_q = DB_TabDt([ 'tab'=>_BdStr($p['bd']).$__tabs_v->id ]);

                        if($__didit_q->e == 'ok' && isN($__didit_q->id) /*&& in_array($__tabs_v->id, $__incl )*//* ){

                            if($__tabs_v->cll != TAB_CHRST){

                                echo $_AUTOP->li($__tabs_v->id.' has to change charset');

                                $mdf = "ALTER TABLE "._BdStr($p['bd']).$__tabs_v->id." CHARACTER SET ".DB_CHRST." COLLATE ".TAB_CHRST;
                                echo $_AUTOP->li($mdf);
                                $rs = $__cnx->_prc($mdf);
                                if($rs){ echo $_AUTOP->scss(' Modified Success'); }

                            }

                            if( !isN( $__tabs_v->col ) ){

                                foreach($__tabs_v->col as $_col_k=>$_col_v){

                                    if($_col_v->tp == 'varchar' || $_col_v->tp == 'mediumtext' || $_col_v->tp == 'longtext' || $_col_v->tp == 'text'){

                                        if($_col_v->cllnm != TAB_CHRST){

                                            $_dtpe_q = NULL;
                                            $_dtpe_max = NULL;

                                            if($_col_v->tp == 'varchar' && $_col_v->dtpe_max <= 255){
                                                if($_col_v->dtpe_max > 191 && $_col_v->dtpe_max <= 255){ $_dtpe_max=191; }else{ $_dtpe_max=$_col_v->dtpe_max; }
                                                if(!isN( $_dtpe_max )){ $_dtpe_q = ' '.$_col_v->dtpe.'('.$_dtpe_max.') '; }
                                            }elseif($_col_v->tp == 'text'){
                                                $_dtpe_q = ' TEXT ';
                                            }elseif($_col_v->tp == 'longtext'){
                                                $_dtpe_q = ' LONGTEXT ';
                                            }elseif($_col_v->tp == 'mediumtext'){
                                                $_dtpe_q = ' MEDIUMTEXT ';
                                            }


                                            if(!isN( $_dtpe_q )){

                                                echo $_AUTOP->li($_col_v->id.' has to change charset');

                                                $mdfc = "ALTER TABLE "._BdStr($p['bd']).$__tabs_v->id." MODIFY ".$_col_v->id.$_dtpe_q." CHARACTER SET ".COL_CHRST." COLLATE ".TAB_CHRST." ";
                                                echo $_AUTOP->li($mdfc);
                                                $rsc = $__cnx->_prc($mdfc);

                                                if($rsc){
                                                    echo $_AUTOP->scss(' Modified Success');
                                                }else{
                                                    $__err = tab_err([ 'tab'=>_BdStr($p['bd']).$__tabs_v->id, 'w'=>'('.$__cnx->c_p->error.') on '.compress_code($mdfc) ]);
                                                    echo $_AUTOP->err(' Col Not Modified '.$__cnx->c_p->error);
                                                    print_r($__err);
                                                }

                                            }

                                        }else{

                                            echo $_AUTOP->scss('UTF8MB4 column is good');

                                        }


                                        foreach($__sch as $_sch_k=>$_sch_v){

                                            echo $_AUTOP->li( 'Search on '.$__tabs_v->id.' '.
                                                            ' ('.$__tabs_v->cll.') '.
                                                            ' '.$_col_v->id.'('.$_col_v->cllnm.')  '.$_sch_v['sch'].
                                                            ' replace with '.$_sch_v['chn']
                                                        );

                                            $_qry_rplc = "UPDATE "._BdStr($p['bd']).$__tabs_v->id." SET ".$_col_v->id."=REPLACE(".$_col_v->id.", '".$_sch_v['sch']."', '".$_sch_v['chn']."') WHERE ".$_col_v->id." LIKE '%".$_sch_v['sch']."%' ";
                                            echo $_AUTOP->li( $_qry_rplc );

                                            $upd = $__cnx->_prc( $_qry_rplc );

                                            if($upd){
                                                echo $_AUTOP->scss('Updated records of column '.$_col_v->id);
                                            }else{
                                                echo $_AUTOP->err('No updated records of column '.$_col_v->id.' '.$__cnx->c_p->error);
                                                $__err = tab_err([ 'tab'=>_BdStr($p['bd']).$__tabs_v->id, 'w'=>'('.$__cnx->c_p->error.') on '.compress_code($_qry_rplc) ]);
                                                print_r($__err);
                                            }

                                        }

                                    }

                                }

                                tab_didit([ 'tb'=>_BdStr($p['bd']).$__tabs_v->id ]);

                            }else{

                                echo $_AUTOP->err('No columns record');

                            }

                        }else{

                            echo $_AUTOP->scss($__tabs_v->id.' is processed');

                        }

                    }

                }

            }

        }

        if($___gtb == 'ok'){

            SchRplc([ 'bd'=>'sumr_bd', 'tb'=>'_sis' ]); // Main DataBase

        }elseif($___gcl == 'ok'){

            if($this->_s_cl->tot > 0){

                foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){
                    echo $this->h2( 'Search and replace on '.$_cl_v->nm.' '.$_cl_v->bd );
                    SchRplc([ 'bd'=>$_cl_v->bd ]); // Main DataBase
                }

            }

        }else{

            SchRplc([ 'bd'=>DBM, 't'=>'sis' ]); // Main DataBase
            //SchRplc([ 'bd'=>DBD, 't'=>'sis' ]); // Downloads DataBase
            //SchRplc([ 'bd'=>DBA, 't'=>'sis' ]); // Auto DataBase
            //SchRplc([ 'bd'=>DBP, 't'=>'sis' ]); // Process DataBase
            //SchRplc([ 'bd'=>DBC, 't'=>'sis' ]); // Chat DataBase
            //SchRplc([ 'bd'=>DBT, 't'=>'sis' ]); // Third DataBase
            //echo $_AUTOP->h2( 'Total clients '.$this->_s_cl->tot );

        }

	}else{

		echo $this->err('AUTO_CHK_EML:off');

	}
*/
?>