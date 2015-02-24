<?php
class Graphe extends AppModel{


	public $validate = array(
     	'arc' => array(
     		'rule' => 'notEmpty'
     	)
    );


	public function MakeAssociations($data, $aNodes, $loop){

		//debug($aNodes);
		//init
		$aArcs = array();

		foreach ($data as $key => $value) {
		
			if(isset($value['node'])){
				if(in_array($value['node'], $aNodes)){
					$aArcs[$key] = array_search($value['node'], $aNodes);
				}
			}elseif(isset($value['arc'])){
				$aArcs[$key] = $value['arc'];
			}else{
				// Si exception.... Quoi faire?
				$aArcs[$key] = null;;
			}
			// traduction
			if($aArcs[$key] != null){
				// DEPRECATED??
				// DEPRECATED??
				// DEPRECATED??
				// DEPRECATED??
				switch ($aArcs[$key]) {
					case 'http://www.w3.org/1999/02/22-rdf-syntax-ns#type':
						$aArcs[$key] = 'rdf:type';
						break;
					case 'http://www.w3.org/2002/07/owl#Class':
						$aArcs[$key] = 'owl:Class';
						break;
					case 'http://www.w3.org/2002/07/owl#Thing':
						$aArcs[$key] = 'owl:Thing';
						break;
					case 'http://www.w3.org/2000/01/rdf-schema#label':
						$aArcs[$key] = 'rdfs:label';
						break;
					case 'http://www.w3.org/2002/07/owl#sameAs':
						$aArcs[$key] = 'owl:sameAs';
						break;
				}
				
			}
		}
		// définition de chaque edge
		$aArcs = array_chunk($aArcs, $loop);

		return $aArcs;
	}	
}