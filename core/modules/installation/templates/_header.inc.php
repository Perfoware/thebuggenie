<?php

    header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
    header ("Cache-Control: no-store, must-revalidate"); // HTTP/1.1
    header ("Pragma: no-cache"); // HTTP/1.0

    $step = $tbg_request->getParameter('step', 0);

    $mode = (isset($mode)) ? $mode : 'install';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>The Bug Genie <?php if ($mode == 'upgrade'): ?>upgrade<?php else: ?>installation<?php endif; ?></title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="zegenie">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="shortcut icon" href="images/favicon.png">
        <script type="text/javascript" src="js/prototype.js"></script>
        <script type="text/javascript" src="js/scriptaculous.js"></script>
        <script type="text/javascript" src="js/install.js"></script>
        <style type="text/css">
            <?php include THEBUGGENIE_PATH . 'themes' . DS . 'oxygen' . DS . 'css' . DS . 'theme.css'; ?>
        </style>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/v4-shims.css">
        <style type="text/css">
            @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,700,700i|Fira+Mono:400,500,700&subset=cyrillic,cyrillic-ext,latin-ext');

            body { font-size: 14px; }
            body, html, div, p, td, input { font-family: "Source Sans Pro", arial; color: #555; }
            h1, h2, h3, h4, h5 { text-shadow: none; border-bottom: 1px dotted #CCC; text-transform: uppercase; font-weight: 400; color: #888; }
            h1 { font-size: 1.6em; }
            h2 { font-size: 1.4em; margin-bottom: 8px; }
            h3 { font-size: 1.2em; }
            h4 { font-size: 1.1em; }
            h5 { font-size: 1.05em; }
            b, strong { font-weight: 600; }
            h2 .smaller { font-size: 0.9em; text-shadow: none; }
            label { vertical-align: middle; font-weight: 300; font-size: 1em; }
            label[for=agree_license] { font-size: 1.05em; display: inline-block; vertical-align: middle; font-weight: 400; }
            .install_progress { font-weight: 300; border: 1px solid #DDD; padding: 3px; font-size: 1em; margin-bottom: 2px; width: 930px; background-color: #FDFDFD; }
            .install_progress.prereq_fail:first-line { font-weight: 600; }
            .install_progress img { float: right; vertical-align: middle; }
            .progress_bar { display: block; width: 500px; position: relative; height: 20px; background-color: #F5F5F5; box-shadow: inset 0 0 3px rgba(100, 100, 100, 0.3); padding: 0; margin: 5px auto; border-radius: 0; }
            .progress_bar .filler { background-color: rgba(133, 185, 0, 0.7); position: absolute; left: 0; top: 0; height: 19px; min-width: 20px; border-bottom: 1px solid rgba(165, 202, 72, 1); border-radius: 0; box-shadow: inset 3px 0 4px rgba(100, 100, 100, 0.3); }
            .prereq_ok { border: 1px solid #aaC6aa; background-color: #CFE8CF; }
            .prereq_fail { border: 1px solid #B76B6B; color: #FFF; font-size: 1em; background-color: #F38888; margin-top: 10px; }
            .prereq_warn { border: 1px solid #FF9900; background-color: #FFFF99; font-size: 12px; }
            .installation_box { padding: 3px 10px 10px 10px; width: 950px; margin-left: auto; margin-right: auto; margin-top: 15px; position: relative; font-size: 1em; line-height: 1.6; }
            .installation_box dl { font-size: 1em; }
            .installation_box dl dd, .installation_box dl dt { vertical-align: middle; font-weight: 300; margin-left: 0; }
            .donate { border: 1px solid #aaC6aa; background-color: #CFE8CF; margin: 0; }
            .grey_box { border: 1px solid #DDD; background-color: #F5F5F5; }
            .command_box { border: 1px dashed #DDD; background-color: #F5F5F5; padding: 4px; font-family: 'Fira Mono', monospace; margin-top: 5px; margin-bottom: 15px; font-size: 0.9em; }
            .features { width: 400px; float: right; margin-left: 10px; }
            .feature { border: 1px solid #DDD; background-color: #F5F5F5; padding: 10px; margin-bottom: 5px; }
            .feature .description { background-color: #FFF; padding: 10px; }
            .feature .content { background-color: transparent; padding: 10px; border-top: 1px solid #EEE; }
            .install_list dd { padding: 2px 0 5px 0; width: 760px; display: inline-block; float: none; }
            .helptext { color: #AAA; vertical-align: middle; display: inline-block; margin-left: 5px; }
            .install_list dt { width: 200px; padding: 7px 0; display: inline-block; float: none; }
            .install_list dt .faded_out { font-weight: 300; }
            .install_list select { padding: 5px; font-weight: 1.1em; height: auto; vertical-align: middle; border: 1px solid #BEBEBE; border-radius: 4px; }
            .main_header_print
            {
                background: #4E81AB; /* Old browsers */
                color: white;
                border-radius: 0;
                margin-top: 0;
                display: block;
                -moz-border-radius-bottomleft: 7px;
                -moz-border-radius-bottomright: 7px;
                -webkit-border-bottom-left-radius: 7px;
                -webkit-border-bottom-right-radius: 7px;
                height: 80px !important;
            }

            input[type=text] { padding: 4px; border: 1px solid #BEBEBE; border-radius: 4px;}
            input[type=text].small { width: 100px; margin-top: -5px; }
            input[type=text].dsn { width: 400px; margin-top: -5px; }
            input[type=text].smallest { width: 50px; }

            .footer_container { background-color: #F5F5F5; width: 100%; border-top: 1px solid #DDD; padding: 5px; text-shadow: 1px 1px 0px #FFF; }
            .footer_container img { margin-right: 10px; }
            .padded_box { padding: 3px 10px 10px 10px; }
            .error { padding: 4px; border: 1px solid #B77; background-color: #FEE; color: #955; margin: 10px 0 10px 0; }
            .ok { padding: 4px; border: 1px solid #aaC6aa; background-color: #CFE8CF; margin: 10px 0 10px 0; }
            .error:first-line, .ok:first-line { font-weight: 600; }

            .logo_small { font-size: 1.1em; color: white; white-space: nowrap; margin-top: 5px; display: inline-block; }

            fieldset { border: 1px solid #DDD; margin: 10px 0 10px 0; background-color: #F5F5F5; padding: 0 0 0 8px; }
            legend { font-weight: 300; font-size: 1.1em; color: #555; text-transform: uppercase; padding: 5px 10px; }

            ul.outlined { margin-top: 5px; }
            ul.outlined li { font-weight: 600; }

            #logo_container { line-height: 1em; display: flex; padding: 10px; margin: 0; }
            #logo_container .logo_image_container { flex: 0 0 55px; text-align: left;}
            #logo_container .logo_name_container { flex: 1 1 auto; line-height: 1.1em; }
            #logo_container .logo_name { font-size: 1.5em; display: block; color: #ECF0F4; margin: 0; }
            #logo_container .logo_small { display: block; }

            .scope_upgrade { margin: 5px; padding: 0; font-size: 0.9em; }
            .scope_upgrade li { margin: 0; padding: 2px 0; list-style: none; display: inline-block; width: 450px; }
            .scope_upgrade li:hover { background-color: rgba(200, 230, 200, 0.3); }
            .scope_upgrade li label { display: inline-block; width: 180px; vertical-align: middle; text-align: right; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
            .scope_upgrade li select { width: 250px; }

            .progress_buttons { padding: 25px 0 0; height: 30px; }
            .progress_buttons .button, .installation_box input[type="submit"] { font-size: 1.2em; padding: 4px 10px !important; }
            .progress_buttons .button-next { float: right; }
            .progress_buttons .button-previous { float: left; }

            .installpage { font-size: 1.1em; }
            ul.backuplist { margin: 15px 0; padding: 0; }
            ul.backuplist > li { background-position: 0 13px; background-repeat: no-repeat; list-style: none; padding: 10px 0 10px 40px; }
            ul.backuplist > li:first-line { font-weight: 600; font-size: 1.1em; }
            ul.backuplist > li.faded { opacity: 0.3; }
            ul.backuplist > li label, ul.backuplist > li input, ul.passwordlist li label, ul.passwordlist li input { vertical-align: middle; }
            ul.backuplist > li > ul { margin: 10px 0; padding: 0; }
            ul.backuplist > li > ul li { margin: 2px 0; display: block; clear: both; float: none; max-width: 800px; }

            ul.passwordlist { list-style: none; margin: 0; padding: 0; }
            ul.passwordlist li { margin: 5px 0 15px; }
            ul.passwordlist li .explanation { padding: 5px; font-size: 1em; }
            .installpage ul li input[type=text], input.username {
                background-image: url('images/user_mono.png');
            }
            input[type=email], input.email {
                background-image: url('images/icon-mono-email.png');
            }
            input.password, input.adminpassword {
                background-image: url('images/password_mono.png');
            }
            .installpage ul li input[type=text], input.username, input.email, input.password, input.adminpassword {
                background-position: 7px 7px;
                background-repeat: no-repeat;
                padding: 5px 5px 5px 28px;
                font-size: 1.1em;
                border-radius: 4px;
                width: 300px;
                margin-top: -5px;
                border: 1px solid #BEBEBE;
            }

            .message-box {
                display: flex;
                width: calc(100% - 20px);
                box-sizing: border-box;
                margin: 10px;
                padding: 10px;
                border: 1px solid rgba(200, 200, 200, 0.7);
                align-items: baseline;
                border-radius: 3px;
            }
            .message-box.type-warning {
                background-color: rgba(249, 245, 178, 0.6);
            }
            .message-box.type-info {
                background-color: rgba(177, 210, 143, 0.3);
            }
            .message-box .fas,
            .message-box .fab,
            .message-box .far {
                margin-right: 5px;
            }
            .message-box .message {
                flex: 1 1 auto;
                font-size: 1.1em;
                color: rgba(0, 0, 0, .4);
            }
            .message-box .actions {
                flex: 0 0 auto;
            }
            .message-box .message + .actions {
                margin-left: 10px;
            }
            .message-box .actions .button {
                padding: 4px 7px;
            }

        </style>
    </head>
    <body>
        <table style="width: 1000px; height: 100%; table-layout: fixed;" cellpadding=0 cellspacing=0 align="center">
            <tr style="height: 80px;">
                <td valign="top" id="maintd" class="main_header_print">
                    <div id="logo_container" width="100%">
                        <div class="logo_image_container"><img src="images/logo_48.png" alt="The Bug Genie - Installation"></div>
                        <div class="logo_name_container">
                            <div class="logo_name">The Bug Genie</div>
                            <div class="logo_small"><b>Friendly</b> issue tracking and project management</div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="height: auto; overflow: auto;" valign="top" id="maintd">
                    <div class="print_header_strip" style="text-align: left; padding: 5px;">
                        <?php if ($mode == 'upgrade'): ?>
                            <b style="font-size: 1.2em;">The Bug Genie upgrade</b>
                        <?php endif; ?>
                    </div>
                    <div style="text-align: left; padding: 0px;">
                        <?php if ($mode == 'install'): ?>
                            <div style="text-align: center; width: 100%; margin-top: 5px; font-size: 14px;">
                                <b>Installation progress</b><br>
                                <div class="progress_bar">
                                    <div class="filler" style="width: <?php echo ($step == 6) ? 100 : $step * 15; ?>%;"></div>
                                </div>
                            </div>
                        <?php endif; ?>
