<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 01.10.2019
 */

namespace Appus\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Appus\Admin\Details\Details;
use Appus\Admin\Form\Form;
use Appus\Admin\Table\Table;

abstract class AdminController extends Controller
{

    public function index()
    {
        return $this->grid()->render();
    }

    public function show()
    {
        return $this->details()->render();
    }

    public function create()
    {
        return $this->form()->currentRouteAction('create')->render();
    }

    public function store()
    {
        return $this->form()->save();
    }

    public function update()
    {
        return $this->form()->save();
    }

    public function edit()
    {
        return $this->form()->currentRouteAction('edit')->render();
    }

    public function destroy()
    {
        return $this->form()->delete();
    }

    abstract public function grid(): Table;

    abstract public function details(): Details;

    abstract public function form(): Form;

}
