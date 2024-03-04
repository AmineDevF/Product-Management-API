<?php
/**
 * User: amine
 * Date: 3/3/2024
 * Time: 6:34 AM
 */

namespace App\Enums;


/**
 * Class PaymentStatus
 *
 * @author  hmidouche amine  <amine.devinf@gmail.com>
 * @package App\Enums
 */
enum PaymentStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Failed = 'failed';
}
