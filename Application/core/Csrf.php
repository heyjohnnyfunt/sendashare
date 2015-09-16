<?php /**
 * Created by PhpStorm.
 * User: skogs
 * Date: 16.09.2015
 * Time: 9:59
 */
class Csrf
{
    private static $max_time = 60 * 60 * 24; // token is valid for 1 day

    public static function makeToken()
    {
        $stored_time = Session::get('csrf_token_time');
        $csrf_token = Session::get('csrf_token');
        if (self::$max_time + $stored_time <= time() || empty($csrf_token)) {
            Session::set('csrf_token', md5(uniqid(rand(), true)));
            Session::set('csrf_token_time', time());
        }
        return Session::get('csrf_token');
    }

    public static function isTokenValid()
    {
        $stored_time = Session::get('csrf_token_time');
        if (self::$max_time + $stored_time <= time()) {
            return false;
        }
        $token = Request::get_post('csrf_token');
        return $token === Session::get('csrf_token') && !empty($token);
    }

    public static function generateKeys()
    {
        $config = array(
            "digest_alg" => "sha256",
            "private_key_bits" => 1024,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );

        // Create the private and public key
        $res = openssl_pkey_new($config);
        // Extract the private key from $res to $privateKey
        openssl_pkey_export($res, $privateKey);

        // Extract the public key from $res to $publicKey
        $publicKey = openssl_pkey_get_details($res);
        $publicKey = $publicKey["key"];

        Session::set('RSA_private',$privateKey);
        Session::set('RSA_public',$publicKey);

        return Session::get('RSA_public');
    }
}