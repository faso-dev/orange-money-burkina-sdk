<?php
/**
 * @author Yentema Nadjoari <n.yenteck@gmail.com> ,
 * @author S.C Jerôme ONADJA <jeromeonadja28@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Fasodev\Sdk;

use Fasodev\Exceptions\PaymentSDKException;

/**
 * Interface TransactionInterface
 * @package Fasodev\Sdk
 */
interface TransactionInterface
{
    /**
     * @return mixed
     * @throws PaymentSDKException
     */
    public function processPayment();
}