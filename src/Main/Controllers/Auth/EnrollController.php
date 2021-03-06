<?php

namespace Main\Controllers\Auth;

use Main\Models\Admin;
use Main\Transformers\AdminTransformer;
use Interop\Container\ContainerInterface;
use League\Fractal\Resource\Item;
use Slim\Http\Request;
use Slim\Http\Response;
use Respect\Validation\Validator as v;

class EnrollController
{

    /** @var \Conduit\Validation\Validator */
    protected $validator;
    /** @var \Illuminate\Database\Capsule\Manager */
    protected $db;
    /** @var \League\Fractal\Manager */
    protected $fractal;
    /** @var \Conduit\Services\Auth\Auth */
    private $auth;

    public function __construct(ContainerInterface $container)
    {
        $this->auth = $container->get('auth');
        $this->validator = $container->get('validator');
        $this->db = $container->get('db');
        $this->fractal = $container->get('fractal');
    }

    
    public function enroll(Request $request, Response $response)
    {
        $validation = $this->validateEnrollRequest($adminParams = $request->getParam('admin'));

        if ($validation->failed()) {
            return $response->withJson(['errors' => $validation->getErrors()], 422);
        }

        $admin = new Admin($adminParams);
        $admin->token = $this->auth->generateTokenAdmin($admin);
        $admin->password = password_hash($adminParams['password'], PASSWORD_DEFAULT);
        $admin->save();

        $resource = new Item($admin, new AdminTransformer());
        $admin = $this->fractal->createData($resource)->toArray();

        return $response->withJson(
            [
                'admin' => $admin,
            ]
        );
    }

    /**
     * @param array
     *
     * @return \Main\Validation\Validator
     */
    protected function validateEnrollRequest($values)
    {
        return $this->validator->validateArray(
            $values,
            [
                'email'     => v::noWhitespace()->notEmpty()->email()->existsInTable($this->db->table('admins'), 'email'),
                'username'  => v::noWhitespace()->notEmpty()->existsInTable($this->db->table('admins'), 'username'),
                'role'      => v::noWhitespace()->notEmpty(),
                'password'  => v::noWhitespace()->notEmpty(),
            ]
        );
    }
}