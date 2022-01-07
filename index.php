<?php

    if ($_SERVER["REQUEST_METHOD"] === 'GET') {
        
        if (isset($_GET['steam32'])) {
            $id = $_GET['steam32'];

            if (!empty($id))
            {
                die(ConvertID($id));
            } 
            else
            {
                $data = [ "status" => "failed", "message" => "Parameter 'steam32' is empty!" ];
                die(json_encode(($data)));
            }
        }
        else {
            $data = [ "status" => "failed", "message" => "Required parameter 'steam32' is missing!" ];
            die(json_encode(($data)));
        }

    }
    else {
        $data = [ "status" => "failed", "message" => "Please use 'GET' as request method!" ];
        die(json_encode(($data)));
    }

    /*
    Tries to convert a given steam32 id to steam64
    If not it returns the steam32
    */
    function ConvertID($id) {
        $d = null;

        if (preg_match('/^STEAM_/', $id)) {
            $parts = explode(':', $id);
            $converted = bcadd(bcadd(bcmul($parts[2], '2'), '76561197960265728'), $parts[1]);
            $d = ["status" => "success", "message" => $converted];
        } elseif (is_numeric($id) && strlen($id) < 16) {
            $converted = bcadd($id, '76561197960265728');
            $d = ["status" => "success", "message" => $converted];
        } else {
            $d = ["status" => "failed", "message" => $id];
        }

        return json_encode($d);
    }
?>