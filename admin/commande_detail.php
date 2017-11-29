<?php 
require_once('verifier_access.php'); 

@$id = $_GET['id'];

  require_once("../classes/Produit.php");
  require_once("../classes/Produit_Commande.php");
  require_once("../classes/Commande.php");
  //$prod= new Produit();
  //$prod = $prod->details($id);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Gestion des produits</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width">

  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/main.css">

  <link rel="stylesheet" type="text/css" href="bootstrap-wysihtml5/lib/css/bootstrap.min.css"></link>
  <link rel="stylesheet" type="text/css" href="bootstrap-wysihtml5/lib/css/prettify.css"></link>
  <link rel="stylesheet" type="text/css" href="bootstrap-wysihtml5/src/bootstrap-wysihtml5.css"></link>
  <style>input, textarea, select, .uneditable-input{height:auto;}#loadimg{display:none;}</style> 
  <style type="text/css">
.table { 
    border-collapse: collapse; 
    margin:30px auto;
    }

.th { 
    background: #3498db; 
    color: white; 
    font-weight: bold; 
    }
.td, .th { 
    padding: 10px; 
    border: 1px solid #ccc; 
    text-align: left; 
    font-size: 18px;
    }
</style>     
</head>
<body>

  <?php require_once('header.php'); ?>
<br>
  <div class="container2">
   <center> <h1>Détail Commande :</h1></center>
  </div>

  <div class="container2">

   <div class="clear"><p>&nbsp;</p></div>
   <div id="resultat-bien"></div>
   <form id="form_bien" class="form_valid" method="POST" action="imprimer.php" enctype="multipart/form-data">
    <table class="table table-striped">   
      <?php $cat = new Commande(); 
          $liste = $cat->liste();
          foreach($liste as $data )
          {
            if($data->_id==$id){
            ?>
        <tr>
        <th>
          Date Commande :<span style="color:red;"></span>            
        </th>
            <td><?php echo $data->_date_c; ?></td>
        </tr>
       <tr>
        <th>
          id Commande :<span style="color:red;"></span>            
        </th>
            <td><?php echo $data->_id; ?></td>
        </tr>
        <tr>
        <th>
          Nom et Prénom :<span style="color:red;"></span>            
        </th>
            <td><?php echo $data->_nom; ?></td>
        </tr>
        <tr>
        <th>
          Email :<span style="color:red;"></span>            
        </th>
            <td><?php echo $data->_email; ?></td>
        </tr>
        <tr>
        <th>
          Adresse :<span style="color:red;"></span>            
        </th>
            <td><?php echo $data->_adress; ?></td>
       </tr>
     </table>
     <br>
      <table  class="table">   
<tr class="tr">
  <th class="th">Liste des Produit :</th>
  <th class="th">Qte :</th>
  <th class="th">Prix :</th>
</tr>

<tr> 
      <td class="td">
              <?php
              $pc=new Produit_Commande();
              $lpc=$pc->liste();
              foreach ($lpc as $ke) {
                if ($data->_id==$ke->_id_com) {
                  $p=new Produit();
                  $lp=$p->liste();
                 foreach ($lp as $value) {
                  if ($ke->_id_prod==$value->_id) {
                    echo $value->_libelle."<br>";
                  }
                 }
                }
              }
              ?>
      </td>
      <td class="td">
        <?php
              $pc=new Produit_Commande();
              $lpc=$pc->liste();
              foreach ($lpc as $ke) {
                if ($data->_id==$ke->_id_com) {
                  $p=new Produit();
                  $lp=$p->liste();
                 foreach ($lp as $value) {
                  if ($ke->_id_prod==$value->_id) {
                    echo $ke->_qte."<br>";
                  }
                 }
                }
              }
              ?></td>
      <td class="td">
        <?php
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
                    echo $prix."TND<br>";
                    $t+=$prix;
                  }
                 }
                }
              }
              ?>
            </td>
</tr>
<tr class="tr"><td class="td"></td><td class="td"></td><td class="td"> <?php echo "<b>HT : ".$t."TND </b>"; ?></td></tr>
<tr class="tr"><td class="td"></td><td class="td"></td><td class="td"> <?php echo "<b>Tva : ".($t*10/100)."DTN </b>"; ?></td></tr>
<tr class="tr"><td class="td"></td><td class="td"></td><td class="td"> <?php echo "<b>Totale : ".($t+($t*10/100))."DTN </b>"; ?></td></tr>
<?php  }} ?>

     </table>
     <br>
     <center> 
     <a class="btn btn-primary" href="commande_liste.php">
                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>  Retourner
     </a>
     </center>
     <div id="loadimg"><img src="../images/loading.gif" width="25" height="25" /></div>
   </form>

 </div>

 <hr>

 <script src="js/jquery.min.js"></script>
 <script src="js/bootstrap.js"></script>
 <script src="js/bootstrap.validate.js"></script>
 <script src="js/bootstrap.validate.en.js"></script>
 <script type="text/javascript" src="js/jquery.form.js"></script>

 <script src="bootstrap-wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
 <script src="bootstrap-wysihtml5/lib/js/prettify.js"></script>
 <script src="bootstrap-wysihtml5/src/bootstrap-wysihtml5.js"></script>

 <script>
   $('.textarea').wysihtml5();
   $(prettyPrint);

   function confirmDelete(delUrl) {
    if (confirm("Voulez vous vraiment supprimer ce Partenaire ?")) {
     document.location = delUrl;
   }
 }
</script>

</body>
</html>