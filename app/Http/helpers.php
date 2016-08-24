<?php

function setActive($route){
    return strpos(Request::url(), $route) !== false ? 'active' : '';
}