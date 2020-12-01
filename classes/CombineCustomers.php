<?php

require __DIR__ . '/../vendor/autoload.php';

class CombineCustomers
{
    private $api;

    public function __construct($client)
    {
        $this->api = $client = new \RetailCrm\ApiClient(
            'https://youngyou.retailcrm.ru/',
            'Dzz4SpTgMNmvF9M5pGqqwnHtAUKnTEBB',
            \RetailCrm\ApiClient::V5
        );
    }

    public function checkByFields($customerCheck = array(), $fields = array()) : Array {
        $filter = $this->generateFilter($customerCheck,$fields);
        $customers = $this->api->request->customersList($filter,1,100);
        $totalCount = $customers['pagination']['totalCount'];


        return [];
    }

    private function generateFilter($customerCheck,$fields = []) : Array {
        $filter = [];
        foreach ($fields as $field) {
            if ($field == 'phone')
                $filter[$field] = $customerCheck['phones'][0]['number'];
            else
                $filter[$field] = $customerCheck[$field];
        }
        return $filter;
    }
}