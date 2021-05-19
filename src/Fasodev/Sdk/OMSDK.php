<?php
/**
 * @author Yentema Nadjoari <n.yenteck@gmail.com> ,
 * @author S.C Jerôme ONADJA <jeromeonadja28@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Fasodev\Sdk;

/**
 * Class OMSDK
 * @package Fasodev\Sdk
 */
class OMSDK
{
    /**
     * @var TransactionInterface
     */
    protected $transaction;

    /**
     * OMSDK constructor.
     *
     * @param TransactionInterface $transaction <p>API to be used to handle payment process</>
     */
    public function __construct(TransactionInterface $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * @return mixed
     */
    public function handlePayment()
    {
        return $this->transaction->processPayment();
    }
}
