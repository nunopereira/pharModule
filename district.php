<?php

	class District {

		var $districtId;
		var $districtName;
		

		function getDistrictId(){
			echo 'get :: ',$districtId,'<br>';
			return $districtId;
		}
		function getDistrictName(){
			return $districtName;
		}
		

		function setDistrictId($v){
			echo 'enter :: ',$v,'<br>';
			 $districtId=$v;
			 echo 'exit :: ',$districtId,'<br>';
		}

		function setDistrictName($v){
			$districtName=$v;
		}

		function getDistricts($post){
                $url = "http://services.sapo.pt/GIS/GetDistrictsSortedById";
                $xml = new SimpleXMLElement($url, NULL, TRUE);
                foreach ($xml->GetDistrictsSortedByIdResult->District as $district){
                  if ((!empty($post))&&($post==$district->DistrictId)){
                    echo '<option selected value="',$district->DistrictId,'">',$district->DistrictName,'</option><br>';
                  }else{
                    echo '<option value="',$district->DistrictId,'">',$district->DistrictName,'</option><br>';
                  }
                } 
		}
		
	}

?>