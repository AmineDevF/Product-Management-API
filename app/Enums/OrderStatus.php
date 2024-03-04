<?php
/**
 * User: amine
 * Date: 3/3/2024
 * Time: 6:34 AM
 */

namespace App\Enums;


/**
 * Class OrderStatus
 *
 * @author  amine hmidouche <amine.devinf@gmail.com>
 * @package App\Enums
 */
enum OrderStatus: string
{
    case Unpaid = 'unpaid';
    case Paid = 'paid';
    case Cancelled = 'cancelled';
    case Shipped = 'shipped';
    case Completed = 'completed';

    public static function getStatuses()
    {
        return [
            self::Paid, self::Unpaid, self::Cancelled, self::Shipped, self::Completed
        ];
    }
}
