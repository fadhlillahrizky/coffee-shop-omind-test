<?php

function get_user($request, $return_id = false)
{
    try {
        $header_token = $request->header('authorization');

        if (is_null($header_token)) {
            return null;
        }

        $sqluser = Tymon\JWTAuth\Facades\JWTAuth::toUser($header_token);

        if (empty($sqluser->id)) {
            return null;
        }

        if ($return_id) {
            return $sqluser->id;
        } else {
            return App\Models\User::find($sqluser->id);
        }

    } catch (Exception $e) {
        return null;
    }
}

function get_user_by_token($header_token, $return_id)
{
    try {
        if (is_null($header_token))
            return NULL;
        $sqluser = Tymon\JWTAuth\Facades\JWTAuth::toUser($header_token);
        if (empty($sqluser->id)) {
            return NULL;
        }

        if ($return_id)
            return $sqluser->id;
        else
            return App\Models\User::find($sqluser->id);
    } catch (Exception $e) {
        return NULL;
    }
}

function get_user_login($request, $return_id = FALSE)
{
    try {
        $header_token = $request->header('authorization');
        if (is_null($header_token))
            return NULL;
        for ($a = 1; $a <= 10; $a++) {
            $sqluser = Tymon\JWTAuth\Facades\JWTAuth::toUser($header_token);
            //Log::info("Attempt Login" . $a);
            if (empty($sqluser->id))
                continue;
            else
                break;

        }

        if ($return_id)
            return $sqluser->id;
        else
            return App\Models\User::find($sqluser->id);
    } catch (Exception $e) {
        return NULL;
    }
}


function get_merchant($request, $return_id = FALSE)
{
    try {
        $header_token = $request->header('authorization');
        if (is_null($header_token))
            return NULL;
        $sqlmerchant = Tymon\JWTAuth\Facades\JWTAuth::toUser($header_token);
        if (empty($sqlmerchant->id)) {
            return NULL;
        }

        if ($return_id)
            return $sqlmerchant->id;
        else
            return App\Models\Mysql\Merchants::find($sqlmerchant->id);
    } catch (Exception $e) {
        return NULL;
    }
}

function get_merchant_by_token($header_token, $kode_suplier)
{
    try {
        if (is_null($header_token))
            return NULL;
        $sqlmerchant = Tymon\JWTAuth\Facades\JWTAuth::toUser($header_token);
        if (empty($sqlmerchant->id)) {
            return NULL;
        }

        if ($kode_suplier)
            return $sqlmerchant->id;
        else
            return App\Models\Mysql\Merchants::find($sqlmerchant->id);
    } catch (Exception $e) {
        return NULL;
    }
}

function get_merchant_login($request, $kode_suplier = FALSE)
{
    try {
        $header_token = $request->header('authorization');
        if (is_null($header_token))
            return NULL;
        for ($a = 1; $a <= 10; $a++) {
            $sqlmerchant = Tymon\JWTAuth\Facades\JWTAuth::toUser($header_token);
            //Log::info("Attempt Login" . $a);
            if (empty($sqlmerchant->id))
                continue;
            else
                break;

        }

        if ($kode_suplier)
            return $sqlmerchant->id;
        else
            return App\Models\Mysql\Merchants::find($sqlmerchant->id);
    } catch (Exception $e) {
        return NULL;
    }
}

