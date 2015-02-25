<?= $this->Html->script('General', array('inline' => false)); ?>
<?= $this->Html->script('AjaxSave', array('inline' => false)); ?>
<script>
var data = <?php echo json_encode($data) ?>;
</script>

<?= $this->element('info');?>

<?php if($safari == true):?>
<div class="row text-center" style="background-color: #fff8eb">
	<h3>
		Nous vous conseillons d'utiliser un autre navigateur que Safari.
	</h3>

	<h3>
		We recommand to use another browser than Safari
	</h3>
</div>
<?php endif;?>

<div class="col-md-12">
	<div class="row">
	<h3><?=__('Requêtes SPARQL')?></h3>
	<p class="info" style="margin-top:-10px">
		<?= $this->Html->link(__('À propos de SPARQL / About SPARQL'), 'http://www.w3.org/TR/rdf-sparql-query/', array('escape' => false, 'target' => '_blank'));?>
	</p>
	<div class="row">
		<div class="col-md-6">
			<?= $this->Form->create('RdfRequest');?>
			<div class="col-md-12">
				<!-- Endpoint -->
				<div class="col-md-6">
					<div class="row">
						<h4>
							<?= __('Endpoint');?>
						</h4>
					</div>
				</div>
				<div class="col-md-6 text-right">
					<div class="row">
						<p class="info">
							<?= $this->Html->link(__('SparqlEndpoints'), 'http://www.w3.org/wiki/SparqlEndpoints', array('escape' => false, 'target' => '_blank'));?>
						</p>
					</div>
				</div>

				<div class="col-md-12">
					<div class="row">
						<?= $this->Form->input('endpoint', array(
							'label' => false, 
							'options' => $endpoints,
							'empty' => __('Veuillez choisir un endpoint / Please select an endpoint '),
							'class' => 'form-control showOther'
						));?>
					</div>
				</div>

				<?php if($Custom_Endpoint):?>
					<div class="col-md-12 space" style="display:block; " id="autre">
				<?php else:?>
					<div class="col-md-12 space" style="display:none; " id="autre">
				<?php endif;?>
					<div class="row">
						<?= $this->Form->input('endpointAutre', array(
							'label' => false, 
							'placeholder' => __('Entrez le URL du endpoint / Specify the Endpoint URL'),
							'class' => 'form-control'
						));?>
					</div>
				</div>
			</div>
			<!-- PRÉFIXE -->
			<div class="col-md-12 space">
				<div class="col-md-6">
					<div class="row">
						<h4>
							<?= __('Préfixes / Prefixes');?>
						</h4>
					</div>
				</div>
				<div class="col-md-6 text-right">
					<div class="row">
						<p class="info">
							<?= $this->Html->link(__('Information sur les préfixes / Prefix declarations'), 'https://code.google.com/p/tdwg-rdf/wiki/Beginners6SPARQL#6.4.1.1._PREFIX_declarations', array('escape' => false, 'target' => '_blank'));?>
						</p>
					</div>
				</div>

				<div class="col-md-12" style="height:100px; overflow-y: scroll; border:solid gray 1px;">
					<div class="row">
						<ul class="list-unstyled" style="margin-left:5px;">
							<?php foreach ($prefixes as $prefix => $uri):?>
								<li>
									PREFIX: <?= $prefix." &lt;".htmlspecialchars($uri)."&gt";?>
								</li>
							<?php endforeach;?>
						</ul>
					</div>
				</div>
			</div>
			<!-- Requêtes -->
			<div class="col-md-12 space">
				<div class="col-md-6">
					<div class="row">
						<h4>
							<?= __('Requête / Query');?>
						</h4>
					</div>
				</div>
				<div class="col-md-6 text-right">
					<div class="row">
						<p class="info">
							<?= $this->Html->link(__('Cheat sheet SPARQL'), 'http://www.iro.umontreal.ca/~lapalme/ift6281/sparql-1_1-cheat-sheet.pdf', array('escape' => false, 'target' => '_blank'));?>
						</p>
					</div>
				</div>

				<div class="col-md-12" style="margin-bottom:10px;">
					<div class="row">
						<?= $this->Form->input('query', array(
	                        'type' => 'textarea',
	                        'label' => false,
	                        'placeholder' => __('Écrivez votre requête SPARQL'),
	                        'default' => $query,
	                        'class' => 'form-control margin-bottom-20',
	                        'rows' => '4'
	                    ));?>
					</div>
				</div>

				<!-- Erreur dans la requête -->
				<?php if($Error_Query):?>
					<div class="col-md-12 error">
				<?php else:?>
					<div class="col-md-12 error" style="display:none;">
				<?php endif;?>
					<?= __('Une erreur est associée à la requête');?>
					<p>
						<?= $Error_Message;?>
					</p>
				</div>
				<!-- Fin erreur dans la requête -->
			
				<div class="col-md-12 row">
					<button type="submit" class="btn btn-primary">
			            <?= __('Envoyer / Send');?>
			        </button>
			    </div>


			</div>
			<?= $this->Form->end();?>

			<?php if($data !== array()):?>
				<div class="col-md-12" style="margin-top:30px; background-color:#F3F3F3">
					<div class="col-md-6">
						<div class="row">
							<h4>
								<?= __('Graphe / Graph');?>
							</h4>
						</div>
					</div>
					<div class="col-md-6 text-right">
						<div class="row">
							<p class="info">
							<!--
								<?= $this->Html->link(__('Cheat sheet SPARQL'), 'http://www.iro.umontreal.ca/~lapalme/ift6281/sparql-1_1-cheat-sheet.pdf', array('escape' => false, 'target' => '_blank'));?>
							-->
							</p>
						</div>
					</div>
				</div>

				<?php if($iNumFields == 3):?>

					<div class="col-md-12 space">

						<?= $this->Form->create('Graphe', array('action' => 'index', 'target' => '_blank'));?>
						<h5>
							<?= __('Quel champ représente la relation entre les noeuds (arc)?')?>
						</h5>

						<h5>
							<?= __('Which element represents the relation between nodes (edge)?')?>
						</h5>
						<?= $this->Form->input('arc', array(
							'label' => false,
							'options' => $aGetFields,
							'empty' => __('Veuillez choisir un champ / Select an element'),
							'class' =>'form-control'
							));?>

						<?= $this->Form->hidden('data', array('value' => serialize($data)));?>

						<?= $this->Form->hidden('nbinput', array('value' => $iNumFields));?>

						
					</div>

					<div class="col-md-12" style="margin-top:10px;">

						<div class="col-md-6">
							<div class="row">
								<button type="submit" class="btn btn-primary" name="basket" value="false">
								    <?= __('Afficher le graphe / Show graph')?>
								</button>
							</div>
						</div>

						<?php if($this->Session->check('basket')):?>
							<div class="col-md-12" style="display:block; margin-top:10px;" id="showBasket">
						<?php else:?>
							<div class="col-md-12" style="display:none; margin-top:10px;" id="showBasket">
						<?php endif;?>
							<div class="row">
								<button type="submit" class="btn btn-warning" name="basket" value="true">
								    <?= __('Afficher le graphe des données en mémoire / Show graph from memory data')?>
								</button>

								<div style="margin-top:10px;">
									<button type="button" class="btn btn-danger" id="DeleteMemory">
										<?= __('Vider la mémoire / Clear memory')?>
									</button>
								</div>
							</div>
							<?= $this->Form->end();?>
						</div>
					</div>
				<?php else:?> <!-- La requête n'a pas trois éléments--> 
					<div class="col-md-12 space">
						<h5>
							<?= __('Votre requête SPARQL doit retourner des triplets (Sujet-Prédicat-Objet) pour permettre l\'affichage du graphe')?>
						</h5>

						<h5>
							<?= __('Your SPARQL query must return triples (subject-predicate-object) in order to show a graph representation')?>
						</h5>
					</div>
				<?php endif;?>
			<?php endif;?>
		</div>

		<?php if($data != array()):?>
			<div class="col-md-6" style="margin-bottom:10px;">
				<?php if($data !== array()):?>
					<div class="row" style="margin-bottom:10px; background-color:#F3F3F3">
						<div class="col-md-7">
							<h4>
								<?= __('Résultats / Results');?>
							
							<?php if($iData_rows != null):?>
								
								(<?= $iData_rows;?>)
	
							<?php endif;?>
							</h4>
						</div>

						<!-- Affichage de la mémoire seulement si on a des triplets-->
						<?php if($iNumFields == 3):?>
							<div class="col-md-5 text-right">
								<h4>
									<button class="btn btn-primary btn-sm" id="basket">
										
										<?= __('<i class="fa fa-plus-square"></i> Mémoire / <i class="fa fa-plus-square"></i> Memory')?>

									</button>
								</h4>
							</div>
						<?php endif;?>
					</div>
				<?php endif;?>
				<div class="row">
					<table class="table table-bordered text-center" style="table-layout: fixed; word-wrap: break-word;">
		                <thead>
		                	<th class="col-md-1"><?= __('Id');?></th>
		                	<?php foreach ($aGetFields as $title):?>
			                    <th class="col-md-3" style="text-align:center;">
			                    	<?= $title;?>
			                    </th>
		                	<?php endforeach;?>
		                </thead>
		                <tbody >
		                	<?php foreach ($data as $key => $element):?>
			                    <tr>
			                    	<td>
			                    		<?= $key+1;?>
			                    	</td>
				                    <?php for ($i=0; $i < $iNumFields; $i++):?>
				                    	<td style="padding:5px;">
					                    	<?php if(isset($element[$i]['resource'])):?>
					                    		<p>
					                    			<?php if (preg_match("#^(http|https)://#", $element[$i]['resource'])):?>
					                    				<?= $this->Html->link($element[$i]['resource'], $element[$i]['resource'], array('escape' => false, 'target' => '_blank'));?>
					                    			<?php else:?>
					                    				<?= $element[$i]['resource'];?>
					                    			<?endif;?>
												</p>

					                    	<?php elseif(isset($element[$i]['literal'])):?>
					                    		<p><?= $element[$i]['literal']['value'];?></p>
					                    		<?php if(isset($element[$i]['literal']['datatype'])):?>
					                    			<?php if($element[$i]['literal']['datatype'] == 'http://www.w3.org/2001/XMLSchema#integer'):?>
					                    				<p>
					                    					xsd:integer
					                    				</p>
					                    			<?php else:?>
					                    				<p>
					                    					<?= $element[$i]['literal']['datatype'];?>
					                    				</p>
					                    			<?php endif;?>
					                    		<?php endif;?>
					                    	<?php else:?>
					                    		<!-- Cas inconnu -->
					                    	<?php endif;?>
				                    	</td>
				                    <?php endfor;?>
			                    </tr>
			                <?php endforeach;?>
		                </tbody>
		            </table>
				</div>
			</div>
		<?php endif;?>
	</div>	
</div>