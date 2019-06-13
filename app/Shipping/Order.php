<?php
declare(strict_types=1);


namespace App\Shipping;


class Order
{
    private $price;
    private $weight;
    private $countryCode;

    /**
     * Order constructor.
     * @param int    $price
     * @param int    $weight
     * @param string $countryCode
     */
    private function __construct(int $price, int $weight, string $countryCode)
    {
        $this->price       = $price;
        $this->weight      = $weight;
        $this->countryCode = $countryCode;
    }

    /**
     * @param int    $price
     * @param int    $weight
     * @param string $countryCode
     * @return Order
     */
    public static function create(int $price, int $weight, string $countryCode): Order
    {
        return new self($price, $weight, $countryCode);
    }

    /**
     * @return string
     */
    public function countryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @return int
     */
    public function weight(): int
    {
        return $this->weight;
    }

    /**
     * @return int
     */
    public function price(): int
    {
        return $this->price;
    }
}