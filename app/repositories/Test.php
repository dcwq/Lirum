<?php

namespace Repository;

use Engine\Repository;

class Test extends Repository
{
    public function rand()
    {
        return rand(1,9000000);
    }
}