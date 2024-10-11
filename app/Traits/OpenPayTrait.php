<?php
/**
namespace App\Traits;

use Openpay\Data\Client as Openpay;

require_once base_path('vendor/autoload.php');

trait OpeyPayTrait
{

    protected $openpay;

    public function __construct()
    {
        Openpay::setId(env('OPENPAY_ID'));
        Openpay::setApiKey(env('OPENPAY_SK'));

        $this->openpay = Openpay::getInstance(env('OPENPAY_ID'), env('OPENPAY_SK'));
    }
}
**/