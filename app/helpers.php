<?php

use Carbon\Carbon;
use App\File;
use App\DollorLog;
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
        case '5':
            return '已退款';
            break; 
        case '6':
            return '拒絕退款';
            break; 
        default:
            return '訂單有問題，請聯絡管理員';
            break;
    }
}
function ContactStatus($status)
{
    switch ($status) {
        case '1':
            return '未處理';
            break;
        case '2':
            return '處理中';
            break;
        case '3':
            return '已回覆';
            break;
        default:
            return '不明狀態';
            break;
    }
}
function userActive($active)
{
    switch ($active) {
        case '1':
            return '否';
            break;
        default:
            return '是';
            break;
    }
}
function getImageInCart($file_id){
    $filename =File::find($file_id)->filename;
    $imgUrl = 'storage/'.$filename.'';
    return $imgUrl;
}
function saveDiscount($percent)
{
    switch ($percent) {
        case 1:
            return 10;
            break;
        case 2:
            return 20;
            break;
        case 3:
            return 30;
            break;
        case 4:
            return 40;
            break;
        case 5:
            return 50;
            break;
        case 6:
            return 60;
        break;
        case 7:
            return 70;
            break;
        case 8:
            return 80;
            break;
        case 9:
            return 90;
            break;
        default:
            return $percent;
            break;
    }
}
function showDiscount($percent)
{
    switch ($percent) {
        case 10:
            return 1;
            break;
        case 20:
            return 2;
            break;
        case 30:
            return 3;
            break;
        case 40:
            return 4;
            break;
        case 50:
            return 5;
            break;
        case 60:
            return 6;
        break;
        case 70:
            return 7;
            break;
        case 80:
            return 8;
            break;
        case 90:
            return 9;
            break;
        default:
            return $percent;
            break;
    }
}
function setDollorLog($user_id,$tx_type,$amount,$sub_total,$memo){
    $dollorLog = new DollorLog;
    $dollorLog->user_id = $user_id;
    $dollorLog->tx_type = $tx_type;
    $dollorLog->amount = $amount;
    $dollorLog->sub_total = $sub_total;
    $dollorLog->memo = $memo;
    $dollorLog->save();
}
