<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 19.11.2019
 */

namespace Appus\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Appus\Admin\EncryptionService;
use Illuminate\Http\Request;

class MetricController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function load(Request $request)
    {
        $class = EncryptionService::decrypt($request->get('key'));
        $class = app($class);
        return $class->load($request->get('filter', []));
    }

}
