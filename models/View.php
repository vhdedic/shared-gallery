<?php
/**
 *
 */
class View
{
    public function render($layout, $name, $args = [])
    {
        ob_start();
        extract($args);
        include VIEWS.$name.'.php';
        $content = ob_get_contents();
        ob_get_clean();

        include VIEWS.'layout/'.$layout.'.php';

        return $this;
    }
}
