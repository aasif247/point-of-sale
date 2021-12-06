<?php

namespace App\Repository\Business;

use App\Models\Business;
use App\Repository\Base\BaseRepository;

class BusinessRepository extends BaseRepository implements IBusinessRepository {

    public function __construct(Business $model)
    {
        parent::__construct($model);
    }

}
