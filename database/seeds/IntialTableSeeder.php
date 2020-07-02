<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class IntialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'admin',
                'email' => 'qwzx3505@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$9Cgx/MM4Ni/yedM9BXmZEOkPeJ39ReIlE0mMnzoFp5NjH4eLiNsEa',
                'remember_token' => '0mi8wdRX86kHGEl7uWO1ejaCgtJrkIrSQLAJYGcxyu5JIITDuFlyjmElxRuy',
                'created_at' => '2020-06-29 01:33:45',
                'updated_at' => '2020-06-29 01:33:45',
                'active' => '1',
                'phone' => '0962051200',
                'address' => '台中市北區太原七街',
                'total_cost' => 0.00,
                'role_id' => 2,
                'level_level' => 0,
            ],
        ]);
        DB::table('products')->insert([
            [
                'id' => 1,
                'name' => '電腦',
                'description' => 'G21CXRTX2080顯卡\r\nI7雙碟獨顯電競機\r\n固態電容不怕爆漿',
                'price' => 30000.00,
                'amount' => 3,
                'buy_yn' => 'Y',
                'display_yn' => 'Y',
                'file_id' => '1',
                'created_at' => '2020-06-29 01:39:09',
                'updated_at' => '2020-06-29 01:39:09',
                'enable' => '1',
            ],
            [
                'id' => 2,
                'name' => '100元',
                'description' => '好用的孫中山',
                'price' => 100.00,
                'amount' => 7,
                'buy_yn' => 'Y',
                'display_yn' => 'Y',
                'file_id' => '2',
                'created_at' => '2020-06-29 01:41:12',
                'updated_at' => '2020-06-29 01:41:12',
                'enable' => '1',
            ],
            [
                'id' => 3,
                'name' => '200元',
                'description' => '可能絕種了',
                'price' => 200.00,
                'amount' => 6,
                'buy_yn' => 'Y',
                'display_yn' => 'Y',
                'file_id' => '3',
                'created_at' => '2020-06-29 01:41:52',
                'updated_at' => '2020-06-29 01:41:52',
                'enable' => '1',
            ],
            [
                'id' => 4,
                'name' => '500元',
                'description' => '台灣少棒',
                'price' => 500.00,
                'amount' => 6,
                'buy_yn' => 'Y',
                'display_yn' => 'Y',
                'file_id' => '4',
                'created_at' => '2020-06-29 01:42:09',
                'updated_at' => '2020-06-29 01:42:09',
                'enable' => '1',
            ],
            [
                'id' => 5,
                'name' => '1000元',
                'description' => '小朋友看地球',
                'price' => 1000.00,
                'amount' => 6,
                'buy_yn' => 'Y',
                'display_yn' => 'Y',
                'file_id' => '5',
                'created_at' => '2020-06-29 01:43:09',
                'updated_at' => '2020-06-29 01:43:09',
                'enable' => '1',
            ],
            [
                'id' => 6,
                'name' => '2000元',
                'description' => '可能是假鈔',
                'price' => 2000.00,
                'amount' => 12,
                'buy_yn' => 'Y',
                'display_yn' => 'Y',
                'file_id' => '6',
                'created_at' => '2020-06-29 01:44:09',
                'updated_at' => '2020-06-29 01:44:09',
                'enable' => '1',
            ],
        ]);
        DB::table('files')->insert([
            [
                'id' => 1,
                'filename' => 'phpEHijw5.png',
                'mime' => 'image/png',
                'original_filename' => '金融.png',
                'created_at' => '2020-06-29 01:39:09',
                'updated_at' => '2020-06-29 01:39:09',
            ],
            [
                'id' => 2,
                'filename' => 'php9IqaFf.png',
                'mime' => 'image/png',
                'original_filename' => '金融.png',
                'created_at' => '2020-06-29 01:39:09',
                'updated_at' => '2020-06-29 01:39:09',
            ],
            [
                'id' => 3,
                'filename' => 'phpti18br.png',
                'mime' => 'image/png',
                'original_filename' => '金融.png',
                'created_at' => '2020-06-29 01:39:09',
                'updated_at' => '2020-06-29 01:39:09',
            ],
            [
                'id' => 4,
                'filename' => 'phpmdMs1c.png',
                'mime' => 'image/png',
                'original_filename' => '金融.png',
                'created_at' => '2020-06-29 01:39:09',
                'updated_at' => '2020-06-29 01:39:09',
            ],
            [
                'id' => 5,
                'filename' => 'phpATaSgZ.png',
                'mime' => 'image/png',
                'original_filename' => '金融.png',
                'created_at' => '2020-06-29 01:39:09',
                'updated_at' => '2020-06-29 01:39:09',
            ],
            [
                'id' => 6,
                'filename' => 'phpsgmJM6.png',
                'mime' => 'image/png',
                'original_filename' => '金融.png',
                'created_at' => '2020-06-29 01:39:09',
                'updated_at' => '2020-06-29 01:39:09',
            ],
        ]);
        DB::table('levels')->insert([
            [
                'id' => 1,
                'name' => 'VIP0',
                'description' => '一般會員',
                'level' => 0,
                'upgrade' => 0.00,
            ],
        ]);
        DB::table('offers')->insert([
            [
                'id' => 1,
                'level_level' => 0,
                'cashback_yn' => 'N',
                'discount_yn' => 'N',
                'rebate_yn'   => 'N',
            ],
        ]);
        DB::table('cashbacks')->insert([
            [
                'id' => 1,
                'offer_id' => 1,
                'above' => 0,
                'percent' => 0,
            ],
        ]);
        DB::table('discounts')->insert([
            [
                'id' => 1,
                'offer_id' => 1,
                'above' => 0,
                'percent' => 0,
            ],
        ]);
        DB::table('rebates')->insert([
            [
                'id' => 1,
                'offer_id' => 1,
                'above' => 0,
                'rebate' => 0,
            ],
        ]);
    }
}
