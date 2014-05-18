<?php

namespace Engine;

use Engine\Behaviour\DIBehaviour;

abstract class Repository
{
    use DIBehaviour {
        DIBehaviour::__construct as protected __DIConstruct;
    }
}