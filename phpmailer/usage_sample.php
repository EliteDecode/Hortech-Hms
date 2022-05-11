<?php

    //IMPORTING MAIL CLASS
    require 'sendmail.php';

    $mailer = new SendMail();

    $message = "<div style='display: block; margin: 10px auto; width: 90%; font-family: arial; color: #223b45; text-align: center;'>
        <img src='https://images.unsplash.com/photo-1591154669695-5f2a8d20c089?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8M3x8dXJsfGVufDB8fDB8fA%3D%3D&auto=format&fit=crop&w=500&q=60' />
        <div style='background: #fafafa; border-radius: 5px; margin: 10px 0; padding: 20px;'>
            <h3 style='font-family: arial; font-weight: 300'>Hi ,</h3>
            <p style='font-weight: 100;'>Here is the confirmation code for eFinance account:</p>
            <h1 style='font-size: 36px'> HIOHN </h1>
            <p style='font-weight: 100; font-size: 15px'>Please, return to the verification page and insert the code above to verify your account.</p>
            <i style='color: #f0434c; font-size: 12px; font-weight: 100; line-height: 0;'>This One Time Passcode Expires. if not attended to within 2hours.</i>
        </div>
        <h4 style='font-family: arial; font-weight: 100; text-align:center; font-size: 12px; '>Copyright &copy; <a href='https://demo.fybomidetravel.com' target='_blank'>App Name.</a> All rights reserved.</h4>
    </div>";

    $mailer->send_mail('ehiosunbishop@gmail.com', 'Bishop', 'Ehiosun', 'Send Me Money!!😁', $message);

?>