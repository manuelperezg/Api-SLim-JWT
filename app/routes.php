<?php

use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;

$app->post('/login', function (Request $request, Response $response, array $args) {

    $input = $request->getParsedBody();
    $sql = "SELECT * FROM usuarios WHERE email= :email";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("email", $input['email']);
    $sth->execute();
    $user = $sth->fetchObject();
    // var_dump($user);

    // verify email address.
    if (!$user) {
        return $this->response->withJson(['error' => true, 'message' => 'Revise sus credenciales de inicio de sesión.']);
    }

    // verify password.
    // if (!password_verify($input['password'],trim($user->password))) {
    if ($input['password'] !== trim($user->password)) {
        return $this->response->withJson(['error' => true, 'message' => 'Credenciales inválidas, intente de nuevo.']);
    }

    $settings = $this->get('settings'); // get settings array.
    $token = JWT::encode(
        [
            'id' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + (60)
        ],
        $settings['jwt']['secret'],
        "HS256"
    );

    $name = $user->nombre . " " . $user->apellido;
    $role = $user->role;

    return $this->response->withJson(['access_token' => $token, 'user' => $name, 'role' => $role]);
});

$app->group('/quiosco', function (\Slim\App $app) {

    $app->get('/user', function (Request $request, Response $response, array $args) {
        print_r($request->getAttribute('decoded_token_data'));
    });

    $app->get('/admin', function (Request $request, Response $response, array $args) {
        print_r($request->getAttribute('decoded_token_data'));
    });
});
