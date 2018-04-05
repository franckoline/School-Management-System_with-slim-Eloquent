<?php

namespace Main\Controllers;

use Main\Models\User;
use Main\Models\Admin;
use Main\Transformers\ProfileTransformer;
use Main\Transformers\UserTransformer;
use Main\Transformers\AdminTransformer;
use Interop\Container\ContainerInterface;
use League\Fractal\Resource\Item;
use Slim\Http\Request;
use Slim\Http\Response;

class ProfileController
{

    public function __construct(ContainerInterface $container)
    {
        $this->auth = $container->get('auth');
        $this->fractal = $container->get('fractal');
    }
//get Single user {admin, staff, student and parents}
    public function showSingle(Request $request, Response $response, array $args)
    {
        $admin = Admin::where('username', $args['username'])->FirstorFail();
        return $response->withJson($admin);
    }
//get Single users {admin, staff, student and parents}
    public function showAll(Request $request, Response $response, array $args)
    {
        $json = Admin::all();
        return $response->withJson($json);
    }

//delete users {admin, staff, student and parents}
    public function destroy(Request $request, Response $response, array $args)
    {
        $admin = Admin::where('username', $args['username'])->firstOrFail();
        $admin->delete();
        return $response->withJson($admin, 200);

    }
}
