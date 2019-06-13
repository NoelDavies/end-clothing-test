# Improvements

**Calculator**

I'd like to add a rules engine for the calculator, something like the below:
```php
$rules = ShippingRules::make([
    \App\Shipping\Rules\JPBasePriceRule::class,
    \App\Shipping\Rules\UKBaseWeightRule::class,
    \App\Shipping\Rules\JPBasePriceRule::class,
    \App\Shipping\Rules\GenericCountryPriceRule::class,
    \App\Shipping\Rules\GenericCountryWeightRule::class
]);

$calculator = ShippingCalculator::withRules($rules);
```

**Repository**
I'd also add a repository in there to enable switching between different data sources.

**Methods**
I didn't get time to write an Update or List action. but I'd add those in too given the time.

In the list and show (read) actions I'd also implement self-describing actions to allow pure API navigation