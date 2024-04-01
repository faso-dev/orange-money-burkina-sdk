<?php
/**
 * @author Yentema Nadjoari <n.yenteck@gmail.com> ,
 * @author S.C Jerôme ONADJA <jeromeonadja28@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Fasodev\Sdk;

use Fasodev\Http\XMLHttp;
use Fasodev\Http\RequestBody;
use Fasodev\Sdk\Config\Credentials;
use Fasodev\Sdk\Config\TransactionData;
use Fasodev\Sdk\Exception\TransactionException;

/**
 * Class OrangeMoneyAPI
 * @package Fasodev\Sdk
 */
class OrangeMoneyAPI implements TransactionInterface
{
    protected const DEV_API_URL = "https://testom.orange.bf:9008/payment";
    protected const PROD_API_URL = "https://apiom.orange.bf";

    protected TransactionData $transactionData;

    protected Credentials $credentials;

    protected string $apiUrl;

    protected bool $withSSLVerification = XMLHttp::WITH_SSL_ENABLED;

    /**
     * @param string $username
     * @param string $password
     * @param string $merchantNumber
     */
    public function __construct(string $username,
                                string $password,
                                string $merchantNumber)
    {
        $this->credentials = Credentials::from($username, $password, $merchantNumber);
        $this->useDevApi();
    }

    /**
     * @return TransactionResponseInterface
     * @throws TransactionException
     */
    public function processPayment(): TransactionResponseInterface
    {
        /**
         * @var $errno int
         * @var $errorMessage string
         * @var $response mixed
         */
        [$errno, $errorMessage, $response] = $this->processRequest();
        if ($errno > 0) {
            throw new TransactionException($errorMessage, $errno);
        }

        $response = TransactionResponse::fromXMLResponse($response);

        if ($response->getStatus() !== 200) {
            throw new TransactionException($response->getMessage(), $response->getStatus());
        }

        return $response;
    }

    /**
     * @return array
     */
    private function processRequest(): array
    {
        return XMLHttp::request($this->apiUrl, [

        ], RequestBody::from($this->credentials, $this->transactionData),
            $this->withSSLVerification
        );
    }

    /**
     * @param string $reference
     * @return $this
     */
    public function withCustomReference(string $reference): self
    {
        $this->transactionData->setReferenceNumber($reference);
        return $this;
    }

    public function withExternalReference(string $externalReference): self
    {
        $this->transactionData->setExternalReference($externalReference);
        return $this;
    }

    /**
     * @param TransactionData $transactionData
     * @return $this
     */
    public function withTransactionData(TransactionData $transactionData): self
    {
        $this->transactionData = $transactionData;
        return $this;
    }

    /**
     * @return $this
     */
    public function withoutSSLVerification(): self
    {
        $this->withSSLVerification = XMLHttp::WITH_SSL_DISABLED;
        return $this;
    }

    /**
     * @param string $devApiUrl
     * @return $this
     */
    public function useDevApi(string $devApiUrl = self::DEV_API_URL): self
    {

        $this->apiUrl = $devApiUrl;
        return $this;
    }

    /**
     * @param string $prodApiUrl
     * @return $this
     */
    public function useProdApi(string $prodApiUrl = self::PROD_API_URL): self
    {
        $this->apiUrl = $prodApiUrl;
        return $this;
    }

}