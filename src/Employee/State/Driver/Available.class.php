<?php
namespace Employee\State\Driver;

use Employee\Factory\Driver\Driver;

class Available extends State {

    private static ?Available $instance = null;

    private function __construct() {
        $this->stateID=parent::getStateID('available');
    }

    public static function getInstance() : Available {
        if (self::$instance === null)
            self::$instance = new self();
        return self::$instance;
    }

    public function allocate(Driver $driver) : void {
        $driver->setState(Allocated::getInstance());
    }
}