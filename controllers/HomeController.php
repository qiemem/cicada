<?php
require_once 'lib/Controller.php';
require_once 'models/SubmissionsModel.php';

class HomeController Extends Controller {
    function index($actionValues) {
        $submissionsModel = new SubmissionsModel();
        $submission = $submissionsModel->randomOrder()->first()->get();
        $this->viewData = array('submission' => $submission);
        $this->renderWithTemplate('home/index','main');
    }
}
?>
