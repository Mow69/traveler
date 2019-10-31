<?php


namespace App\Service;


use Exception;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class OpenStreetMapAPIService
{
    /**
     * @param $ville
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    function createConn($ville)
    {
        $client = HttpClient::create(['http_version' => '2.0']);
        $reponse = $client->request('GET', 'https://nominatim.openstreetmap.org/search/?format=json&limit=1&q=' . $ville);
        if($reponse->getStatusCode() == 200){
            $content = $reponse->toArray();
            return $content;
        } else {
            throw new Exception('Bad connection my friend !!');
        }
    }


    // TODO: Faire la géolocalisation dans le Service

    // Récupérer les données de géolocalisation depuis l'API
//    /**
//     * @return bool|string
//     */
//    public function getAllMap()
//    {
//        return $this->callAPI("GET", "https://nominatim.openstreetmap.org/search.php?q=Lyon&limit=1&format=json");
//    }
//
//    // Geolocalise une photo, une destination, un voyage...
//    public function geolocalizeItem()
//    {
//
//    }
//
//    // Appelle l'API
//
//    /**
//     * @param $type
//     * @param $url
//     * @return bool|string
//     */
//    private function callAPI($type, $url)
//    {
//        $curl = curl_init();
//
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => $url,
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 30,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => $type,
//            CURLOPT_HTTPHEADER => array(
//                "Accept: */*",
//                "Accept-Encoding: gzip, deflate",
//                "Cache-Control: no-cache",
//                "Connection: keep-alive",
//                "Cookie: _osm_totp_token=974351",
//                "Host: nominatim.openstreetmap.org",
//                "Postman-Token: 4542991b-a5de-4d21-a1e9-a154b7c124f4,f8adf27c-c2a7-46ca-b75c-d63395fea9e3",
//                "User-Agent: PostmanRuntime/7.19.0",
//                "cache-control: no-cache"
//            ),
//        ));
//
//        $response = curl_exec($curl);
//        curl_close($curl);
//
//        return $response;
//    }



}