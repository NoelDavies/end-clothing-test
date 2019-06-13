<?php
declare(strict_types=1);


namespace App\Shipping\Exception;


class MissingShippingRuleException extends \RuntimeException
{
    public static function countryCode()
    {
        return new self('Country Code has no valid rule to apply');
    }
}