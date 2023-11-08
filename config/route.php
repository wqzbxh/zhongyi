<?php
/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Webman\Route;
// 匹配所有options路由
//关闭自动路由

//Route::any('/', [app\controller\admin\HomeController::class, 'index']);
Route::group('/api', function () {
    Route::get('/get_prescription_list', [app\controller\api\PrescriptionController::class, 'getPrescriptionList']);
    Route::get('/get_book_list', [app\controller\api\BooksController::class, 'getBooklist']);
//    获取药材
    Route::get('/get_herbs_list', [app\controller\api\HerbsController::class, 'getHerbsList']);
    Route::get('/get_herbs_detail', [app\controller\api\HerbsController::class, 'detail']);
    Route::get('/get_herbs_select_list', [app\controller\api\HerbsController::class, 'getSelectList']);
    Route::get('/search_prescription', [app\controller\api\PrescriptionController::class, 'searchPrescription']);
    Route::get('/get_prescription_detail', [app\controller\api\PrescriptionController::class, 'getDetail']);
    // 匹配所有options路由
    Route::options('[{path:.+}]', function (){
        return response('');
    });
})->middleware([
    app\middleware\AccessControl::class,
]);


Route::disableDefaultRoute();