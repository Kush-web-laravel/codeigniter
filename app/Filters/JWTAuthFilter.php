<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\BlackListedTokensModel;

class JWTAuthFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        //
        $authorization = $request->getServer('HTTP_AUTHORIZATION');

        if(!$authorization){
            return Services::response()->setStatusCode(400)->setJSON([
                'status' => false,
                'message' => "UnAuthorized access"
            ]);
        }

        $authorizationStringParts = explode(" ", $authorization);

        if(count($authorizationStringParts) !== 2 || $authorizationStringParts[0] !== "Bearer"){
            return Services::response()->setStatusCode(400)->setJSON([
                'status' => false,
                'message' => "UnAuthorized access"
            ]);
        }

        try{

            $blockListedTokenObject = new BlackListedTokensModel();
            $tokenData = $blockListedTokenObject->where('token', $authorizationStringParts[1])->first();
            
            if($tokenData){
                return Services::response()->setStatusCode(400)->setJSON([
                    "status" => false,
                    "message" => "Unauthorized access"
                ]);
            }
            
            $decodedData = JWT::decode($authorizationStringParts[1], new Key(getenv("JWT_KEY"), "HS256"));

            $request->jwtToken = $authorizationStringParts[1];
            $request->userData = (array) $decodedData;

        }catch(\Exception $e){
            return Services::response()->setStatusCode(500)->setJSON([
                "status" => false,
                "message" => "Failed to validate the token value",
                "error_message" => $e->getMessage(),
            ]);
        }

    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
