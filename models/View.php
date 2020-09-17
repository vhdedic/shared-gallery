<?php

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
        // Include view
        include VIEWS.$name.'.php';
        // Get buffer content
        $content = ob_get_contents();
        ob_get_clean();

        include VIEWS.'layout/'.$layout.'.php';

        return $this;
    }
}
