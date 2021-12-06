<?php

namespace App\ViewModels\Business;

use App\Services\Business\IBusinessService;

class BusinessesListModel {
    private $businessService;
    private $businesses;

    public function getbusinesses(){
        return $this->businesses;
    }

    public function __construct(IBusinessService $businessService){
        $this->businessService = $businessService;
    }

    public function load(){
        $this->businesses = $this->businessService->getAllBusinesses();
    }
}
