<!-- Initiation js sigma -->
<?= $this->element('Sigma');?>

<div id="graph-container"></div>

<script>
var aNodes = <?php echo json_encode($aNodes) ?>;
var iNbNodes = <?php echo json_encode($iNbNodes) ?>;
var aArcs = <?php echo json_encode($aArcs) ?>;
var iNbArcs = <?php echo json_encode($iNbArcs) ?>;
// Position
var debut = <?php echo json_encode($thisSource) ?>;
var arc = <?php echo json_encode($thisArc) ?>;
var fin = <?php echo json_encode($thisEnd) ?>;

var i,
    s,
    N = iNbNodes,
    E = iNbArcs,
    g = {
      nodes: [],
      edges: []
    };

// Generate a random graph:
for (i = 0; i < N; i++)

  g.nodes.push({
    id: 'n' + i,
    label: aNodes[i],
    x: Math.random(),
    y: Math.random(),
    size: 1,
    color: '#666'
  });


for (i = 0; i < E; i++)
  g.edges.push({
    id: 'e' + i,
    label: aArcs[i][arc],
    source: 'n' + aArcs[i][debut],
    target: 'n' + aArcs[i][fin],
    size: Math.random(),
    color: '#ccc',
    type: ['line', 'curve', 'arrow', 'curvedArrow'][Math.random() * 4 | 0]
  });

// Instantiate sigma:
s = new sigma({
  graph: g,
  renderer: {
    container: document.getElementById('graph-container'),
    type: 'canvas'
  },
  settings: {
    edgeLabelSize: 'proportional'
  }
});
</script>
