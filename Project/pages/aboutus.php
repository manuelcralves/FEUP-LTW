<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../templates/header.tpl.php');
require_once(__DIR__ . '/../templates/footer.tpl.php');
require_once(__DIR__ . '/../utils/init.php');

  if(!isset($_SESSION['username'])){
    header("Location:/index.php");
  }

  function drawAboutUs() {
    echo "<h1>About Our Company</h1>";
    echo "<p>Welcome to HelpDesk, our trouble tickets website. We are a team of experienced professionals who are dedicated to providing the best possible customer support experience for businesses of all sizes. Our mission is to help you resolve your technical issues as quickly and efficiently as possible.</p>";
    
    echo "<h2>Our Team</h2>";
    echo "<p>Our team is made up of experts in a wide range of technical fields and we pride ourselves on our professionalism, expertise, and customer service. Our team is available 24/7 to provide support and assistance whenever you need it.</p>";
    
    echo "<h2>Get in Touch</h2>";
    echo "<p>If you're interested in learning more about our services or would like to speak with one of our technical experts, please don't hesitate to contact us. We're always happy to answer any questions you may have and help you find the right solutions for your business.</p>";
    echo "<p>Thank you for considering our company for your technical needs. We look forward to working with you!</p>";
  }

  drawHeader();
  
  drawAboutUs();
  
  drawFooter();
?>



