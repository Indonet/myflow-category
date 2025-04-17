<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class JwtAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('jwt');

        // Get the token from the header
        $token = $request->getCookie('myflow');

        if (empty($token)) {
            return service('response')->setJSON([
                'status' => 'error',
                'message' => 'Token not provided',
            ])->setStatusCode(401);
        }

        // Verify the token
        $decoded = verify_jwt($token);

        if (!$decoded) {
            return service('response')->setJSON([
                'status' => 'error',
                'message' => 'Invalid or expired token',
            ])->setStatusCode(401);
        }

        // Attach the decoded payload to the request for later use
        $request->decodedToken = $decoded;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after the request
    }
}