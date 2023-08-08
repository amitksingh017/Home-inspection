<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 16.03.2020
 */

namespace Appus\Admin\Http\Controllers\Auth\Traits;

trait RedirectsUsers
{
    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }
}
