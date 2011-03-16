<?php  
class MailerComponent extends Object 
{ 

var $to              = array(); 
var $from            = 'info@strutstuff.co.za'; 
var $fromname        = 'Strutstuff.co.za'; 
var $Subject         = null; 
var $Message         = null; 

function socketmail() { 

        ini_set("smtp_port", "587");  // Optional 
       //ini_set("SMTP", "smtp.yoursite.com"); // Optional 

        ini_set("sendmail_from", $this->from); 

        $connect = fsockopen(ini_get("SMTP"), ini_get("smtp_port"), $errno, $errstr, 30) or die("Could not talk to the sendmail server!");

        $rcv = fgets($connect, 1024); 

      fputs($connect, "HELO {$_SERVER['SERVER_NAME']}\r\n"); 
       
        $rcv .= fgets($connect, 1024); 

  while (list($toKey, $toValue) = each($this->to)) { 

      fputs($connect, "MAIL FROM:$this->from\r\n"); 

        $rcv = fgets($connect, 1024); 

      fputs($connect, "RCPT TO:$toValue\r\n"); 
        $rcv .= fgets($connect, 1024); 

      fputs($connect, "DATA\r\n"); 
        $rcv .= fgets($connect, 1024); 

           
   fputs($connect, "Subject: $this->Subject\r\n"); 
   fputs($connect, "From: $this->fromname <$this->from>\r\n"); 
   fputs($connect, "To: $toKey  <".$toValue.">\r\n"); 
   fputs($connect, "X-Sender: <$this->from>\r\n"); 
   fputs($connect, "Return-Path: <$this->from>\r\n"); 
   fputs($connect, "Errors-To: <$this->from>\r\n"); 
   fputs($connect, "X-Mailer: PHP\r\n"); 
   fputs($connect, "X-Priority: 3\r\n"); 
   fputs($connect, "Content-Type: text/plain; charset=iso-8859-1\r\n"); 
   fputs($connect, "\r\n"); 
   fputs($connect, stripslashes($this->Message)." \r\n"); 
   fputs($connect, ".\r\n"); 

     $rcv .= fgets($connect, 1024); 

   fputs($connect, "RSET\r\n"); 
     $rcv .= fgets($connect, 1024); 


  } 

   fputs ($connect, "QUIT\r\n"); 
     $rcv .= fgets ($connect, 1024); 

   fclose($connect); 
   ini_restore("sendmail_from"); 

    } 

function AddAddress($name = "",$address ) { 

        $cur = count($this->to); 
        $this->to["$name"] = trim($address); 

    } 

} 
?>