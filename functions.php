<?php

// YOUR FUNCTIONS CAN LIVE HERE 🏠
function csvFileConverter($file_content)
{
    $csvLines = explode("\n", $file_content);
    $indexes = str_getcsv(array_shift($csvLines));

    // It's often a good practice to format the user input, especially keys/headers so they are standardized
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
    
    // C'est une bonne idée d'éviter d'appeler ses variables 'array', 'var', 'object', il vaut mieux leur donner un nom qui décrit son contenu (comme tu a fait partout ailleurs 👍). On comprend mieux le code à la lecture

    // Required fields
    $requiredFields = ['name', 'surname', 'city'];
    //var_dump($fileData);
    foreach ($fileData as $entry) {
        //print_r($entry);
        // if (array_diff_key($requiredFields, $entry)) {
        //     var_dump($entry);
        //     var_dump('<br>');
        //     var_dump('Difference de clés');
        //     $array = ['data' => $entry];
        //     var_dump($array);
        //     die();
        // } else {
        //     var_dump($entry);
        //     var_dump('<br>');
        //     var_dump('fichier correct');
        //     $array = ['data' => $entry];
        //     die();
        // }

        if (array_diff_key($requiredFields, $entry)) {
            //var_dump($entry);
            // The API accepts a body with 2 attributes : 'data' and 'token'
            $array = ['data' => $fileData, 'token' => API_TOKEN];
            return postRequest($array);
        } else {
            return ERROR_MESSAGE_WRONG_FORMAT;
        }

        // if (array_diff_key($requiredFields, $entry)) {
        //     //var_dump($entry);
        //     // The API accepts a body with 2 attributes : 'data' and 'token'           
        //     return postRequest([
        //         'data' => $fileData,
        //         'token' => API_TOKEN
        //     ]);
        // } else {
        //     return ERROR_MESSAGE_WRONG_FORMAT;
        // }
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

    //var_dump($opts);
    //die();

    $context = stream_context_create($opts);
    return file_get_contents(API_URL, false, $context);
}