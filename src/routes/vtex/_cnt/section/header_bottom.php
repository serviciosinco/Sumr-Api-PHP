

<header class="header <?php echo $_pm_section.' '.$_pm_action; ?>">
    <div class="header-bottom">
        <div class="_wrp">
            <div class="logo"></div>
            <?php if(!ChckSESS_cnt() && $_pm_module == 'fidelizacion' && $_pm_section != 'login'){ ?>
                <div class="login_acc_bx">
                    <a href="https://familia.miscelandia.com.co/fidelizacion/login">
                        <div class="login_acc">INGRESA A TU CUENTA</div>
                    </a>
                </div>
            <?php } ?>
            <div class="texto">
                <?php if(ChckSESS_cnt()){ ?> 
                    <div class="logout"></div> 
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="borde_inc"></div>
</header>