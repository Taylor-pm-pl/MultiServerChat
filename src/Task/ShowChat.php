<?php

namespace davidglitch04\MultiServerChat\Task;

use davidglitch04\MultiServerChat\Loader;
use pocketmine\scheduler\Task;

class ShowChat extends Task {

    protected Loader $msc;

    public function __construct(Loader $msc)
    {
        $this->msc = $msc;
    }

    public function onRun(): void
    {
        $this->msc->getProvider()->ShowChat();
    }
}