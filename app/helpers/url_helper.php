<?php

    /**
     * @param $page
     * Redirect to specific page
     */
    function redirect($page){
        header('location:'. URLROOT . '/' . $page );
    }