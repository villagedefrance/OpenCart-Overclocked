<?php
final class Front {
	protected $registry;
	protected $pre_action = array();
	protected $error;

	public function __construct($registry) {
		$this->registry = $registry;
	}

	public function addPreAction($pre_action) {
		$this->pre_action[] = $pre_action;
	}

	public function dispatch($action, $error) {
		$this->error = $error;

		foreach ($this->pre_action as $pre_action) {
			$result = $this->execute($pre_action);

			if ($result) {
				$action = $result;
				break;
			}
		}

		while ($action) {
			$action = $this->execute($action);
		}
	}

	private function execute(Action $action) {
		if (file_exists($action->getFile())) {
			require_once($action->getFile());

			$class = $action->getClass();

			$controller = new $class($this->registry);

			if (is_callable(array($controller, $action->getMethod())) && substr($action->getMethod(), 0, 2) != '__') {

				$route = $action->getRoute();
				
				// Trigger the pre events
				$result = $this->registry->get('event')->trigger('controller/' . $route . '/before', array($action));

				if (!is_null($result)) {
					return $result;
				}

				$action = call_user_func_array(array($controller, $action->getMethod()), $action->getArgs());

				// Trigger the post events
				$result = $this->registry->get('event')->trigger('controller/' . $route . '/after', array(&$action));

				if (!is_null($result)) {
					return $result;
				}
			} else {
				$action = $this->error;
				$this->error = '';
			}

		} else {
			$action = $this->error;
			$this->error = '';
		}

		return $action;
	}
}
