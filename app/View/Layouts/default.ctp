<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Ontologia">
    <meta name="author" content="Ontologia">
    <title>
    	<?php 
    		if(isset($titre)){
    			echo $titre;
    		}else{
    			echo "Ontologia";
    		}?>
    </title>
</head>
<body>
    <!-- Header -->
    <?= $this->element('header');?>

    <div class="container">
        <!-- Contenu des ctp -->
        <?= $this->fetch('content'); ?>
        <!-- Contenu des ctp -->
    </div>
    <!-- Footer -->
    <?= $this->element('footer');?>
    <!-- Fin Footer -->
</body>
</html>