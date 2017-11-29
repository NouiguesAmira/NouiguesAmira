<?php
require "vendor/autoload.php";
// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

require_once('verifier_access.php'); 

@$id = $_GET["id"];

  require_once("../classes/Produit.php");
  require_once("../classes/Produit_Commande.php");
  require_once("../classes/Commande.php");
$x='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Commande</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width">

  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/main.css">

  <link rel="stylesheet" type="text/css" href="bootstrap-wysihtml5/lib/css/bootstrap.min.css"></link>
  <link rel="stylesheet" type="text/css" href="bootstrap-wysihtml5/lib/css/prettify.css"></link>
  <link rel="stylesheet" type="text/css" href="bootstrap-wysihtml5/src/bootstrap-wysihtml5.css"></link>
  <style>input, textarea, select, .uneditable-input{height:auto;}#loadimg{display:none;}</style>      
</head>
<body>
   <center> <h1> Commande :</h1></center>


   <div class="clear"><p>&nbsp;</p></div>
   <div id="resultat-bien"></div>
   <form id="form_bien" class="form_valid" method="POST" action="imprimer.php" enctype="multipart/form-data">
    <table class="table table-striped">  '; 
      $cat = new Commande(); 
      $liste = $cat->liste();
      foreach($liste as $data )
      {
      if($data->_id==$id){
      $x='<tr>
        <th>
          Date Commande :            
        </th>
            <td>';
            $x=$x. "$data->_date_c";

      $x1=' </td>
        </tr><tr>
        <th>
          id Commande :<span style="color:red;"></span>            
        </th>
            <td>';
            $x2=$x.$x1." $data->_id".'</td>
        </tr>
        <tr>
        <th>
          Nom et Prénom :<span style="color:red;"></span>            
        </th>
            <td>'." $data->_nom".'</td>
        </tr>
        <tr>
        <th>
          Email :<span style="color:red;"></span>            
        </th>
            <td>'."$data->_email".'</td>
        </tr>
        <tr>
        <th>
          Adresse :<span style="color:red;"></span>            
        </th>
            <td>'." $data->_adress".'</td>
       </tr>
     </table>
     <br>
     <table  border="1" cellpadding="10" cellspacing="1" width="100%">   
<tr>
  <th>Liste des Produit :</th>
  <th>Qte :</th>
  <th>Prix :</th>
</tr>

<tr> ';
      $x3='<td>';
              
              $pc=new Produit_Commande();
              $lpc=$pc->liste();
              foreach ($lpc as $ke) {
                if ($data->_id==$ke->_id_com) {
                  $p=new Produit();
                  $lp=$p->liste();
                 foreach ($lp as $value) {
                  if ($ke->_id_prod==$value->_id) {

                  $x3=$x3.$value->_libelle."<br>";
                  }
                 }
                }
              }
              
     $x3=$x3.' </td>';
     $x4=$x2.$x3;
      $x5='<td>';
       
              $pc=new Produit_Commande();
              $lpc=$pc->liste();
              foreach ($lpc as $ke) {
                if ($data->_id==$ke->_id_com) {
                  $p=new Produit();
                  $lp=$p->liste();
                 foreach ($lp as $value) {
                  if ($ke->_id_prod==$value->_id) {
             
              $x5=$x5.$ke->_qte."<br>";
            }
            }
            }
            }
            $x5=$x5.'</td>';
            $x6=$x4.$x5;
      $x7='<td>';
        
            $t=0;
              $pc=new Produit_Commande();
              $lpc=$pc->liste();
              foreach ($lpc as $ke) {
                if ($data->_id==$ke->_id_com) {
                  $p=new Produit();
                  $lp=$p->liste();
                 foreach ($lp as $value) {
                  if ($ke->_id_prod==$value->_id) {
                    $prix=$ke->_prix;
                    $x7=$x7.$prix." TND<br>";
                    $t+=$prix;
                  }
                 }
                }
              }
              
            $x7=$x7.'</td>';
$x8=$x6.$x7.'</tr>
<tr><td></td><td></td><td><b>HT : '.$t.'TND </b></td></tr>
<tr><td></td><td></td><td> <b>Tva : '.($t*10/100).' TND </b></td></tr>
<tr><td></td><td></td><td><b>Totale : '.($t+($t*10/100)).' TND </b></td></tr>';
  }} 

    $x9=$x8.' </table>
     <div id="loadimg"><img src="../images/loading.gif" width="25" height="25" /></div>
   </form>


 <hr>

 <script src="js/jquery.min.js"></script>

</body>
</html>';
$dompdf->loadHtml($x9);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();

?>
