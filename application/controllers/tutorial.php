<?php

class Tutorial extends controller {

    function Tutorial() {
        parent::Controller();

        $this->load->helper('url');
    }

    function index() {        
        $this->formExample();        
    }

    function formExample() {

    }

}

?>