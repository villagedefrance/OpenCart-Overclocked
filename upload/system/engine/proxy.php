<?php

class Proxy {

    private $model;
    private $route;
    private $event;

    public function __construct(Model $model, $route, Event $event) {
        $this->model = $model;
        $this->route = $route;
        $this->event = $event;
    }

    public function __get($key) {
        if (!property_exists($this->model, $key) && !method_exists($this->model, '__get')) {
            throw new RuntimeException('The property ' .$key .' does not exists for model ' . get_class($this->model));
        }

        return $this->model->{$key};
    }

    public function __set($key, $value) {
        if (!property_exists($this->model, $key) && !method_exists($this->model, '__set')) {
            throw new RuntimeException('The property ' .$key .' does not exists for model ' . get_class($this->model));
        }

        $this->model->{$key} = $value;
    }

    public function __isset($key) {
        return isset($this->model->{$key});
    }

    public function __call($method, $args) {
        if (!is_callable(array($this->model, $method))) {
            throw new RuntimeException('The method ' .$method .' is not callable for model ' . get_class($this->model));
        }

        $route = $this->route . '/' . $method;

        // Trigger the pre events
        $result = $this->event->trigger('model/' . $route . '/before', $args);

        if (!is_null($result)) {
            return $result;
        }

        $output = call_user_func_array(array($this->model, $method), $args);

        // Trigger the post events
        $result = $this->event->trigger('model/' . $route . '/after', array_merge(array(&$output), $args));

        if (!is_null($result)) {
            return $result;
        }

        return $output;
    }

    public function getModel() {
        return $this->model;
    }

    public function getRoute() {
        return $this->route;
    }
}