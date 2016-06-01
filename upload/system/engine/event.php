<?php

class Event {
    protected $registry;
    protected $data = array();

    public function __construct(Registry $registry) {
        $this->registry = $registry;
    }

    public function register($trigger, $route) {
        $this->data[$trigger][] = $route;
    }

    public function unregister($trigger, $route = '') {
        if ($route) {
            foreach ($this->data[$trigger] as $key => $action) {
                if ($action->getRoute() == $route) {
                    unset($this->data[$trigger][$key]);
                }
            }
        } else {
            unset($this->data[$trigger]);
        }
    }

    public function removeAction($trigger, $route) {
        foreach ($this->data[$trigger] as $key => $action) {
            if ($action->getRoute() == $route) {
                unset($this->data[$trigger][$key]);
            }
        }
    }

    public function trigger($event, array $args = array()) {
        foreach ($this->data as $trigger => $routes) {
            if (preg_match('/^' . str_replace(array('\*', '\?'), array('.*', '.'), preg_quote($trigger, '/')) . '/', $event)) {
                foreach ($routes as $route) {
                    $action = new Action($route, $args);

                    if (substr($action->getMethod(), 0, 2) == '__') {
                        throw new RuntimeException('Calls to magic methods are not allowed for action ' . $action->getRoute());
                    }

                    if (file_exists($action->getFile())) {
                        require_once($action->getFile());
                    }

                    $class = $action->getClass();

                    if (class_exists($class)) {
                        throw new RuntimeException('Cannot find a class ' . $class . ' for action ' . $action->getRoute());
                    }

                    $controller = new $class($this->registry);

                    if (!is_callable(array($controller, $action->getMethod()))) {
                        throw new RuntimeException('Cannot call method ' . $action->getMethod() . ' for action ' . $action->getRoute());
                    }

                    $result = call_user_func_array(array($controller, $action->getMethod()), $action->getArgs());

                    if (!is_null($result)) {
                        return $result;
                    }
                }
            }
        }
    }
}
