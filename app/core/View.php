<?php

namespace App\Core;

/**
 * View model
 */
class View
{
    /**
     * Render view with layout
     *
     * @param  string $layout Layout name
     * @param  string $name   View name
     * @param  array  $args   Arguments in view
     * @return object $this
     */
    public function render($layout, $name, $args = [])
    {
        ob_start();
        extract($args);

        include APP.'app/view/'.$name.'.phtml';

        $content = ob_get_contents();
        ob_get_clean();

        include APP.'app/view/'.$layout.'.phtml';

        return $this;
    }
}
