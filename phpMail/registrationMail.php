<?php
header("Content-Type: application/json"); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';  // vendor folder से autoload
function sendRegistrationMail($email, $name, $reg_no, $class) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mdashraf9135@gmail.com';   
        $mail->Password   = 'wdpefvmipogayxhy';   
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        
        $mail->setFrom('akhileshsingh90068@gmail.com', "RN MISSION PUBLIC SCHOOL");
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = "Registration Successful - Reg No: $reg_no";
        $mail->Body    = "
            Dear <span style='text-transform: uppercase;'>$name</span>,<br><br>
            ✅ Registration Completed Successfully.<br>
            Registration No: <b>$reg_no</b><br>
            Class: <b>$class</b><br><br>
            Regards,<br>
            <strong>
                <b>RN MISSION PUBLIC SCHOOL.</b><br>
            </strong>
            <span>Address : Mujauna bazar,Parsa( Saran ).</span> <br>
            <span>Mobile : +91- 9006861511, +91-6201675471</span>
            ";
        $mail->send();
        return [
            "success" => true,
            "message" => "Mail sent successfully"
        ];
    } catch (Exception $e) {
        return [
            "success" => false,
            "message" => "Mailer Error: ".$mail->ErrorInfo
        ];
    }
}
