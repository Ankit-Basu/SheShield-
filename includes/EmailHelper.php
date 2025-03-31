<?php
require_once __DIR__ . '/../PHPMailer/Exception.php';
require_once __DIR__ . '/../PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/SMTP.php';

// Load email configuration if file exists
if (file_exists(__DIR__ . '/../config/email_config.php')) {
    require_once __DIR__ . '/../config/email_config.php';
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailHelper {
    private $mail;
    private $defaultFromEmail;
    private $defaultFromName;

    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->defaultFromEmail = defined('DEFAULT_FROM_EMAIL') ? DEFAULT_FROM_EMAIL : '';
        $this->defaultFromName = defined('DEFAULT_FROM_NAME') ? DEFAULT_FROM_NAME : 'SheShield';
        $this->setupMailer();
    }

    private function setupMailer() {
        try {
            $this->mail->isSMTP();
            $this->mail->Host = defined('SMTP_HOST') ? SMTP_HOST : 'smtp.gmail.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = defined('SMTP_USERNAME') ? SMTP_USERNAME : '';
            $this->mail->Password = defined('SMTP_PASSWORD') ? SMTP_PASSWORD : '';
            $this->mail->SMTPSecure = defined('SMTP_ENCRYPTION') && SMTP_ENCRYPTION === 'tls' ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS;
            $this->mail->Port = defined('SMTP_PORT') ? SMTP_PORT : 465;
            $this->mail->isHTML(true);
            $this->mail->setFrom($this->defaultFromEmail, $this->defaultFromName);
        } catch (Exception $e) {
            throw new Exception("Mailer setup failed: " . $e->getMessage());
        }
    }

    public function sendVolunteerRegistrationEmail($volunteerEmail, $volunteerName) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($volunteerEmail, $volunteerName);
            
            $this->mail->Subject = 'Welcome to SheShield - Volunteer Registration';
            $this->mail->Body = $this->getVolunteerWelcomeTemplate($volunteerName);
            
            return $this->mail->send();
        } catch (Exception $e) {
            error_log("Failed to send volunteer registration email: " . $e->getMessage());
            throw new Exception("Failed to send volunteer registration email: " . $e->getMessage());
        }
    }

    public function sendIncidentReport($reportDetails) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($this->defaultFromEmail, 'SheShield Admin');
            
            $this->mail->Subject = 'New Incident Report Submitted';
            $this->mail->Body = $this->getIncidentReportTemplate($reportDetails);
            
            return $this->mail->send();
        } catch (Exception $e) {
            throw new Exception("Failed to send incident report email: " . $e->getMessage());
        }
    }

    public function sendWalkRequestEmail($escortEmail, $escortName, $details) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($escortEmail, $escortName);
            
            $this->mail->Subject = 'New Walk Request - SheShield';
            $this->mail->Body = $this->getWalkRequestTemplate($escortName, $details);
            
            return $this->mail->send();
        } catch (Exception $e) {
            error_log("Failed to send walk request email: " . $e->getMessage());
            throw new Exception("Failed to send walk request email: " . $e->getMessage());
        }
    }

    private function getVolunteerWelcomeTemplate($volunteerName) {
        return "
            <html>
            <body style='font-family: Arial, sans-serif;'>
                <h2>Welcome to SheShield!</h2>
                <p>Dear {$volunteerName},</p>
                <p>Thank you for registering as a volunteer with SheShield. Your commitment to helping others is greatly appreciated.</p>
                <p>As a volunteer, you will have access to:</p>
                <ul>
                    <li>Incident reports in your area</li>
                    <li>Emergency alerts</li>
                    <li>Training resources</li>
                    <li>Support network</li>
                </ul>
                <p>Please complete your profile and training modules to start helping others.</p>
                <p>Best regards,<br>The SheShield Team</p>
            </body>
            </html>
        ";
    }

    private function getIncidentReportTemplate($details) {
        return "
            <html>
            <body style='font-family: Arial, sans-serif;'>
                <h2>New Incident Report</h2>
                <div style='background: #f5f5f5; padding: 15px; border-radius: 5px;'>
                    <p><strong>Incident Type:</strong> {$details['type']}</p>
                    <p><strong>Location:</strong> {$details['location']}</p>
                    <p><strong>Date/Time:</strong> {$details['datetime']}</p>
                    <p><strong>Description:</strong> {$details['description']}</p>
                </div>
                <p>Please review and take appropriate action.</p>
            </body>
            </html>
        ";
    }

    private function getWalkRequestTemplate($escortName, $details) {
        return "
            <html>
            <body style='font-family: Arial, sans-serif;'>
                <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
                    <h2 style='color: #d946ef;'>New Walk Request</h2>
                    <p>Hello {$escortName},</p>
                    <p>You have received a new walk request with the following details:</p>
                    
                    <div style='background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;'>
                        <p><strong>Walk ID:</strong> {$details['walkId']}</p>
                        <p><strong>Pickup Location:</strong> {$details['pickupLocation']}</p>
                        <p><strong>Destination:</strong> {$details['destination']}</p>
                        <p><strong>Request Time:</strong> {$details['requestTime']}</p>
                    </div>
                    
                    <p>Please respond to this request as soon as possible through your SheShield dashboard.</p>
                    
                    <div style='margin-top: 30px;'>
                        <p>Best regards,<br>SheShield Team</p>
                    </div>
                </div>
            </body>
            </html>
        ";
    }
}
