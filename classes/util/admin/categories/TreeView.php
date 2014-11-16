<?php

abstract class TreeView {

	protected $treeViewModel;
	protected $showRoot;
	protected $treeViewId;
	protected $rowsIndent;

	function __construct($treeViewModel, $showRoot, $treeViewId) {
		$this->treeViewModel = $treeViewModel;
		$this->showRoot = $showRoot;
		$this->treeViewId = $treeViewId;
		$this->rowsIndent = 10;
	}

	/**
	 * Default value is 10
	 */
	public function setRowsIndent($rowsIndent) {
		$this->rowsIndent = $rowsIndent;
	}

	public function display($expandable) {
		$root = $this->treeViewModel->getRootNode();
		echo "<ul>";
		if ($this->showRoot === true) {
			$this->displayNode($root, $expandable, null);
		} else {
			if ($root->getChildren()) {
				foreach ($root -> getChildren() as $key => $child) {
					$this->displayNode($child, $expandable, $root);
				}
			}
		}
		echo "</ul>";
	}

	private function displayNode($node, $expandable, $parentNode) {
		$leaf = $node->isLeaf();
		$isExpanded = $this->treeViewModel->isNodeExpanded($node);
		$nodeData = $this->treeViewModel->getNodeStringData($node);
		echo "<li>";	
		
		echo $this->getNodeTitle($node);
		

		echo "</li>";
		if ($leaf) {
			//echo $node->getTitle().' is Leaf';
			return;
		}

		echo "<ul>";
		if (count($node->getChildren()) > 0) {
			$childrenKeys = array();
			foreach ($node->getChildren() as $key => $child) {
				$this->displayNode($child, $expandable, $node);
				$childrenKeys[] = $child->getKey();
			}			
		}

		echo "</ul>";
	}

	abstract function getNodeTitle($node);
	
}
?>