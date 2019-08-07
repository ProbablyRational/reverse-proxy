<?php

Route::middleware('api')->any('/reverse', 'ProbablyRational\ReverseProxy\RouteController@handle');