<?php

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Core/functions.php';
(new Dotenv ())->load(__DIR__ . '/../.env');

$request = Request::createFromGlobals();

if (env('ADMIN_ROUTE_KEY') !== $request->get('key'))
{
    http_response_code(403);
    die();
}

$allowed_commands = [ 'storage-link' ];
$cmd = $request->get('command');


switch ($cmd)
{
    case 'storage-link' :
        symlink(__DIR__ . '/../storage/', __DIR__ . '/public');
        echo "Storage link created";
        break;
    default :
        echo "No command provided.";
        break;
}