<?php
/**
 *
 * @category   Web sémantique DIC938I
 * @author     Benoit Potvin
 * @version    BETA
 * @see        Janvier 2015
 *
 *
 */
App::uses('AppController','Controller');

// Définitions
App::import('lib', 'Definition');

class RdfRequestsController extends AppController{

	public function index(){


		// Si nécessaire de contrôler mémoire et temps des requêtes
		//ini_set('memory_limit', '256M');
		//set_time_limit(0);

		//Librairie Easyrdf
		require APP . 'Vendor' . DS . "easyrdf/lib/EasyRdf.php";


		//Bogue safari
		$user_agent = $_SERVER['HTTP_USER_AGENT']; 
		if (strpos( $user_agent, 'Safari') !== false)
			{
			   
			}

		// Déclaration variables de base
		// Init Array contenant les données reformatées de la requête
		$data = array();
		// Init Nombre de lignes à la réponse de la requête
		$iData_rows = null;
		// Init Nombre de champs de la requête
		$iNumFields = null;
		// Init Le nom des champs de la requête
		$aGetFields = array();
		// Erreur dans la requête
		$Error_Query = false;
		// Init 
		$Query_Results = array();

		// Endpoint custom
		$Custom_Endpoint = false;

		//Chargement librairie personnel dans lib/Definition.php
		$definition = new Definition();

		// Détection safari parce qu'il y a un bogue avec le javascript?
		$safari = false;
		if (strpos( $user_agent, 'Safari') !== false)
		{
		   $safari = true;
		}
		$this->set('safari', $safari);


		// Liste des endpoints
		$endpoints = $definition->aEndpoints();
		//Envoi à la vue
		$this->set('endpoints', $endpoints);


		//Liste des préfixes
		$prefixes = EasyRdf_Namespace::namespaces();
		//Envoi à la vue
		$this->set('prefixes', $prefixes);

		if(empty($this->request->data)){
			$query = "SELECT * WHERE {\n ?s ?p ?o\n}\nLIMIT 10";
		}else{
			$query = $this->request->data['RdfRequest']['query'];
		}
		//Envoi à la vue
		$this->set('query', $query);
		
	 
		// Request->data (Variables posts)
		if(!empty($this->request->data)){

			// Input pour Endpoint supplémentaire
			if($this->request->data['RdfRequest']['endpoint'] == 'Autre'){
				$Custom_Endpoint = true;
			}

			// Endpoint
			if($this->request->data['RdfRequest']['endpoint'] == 'Autre'){
				$myEndpoint = $this->request->data['RdfRequest']['endpointAutre'];
			}else{
				$myEndpoint = $this->request->data['RdfRequest']['endpoint'];
			}
			
			// Requête au endPoint
			$sparql = new EasyRdf_Sparql_Client($myEndpoint);
			try {
                
				$Query_Results = $sparql->query($this->request->data['RdfRequest']['query']);
				
				}

            catch (Exception $e) {
                $Error_Query = true;
                $Error_Message = $e->getMessage();
                $this->set('Error_Message', $Error_Message);
            }


            if($Query_Results !== array()){
            	//echo $Query_Results->dump('text');
            	//debug($Query_Results);
            	//debug(get_class($Query_Results));
            	
            	if(get_class($Query_Results) === 'EasyRdf_Sparql_Result'){
            		//Nombre de colonnes et nombre de lignes à la requête;
			        $iNumFields = $Query_Results->numFields();
			        // Donne le nombre de résultats de la requête
	        		$iData_rows = $Query_Results->numRows();
	        		// Champs demandés
	        		$aGetFields = $Query_Results->getFields();


            		// Requête select ou ask. On a un objet EasyRdf_Sparql_Result.
					if($Query_Results->getType() == 'bindings'){
						// Conversion en triplets d'objets
						$data = $this->RdfRequest->aConvertBindings($Query_Results, $iNumFields, $aGetFields);
						// Get Uri des objets et ressources
						//debug($data);
						if($data !== array()){
							$data = $this->RdfRequest->aGetUris($data);
						}

						//echo memory_get_usage();
						//debug($data);

					}else{// Requête construct ou describe. On a un objet EasyRdf_Graph.
						
					}
				}elseif(get_class($Query_Results) === 'EasyRdf_Graph'){ 
					// On a un object graph
					$uri = $Query_Results->getUri();
					//debug($uri);
				}
            }
		}// Fin du request data

		// Short avec les namespaces
		$data = $this->RdfRequest->aNamespace($data);

		// Envoi message erreur à la vue
		$this->set('Error_Query', $Error_Query);
		// Résultats reformatés
		$this->set('data', $data);
		// L'adresse custom du endpoint pour le default de l'input autreEndpoint
		$this->set('Custom_Endpoint', $Custom_Endpoint);
		// Information sur la requête
		$this->set(array(
			'iData_rows' => $iData_rows, // Nombre de résultats
			'iNumFields' => $iNumFields, // Nombre de champs demandés
			'aGetFields' => $aGetFields // Noms des champs demandés
		));
    }

    public function SessionSave(){

    	$this->autoRender = false;

    	if(!empty($this->request->data)){
    		if($this->Session->check('basket')){
    			$basket = $this->Session->read('basket');
    			$basket = array_merge($basket, $this->request->data);
    			$this->Session->delete('basket');
    			$this->Session->write('basket', $basket);
	    	}else{
	    		$this->Session->write('basket', $this->request->data);
	    	}
    	}else{
    		$this->redirect($this->referer());
    	}
    	
    	return 'success';
    }



    public function SessionDelete(){

    	$this->autoRender = false;
    	if($this->Session->check('basket')){
    		$this->Session->delete('basket');
    	}
    	return 'success';
    }
}