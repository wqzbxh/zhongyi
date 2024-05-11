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
Route::disableDefaultRoute();

Route::any('/', function (){
    return "<h1>Heelo </h1>";
});
Route::group('/api', function () {
    Route::get('/get_prescription_list', [app\controller\admin\PrescriptionController::class, 'getPrescriptionList']);

//    获取药材
    Route::get('/get_herbs_list', [app\controller\admin\HerbsController::class, 'getHerbsList']);
    Route::get('/get_herbs_select_list', [app\controller\admin\HerbsController::class, 'getSelectList']);
})->middleware([
    app\middleware\AccessControl::class,
]);

