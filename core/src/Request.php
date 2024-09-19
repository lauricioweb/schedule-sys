<?php
class Request extends Novel
{
    public $return = false;
    public $error = false;
    public $info = false;

    public static function get($endpoint, $body = array(), $conf = array())
    {
        return self::req("GET", $endpoint, $body, $conf);
    }
    public static function post($endpoint, $body = array(), $conf = array())
    {
        return self::req("POST", $endpoint, $body, $conf);
    }
    public static function put($endpoint, $body = array(), $conf = array())
    {
        return self::req("PUT", $endpoint, $body, $conf);
    }
    public static function delete($endpoint, $body = array(), $conf = array())
    {
        return self::req("DELETE", $endpoint, $body, $conf);
    }
    public static function req($method, $endpoint, $body = array(), $headers_append = array())
    {
        global $_APP, $_SESSION;

        if (!extension_loaded('curl')) {
            Novel::refreshError("Extension error", "CURL extension is not loaded");
        }

        // URL
        // something://
        if (@explode('://', $endpoint)[1]) {
            $api_id = explode('://', $endpoint)[0];
            // api_id://
            if ($api_id !== 'http' and $api_id !== 'https') {
                $endpoint_clean = explode('://', $endpoint)[1];
                if (@!$_APP['API_CLIENT'][$api_id]['DNS']) {
                    Novel::refreshError("Request error", "Api client ID not found: $api_id");
                }
                $url = $_APP['API_CLIENT'][$api_id]['DNS'] . '/' . $endpoint_clean;
            }
            // https://
            else {
                $url = $endpoint;
            }
        }
        // DONT HAVE " :// "
        // CHOOSE FIRST API ID
        else {
            foreach ($_APP['API_CLIENT'] as $k => $v) {
                $api_id = $k;
                break;
            }
            $url = @$_APP['API_CLIENT'][$api_id]['DNS'];
            $url .= $endpoint;
        }

        // Data & headers
        $headers = array('Content-Type: application/json');
        $h = @$_APP['API_CLIENT'][$api_id]['HEADER'];
        $h = @$_SESSION[$h];
        if ($h) foreach ($h as $k => $v) $headers[] = "$k: $v";
        if ($headers_append) {
            foreach ($headers_append as $k => $v) $headers[] = "$k: $v";
        }
        $body = json_encode($body);

        // Send curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_STDERR, fopen('php://stderr', 'w'));
        //
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        //
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, "Thunder Client (https://www.thunderclient.io)");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $res = curl_exec($ch);

        // Return
        $info = curl_getinfo($ch);
        if (curl_error($ch)) {
            $error = curl_error($ch);
            return ['error' => $error, 'info' => $info];
        }
        $return = json_decode($res, true);
        if (json_last_error()) $return = $res;
        curl_close($ch);

        // Return
        return $return;
    }
}
