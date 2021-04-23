<?php
$param = $_GET["spf"];
$param2 = "_dmarc." . $_GET["dmarc"];
if ($param) {
    check($param,"v=spf1");
}
if ($param2) {
    check($param2,"v=DMARC1");
}

function check($url, $string) {
    $array = dns_get_record($url, DNS_ALL);
    for ($i = 0; $i <= count($array) - 1; $i++) {
        $nestedarray = $array[$i];
        for ($j = 0; $j <= count($nestedarray) - 1; $j++) {
            if (array_key_exists("txt", $nestedarray)) {
                $str = $nestedarray['txt'];
                $search = $string;
                if (preg_match("/{$search}/i", $str)) {
                    echo (prepareAPIResponse("success", $str, "found"));
                    break;
                }
            }
        }
    }
}

function prepareAPIResponse($status='success', $data=null, $msg=null) {
    header('content-type: application/json');
    return json_encode([
       'status'=>$status,
       'data'=>$data,
       'message'=>$msg
    ]);
}
