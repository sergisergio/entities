<?php

/* Maintenant qu'on travaille en POO, on travaille avec des objets et non plus des tableaux.
Une classe est composée de 2 voire 3 parties :
1. attributs => caractéristiques de l'objet.
2. méthodes => fonctionnalités de l'objet.
3. éventuellement une partie déclarant les constantes de classe.

Quand on crée une classe, on doit se poser ces 2 questions :
1. Quelles seront les caractéristiques de mes objets ? ( voir les colonnes de la BDD).
2. Quelles seront les fonctionnalités de mes objets ?
*/
$db = new PDO('mysql:host=localhost;dbname=POO;charset=utf8', 'root', 'root');

class Personnage
{
	protected $_id;
	protected $_nom;
	protected $_forcePerso;
	protected $_degats;
	protected $_niveau;
	protected $_experience;


	/*
     * Méthode de construction
     */
	public function __construct(array $data) 
	  {
	  	$this->hydrate($data);
	  	//$this->setId($id);
	  	//$this->setNom($nom);
	    //$this->setForcePerso($forcePerso); // Initialisation de la force.
	    //$this->setDegats($degats); // Initialisation des dégâts.
	    //$this->setNiveau($niveau);
	    //$this->setExperience($experience);
	  }

	/*
     * Methode d'hydratation
     */
    public function hydrate(array $datas) {
        foreach ($datas as $key => $value) {
            $method = 'set'.ucfirst($key);
            
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

	// Il faut bien sûr implémenter les getters et setters.
	// Getter : méthode chargée de renvoyer la valeur d'un attribut.
	// Setter : méthode chargée d'assigner une valeur à un attribut en vérifiant son intégrité.

	// Liste des getters

	public function id()
	{
		return $this->_id;
	}

	public function nom()
	{
		return $this->_nom;
	}

	public function forcePerso()
	{
		return $this->_forcePerso;
	}

	public function degats()
	{
		return $this->_degats;
	}

	public function niveau()
	{
		return $this->_niveau;
	}

	public function experience()
	{
		return $this->_experience;
	}

	// Liste des setters

	public function setId($id)
	{
		// On convertit l'argument en nombre entier
		// Si c'en était déjà un, rien ne changera
		// Sinon, la conversion donnera le nombre 0 (à quelques exceptions près, mais rien d'important ici).
		$id = (int) $id;

		// On vérifie ensuite si ce nombre est bien strictement positif.
		if($id > 0)
		{
			// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
			$this->_id = $id;
		} 
	}

	public function setNom($nom)
	{
		// On vérifie qu'il s'agit bien d'une chaîne de caractères.
		if (is_string($nom))
		{
			$this->_nom = $nom;
		}
	}

	public function setForcePerso($forcePerso)
	{
		$forceperso = (int) $forcePerso;

		if ($forcePerso >= 1 && $forcePerso <= 100)
		{
			$this->_forcePerso = $forcePerso;
		}
	}

	public function setDegats($degats)
	{
		$degats = (int) $degats;

		if ($degats >= 1 && $degats <= 100)
		{
			$this->_degats = $degats;
		}
	}

	public function setNiveau($niveau)
	{
		$niveau = (int) $niveau;

		if ($niveau >= 1 && $niveau <= 100)
		{
			$this->_niveau = $niveau;
		}
	}

	public function setExperience($experience)
	{
		$experience = (int) $experience;

		if ($experience >= 1 && $experience <= 100)
		{
			$this->_experience = $experience;
		}
	}
}

?>	

<?php
// On admet que $db est un objet PDO.
$request = $db->query('SELECT id, nom, forcePerso, degats, niveau, experience FROM personnages');

while ($data = $request->fetch(PDO::FETCH_ASSOC)) // Chaque entrée sera récupérée et placée dans un array.
{
	echo '<p>Affichage avec tableaux : </p>';
	echo $data['nom'], ' a ', $data['forcePerso'], ' de force, ', $data['degats'], ' de dégâts, ', $data['experience'], ' d\'expérience et est au niveau ', $data['niveau'];
	// On passe les données ( stockées dans un tableau) concernant le personnage au constructeur de la classe.
	// On admet que le constructeur de la classe appelle chaque setter pour assigner les valeurs qu'on lui a données aux attributs correspondants.
	echo '<p>Affichage avec objets :</p>';
	$perso = new Personnage($data);

	echo $perso->nom(), ' a ', $perso->forcePerso(), ' de force, ', $perso->degats(), ' de dégâts, ', $perso->experience(), ' d\'expérience et est au niveau ', $perso->niveau();
    
    echo 'Voir code pour les différences';
}