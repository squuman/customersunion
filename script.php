<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ .'/classes/CombineCustomers.php';

$client = new \RetailCrm\ApiClient(
    '',
    '',
    \RetailCrm\ApiClient::V5
);

$combineCustomers = new CombineCustomers($client);
$customerRequest = $client->request->customersList([],1,100);
$totalCount = $customerRequest['pagination']['totalCount'];

for ($i = 1; $i <= $totalCount;$i++) {
    $customers = $client->request->customersList([],$i,100);
    foreach ($customers['customers'] as $customer) {
        $combineIds = $combineCustomers->findCustomersByFields($customer,['email','firstName']);
        if (isset($combineIds['warning']))
            continue;
        print_r($customer['id']);
        print_r($combineIds);
        die;
    }
}
