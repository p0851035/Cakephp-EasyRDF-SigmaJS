<?php
class RdfRequest extends AppModel{

    // Validation des champs
	public $validate = array(
     	'endpoint' => array(
     		'rule' => 'notEmpty'
     	),
     	'endpointAutre' => array(
     		'rule' => 'url',
     		'allowEmpty' => true
     	),
     	'query' => array(
     		'rule' => 'notEmpty'
     	)
    );

    // Permet de convertir l'objet de type 'bindings' en un array contenant les objets (ressources/littéraux)
    public function aConvertBindings($request, $numFields, $getFields){

        // set variables
        $fields = array();
        $results = array();
        // Décomposition en sous-objets
        $j = 0;
        foreach ($request as $row) {
            $i = 0;
            while($i < $numFields){
                foreach ($request->getFields() as $field) {   
                    if (isset($row->$field)) {
                        $results[$j][$i] = $row->$field;
                    }else{
                        $results[$j][$i] = null;
                    }
                    $i++;
                }
            }
            $j++;
        }
        return $results;
    }

    // Permet d'obtenir les URI des objets
    public function aGetUris($data){
        $uris = array();

        foreach ($data as $key => $value) {
            // Pour chaque objet
            foreach ($value as $key2 => $object) {
                // On identifie l'object
                if(get_class($object) == 'EasyRdf_Resource'){
                    //$graph = new EasyRdf_Graph();
                    $uris[$key][$key2]['resource'] = $object->getUri();
                }elseif(get_class($object) == 'EasyRdf_Literal'){
                    //$literal = new EasyRdf_Graph($object);
                    $uris[$key][$key2]['literal'] = $object->toRdfPhp();
                }elseif(get_class($object) == 'EasyRdf_Literal_Integer'){
                   $uris[$key][$key2]['literal'] = $object->toRdfPhp();
                }else{
                    // cas?
                }
            }
        }
        return $uris;
    }

    // Namespace des ressources typiques.
    public function aNamespace($data){
        foreach ($data as $key => $element) {
            foreach ($element as $key2 => $value) {
                if(isset($value['resource'])){
                    $short = EasyRdf_Namespace::shorten($value['resource']);
                    if($short !== null){
                        $data[$key][$key2]['resource'] = $short;
                    }
                }elseif(isset($value['literal']['value'])){
                    $short = EasyRdf_Namespace::shorten($value['literal']['value']);
                    if($short !== null){
                        $data[$key][$key2]['literal']['value'] = $short;
                    }
                }
            }
        }
        return $data;
    }
}