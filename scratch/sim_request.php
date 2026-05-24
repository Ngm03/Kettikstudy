<?php
$_SERVER['REQUEST_URI'] = '/api/admin/lead-status';
$_SERVER['REQUEST_METHOD'] = 'POST';
$_COOKIE['auth_token'] = 'invalid'; // Just to get past auth or if we bypass auth. Wait, auth is required.
