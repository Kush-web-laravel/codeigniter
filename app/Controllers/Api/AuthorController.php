<?php

namespace App\Controllers\Api;


use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use App\Models\BlackListedTokensModel;

class AuthorController extends ResourceController
{

    protected $modelName = "App\Models\AuthorModel";
    protected $format = "json";

    public function registerAuthor()
    {
        $validationRules = array(
            "name" => array(
                "rules" => "required|min_length[3]",
                "errors" => array(
                    "required" => "Name field is required",
                    "min_length" => "Author name should have atleast 3 characters."
                )
            ),
            "email" => array(
                "rules" => "required|min_length[4]|is_unique[authors.email]",
                "errors" => array(
                    "required" => "Author email is required",
                    "min_length" => "Email should have atleast 4 characters in length.",
                    "is_unique" => "Email already exists"
                )
            ),
            "password" => array(
                "rules" => "required|min_length[5]",
                "errors" => array(
                    "required" => "Password is required",
                    "min_length" => "Password will be atleast of 5 characters."
                ) 
            )
        );

        if(!$this->validate($validationRules)){

            return $this->fail(array(
                'status' => false,
                "message" => "Form submission failed",
                "errors" => $this->validator->getErrors()
            ));
        }

        $authorData = [
            "name" => $this->request->getVar("name"),
            "email" => $this->request->getVar("email"),
            "password" => password_hash($this->request->getVar("password"), PASSWORD_DEFAULT) 
        ];

        if($this->model->save($authorData)){
            return $this->respond([
                'status' => true,
                'message' => 'Author registered successfully'
            ]);
        }else{
            return $this->respond([
                'status' => false,
                'message' => 'Failed to register author'
            ]);
        }
    }

    public function loginAuthor()
    {
        $validationRules = [
            'email' => [
                "rules" => "required"
            ], 
            'password' => [
                "rules" => "required"
            ]
        ];

        if(!$this->validate($validationRules)){

            return $this->respond([
                "status" => false,
                "message" => "Fields are required",
                "errors" => $this->validator->getErrors()
            ]);
        }

        //Check Author by email

        $authorData = $this->model->where('email', $this->request->getVar('email'))->first();

        if($authorData){

            if(password_verify($this->request->getVar('password'), $authorData['password'])){
                $key = getenv("JWT_KEY");

                $payloadData = [
                    "iss" => "localhost",
                    "aud" => "localhost",
                    "iat" => time(),
                    "exp" => time() * 3600, //token value will be expired after current time addon of 1 hour
                    "user" => [
                        "id" => $authorData["id"],
                        "email" => $authorData["email"]
                    ],
                ];

                $token = JWT::encode($payloadData, $key, "HS256");

                return $this->respond([
                    'status' => true,
                    'message' => "User logged in",
                    'token' => $token
                ]);

            }else{
                return $this->respond([
                    "status" => false,
                    "message" => "Login failed due to incorrect password value"
                ]);
            }

        }else{
            return $this->respond([
                "status" => false,
                "message" => "Login failed due to incorrect email value"
            ]);
        }
    }

    public function authorProfile()
    {
        return $this->respond([
            "status" => true,
            "message" => "Author Profile Information",
            "data" => $this->request->userData
        ]);
    }

    public function logoutAuthor()
    {
        $token = $this->request->jwtToken;

        $tokenBlackListedObject = new BlackListedTokensModel();

        if($tokenBlackListedObject->insert([
            "token" => $token
        ])){
            return $this->respond([
                "status" => true,
                "message" => "Author successfully logged out."
            ]);
        }else{
            return $this->respond([
                "status" => false,
                "message" => "Logout Failed."
            ]);
        }
    }

}
