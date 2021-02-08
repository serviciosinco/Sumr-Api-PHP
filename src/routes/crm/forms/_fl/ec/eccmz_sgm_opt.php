<?php 
    $__sgm = Php_Ls_Cln($_GET['eccmzsgm_sgm']);
	$__cmz = Php_Ls_Cln($_GET['id_eccmz']);
	$__div = Php_Ls_Cln($_GET['iddv']);
?>
<div class="htmlcod_opt">
    <h1>Opciones del Parrafo</h1>
    <ul>
        <li><button class="_btn _wrex _anm" action-type="wrex" sgm-id="<?php echo $__sgm; ?>">Limpiar Word / Excel</button></li>
        <li><button class="_btn _clns _anm" action-type="clns" sgm-id="<?php echo $__sgm; ?>">Limpiar Estilos</button></li>
        <li><button class="_btn _clna _anm" action-type="clna" sgm-id="<?php echo $__sgm; ?>">Borrar Todo</button></li>
        <li><button class="_btn _nhgt _anm" action-type="nhgt" sgm-id="<?php echo $__sgm; ?>">Normalizar Interlineado</button></li>
        <li><button class="_btn _code _anm" action-type="code" sgm-id="<?php echo $__sgm; ?>">Editor de Código</button></li>
    </ul>
</div>