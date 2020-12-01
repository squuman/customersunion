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

    public function findCustomersByFields($customerCheck = array(), $fields = array()): array
    {
        $filter = $this->generateFilter($customerCheck, $fields);
        $customers = $this->api->request->customersList($filter, 1, 100);
        $totalCount = $customers['pagination']['totalCount'];
        $combineCustomersId = [];
        for ($i = 1; $i <= $totalCount; $i++) {
            foreach ($customers['customers'] as $customer) {
                if ($customer['id'] != $customerCheck['id'] and !in_array($customer['id'],$combineCustomersId)) {
                    $combineCustomersId[] = $customer['id'];
                    print_r($customer);
                }

            }
        }

        if (empty($combineCustomersId))
            return [
              'warning' => 'customers not found'
            ];

        return $combineCustomersId;
    }

    private function generateFilter($customerCheck, $fields = []): array
    {
        if (empty($fields))
            return [];

        $filter = [];

        foreach ($fields as $field) {
            if ($field == 'phone')
                $filter[$field] = $customerCheck['phones'][0]['number'];
            elseif (in_array($field, ['firstName', 'lastName', 'patronymic']))
                $filter['name'] = $customerCheck[$field];
            else
                $filter[$field] = $customerCheck[$field];
        }
        return $filter;
    }
}