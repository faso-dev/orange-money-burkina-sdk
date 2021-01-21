<?php

namespace App\CUrl;

/**
 * Class RawCUrlResponse
 * @package App\CUrl
 */
class RawCUrlResponse
{
    private $header;
    private $content;
    private $erno;
    private $error;

    public function __construct(array $data)
    {
        $this->header   = isset($data['header']) ? $data['header'] : null;
        $this->content  = isset($data['body']) ? $data['body'] : null;
        $this->erno     = isset($data['erno']) ? $data['erno'] : null;
        $this->error    = isset($data['error']) ? $data['error'] : null;
    }

    /**
     * @return string|null
     */
    public function getHeader(): ?string
    {
        return $this->header;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Different de 0 si la requête n'aboutit pas par exemple probleme réseau ou refus de connexion de la par du serveur
     * @return mixed
     */
    public function getErno()
    {
        return $this->erno;
    }

    /**
     * L'erreur compter par <b>erno</b>
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

}
