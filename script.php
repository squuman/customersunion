<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ .'/classes/CombineCustomers.php';

$client = new \RetailCrm\ApiClient(
    'https://youngyou.retailcrm.ru/',
    'Dzz4SpTgMNmvF9M5pGqqwnHtAUKnTEBB',
    \RetailCrm\ApiClient::V5
);

$combineCustomers = new CombineCustomers($client);
$customerRequest = $client->request->customersList([],1,100);
$totalCount = $customerRequest['pagination']['totalCount'];

for ($i = 1; $i <= $totalCount;$i++) {
    $customers = $client->request->customersList([],$i,100);
    foreach ($customers['customers'] as $customer) {
        print_r($customer);
        $combineCustomers->checkByFields($customer,['email','firstName']);
        die;
    }
}
