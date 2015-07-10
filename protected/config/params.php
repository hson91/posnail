<?php
return array(
        'gender' => array(1 => 'Male',2 => 'Female',3 => 'Other'),
        'flag.disable' => array(0 => 'No', 1 => 'Yes'),
        'flag.delete' => array(0 => 'No', 1 => 'Yes'),
        'flag.sync' => array(0 => 'Unfulfilled', 1 => 'Synced'),
        'customer.level' => array(0 => 'NORMAL', 1 => 'VIP'),
        'order.status' => array(0 => 'Unsave',1 => 'Opening',2 => 'Closed',3 => 'Cancelled'),
        'order.method' => array(1 => 'Cash',2 => 'Credit',3 => 'Gifcard',4 => 'Check', 5 => 'Other'),
        'store.status' => array(0 => 'N/A',1 => 'Disable',2 => 'Enable',3 => 'lock', 4 => 'Lock unlimit', 5 => 'Trial', 6 => 'Expired trial'),
        'lock' => array(0 => 'Unlock',1 => 'Locked'),
        'active' => array(0 => 'Disable',1 => 'Enable'),
        'user.role' => array(1 => 'Admin',2 => 'Manager'),
        'user.intended' => array(0 => 'System',1 => 'Store'),
        'defaultPageSize' => 10,
        'recordsPerPage'=>array(10 => 10, 20 => 20,100 => 100,500=>500, 1000 => 1000),
        'request'=>array('enableCsrfValidation'=>true,'enableCookieValidation'=>true),
        'copyright.info' => array('name' => '','email' => 'hson91@gmail.com', 'tel' => '','skype' => '','website' => '//:www.khoisang.com','version' => 'v.01'),
    );
?>