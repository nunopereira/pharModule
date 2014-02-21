<?php

	class Parish {

		var $parishId;
		var $parishName;
		

		function getParishId(){
			return $parishId;
		}
		function getParishName(){
			return $parishName;
		}
		

		function setParishId($v){
			 $parishId=$v;
		}
		function setParishName($v){
			$parishName=$v;
		}
		
		/*
		function getParishes($postp,$postm){
			$urlP = 'http://services.sapo.pt/Pharmacy/GetPharmaciesAtServiceByMunicipalityId?municipalityId='.$postm;
            $xmlP = new SimpleXMLElement($urlP, NULL, TRUE);
            foreach ($xmlP->GetPharmaciesAtServiceByMunicipalityIdResult->Pharmacies->Pharmacy as $pharm){
                if ((!empty($postp))&&($postp==$pharm->Address->ParishId)){
                    echo '<option selected value="',$pharm->Address->ParishId,'">',$pharm->Address->ParishName,'</option><br>';
                }else{
                    echo '<option value="',$pharm->Address->ParishId,'">',$pharm->Address->ParishName,'</option><br>';
                }
            } 
		}
		*/
		function getParishes($postp,$postm){
			$urlP = 'http://services.sapo.pt/GIS/GetParishesByMunicipalityIdSortedById?municipalityId='.$postm;
            $xmlP = new SimpleXMLElement($urlP, NULL, TRUE);
            foreach ($xmlP->GetParishesByMunicipalityIdSortedByIdResult->Parish as $par){
                if ((!empty($postp))&&($postp==$par->ParishId)){
                    echo '<option selected value="',$par->ParishId,'">',$par->ParishName,'</option><br>';
                }else{
                    echo '<option value="',$par->ParishId,'">',$par->ParishName,'</option><br>';
                }
            } 
		}
	}

?>