 <?php 
 	include 'district.php';
 	include 'municipality.php';
 	include 'pharmacy.php';

 	$district = new District;
 	$municipality = new Municipality;
 	$district->setDistrictId('12');
 	echo 'X ',$district->getDistrictId();


/*************************************

		Districts

*************************************/
	function getDistrict($dis)
	{
		$url = "http://services.sapo.pt/GIS/GetDistrictsSortedById";
		$xml = new SimpleXMLElement($url, NULL, TRUE);
		foreach ($xml->GetDistrictsSortedByIdResult->District as $d){
			if($d->DistrictId==$dis->getDistrictId()){
			echo 'Checked -> ', $d->DistrictName;
			}
		} 
	}

	function getAllDistricts()
	{
		$url = "http://services.sapo.pt/GIS/GetDistrictsSortedById";
		$xml = new SimpleXMLElement($url, NULL, TRUE);
		foreach ($xml->GetDistrictsSortedByIdResult->District as $district){
			echo 'Checked -> ', $district->DistrictName,'<br>';
		} 
	}

	function getArrAllDistricts()
	{
		$url = "http://services.sapo.pt/GIS/GetDistrictsSortedById";
		$xml = new SimpleXMLElement($url, NULL, TRUE);
		$i=0;
		foreach ($xml->GetDistrictsSortedByIdResult->District as $district){
			$ad[$i]=$district->DistrictId;
			$i++;
		} 
		return $ad;
	}
/*************************************

		Municipalities

*************************************/

	/* Prints Municipality Name by Id */
	/*function getEchoMunicipality($codMun)
	{
		$url = "http://services.sapo.pt/GIS/GetMunicipalitiesSortedById";
		$xml = new SimpleXMLElement($url, NULL, TRUE);
		foreach ($xml->GetMunicipalitiesSortedByIdResult->Municipality as $mun){
			if($mun->MunicipalityId==$codMun){
				echo 'Checked -> ', $mun->MunicipalityName;
			}
		} 
	}
	*/

	/* Prints All Municipalities from Portugal */
	/*
	function getAllMunicipalities()
	{
		$url = "http://services.sapo.pt/GIS/GetMunicipalitiesSortedById";
		$xml = new SimpleXMLElement($url, NULL, TRUE);
		foreach ($xml->GetMunicipalitiesSortedByIdResult->Municipality as $municipality){
			echo $municipality->MunicipalityName,'<br>';
		} 
	}
	*/

	/* Returns an array [MunicipalityID]=Municipality Name */
	function getMunicipalitiesByDistrict($codDis)
	{
		$url = "http://services.sapo.pt/GIS/GetMunicipalitiesByDistrictIdSortedById?districtId=".$codDis;
		$xml = new SimpleXMLElement($url, NULL, TRUE);
		foreach ($xml->GetMunicipalitiesByDistrictIdSortedByIdResult->Municipality as $municipality){
			$mbd[intval($municipality->MunicipalityId)] = (string)$municipality->MunicipalityName;
		}
		return $mbd;
	}


