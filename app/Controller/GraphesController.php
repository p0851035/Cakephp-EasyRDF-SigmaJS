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
class GraphesController extends AppController{

	public function index(){
		// Si le request->data n'Est pas vide
		if(!empty($this->request->data['Graphe']['data'])){

			// Basket
			if($this->request->data['basket'] == 'true'){
				$data = $this->Session->read('basket');
			// data
			}else{
				$data = unserialize($this->request->data['Graphe']['data']);
			}

			// init arrays
			$aArcs = array();
			$aNodes = array();
			$aOneLevelArray = array();
	
			//debug($data);

			// On digère le data pour obtenir tous les noeuds et arcs uniques.
			foreach ($data as $key => $value) {
				for ($i=0; $i < $this->request->data['Graphe']['nbinput']; $i++) { 
					// Si l'Arc est une ressource
					
					if($i == $this->request->data['Graphe']['arc']){
						if(isset($value[$this->request->data['Graphe']['arc']]['resource'])){
							//$aArcs[] = $value[$this->request->data['Graphe']['arc']]['resource'];
							$aOneLevelArray[]['arc'] = $value[$this->request->data['Graphe']['arc']]['resource'];
						// Si l'Arc est un litéral
						}elseif(isset($value[$this->request->data['Graphe']['arc']]['literal']['value'])){
							//$aArcs[] = $value[$this->request->data['Graphe']['arc']]['literal']['value'];
							$aOneLevelArray[]['arc'] = $value[$this->request->data['Graphe']['arc']]['literal']['value'];
						
						}else{
							// L'arc est quelque chose d'autre? Gérer exception?
						}
					// C'est un noeud
					}else{
						// Le noeud est une ressource
						if(isset($value[$i]['resource'])){
							$aNodes[] = $value[$i]['resource'];
							$aOneLevelArray[]['node'] = $value[$i]['resource'];
						// Le noeud est une valeur
						}elseif(isset($value[$i]['literal']['value'])){
							$aNodes[] = $value[$i]['literal']['value'];
							$aOneLevelArray[]['node'] = $value[$i]['literal']['value'];
						// Le noeud est quelque chose d'autre?
						}else{
							// Gérer exception??
						}
					}
				}
			}
			// On enlève tous les doublons
			//$aArcs = array_map("unserialize", array_unique(array_map("serialize", $aArcs)));
			$aNodes = array_map("unserialize", array_unique(array_map("serialize", $aNodes)));
			// On remet à zéro le compteur des clés
			$aNodes = array_values($aNodes);
			// On crée le tableau d'association entre les noeuds et les arcs
			$aArcs = array();
			$aArcs = $this->Graphe->MakeAssociations($aOneLevelArray, $aNodes, $this->request->data['Graphe']['nbinput']);
			
			// Nombre d'éléments
			$iNbArcs = count($aArcs);
			$iNbNodes = count($aNodes);
			// Envoi des variables à la vue;
			$this->set('aNodes', $aNodes);
			$this->set('iNbNodes', $iNbNodes);
			$this->set('aArcs', $aArcs);
			$this->set('iNbArcs', $iNbArcs);


			// Fonctionne seulement pour des triplets
			// Identification des positions des arcs : Source Arc fin
			$myArray = array('0', '1', '2');
			$thisArc = $this->request->data['Graphe']['arc'];
			unset($myArray[$thisArc]);
			$myArray = array_values($myArray);
			$thisSource = $myArray[0];
			$thisEnd = $myArray[1];
			
			$this->set(array(
				'thisArc' => $thisArc,
				'thisSource' => $thisSource,
				'thisEnd' => $thisEnd));
				
		}
	}
}