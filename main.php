<?php
if ($argc < 2) {
    echo "Usage: php script.php <url> [--output=json]\n";
    exit(1);
}

$url = $argv[1];
$outputFormat = in_array('--output=json', $argv) ? 'json' : 'text';
$results = [];

check($url, "v=spf1");
check("_dmarc." . $url, "v=DMARC1");

if ($outputFormat === 'json') {
    echo json_encode($results, JSON_PRETTY_PRINT) . PHP_EOL;
} else {
    displayTextOutput();
}

function check($url, $string) {
    global $results;

    $txtRecords = dns_get_record($url, DNS_TXT);
    $status = "fail";
    $data = "";

    foreach ($txtRecords as $txtRecord) {
        if (preg_match("/{$string}/i", $txtRecord['txt'])) {
            $status = "success";
            $data = $txtRecord['txt'];
            break;
        }
    }

    $recordType = ($string === "v=spf1") ? "SPF" : "DMARC";

    $results[] = [
        'type' => $recordType,
        'status' => $status,
        'data' => $data
    ];
}

function displayTextOutput() {
    global $results;

    foreach ($results as $result) {
        echo "{$result['type']} Records:\n";
        
        if ($result['type'] === 'DMARC' && $result['status'] === 'fail') {
            echo "Not Found\n";
        } else {
            echo "{$result['data']}\n";
        }
        
        echo "\n";
    }
}
