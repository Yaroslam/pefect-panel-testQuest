<?php

namespace Exchange\Exchanger;

use Exchange\Exceptions\CurrencyNotFoundException;
use Exchange\Exceptions\MinimumValueException;

class Exchanger
{
    const COMMISSION_RATE = 0.02;

    private $targetCurrency = 'BTC';

    private $minExchange = 0.01;

    private $exchangeData;

    public function __construct($exchangeData)
    {
        $this->exchangeData = $exchangeData;
    }

    private function applyCommission($val, $raise = true)
    {
        return $raise ? $val * 1 + self::COMMISSION_RATE : $val * 1 - self::COMMISSION_RATE;
    }

    private function checkIsCurrencySet($currency): bool
    {
        return array_key_exists($currency, $this->exchangeData);
    }

    public function exchange($from, $to, $value)
    {
        $this->checkForMinChange($value);
        if ($from == $this->targetCurrency) {
            if (! $this->checkIsCurrencySet($to)) {
                throw new CurrencyNotFoundException($to);
            }
            $rate = $this->applyCommission($this->exchangeData[$to]['last']);
            $converted_value = round($value * $rate, 2);
        } else {
            if (! $this->checkIsCurrencySet($from)) {
                throw new CurrencyNotFoundException($from);
            }
            $rate = $this->applyCommission($this->exchangeData[$from]['last'], false);
            $converted_value = round($value / $rate, 10);
        }

        return ['value' => $value,
            'converted_value' => $converted_value,
            'rate' => $rate,
            'currency_from' => $from,
            'currency_to' => $to];
    }

    public function getRates(array $needsRates, $sort = true)
    {
        $resRates = [];
        foreach ($needsRates as $rate) {
            if (! $this->checkIsCurrencySet($rate)) {
                throw new CurrencyNotFoundException($rate);
            }
            $resRates[$rate] = $this->applyCommission($this->exchangeData[$rate]['last']);
        }

        if ($sort) {
            asort($resRates);
        }

        return $resRates;
    }

    private function checkForMinChange($value)
    {
        return $value >= $this->minExchange ? true : throw new MinimumValueException($this->minExchange);
    }

    public function getCommision()
    {
        return self::COMMISSION_RATE;
    }
}
