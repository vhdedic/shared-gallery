<?php

Namespace App\Core;

class Test
{
    function checkInclude()
    {
        echo '<pre>';
        var_dump(get_included_files());
        echo '</pre>';
    }

}
