<?php

use Carbon\Carbon;
function presentPrice($price)
{
    return number_format($price);
}
function orderStatus($status)
{
    switch ($status) {
        case '1':
            return '處理中';
            break;
        case '2':
            return '寄送中';
            break;
        case '3':
            return '已簽收';
            break;
        case '4':
            return '申請退款';
            break;    
        default:
            return '訂單有問題，請聯絡管理員';
            break;
    }
}
