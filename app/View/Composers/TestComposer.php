<?php

namespace App\View\Composers;

use Illuminate\View\View;

class TestComposer
{
    public function compose(View $view)
    {
        $view->with('test_key', 'test_value');
    }

}
