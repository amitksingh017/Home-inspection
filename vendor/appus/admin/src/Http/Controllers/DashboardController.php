<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 21.04.2020
 */

namespace Appus\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class DashboardController extends Controller
{

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('admin::dashboard')
            ->with([
                'metrics' => $this->metrics(),
            ]);
    }

    /**
     * @return array
     */
    public function metrics(): array
    {
        return [

        ];
    }

}
