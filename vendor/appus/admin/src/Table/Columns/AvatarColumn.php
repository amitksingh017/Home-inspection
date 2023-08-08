<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 10.10.2019
 */

namespace Appus\Admin\Table\Columns;

class AvatarColumn extends ImageColumn
{

    public function __construct($field, $name)
    {
        parent::__construct($field, $name);
        $this->styles['border-radius'] = '50%';
    }

}
