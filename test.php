<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pharmacies</title>
    <?php 
        include 'district.php';
        include 'municipality.php';
        include 'parish.php';
        include 'pharmacy.php';
        $dis = new District;
        $mun = new Municipality;
        $par = new Parish;
        $pharm = new Pharmacy;
    ?>
    <!-- Bootstrap -->
    <style rel="stylesheet" type="text/css">
        div.menu{-webkit-border-radius:15px;-moz-border-radius:15px;-ms-border-radius:15px;-o-border-radius:15px;border-radius:15px;display:block;padding:25px;margin:0 auto;width:300px;background:rgba(255,255,255,.65)}
    </style>
    <link href="css/bootstrap.css" rel="stylesheet">
    <script type="text/javascript">
      function save(){
          alert('v3');
          $("#form").submit();
          $.ajax({
            url: 'save_config.php',
            type: 'POST',
            data: $("#form").serialize(),
            success:function(response){
                alert('Success');
            }
          });
         e.preventDefault();
    }
    </script>

  </head>


  <body style="background: url('background.jpg') no-repeat fixed center center / cover transparent;">
    <br><br><br>
    <div style="display: table; height: 90%; overflow: hidden; width: 100%;">
      <div style="display: table-cell; vertical-align: middle;">
        <div class="menu" style="margin-top:auto; margin-button:auto;">
              <h4>Districts</h4>
                <form  method="post" id="form" action=<?php echo $_SERVER['PHP_SELF']; ?> >
                    <select id="selDist" name="selDist" class="form-control" onchange="this.form.submit();">
                      <option>Select your district</option>
                  	  <?php
                        $dis->getDistricts($_POST['selDist']);
                  	  ?>
                	 </select>
              <h4>Municipalities</h4>
                <select id="selMun" name="selMun" class="form-control" onchange="this.form.submit();">
                    <option>Select your Municipality</option>

                  <?php
                        
                        $mun->getMunicipalities($_POST['selMun'],$_POST['selDist'])
                    ?>
                </select>

               <h4>Parishes</h4>
              <select id="selPar" name="selPar" class="form-control" onchange="this.form.submit();">
                   <option>Select your Parish</option>

                      <?php
                            $par->getParishes($_POST['selPar'],$_POST['selMun']);

                        ?>
              </select>

               <h4>Pharmacy</h4>
              <select id="selPar" name="selPharm" class="form-control" onchange="this.form.submit();">
                <option>Select your Pharmacy</option>
                      <?php
                            $pharm->getPharmacies($_POST['selPharm'],$_POST['selPar']);
                            echo 'ESTOU AQUI ',$_POST['selPharm'];
                      ?>
              </select>

              <h4>Refresh Time</h4>
              <input  type="number" class="form-control" name="refTime" id="refTime" placeholder="Time in hours">
              <h4>Distance</h4>
              <input  type="number" class="form-control" name="radious" id="radious" placeholder="Distance in Meters">
              <div class="checkbox">
                  <label class="checkbox">
                    <input type="checkbox" id="cbMap" name="cbMap" value="cbMap"> Show Map
                  </label><br>
                  <label class="checkbox">
                    <input type="checkbox" id="cbAva" name="cbAva" value="cbAva"> Show Availability
                  </label><br>
              </div><center>

              <button id="bSave" onclick="save()" type="button" value="save" class="btn btn-success btn-xn">Save Configuration</button></center>
            </form>
        </div>
        </div>
        </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    
  </body>
</html>
