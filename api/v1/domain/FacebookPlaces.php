<?php
namespace Beltrao\v1\domain;

use Beltrao\v1\database\DBConnection;

     $db;

     class FacebookPlaces{

        $database = new DBConnection();



        function getPlaces($lat=-3.063628, $lng=-60.0201654, $distance= 500){

            $fb = new \Facebook\Facebook([
                'app_id' => '223567718401525',
                'app_secret' => 'c2ab61d901286b35045c0d70e4ef8aa0',
                'default_graph_version' => 'v3.0',
                'default_access_token' => '223567718401525|nRFP6P0BlCSR53zFKFAPqw8l6NI', // optional
            ]);

             
            try{    
            $response = $fb->get("search?type=place&fields=name,checkins,picture,location,phone,website&center=".$lat.",".$lng."&distance=".$distance."&limit=100", "223567718401525|nRFP6P0BlCSR53zFKFAPqw8l6NI");
        
        
         } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
          } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
          }   
          
          
          $data = json_decode( $response->getGraphEdge());
          
          for($i=0; $i< count($data); $i++){


            echo $data[$i]->name."\n";


          }

          die;

           return $node;
                
          
         
        }


    }