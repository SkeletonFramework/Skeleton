<?php

namespace SkeletonFramework;

class Page extends ApplicationComponent {

	  protected $contentFile;
	  protected $vars = [];

	  public function addVar($var, $value)
	  {
	    if (!is_string($var) || is_numeric($var) || empty($var))
	    {
	      throw new \InvalidArgumentException('Le nom de la variable doit être une chaine de caractères non nulle');
	    }

	    $this->vars[$var] = $value;
	  }

	/**
	* Fonction qui va permettre de jouet avec le buffer et va permettre de combiner deux fichiers en même temps.
	* Un layout principal suivis du fichier demandé comportant la vue.
	*
	*/
	public function getGeneratedPage () {
		if (!file_exists($this->getContentFile())) {
			throw new \Exception("Page inexistante");
		}

		$user = $this->app->getUser();

		extract($this->vars); //Toute les variables seront disponible dans la page.

		ob_start();
			require $this->getContentFile();
		$content = ob_get_clean();

		ob_start();
			require $this->getLayout();
		return ob_get_clean();

	}

	public function getLayout() {
		return __DIR__ . "/../../App/" . $this->app->getName() . "/Templates/layout.php";
	}

	public function setContentFile($contentFile) {
		if (!is_string($contentFile) || empty($contentFile)) {
			throw new \InvalidArgumentException("Contenu de la page inexistant");			
		}

		$this->contentFile = $contentFile;

		return $this;
	}

	public function getContentFile () {
		return $this->contentFile; 
	}
}