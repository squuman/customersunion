<?php
require __DIR__ . '/vendor/autoload.php';

$client = new \RetailCrm\ApiClient(
    'https://youngyou.retailcrm.ru/',
    'Dzz4SpTgMNmvF9M5pGqqwnHtAUKnTEBB',
    \RetailCrm\ApiClient::V5
);

$customerRequest = $client->request->customersList([],1,100);
$totalCount = $customerRequest['pagination']['totalCount'];

for ($i = 1; $i <= $totalCount;$i++) {
    $customers = $client->request->customersList([],$i,100);
    foreach ($customers['customers'] as $customer) {
        print_r($customer);
        die;
    }
}
