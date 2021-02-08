<?php 
	try{
        $_d = Php_Ls_Cln($_POST['d']);
        $_attr = Php_Ls_Cln($_POST['_attr']);
        $_vl = Php_Ls_Cln($_POST['_vl']);
        $_fld = Php_Ls_Cln($_POST['_id_fld']);
        $_enc = Php_Ls_Cln($_POST['_enc']);

        $__Cl = new CRM_Cl();
        $__Cl->fld = $_fld;

        if($_d == 'new'){
            $__Cl->attr = $_attr;
            $__Cl->vl = $_vl;

            $new = $__Cl->MdlSTpFmRowFldAttr_In();

            if($new->e = 'ok'){
                $rsp['mdl_fm']['attr'] = $__Cl->MdlSTpFmRowFldAttr_Ls();
            }

        }else if($_d == 'eli'){
            $__Cl->enc = $_enc;

            $eli = $__Cl->MdlSTpFmRowFldAttr_Eli();

            if($eli->e = 'ok'){
                $rsp['mdl_fm']['attr'] = $__Cl->MdlSTpFmRowFldAttr_Ls();
            }

        }else if($_d == 'edt'){
            $__Cl->enc = $_enc;
            $__Cl->attr = $_attr;
            $__Cl->vl = $_vl;

            $edt = $__Cl->MdlSTpFmRowFldAttr_Edt();

            if($edt->e = 'ok'){
                $rsp['mdl_fm']['attr'] = $__Cl->MdlSTpFmRowFldAttr_Ls();
            }

        }else{

            $rsp['mdl_fm']['attr'] = $__Cl->MdlSTpFmRowFldAttr_Ls();

        }
        
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
    }
    
?>