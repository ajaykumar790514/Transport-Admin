
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class Errors extends Main {
    public function show_404() {
        if (!$user         = $this->checkLogin()) {
            redirect('login');
        } else {
            $this->load->view('errors/custom_404');
        }
    }
}
