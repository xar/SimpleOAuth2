<?php

namespace Media24si\SimpleOAuth2\Entities;

use Illuminate\Database\Eloquent\Model;
use OAuth2\Model\IOAuth2Token;
use Illuminate\Contracts\Auth\Authenticatable;

abstract class Token extends Model implements IOAuth2Token
{

    public $timestamps = false;

    protected $casts = [
        'user_id'    => 'integer',
        'expires_at' => 'integer'
    ];

    public function client()
    {
        return $this->belongsTo('Media24si\SimpleOAuth2\Entities\Client');
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @return integer
     */
    public function getExpiresIn()
    {
        return $this->expires_at - time();
    }

    /**
     * @return boolean
     */
    public function hasExpired()
    {
        return $this->expires_at < time();
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return null|string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->user_id;
    }

    public function setData($data)
    {

        if ($data instanceof Authenticatable) {
            $this->user_id = $data->getAuthIdentifier();
        } else {
            if (is_numeric($data)) {
                $this->user_id = $data;
            }
        }

    }

}
