<?php

class Definition{

	public function aEndpoints(){
		$aEndpoints = array(
			array('name' => 'BBC Programmes and Music', 'value' => 'http://lod.openlinksw.com/sparql/'),
			array('name' => 'BioGateway', 'value' => 'http://www.semantic-systems-biology.org/biogateway/endpoint'),
			array('name' => 'DBpedia', 'value' => 'http://dbpedia.org/sparql'),
			array('name' => 'EEA (European Environment Agency) ', 'value' => 'http://semantic.eea.europa.eu/sparql'),
			array('name' => 'Information about the Web-based Systems Group', 'value' => 'http://wifo5-03.informatik.uni-mannheim.de/dws-group/sparql'),
			array('name' => 'International Chronostratigraphic Chart', 'value' => 'http://resource.geosciml.org/sparql/isc2014'),
			array('name' => 'Linked Movie Data Base', 'value' => 'http://data.linkedmdb.org/sparql'),
			array('name' => 'Musicbrainz', 'value' => 'http://dbtune.org/musicbrainz/sparql'),
			array('name' => 'Project Gutenberg Metadata', 'value' => 'http://wifo5-03.informatik.uni-mannheim.de/gutendata/sparql'),
			array('name' => 'UniProt', 'value' => 'http://beta.sparql.uniprot.org/sparql'),
			array('name' => 'URIBurner.com', 'value' => 'http://uriburner.com/sparql/'),
			array('name' => 'World Factbook', 'value' => 'http://wifo5-03.informatik.uni-mannheim.de/factbook/sparql'),
			array('name' => __('Autre / Other'), 'value' => 'Autre')	
		);

		return $aEndpoints;
	}

}