<?php
include("config.php");
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];

    // Security: Prevent SQL injection
    $id = mysqli_real_escape_string($db, $id);
    
    // Get feedback data
    $sql = "SELECT * FROM feedback1 WHERE ID = '$id'";
    $query = mysqli_query($db, $sql);
    
    if (!$query) {
        die("Database error: " . mysqli_error($db));
    }
    
    $feedback = mysqli_fetch_assoc($query);

    if ($feedback) {
        $mail = new PHPMailer(true);
        
        try {
            // Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF; // Change to DEBUG_SERVER for troubleshooting
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'aryamahesa74@gmail.com';
            $mail->Password   = 'vijmlwwjxabfygen';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            
            // Important email headers
            $mail->Priority = 1; // High priority
            $mail->addCustomHeader('X-Mailer: PHP/' . phpversion());
            $mail->addCustomHeader('X-Priority: 1');
            $mail->addCustomHeader('X-MSMail-Priority: High');
            
            // Recipients
            $mail->setFrom('aryamahesa74@gmail.com', 'RB Feedback system');
            $mail->addAddress($feedback['email'], $feedback['nama']);
            $mail->addReplyTo('noreply@yourdomain.com', 'No Reply');
            
          // Content
$mail->isHTML(true);
$mail->Subject = "Konfirmasi Penerimaan Feedback - " . htmlspecialchars($feedback['nama']);

// HTML Version
$mail->Body = "
<!DOCTYPE html>
<html>
<head>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            line-height: 1.6; 
            color: #333333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .email-header {
            background-color: #A98467;
            color: #ffffff;
            padding: 25px 30px;
            text-align: center;
        }
        .email-body {
            padding: 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #444444;
        }
        .content-block {
            margin-bottom: 25px;
        }
        .feedback-container {
            background-color: #FAF3E0;
            border-left: 4px solid #C8B6A6;
            padding: 18px;
            margin: 25px 0;
            border-radius: 0 4px 4px 0;
        }
        .feedback-label {
            font-weight: 600;
            color: #A98467;
            margin-bottom: 8px;
            display: block;
        }
        .feedback-content {
            font-style: italic;
            line-height: 1.7;
        }
        .signature {
            margin-top: 30px;
            border-top: 1px solid #eeeeee;
            padding-top: 20px;
        }
        .footer {
            font-size: 12px;
            color: #999999;
            text-align: center;
            padding: 15px;
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class='email-container'>
        <div class='email-header'>
            <h2>Terima Kasih Atas Masukan Anda</h2>
        </div>
        
        <div class='email-body'>
            <div class='greeting'>
                <p>Halo <strong>".htmlspecialchars($feedback['nama'])."</strong>,</p>
            </div>
            
            <div class='content-block'>
                <p>Kami sangat menghargai waktu yang Anda luangkan untuk memberikan masukan berharga kepada kami. Feedback dari pengguna seperti Anda membantu kami terus berkembang dan meningkatkan kualitas layanan.</p>
            </div>
            
            <div class='feedback-container'>
                <span class='feedback-label'>FEEDBACK ANDA:</span>
                <div class='feedback-content'>
                    <p>".nl2br(htmlspecialchars($feedback['feedback']))."</p>
                </div>
            </div>
            
            <div class='content-block'>
                <p>Tim kami telah menerima dan akan meninjau masukan Anda dengan seksama. Setiap saran yang membangun sangat berarti bagi perkembangan produk kami.</p>
                
                <p>Jika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami melalui email resmi kami.</p>
            </div>
            
            <div class='signature'>
                <p>Salam hormat,</p>
                <p><strong>Tim Customer Experience</strong></p>
                <p>Nama Perusahaan Anda</p>
            </div>
        </div>
        
        <div class='footer'>
            <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
            <p>&copy; ".date('Y')." Nama Perusahaan Anda. All rights reserved.</p>
        </div>
    </div>
</body>
</html>";

// Plain text version
$mail->AltBody = "Terima Kasih Atas Masukan Anda\n\n".
"Halo ".$feedback['nama'].",\n\n".
"Kami sangat menghargai waktu yang Anda luangkan untuk memberikan masukan berharga kepada kami. Feedback dari pengguna seperti Anda membantu kami terus berkembang dan meningkatkan kualitas layanan.\n\n".
"---\nFEEDBACK ANDA:\n".
$feedback['feedback']."\n".
"---\n\n".
"Tim kami telah menerima dan akan meninjau masukan Anda dengan seksama. Setiap saran yang membangun sangat berarti bagi perkembangan produk kami.\n\n".
"Jika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami melalui email resmi kami.\n\n".
"Salam hormat,\n".
"Tim Customer Experience\n".
"Nama Perusahaan Anda\n\n".
"---\n".
"Email ini dikirim secara otomatis. Mohon tidak membalas email ini.\n".
"© ".date('Y')." Nama Perusahaan Anda. All rights reserved.";
            
            // Verify email address before sending
            if (!$mail->validateAddress($feedback['email'])) {
                throw new Exception("Email address {$feedback['email']} is invalid");
            }
            
            $mail->send();
            
            // Log successful delivery
            file_put_contents('email_log.txt', date('Y-m-d H:i:s') . " - Email sent to {$feedback['email']}\n", FILE_APPEND);
            
            echo "<script>
                alert('Email balasan telah berhasil dikirim!');
                window.location.href='form-admin.php';
            </script>";
            
        } catch (Exception $e) {
            // Log the error
            $error_msg = date('Y-m-d H:i:s') . " - Error sending to {$feedback['email']}: " . $e->getMessage() . "\n";
            file_put_contents('email_errors.log', $error_msg, FILE_APPEND);
            
            echo "<script>
                alert('Gagal mengirim email. Silakan coba lagi atau hubungi administrator.\\nError: " . addslashes($e->getMessage()) . "');
                window.location.href='form-admin.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Data feedback tidak ditemukan.');
            window.location.href='form-admin.php';
        </script>";
    }
} else {
    echo "<script>
        alert('ID feedback tidak valid.');
        window.location.href='form-admin.php';
    </script>";
}
?>