購物網專案<br>
1.下載完專案後 請用 cp .env.example .env 複製環境檔<br>
2.執行composer install<br>
3.建立公開儲存空間php artisan storage:link<br>
4.建立資料表單php artisan migrate<br>
5.產生預設資料php artisan db:seed<br>
6.產生php artisan key:generate<br>
7.使用內建php artisan serve 開啟方法:<br>
開啟兩個cmd 到專案路徑底下 分別執行：<br>
php artisan serve --host=shoppingweb.user.com --port=8001<br>
http://shoppingweb.user.com:8001/<br>
圖片會找不到請到後端庫存管理修改，重新上傳想要的圖片<br>
php artisan serve --host=shoppingweb.admin.com --port=8002<br>
http://shoppingweb.admin.com:8002/<br>
後台 帳號:admin 密碼:admin

