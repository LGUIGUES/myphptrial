<?php

function csvFileConverter($file_content)
{
    $csvLines = explode("\n", $file_content);
    $indexes = str_getcsv(array_shift($csvLines));

    $headers = array_map(function ($header) {
        return strtolower(trim($header));
    }, $indexes);

    $array = array_map(function ($line) use ($headers) {
        return array_combine($headers, str_getcsv($line));
    }, $csvLines);
    
    return json_encode($array);
}

function fileValidator($validFile)
{
    $fileData = json_decode($validFile, true);

    // Required fields
    $requiredFields = ['name', 'surname', 'city'];

    foreach ($fileData as $entry) {
        
            $missingField = array_diff($requiredFields, array_keys($entry));
        }

        if (!empty($missingField)) {
            
            return ERROR_MESSAGE_WRONG_FORMAT;
        } else {
            
            // The API accepts a body with 2 attributes : 'data' and 'token'
            $array = ['data' => $fileData, 'token' => API_TOKEN];
            return postRequest($array);
        }
}

function postRequest($array)
{
    $opts = array(
        'http' =>
        array(
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($array)
        )
    );

    $context = stream_context_create($opts);
    return file_get_contents(API_URL, false, $context);
}