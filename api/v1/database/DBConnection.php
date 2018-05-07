<?php
namespace  Beltrao\v1\database;                                                              
use \PDO;

    class DBConnection{




        function connect2FacebookDatabase(){



            try {
                $db = new \PDO(
                    'mysql:host=localhost;dbname=facebook_places', 
                    'root', 
                    ''
                );

                return $db;
            } catch (Exception $e) {
                //die("Unable to connect: " . $e->getMessage());
                return null;

            }



        }



    }




