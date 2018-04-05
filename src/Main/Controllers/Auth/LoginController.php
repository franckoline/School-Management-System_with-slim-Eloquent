<?php

namespace Main\Controllers\Auth;

use Main\Models\User;
use Main\Models\Admin;
use Main\Models\Student;
use Main\Transformers\UserTransformer;
use Main\Transformers\AdminTransformer;
use Main\Transformers\StudentTransformer;
use Interop\Container\ContainerInterface;
use League\Fractal\Resource\Item;
use Slim\Http\Request;
use Slim\Http\Response;
use Respect\Validation\Validator as v;
use Main\Controllers\User\UserController;

class LoginController
{

    /** @var \Main\Validation\Validator */
    protected $validator;
    /** @var \Illuminate\Database\Capsule\Manager */
    protected $db;
    /** @var \League\Fractal\Manager */
    protected $fractal;
    /** @var \Main\Services\Auth\Auth */
    private $auth;

    /**
     * RegisterController constructor.
     *
     * @param \Interop\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->auth = $container->get('auth');
        $this->validator = $container->get('validator');
        $this->db = $container->get('db');
        $this->fractal = $container->get('fractal');
    }

    /**
     * Return token after successful login
     *
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     *
     * @return \Slim\Http\Response
     */
    public function login(Request $request, Response $response)
    {
        $validation = $this->validateLoginRequest($adminParams = $request->getParam('admin'));
        

        if ($validation->failed()) {
            return $response->withJson(['errors' => [' email or password' => ['is invalid']]], 422);
        }

        if ($admin = $this->auth->attemptAdmin($adminParams['email'], $adminParams['password'])) {
            $admin->token = $this->auth->generateTokenAdmin($admin);
            $data = $this->fractal->createData(new Item($admin, new AdminTransformer()))->toArray();

            return $response->withJson(['admin' => $data]);
        }
        return $response->withJson(['errors' => ['email or password' => ['is invalid']]], 422);
    }

    /**
     * @param array
     *
     * @return \Main\Validation\Validator
     */
    protected function validateLoginRequest($values)
    {
        return $this->validator->validateArray(
            $values,
            [
                'email'     => v::noWhitespace()->notEmpty(),
                'password'  => v::noWhitespace()->notEmpty(),
                'role'      => v::noWhitespace()->notEmpty(),
            ]
        );
    }
}
