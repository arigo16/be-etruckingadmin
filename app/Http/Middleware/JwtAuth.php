<?php
namespace App\Http\Middleware;
use Closure;
use Exception;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class JwtAuth
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->bearerToken();
        
        if(!$token) {
            return response()->json([
                'status' => 401,
                "message" => 'Token not provided.',
                "data" => []
            ], 401);
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch(ExpiredException $e) {
            return response()->json([
                'status' => 400,
                "message" => 'Provided token is expired.',
                "data" => []
            ], 400 );
        } catch(Exception $e) {
            return response()->json([
                'status' => 400,
                "message" => 'Token invalid',
                "data" => []
            ], 400 );
        }

        $user = User::find($credentials->sub);
        $request->auth = $user;
        return $next($request);
    }
}