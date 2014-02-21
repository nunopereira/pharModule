<?php

	class Municipality {

		var $municipalityId;
		var $municipalityName;
		

		function getMunicipalityId(){
			return $municipalityId;
		}
		function getMunicipalityName(){
			return $municipalityName;
		}
		

		function setMunicipalityId($v){
			 $municipalityId=$v;
		}
		function setMunicipalityName($v){
			$municipalityName=$v;
		}
		
		function getMunicipalities($postm,$postd){
			$urlM = "http://services.sapo.pt/GIS/GetMunicipalitiesByDistrictIdSortedById?districtId=".$postd;
            $xmlM = new SimpleXMLElement($urlM, NULL, TRUE);
            foreach ($xmlM->GetMunicipalitiesByDistrictIdSortedByIdResult->Municipality as $mun){
               if (!empty($postm)&&($postm==$mun->MunicipalityId)){
                  echo '<option selected value="',$mun->MunicipalityId,'">',$mun->MunicipalityName,'</option><br>';
                }else{
                  echo '<option value="',$mun->MunicipalityId,'">',$mun->MunicipalityName,'</option><br>';
                }
            }
		}
	}

?>