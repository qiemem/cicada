<?php
require_once 'lib/Controller.php';
require_once 'models/SubmissionsModel.php';

class SubmissionsController Extends Controller {
    protected $model = NULL;
    
    function __construct() {
        $this->model = new SubmissionsModel();
    }
    function index($actionValues) {
        if(isset($actionValues['sortBy'])){
            $sortBy = $actionValues['sortBy'];
        }else{
            $sortBy = 'dateAdded';
        }
        if(isset($actionValues['pageSize'])){
            $pageSize = $actionValues['pageSize'];
        }else{
            $pageSize = 10;
        }
        if(isset($actionValues['page'])){
            $page = $actionValues['page']-1;
        }else{
            $page = 0;
        }
        if(isset($actionValues['direction'])){
            $direction = $actionValues['direction'];
        }else{
            $direction = 'desc';
        }
        if($direction=='desc'){
            $this->model->descending();
        }else if($direction=='asc'){
            $this->model->ascending();
        }
        $this->model->from($page*$pageSize)->atMost($pageSize);
        $urlSuffix = "module=submissions&action=index&sortBy=$sortBy&direction=$direction&pageSize=$pageSize";
        if($sortBy=="random"){
            if(isset($actionValues['seed'])){
                $seed = $actionValues['seed'];
            }else{
                $seed = rand();
            }
            $submissions = $this->model->shuffle($seed)->get();
            $urlSuffix .= "&seed=$seed";
        }else{
            $submissions = $this->model->orderBy($sortBy)->get();
        }
        $this->viewData = array(
            'submissions' => $submissions,
            'numPages' => ($this->model->count())/$pageSize,
            'page' => $page+1,
            'urlSuffix' => $urlSuffix
        );
        $this->renderWithTemplate('submissions/index','main');
    }
    function view($actionValues) {
        $id = $actionValues['id'];
        $submission = $this->model->first()->withId($id)->get();
        $this->viewData = $submission;
        $this->renderWithTemplate('submissions/view','main');
    }
    function add() {
        $this->viewData = array();
        $this->renderWithTemplate('submissions/add','main');
    }
    function addPost($actionValues) {
        $this->model->add(1, $actionValues['body']);
        $submission = $this->model->first()->withUser(1)->get();
        $this->viewData = $submission;
        $this->renderWithTemplate('submissions/addPost','main');
    }
    
}
?>
