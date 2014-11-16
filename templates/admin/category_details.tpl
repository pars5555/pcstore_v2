
<h1>Category Attributes</h1>
Title:
<input type="text" id="ac_display_name" value="{$ns.categoryDto->getDisplayName()}"/>
<input type="checkbox" id="ac_is_last_clickable" {if $ns.categoryDto->getLastClickable()==1}checked{/if}/>
<button id="ac_save">save</button>
<button id="ac_reset">reset</button>

<h1>Add/Remove Categoies</h1>
<button id="ac_add_child_category">Add child category</button>
<button id="ac_remove_category">Delete Category</button>
<button id="ac_move_up">Move Up</button>
<button id="ac_move_down">Move Down</button>


<input type="hidden" id="ac_category_id" value="{$ns.categoryDto->getId()}"/>