<?php
namespace Beltrao\v1\domain;

 use Beltrao\v1\database\DBConnection;


     class FacebookPlaces{




        function getPlaces($lat=-3.063628, $lng=-60.0201654, $distance= 500){

            $dadabase = new DBConnection();

            $fb = new \Facebook\Facebook([
                'app_id' => '223567718401525',
                'app_secret' => 'c2ab61d901286b35045c0d70e4ef8aa0',
                'default_graph_version' => 'v3.0',
                'default_access_token' => '223567718401525|nRFP6P0BlCSR53zFKFAPqw8l6NI', // optional
            ]);

             
            try{    
            $response = $fb->get("search?type=place&fields=name,checkins,picture,location,phone,website&center=".$lat.",".$lng."&distance=".$distance."&limit=100", "223567718401525|nRFP6P0BlCSR53zFKFAPqw8l6NI");



                if($dadabase!= null){

                    $data = json_decode( $response->getGraphEdge());

                    $dadabase->beginTransaction();

                    $query = "";
                    $query_photo = "";
                    $query_location="";


                    $stm = $dadabase->prepare($query);
                    $stm_photo = $dadabase->prepare($query_photo);
                    $stm_location = $dadabase->prepare($query_location);



                    for($i=0; $i< count($data); $i++){


                        $stm->bindValue(":id", $data[$i]->id);
                        $stm->bindValue(":phone", array_key_exists("phone",$data[$i]) ? $data[$i]->phone: "---" );

                        $stm->bindValue(":name", $data[$i]->name);
                        $stm->bindValue(":website", array_key_exists("website", $data[$i])? $data[$i]->website: "");
                        $stm->bindValue(":checkins", $data[$i]->checkins);

                        $stm->execute();

                        $stm_location->bindValue(":city", $data[$i]->location->city);
                        $stm_location->bindValue(":country", $data[$i]->location->country);
                        $stm_location->bindValue(":latitude", $data[$i]->location->latitude);
                        $stm_location->bindValue(":longitude", $data[$i]->location->longitude);
                        $stm_location->bindValue(":state", $data[$i]->location->state);
                        $stm_location->bindValue(":place_id", $data[$i]->id);

                        $stm_location->execute();


                        $stm_photo->bindValue(":place_id", $data[$i]->id);
                        $stm_photo->bindValue(":height", $data[$i]->picture->height);
                        $stm_photo->bindValue(":width", $data[$i]->picture->width);
                        $stm_photo->bindValue(":url", $data[$i]->pucture->url);
                        $stm_photo->bindValue(":is_silhouettte", $data[$i]->picture->is_silhouette);

                          $stm_location->execute();


                    }

                $dadabase->commit();


                return("registros add com sucesso");

                }
        
         } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
          } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
          }



            return("erro");


        }


    }