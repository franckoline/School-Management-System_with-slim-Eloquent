<?php


use Main\Controllers\Auth\LoginController;
use Main\Controllers\Auth\RegisterController;
use Main\Controllers\Auth\EnrollController;
use Main\Controllers\ProfileController;
use Main\Controllers\Admin\AdminController;
use Main\Controllers\User\UserController;
use Main\Middleware\OptionalAuth;
use Main\Models\Tag;
use Slim\Http\Request;
use Slim\Http\Response;


// Api Routes
$app->group('/api',
    function () {
        $jwtMiddleware = $this->getContainer()->get('jwt');
        $optionalAuth = $this->getContainer()->get('optionalAuth');
        /** @var \Slim\App $this */

        // Auth Routes
       // $this->post('/admin', RegisterController::class . ':register')->setName('auth.register');
        $this->post('/enroll', EnrollController::class . ':enroll')->setName('auth.enroll');
        $this->post('/login', LoginController::class . ':login')->setName('auth.login');
       
        // The General Users Routes (Admin, Staff, Student and Parent)
        $this->get('/admin', AdminController::class . ':showAll')->setName('admin.showAll');
        $this->get('/allUsers', ProfileController::class . ':showAll')
                ->add($optionalAuth)  
                ->setName('admin.showAll');
        $this->get('/singleUser/{username}', ProfileController::class . ':showSingle')
                ->add($optionalAuth)        
                ->setName('admin.showSingle');
        $this->put('/update/{username}', ProfileController::class . ':update')->setName('update');
        $this->delete('/deleteUser/{username}', ProfileController::class . ':destroy')->setName('delete');

        // Students Routes
        $this->post('/student/admission', EnrollController::class . ':admission')
                ->add($optionalAuth)
                ->setName('students.admission');
        $this->get('/students/{class}', StudentController::class . ':show')->add($optionalAuth)->setName('students.show');
        $this->put('/students/{class}',
            StudentController::class . ':update')->add($jwtMiddleware)->setName('students.update');
        $this->delete('/students/{class}',
            StudentController::class . ':destroy')->add($jwtMiddleware)->setName('students.destroy');
        $this->post('/students', StudentController::class . ':store')->add($jwtMiddleware)->setName('students.store');
        $this->get('/students', StudentController::class . ':index')->add($optionalAuth)->setName('students.index');

       
        $this->get('/tags', function (Request $request, Response $response) {
            return $response->withJson([
                'tags' => Tag::all('title')->pluck('title'),
            ]);
        });
    });


// Routes

$app->get('/[{name}]',
    function (Request $request, Response $response, array $args) {
        // Sample log message
        $this->logger->info("Slim-Skeleton '/' route");

        // Render index view
        return $this->renderer->render($response, 'index.phtml', $args);
    });
