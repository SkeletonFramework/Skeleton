<?php


namespace SkeletonFramework;

abstract class BackController extends ApplicationComponent {
	protected $module;
	protected $action;
	protected $page; // Element final retourné à l'utilisateur qui va interprété les vue afin de les parser 
	protected $view;

	protected $managers = null;

	function __construct(Application $application, $module, $action) {
		parent::__construct($application);

		// La page qui sera retourné au client
		$this->setPage(new Page($application));
		$this->managers = new Managers('PDO', PDOFactory::getPsqlCOnnection());

		$this->setModule($module);
		$this->setAction($action);
		$this->setView($action); // Par défaut la vue porte le même nom que l'action
	}

	public function setModule($module) {

		if (!is_string($module) || empty($module)) {
			throw new \InvalideArgumentException("Le type de module n'est pas bon.");		
		}

		$this->module = $module;

		return $this;
	}

	public function getModule() {
		return $this->module;
	}

	/**
	* Action
	*/
	public function getAction() {
		return $this->action;
	}

	/**
	* Action
	*/
	public function setAction($action) {
		if(!is_string($action)) {
			throw new \InvalideArgumentException("L'action n'est pas une chaine valide");
		}

		$this->action = $action;

		return $this;
	}

	/**
	* Page
	*/
	public function getPage() {
		return $this->page;
	}

	/**
	* Page
	*/
	public function setPage(Page $page = null) {
		$this->page = $page;

		return $this;
	}

	/**
	* Page
	*/
	public function getView() {
		return $this->view;
	}

	/**
	* Affecte la vue et informe la page du fait qu'à un controller est associé une page.
	*/
	public function setView($view) {
		if (!is_string($view) || empty($view)) {
			throw new \InvalideArgumentException('La vue doit être une chaine de caractère valide.');
		}

		$this->view = $view;

		$this->getPage()->setContentFile(__DIR__ . '/../../App/' . $this->getApplication()->getName() . '/Modules/' . $this->getModule() .'/Views/' . $this->view . '.php');

		return $this;
	}

	public function execute() {

		$method = 'execute' . ucfirst($this->getAction());

		if (!is_callable([$this, $method])) {
			throw new \RuntimeError("La méthode ne peut être appelé");
		}

		// On exécute la méthod ET on passe la requete à chaque méthode par facilité de récupération des élément
		$this->$method($this->getApplication()->getRequest());
	}
}