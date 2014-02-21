<?php
	include 'pharmacy.php';

	$pharm = new Pharmacy;
	$teste = array();

	//$content="DIRECT--------\nDistrictID: ".$_POST['selDist']."\nMunicipalityID: ".$_POST['selMun']."\nParishID: ".$_POST['selPar']."\nPharmacyID: ".;

	$pharm->setPharmDetails($_POST['selPharm'],$_POST['selPar']);
	$lat = $pharm->getLatitude();
	$long = $pharm->getLongitude();
	
	$i=0;
	$url = 'http://services.sapo.pt/GIS/GetPOIByCoordinatesAndCategoryId?latitude='.$lat.'&longitude='.$long.'&radius='.$_POST['radious'].'&categoryId=73';
	$xmlPharm = new SimpleXMLElement($url, NULL, TRUE);
    foreach ($xmlPharm->GetPOIByCoordinatesAndCategoryIdResult->POI as $phar){
    	if(intval($phar->POISourceId)!=intval($_POST['selPharm'])){
			$pharmacy = new Pharmacy;
			if ($pharmacy->checkPharmacy($phar->POISourceId,$phar->ParishId)==1){
				if(isset($_POST['cbAva'])){
					if($pharmacy->checkAvailability($phar->POISourceId,$phar->ParishId)==1){
						$pharmacy->setServicePharmDetails($phar->POISourceId,$phar->ParishId);
			    		$teste[$i]=$pharmacy;
			    		$i++;
					}
				}else{
					if($pharmacy->checkAvailability($phar->POISourceId,$phar->ParishId)==0){
						$pharmacy->setServicePharmDetails($phar->POISourceId,$phar->ParishId);
			    		$teste[$i]=$pharmacy;
			    		$i++;
					}
				}
	    	}
	    }
    }
    $i--;
    $content="";
	while($i>=0){
		$content.=$teste[$i]->getName()."|".
			$teste[$i]->getAddress()."|".
			$teste[$i]->getZipcode()."|".
			$teste[$i]->getParishName()."|".
			$teste[$i]->getMunicipalityName()."|".
			$teste[$i]->getPhone()."|".
			$teste[$i]->getLatitude()."|".
			$teste[$i]->getLongitude()."|".
			$teste[$i]->getService()."\n";
			echo $content;
			$i--;
	}

	if(isset($_POST['cbMap'])){
		$content .="TRUE|";
	} else {
		$content .="FALSE|";
	}
	if(isset($_POST['cbAva'])){
		$content .="TRUE|";
	} else {
		$content .="FALSE|";
	}
	$content .=$lat.'|';
	$content .=$long;
	
	/*
	function refreshFile($idPharm,$idParish,$radious,$m,$av){
		$teste = array();
		$pharm = new Pharmacy;
		$pharm->setPharmDetails($idPharm,$idParish);
		$lat = $pharm->getLatitude();
		$long = $pharm->getLongitude();
		$i=0;
		$url = 'http://services.sapo.pt/GIS/GetPOIByCoordinatesAndCategoryId?latitude='.$lat.'&longitude='.$long.'&radius='.$radious.'&categoryId=73';
		$xmlPharm = new SimpleXMLElement($url, NULL, TRUE);
	    echo $url,'<br>';
	    foreach ($xmlPharm->GetPOIByCoordinatesAndCategoryIdResult->POI as $phar){
	    	if(intval($phar->POISourceId)!=intval($idPharm){
				$pharmacy = new Pharmacy;
				if ($pharmacy->checkPharmacy($phar->POISourceId,$phar->ParishId)==1){
		    		$pharmacy->setServicePharmDetails($phar->POISourceId,$phar->ParishId);
		    		$teste[$i]=$pharmacy;
		    		$i++;
		    	}
		    }
	    }
	    $i--;
	    $content="";
		while($i>=0){
			$content.=$teste[$i]->getName()."|".
				$teste[$i]->getAddress()."|".
				$teste[$i]->getZipcode()."|".
				$teste[$i]->getParishName()."|".
				$teste[$i]->getMunicipalityName()."|".
				$teste[$i]->getPhone()."|".
				$teste[$i]->getLatitude()."|".
				$teste[$i]->getLongitude()."\n";
				echo $content;
				$i--;
		}

		if($m==1){
			$content .="TRUE|";
		} else {
			$content .="FALSE|";
		}
		if($av==1{
			$content .="TRUE|";
		} else {
			$content .="FALSE|";
		}
		$content .=$lat.'|';
		$content .=$long;
	}
/*
	if(!($_POST['refTime']=="")){
		$content .=$_POST['refTime']."|";
	} else {
		$content .="FALSE"."|";
	}*/
//}


//echo $data;
$fp = fopen("data/data.db","wb");
if( $fp == false ){
    //do debugging or logging here
}else{
    fwrite($fp,$content);
    fclose($fp);
}

?>