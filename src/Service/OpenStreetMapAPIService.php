<?php


namespace App\Service;


class OpenStreetMapAPIService
{



    // TODO: Faire la géolocalisation dans le Service

    // Récupérer les données de géolocalisation depuis l'API
    /**
     * @return bool|string
     */
    public function getAllMap()
    {
        return $this->callAPI("GET", "https://www.openstreetmap.org/#map=12/45.4315/4.4055");
    }

    // Geolocalise une photo, une destination, un voyage...
    public function geolocalizeItem()
    {
        
    }

    // Appelle l'API

    /**
     * @param $type
     * @param $url
     * @return bool|string
     */
    private function callAPI($type, $url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => $type,
              CURLOPT_HTTPHEADER => array(
                    "Accept: */*",
                    "Accept-Encoding: gzip, deflate",
                    "Cache-Control: no-cache",
                    "Connection: keep-alive",
                    "Cookie: _osm_session=ecae3ffe2e84df5c1a4f05b11fa7c29d; _osm_banner_sotm_asia_2019=1; _osm_totp_token=581977",
                    "Host: www.openstreetmap.org",
                    "Postman-Token: 36b88083-1b86-465e-afc7-b7a6469e0b97,8a59ba66-f3bb-4ef4-88d9-88c66153d35f",
                    "User-Agent: PostmanRuntime/7.19.0",
                    "cache-control: no-cache"
              ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

}