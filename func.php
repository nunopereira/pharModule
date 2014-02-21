<?php
  $codDis = $_POST['data'];
echo "COOOOODE "+$codDis;
    $url = "http://services.sapo.pt/GIS/GetMunicipalitiesByDistrictIdSortedById?districtId=".$codDis;
    $xml = new SimpleXMLElement($url, NULL, TRUE);
    foreach ($xml->GetMunicipalitiesByDistrictIdSortedByIdResult->Municipality as $municipality){
      $mbd[intval($municipality->MunicipalityId)] = (string)$municipality->MunicipalityName;
    }

?>
