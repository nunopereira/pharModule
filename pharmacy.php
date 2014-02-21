<?php

	class Pharmacy {

		var $pharmId;
		var $name;
		var $address;
		var $zipcode;
		var $districtId;
		var $municipalityId;
		var $parishId;
		var $parishName;
		var $municipalityName;
		var $latitude;
		var $longitude;
		var $service;
		var $phone;

		function getPharmId(){
			return $this->pharmId;
		}
		function getName(){
			return $this->name;
		}
		function getAddress(){
			return $this->address;
		}
		function getPhone(){
			return $this->phone;
		}
		function getZipcode(){
			return $this->zipcode;
		}
		function getDistrictId(){
			return $this->districtId;
		}
		function getMunicipalityId(){
			return $this->municipalityId;
		}
		function getMunicipalityName(){
			return $this->municipalityName;
		}
		function getParishId(){
			return $this->parishId;
		}
		function getParishName(){
			return $this->parishName;
		}
		function getLatitude(){
			return $this->latitude;
		}
		function getLongitude(){
			return $this->longitude;
		}
		function getService(){
			return $this->service;
		}

		function setPharmId($v){
			 $this->pharmId=$v;
		}
		function setName($v){
			$this->name=$v;
		}
		function setAddress($v){
			$this->address=$v;
		}
		function setPhone($v){
			$this->phone=$v;
		}
		function setZipcode($v){
			$this->zipcode=$v;
		}
		function setDistrictId($v){
			$this->districtId=$v;
		}
		function setMunicipalityId($v){
			$this->municipalityId=$v;
		}
		function setParishId($v){
			$this->parishId=$v;
		}
		function setMunicipalityName($v){
			$this->municipalityName=$v;
		}
		function setParishName($v){
			$this->parishName=$v;
		}
		function setLatitude($v){
			$this->latitude=$v;
		}
		function setLongitude($v){
			$this->longitude=$v;
		}
		function setService($v){
			$this->service=$v;
		}

		/*function getPharmacies($postpharm, $postp){
			$urlPharm = 'http://services.sapo.pt/Pharmacy/GetPharmaciesAtServiceByParishId?parishId='.$postp;
                $xmlPharm = new SimpleXMLElement($urlPharm, NULL, TRUE);
                echo $urlPharm;
                  foreach ($xmlPharm->GetPharmaciesAtServiceByParishIdResult->Pharmacies->Pharmacy as $pharm){

                    if ((!empty($postpharm))&&($postpharm==$pharm->Code)){
                      echo '<option selected value="',$pharm->Code,'">',$pharm->Name,'</option><br>';
                    }else{
                      echo '<option value="',$pharm->Code,'">',$pharm->Name,'</option><br>';
                    }
                  } 
		}*/
		function getPharmacies($postpharm, $postp){
			$urlPharm = 'http://services.sapo.pt/GIS/GetPOIByParishIdAndCategoryId?parishId='.$postp.'&categoryId=73';
            $xmlPharm = new SimpleXMLElement($urlPharm, NULL, TRUE);
                  foreach ($xmlPharm->GetPOIByParishIdAndCategoryIdResult->POI as $pharm){

                    if ((!empty($postpharm))&&($postpharm==$pharm->POISourceId)){
                      echo '<option selected value="',$pharm->POISourceId,'">',$pharm->Name,'</option><br>';
                    }else{
                      echo '<option value="',$pharm->POISourceId,'">',$pharm->Name,'</option><br>';
                    }
                  } 
		}

		function getLatitudeByInfo($parId,$pharId){
			$urlPharm = 'http://services.sapo.pt/GIS/GetPOIByParishIdAndCategoryId?parishId='.$parishId.'&categoryId=73';
            $xmlPharm = new SimpleXMLElement($urlPharm, NULL, TRUE);
            foreach ($xmlPharm->GetPOIByParishIdAndCategoryIdResult->POI as $pharm){
            	if($pharm->POISourceId==$pharId){
            		return $pharm->Latitude;
            	}
            }
		}

		function getLongitudeByInfo($parId,$pharId){
			$urlPharm = 'http://services.sapo.pt/GIS/GetPOIByParishIdAndCategoryId?parishId='.$parishId.'&categoryId=73';
            $xmlPharm = new SimpleXMLElement($urlPharm, NULL, TRUE);
            foreach ($xmlPharm->GetPOIByParishIdAndCategoryIdResult->POI as $pharm){
            	if($pharm->POISourceId==$pharId){
            		return $pharm->Longitude;
            	}
            }
		}

		function getLatitudeById(){
			$urlPharm = 'http://services.sapo.pt/GIS/GetPOIByParishIdAndCategoryId?parishId='.$this->parishId.'&categoryId=73';
            $xmlPharm = new SimpleXMLElement($urlPharm, NULL, TRUE);
            foreach ($xmlPharm->GetPOIByParishIdAndCategoryIdResult->POI as $pharm){
            	if($pharm->POISourceId==$this->pharmId){
            		return $pharm->Latitude;
            	}
            }
		}
		function getLongitudeById(){
			$urlPharm = 'http://services.sapo.pt/GIS/GetPOIByParishIdAndCategoryId?parishId='.$this->parishId.'&categoryId=73';
            $xmlPharm = new SimpleXMLElement($urlPharm, NULL, TRUE);
            foreach ($xmlPharm->GetPOIByParishIdAndCategoryIdResult->POI as $pharm){
            	if($pharm->POISourceId==$this->pharmId){
            		return $pharm->Longitude;
            	}
            }
		}

		function setPharmDetails($idPharm, $idParish){
			$urlPharm = 'http://services.sapo.pt/GIS/GetPOIByParishIdAndCategoryId?parishId='.$idParish.'&categoryId=73';
            $xmlPharm = new SimpleXMLElement($urlPharm, NULL, TRUE);
            foreach ($xmlPharm->GetPOIByParishIdAndCategoryIdResult->POI as $pharm){
            	if(intval($pharm->POISourceId)==intval($idPharm)){
            		$this->setParishId($idParish);
//            		echo 'PID ',$this->getParishId(),'<br>';
            		$this->setAddress($pharm->Address);
//            		echo 'PID ',$this->getAddress(),'<br>';
		            $this->setName($pharm->Name);
//		            echo 'PID ',$this->getName(),'<br>';
		            $this->setPharmId($idPharm);
//		            echo 'PID ',$this->getPharmId(),'<br>';
		            $this->setParishName($pharm->Parish);
//		            echo 'PID ',$this->getParishName(),'<br>';
		            $this->setMunicipalityName($pharm->Municipality);
//          		echo 'PID ',$this->getMunicipalityName(),'<br>';
		            $this->setZipcode($pharm->ZipCode);
//		            echo 'PID ',$this->getZipcode(),'<br>';
		            $this->setLongitude($pharm->Longitude);
//		            echo 'PID ',$this->getLongitude(),'<br>';
		            $this->setLatitude($pharm->Latitude);
//		            echo 'PID ',$this->getLatitude(),'<br>';
		        }
			}
		}
		function checkPharmacy($idPharm, $idParish){
			$urlPharm = 'http://services.sapo.pt/Pharmacy/GetPharmaciesAtServiceByParishId?parishId='.$idParish;
            $xmlPharm = new SimpleXMLElement($urlPharm, NULL, TRUE);
            if (intval($xmlPharm->GetPharmaciesAtServiceByParishIdResult->Total)==0){
            	return 0;
            }
            foreach ($xmlPharm->GetPharmaciesAtServiceByParishIdResult->Pharmacies->Pharmacy as $pharm){
            	if(intval($pharm->Code)==intval($idPharm)){
            		return 1;
            	}
            }
            return 0;
		}
		function checkAvailability($idPharm, $idParish){
			$urlPharm = 'http://services.sapo.pt/Pharmacy/GetPharmaciesAtServiceByParishId?parishId='.$idParish;
            $xmlPharm = new SimpleXMLElement($urlPharm, NULL, TRUE);
            foreach ($xmlPharm->GetPharmaciesAtServiceByParishIdResult->Pharmacies->Pharmacy as $pharm){
            	if($pharm->Services->Service->Type=="DISPONIBILIDADE"){
            		return 1;
            	}
            }
            return 0;
		}
		function setServicePharmDetails($idPharm, $idParish){
			$urlPharm = 'http://services.sapo.pt/Pharmacy/GetPharmaciesAtServiceByParishId?parishId='.$idParish;
            $xmlPharm = new SimpleXMLElement($urlPharm, NULL, TRUE);
            echo $urlPharm,'<br>';
            foreach ($xmlPharm->GetPharmaciesAtServiceByParishIdResult->Pharmacies->Pharmacy as $pharm){
            	if(intval($pharm->Code)==intval($idPharm)){
		            $this->setName($pharm->Name);
		                        		                //echo 'PID ',$this->getName(),'<br>';
            		$this->setAddress($pharm->Address->Street);
            		                					//echo 'PID ',$this->getAddress(),'<br>';
		            $this->setZipcode($pharm->Address->ZipCode);
		                        		                //echo 'PID ',$this->getZipcode(),'<br>';
		            $this->setParishName($pharm->Address->Parish);
		                        		                //echo 'PID ',$this->getParishName(),'<br>';
		            $this->setMunicipalityName($pharm->Address->Municipality);
          		                					//echo 'PID ',$this->getMunicipalityName(),'<br>';
		            $this->setPhone($pharm->Phone);
          		                					//echo 'PID ',$this->getPhone(),'<br>';
		            $this->setLatitude($pharm->Address->Coordinates->Latitude);
		                        		                //echo 'PID ',$this->getLatitude(),'<br>';
		            $this->setLongitude($pharm->Address->Coordinates->Longitude);
		                        		                //echo 'PID ',$this->getLongitude(),'<br>';
	            	if($pharm->Services->Service->Type=="DISPONIBILIDADE"){
	            		$this->setService(1);
	            	} else {
	            		$this->setService(0);
	            	}
		        }
			}
		}

	}
?>