/*************************************

		Parishes

*************************************/

	/* Prints All Municipalities by MunicipalityId */
	function getAllParishes($codMun)
	{
		$urlPharm = 'http://services.sapo.pt/Pharmacy/GetPharmaciesAtServiceByMunicipalityId?municipalityId='.$codMun;
		$xmlPharm = new SimpleXMLElement($urlPharm, NULL, TRUE);
			foreach ($xmlPharm->GetPharmaciesAtServiceByMunicipalityIdResult->Pharmacies->Pharmacy as $pharm){
					echo  $pharm->Address->Parish,'<br>';
			}
	}

	/* Returns an array [ParishID]=Parish Name by MunicipalityId */
	function getParishesMap($codMun)
	{
		$urlPharm = 'http://services.sapo.pt/Pharmacy/GetPharmaciesAtServiceByMunicipalityId?municipalityId='.$codMun;
		$xmlPharm = new SimpleXMLElement($urlPharm, NULL, TRUE);
		foreach ($xmlPharm->GetPharmaciesAtServiceByMunicipalityIdResult->Pharmacies->Pharmacy as $pharm)
		{
				echo $pharm->Address->ParishId, ' :: ', $pharm->Address->Parish,'<br>';
				$s[intval($pharm->Address->ParishId)]=(string)$pharm->Address->Parish;
		}
			return $s;
	}



	/* Prints a list of parishes from all municipalities by DistrictID
	function getMunicipalitiesMap($codDis)
	{
		$mmap=getMunicipalitiesByDistrict($codDis);
		foreach($mmap as $key=>$val) {	
			echo 'Municipality:<br>',$val,'<br>Parishes:<br>';
			$pmap=getParishesMap($key);
							echo'<br><br>';

			}
	}
	*/

/*************************************

		Pharmacies

*************************************/
	function GetPharmaciesAtServiceByParishId($pid){
		$urlPharm = 'http://services.sapo.pt/Pharmacy/GetPharmaciesAtServiceByParishId?parishId='.$pid;
		$xmlPharm = new SimpleXMLElement($urlPharm, NULL, TRUE);
		foreach ($xmlPharm->GetPharmaciesAtServiceByParishIdResult->Pharmacies->Pharmacy as $pharm){
				$f[intval($pharm->Code)]=(string)$pharm->Name;
		}

		return $f;
	}


	function getLatPharmacy($codPar,$pharmId){
		$urlPharm = 'http://services.sapo.pt/Pharmacy/GetPharmaciesAtServiceByParishId?parishId='.$codPar;
		$xmlPharm = new SimpleXMLElement($urlPharm, NULL, TRUE);
		foreach ($xmlPharm->GetPharmaciesAtServiceByParishIdResult->Pharmacies->Pharmacy as $pharm){
			if($pharm->Code==$pharmId)
				return $pharm->Address->Coordinates->Latitude;
		}
	}
	function getLonPharmacy($codPar, $pharmId){
		$urlPharm = 'http://services.sapo.pt/Pharmacy/GetPharmaciesAtServiceByParishId?parishId='.$codPar;
				echo $urlPharm;

		$xmlPharm = new SimpleXMLElement($urlPharm, NULL, TRUE);
		foreach ($xmlPharm->GetPharmaciesAtServiceByParishIdResult->Pharmacies->Pharmacy as $pharm){
			if($pharm->Code==$pharmId){
				return $pharm->Address->Coordinates->Longitude;
			}
		}
	}
	function getPharmaciesPOI($lat,$long,$rad){
		$urlPharmPOI = 'http://services.sapo.pt/GIS/GetPOIByCoordinatesAndCategoryId?latitude='.$lat.'&longitude='.$long.'&radius='.$rad.'&categoryId=73';
		$xmlPharmPOI = new SimpleXMLElement($urlPharmPOI, NULL, TRUE);
		echo $urlPharmPOI;
		foreach ($xmlPharmPOI->GetPOIByCoordinatesAndCategoryIdResult->POI as $pharPOI){
			$f[intval($pharPOI->POISourceId)]=(string)$pharPOI->ParishId;
		}
		return $f;
	}

	function getPharmaciesService($pharmPOI){
		foreach($pharmPOI as $kppoi =>$ppoi){
			$pbp = GetPharmaciesAtServiceByParishId($ppoi);
			if($pbp[$kppoi]){
				echo $pbp[$kppoi],'<br>';
			}
		}
	}

/*************************************

		Tests

*************************************/
	/*$lat = getLatPharmacy('131422','6726');
	$lon = getLonPharmacy('131422','6726');
	$pp = getPharmaciesPOI($lat,$lon,100);
	getPharmaciesService($pp);*/
	echo 'X ',$district->getDistrictId();
	getDistrict($dst);
?>
