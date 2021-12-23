<?php

namespace Fasodev\Sdk;

class TransactionResponse implements TransactionResponseInterface
{
    protected int $status;
    protected string $message;
    protected ?string $transactionId = null;

    private function __construct(int $status, string $message, ?string $transactionId = null)
    {
        $this->transactionId = $transactionId;
        $this->message = $message;
        $this->status = $status;
    }

    public static function fromXMLResponse($xmlResponse): self
    {
        return new self((int)$xmlResponse->status, (string)$xmlResponse->message, (string)$xmlResponse->transID);
    }

    /**
     * @inheritdoc
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @inheritdoc
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }


    /**
     * @inheritdoc
     */
    public function getMessage(): string
    {
        return $this->message;
    }


}