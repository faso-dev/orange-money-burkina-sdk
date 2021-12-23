<?php

namespace Fasodev\Sdk;

interface TransactionResponseInterface
{
    /**
     * @return int
     */
    public function getStatus(): int;

    /**
     * @return string
     */
    public function getTransactionId(): string;


    /**
     * @return string
     */
    public function getMessage(): string;


}