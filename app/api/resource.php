<?php

namespace Api;

use \Exception;

try {
    // Prevent displaying errors
    ob_start();

    $response = array();
    $allowedMethods = array('GET');
    $allowedHeaders = array();

    $resources = array(
        'html5-boilerplate' => array(
            'name' => 'HTML5 Boilerplate',
            'description' => 'HTML5 Boilerplate is a professional front-end template'
                . ' for building fast, robust, and adaptable web apps or sites.',
        ),
        'bootstrap' => array(
            'name' => 'Bootstrap',
            'description' => 'Sleek, intuitive, and powerful mobile first front-end'
                . ' framework for faster and easier web development.',
        ),
        'modernizr' => array(
            'name' => 'Modernizr',
            'description' => 'Modernizr is an open-source JavaScript library that'
                .   ' helps you build the next generation of HTML5 and CSS3-powered'
                .   ' websites.',
        ),
    );

    // Get headers and normalize them
    if (function_exists('getallheaders')) {
        $headers = getallheaders();
    }
    else {
        $headers = array();
        foreach ($_SERVER as $name => $value) {
            if (preg_match('/^HTTP_(.*)$/', $name, $matches)) {
                $headers[str_replace('_', '-', $matches[1])] = $value;
            }
        }
    }
    foreach ($headers as $name => $value) {
        unset($headers[$name]);
        $headers[ucwords(strtolower($name))] = $value;
    }

    // Handle OPTIONS method
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header('Allow: ' . implode(', ', $allowedMethods));
        header('Access-Control-Allow-Methods: ' . implode(', ', $allowedMethods));
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Request-Headers: ' . implode(', ', $allowedHeaders));
        exit();
    }

    // Reject if method is not allowed
    if (!in_array($_SERVER['REQUEST_METHOD'], $allowedMethods)) {
        throw new Exception(
            'Only ' . implode(', ', $allowedMethods)
            . (count($allowedMethods) === 1 ? ' method is' : ' methods are')
            . ' allowed',
            405
        );
    }

    // Reject if not acceptable
    if (!array_key_exists('Accept', $headers) || !in_array('application/json', explode(', ', $headers['Accept']))) {
        throw new Exception('Only application/json is acceptable');
    }

    /**
     * -------------------------------------------------------------------------
     * /resource/{id}
     * -------------------------------------------------------------------------
     */
    if (isset($_GET['id'])) {
        if (!preg_match('/^[a-z0-9-]+$/', $id = $_GET['id'])) {
            throw new Exception('Resource id must contain only alphanumeric and - characters', 400);
        }
        if (!array_key_exists($id, $resources)) {
            throw new Exception("Resource with id $id does not exist", 404);
        }
        $response = array_merge(
            $response,
            array('id' => $id),
            $resources[$id]
        );
    }
    /**
     * -------------------------------------------------------------------------
     * /resource
     * -------------------------------------------------------------------------
     */
    else {
        $url = 'http' . (array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] === 'on' ? 's' : '') . '://'
            . $headers['Host'] . $_SERVER['REQUEST_URI'];

        $response['resources'] = array();
        foreach ($resources as $id => $resource) {
            array_push($response['resources'], array(
                'id' => $id,
                'name' => $resource['name'],
                'href' => preg_match('/\.php$/', $url) ? "$url?id=$id" : "$url/$id",
            ));
        }
    }

    // Catch non-exception errors
    $output = ob_get_clean();
    if ($output !== '') {
        throw new Exception(trim($output), 500);
    }

    header('HTTP/1.1 200 OK');
    header('Content-Type: application/json');
    echo json_encode($response);
}
catch(Exception $e) {

    $response = array(
        'status' => $e->getCode(),
        'statusText' => null,
        'description' => $e->getMessage(),
        'stack' => $e->getTrace(),
    );

    switch ($response['status']) {
        case 400:
            $response['statusText'] = 'Bad Request';
            break;
        case 404:
            $response['statusText'] = 'Not Found';
            break;
        case 405:
            $response['statusText'] = 'Method Not Allowed';
            break;
        case 405:
            $response['statusText'] = 'Not Acceptable';
            break;
        default:
            $response['statusText'] = 'Internal Server Error';
            $response['status'] = 500;
            break;
    }

    header('HTTP/1.1 ' . $response['status'] . ' ' . $response['statusText']);
    header('Content-Type: application/json');
    echo json_encode($response);
}
