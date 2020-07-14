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
            return __('shop.Processing');
            break;
        case '2':
            return __('shop.Sending');
            break;
        case '3':
            return __('shop.Received');
            break;
        case '4':
            return __('shop.applyrefund');
            break;   
        case '5':
            return __('shop.Refunded');
            break; 
        case '6':
            return __('shop.Refused to refund');
            break; 
        default:
            return __('shop.please contact the administrator');
            break;
    }
}
function ContactStatus($status)
{
    switch ($status) {
        case '1':
            return  __('shop.Unprocessed');
            break;
        case '2':
            return  __('shop.Processing');
            break;
        case '3':
            return  __('shop.Case Close');
            break;
        default:
            return __('shop.Unknown state');
            break;
    }
}
function txStatus($status)
{
    switch ($status) {
        case '1':
            return __('shop.Manual deposit');
            break;
        case '2':
            return __('shop.Manual withdrawal');
            break;
        case '3':
            return __('shop.Shopping discount');
            break;
        case '4':
            return __('shop.Virtual currency feedback');
            break;
        case '5':
            return __('shop.Rebated');
            break;
        case '6':
            return __('shop.Return and return virtual currency');
            break;
        case '7':
            return __('shop.Refused cashback');
            break;
        case '8':
            return __('shop.Refused rebate');
            break;
        default:
            return __('shop.Account default');
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
function setDollorLog($user_id,$tx_type,$amount,$sub_total,$order,$memo)
{
    $dollorLog = new DollorLog;
    $dollorLog->user_id = $user_id;
    $dollorLog->tx_type = $tx_type;
    $dollorLog->amount = $amount;
    $dollorLog->sub_total = $sub_total;
    $dollorLog->order_id = $order;
    $dollorLog->memo = $memo ?? '';
    $dollorLog->save();
}
