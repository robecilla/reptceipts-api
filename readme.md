# reptceipts
get purchase receipts in your mobile phone

#API enpoints (so far)
+-----------+------------------------------+------------------+--------------------------------------------------+--------------+
| Method    | URI                          | Name             | Action                                           | Middleware   |
+-----------+------------------------------+------------------+--------------------------------------------------+--------------+
| GET|HEAD  | /                            |                  | Closure                                          | web          |
| POST      | api/login                    |                  | App\Http\Controllers\AuthController@login        | api          |
| GET|HEAD  | api/receipt                  | receipt.index    | App\Http\Controllers\ReceiptController@index     | api,jwt.auth |
| POST      | api/receipt                  | receipt.store    | App\Http\Controllers\ReceiptController@store     | api,jwt.auth |
| GET|HEAD  | api/receipt/create           | receipt.create   | App\Http\Controllers\ReceiptController@create    | api,jwt.auth |
| GET|HEAD  | api/receipt/getDetail/{id}   |                  | App\Http\Controllers\ReceiptController@getDetail | api,jwt.auth |
| PUT|PATCH | api/receipt/{receipt}        | receipt.update   | App\Http\Controllers\ReceiptController@update    | api,jwt.auth |
| DELETE    | api/receipt/{receipt}        | receipt.destroy  | App\Http\Controllers\ReceiptController@destroy   | api,jwt.auth |
| GET|HEAD  | api/receipt/{receipt}        | receipt.show     | App\Http\Controllers\ReceiptController@show      | api,jwt.auth |
| GET|HEAD  | api/receipt/{receipt}/edit   | receipt.edit     | App\Http\Controllers\ReceiptController@edit      | api,jwt.auth |
| POST      | api/register                 |                  | App\Http\Controllers\AuthController@register     | api          |
| POST      | api/retailer                 | retailer.store   | App\Http\Controllers\RetailerController@store    | api,jwt.auth |
| GET|HEAD  | api/retailer                 | retailer.index   | App\Http\Controllers\RetailerController@index    | api,jwt.auth |
| GET|HEAD  | api/retailer/create          | retailer.create  | App\Http\Controllers\RetailerController@create   | api,jwt.auth |
| DELETE    | api/retailer/{retailer}      | retailer.destroy | App\Http\Controllers\RetailerController@destroy  | api,jwt.auth |
| PUT|PATCH | api/retailer/{retailer}      | retailer.update  | App\Http\Controllers\RetailerController@update   | api,jwt.auth |
| GET|HEAD  | api/retailer/{retailer}      | retailer.show    | App\Http\Controllers\RetailerController@show     | api,jwt.auth |
| GET|HEAD  | api/retailer/{retailer}/edit | retailer.edit    | App\Http\Controllers\RetailerController@edit     | api,jwt.auth |
| GET|HEAD  | api/user                     | user.index       | App\Http\Controllers\UserController@index        | api,jwt.auth |
| POST      | api/user                     | user.store       | App\Http\Controllers\UserController@store        | api,jwt.auth |
| GET|HEAD  | api/user/create              | user.create      | App\Http\Controllers\UserController@create       | api,jwt.auth |
| DELETE    | api/user/{user}              | user.destroy     | App\Http\Controllers\UserController@destroy      | api,jwt.auth |
| PUT|PATCH | api/user/{user}              | user.update      | App\Http\Controllers\UserController@update       | api,jwt.auth |
| GET|HEAD  | api/user/{user}              | user.show        | App\Http\Controllers\UserController@show         | api,jwt.auth |
| GET|HEAD  | api/user/{user}/edit         | user.edit        | App\Http\Controllers\UserController@edit         | api,jwt.auth |
+-----------+------------------------------+------------------+--------------------------------------------------+--------------+
