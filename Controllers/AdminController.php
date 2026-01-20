<?php
public function index() {
    $data = $this->model->getFullHierarchy();
    require 'Views/admin_dashboard.php';
}
?>