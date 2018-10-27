<?php
namespace App\Services;

class DefaultProps {
  protected $data;

  public function __construct() {
    $this->data = [
      'brand_name' => 'GraceVET'
    ];
  }

  public function get($name) {
    return $this->data[$name];
  }
}