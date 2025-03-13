<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'third_party/phpqrcode/qrlib.php';

class Ciqrcode {
    public function generate($params = array()) {
        QRcode::png($params['data'], $params['savename'], $params['level'], $params['size'], 2);
    }
}
?>
