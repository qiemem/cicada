<?php

abstract class Controller {
    protected $viewData;

    protected function getViewPath($view) {
        return 'views/'.$view.'.php';
    }

    protected function getTemplatePath($template) {
        return 'views/templates/'.$template.'.php';
    }
    
    protected function render($view) {
        $viewPath = $this->getViewPath($view);

        if (!file_exists($viewPath)) {
            trigger_error('View `'.$view.'` does not exist.', E_USER_NOTICE);
            return false;
        }

        foreach ($this->viewData as $key => $value) {
            $$key = $value;
        }

        include_once($viewPath);
    }

    protected function renderWithTemplate($view, $template) {
        $viewPath = $this->getViewPath($view);

        if (!file_exists($viewPath)) {
            trigger_error('View `'.$view.'` does not exist.', E_USER_NOTICE);
            return false;
        }

        $templatePath = $this->getTemplatePath($template);

        if (!file_exists($templatePath)) {
            trigger_error('Template `'.$template.'` does not exist.', E_USER_NOTICE);
            return false;
        }

        foreach ($this->viewData as $key => $value) {
            $$key = $value;
        }

        include_once($templatePath);
    }
}
?>
