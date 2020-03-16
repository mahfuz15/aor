<?php
 $widget = $this->val('widget');
 $menus = $this->val('menus');
 $currentMenus = $this->val('currentMenus');
 $widgetAvailPositions = ['rightbar', 'footer-copy', 'footer1', 'footer2', 'footer3'];
 $widgetTypes = ['menu-type', 'menu', 'html'];
//$currentMenus = implode(',', $currentMenus);
?>
<div class="content-wrapper">
    <section class="content-header">
	<h1>
	    <?php
	     if (!empty($widget)) {
		 echo '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Widget';
	     } else {
		 echo '<i class="fa fa-file-o" aria-hidden="true"></i> New Widget';
	     }
	    ?>
	    <small><?php echo isset($widget->name) ? 'Edit Widget' : 'Add new Widget'; ?></small>
	</h1>
	<ol class="breadcrumb">
	    <li><a href="admin/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	    <li><a href="admin/widgets/" class="active"> Widgets</a></li>
	    <li> <?php echo!empty($widget) ? 'Edit' : 'Add'; ?> Widget</li>
	</ol>
    </section>
    <section class="content">
	<div class="row">
	    <form method="post" id="menuTypeForm">
		<div class="col-md-8 col-xs-12">
		    <div class="box box-primary">
			<div class="box-header with-border">
			    <h3 class="box-title"><i class="fa fa-info"></i> Widget Info</h3>
			</div>
			<div class="box-body">

			    <div class="col-sm-12">
				<div class="form-group">
				    <label for="inputTitle">Widget Title</label>
				    <input type="text" name="title" class="form-control input-lg" placeholder="Widget title" value="<?php echo $this->objval('widget', 'title'); ?>">
				</div>
			    </div>
			    <div class="col-sm-6">
				<div class="form-group">
				    <label for="inputPosition">Widget Type</label>
				    <select name="type" id="widgetType" class="form-control input-lg" placeholder="Widget Type">
					<?php
					 foreach ($widgetTypes as $type)
					 {
					     if ($type == $this->objval('widget', 'type')) {
						 $selected = ' selected';
					     } else {
						 $selected = '';
					     }
					     ?>
     					<option value="<?php echo $type; ?>"<?php echo $selected; ?>><?php echo ucfirst($type); ?></option>
					 <?php } ?>
				    </select>
				</div>
			    </div>
			    <div class="col-sm-6">
				<div class="form-group">
				    <label for="inputPosition">Position</label>
				    <select name="position" class="form-control input-lg" placeholder="Widget Position">
					<?php
					 foreach ($widgetAvailPositions as $position)
					 {
					     if ($position == $this->objval('widget', 'position')) {
						 $selected = ' selected';
					     } else {
						 $selected = '';
					     }
					     ?>
     					<option value="<?php echo $position; ?>"<?php echo $selected; ?>><?php echo ucfirst($position); ?></option>
					 <?php } ?>
				    </select>
				</div>
			    </div>
			</div>
		    </div>
		    <div class="box box-warning">
			<div class="box-header with-border">
			    <h3 class="box-title"><i class="fa fa-cogs"></i> Widget Type Settings</h3>
			</div>
			<div class="box-body">
			    <div class="col-sm-12">
				<div class="form-group" id="menuGroup">
				    <label for="inputMenuParents">Menu</label> <small>(Only 1st level child items will be visible in widget)</small>
				    <select name="menucontents" id="menuParents" class="form-control input-lg" placeholder="Menu Type">
					<?php
					 if (!empty($menus)) {
					     foreach ($menus as $menuTypes)
					     {
						 if (!empty($menuTypes['items'])) {
						     foreach ($menuTypes['items'] as $menuParents)
						     {
							 if (!empty($menuParents->child)) {
							     ?>
		     					<option value="<?php echo $menuParents->id; ?>"<?php echo $selected; ?>>
								 <?php echo $menuParents->name; ?>
		     					</option>
							     <?php
							     foreach ($menuParents->child as $menuChildParent)
							     {
								 if (!empty($menuChildParent->child)) {
								     ?>
			     					<option value="<?php echo $menuChildParent->id; ?>"<?php echo $selected; ?>>
									 <?php echo $menuChildParent->name; ?>
			     					</option>
								     <?php
								 }
							     }
							 }
						     }
						 }
					     }
					 }
					?>
				    </select>
				</div>
				<div class="form-group hide" id="menu-typeGroup">
				    <label for="inputMenuTypes">Menu Type</label>
				    <select name="menu-typecontents" id="menuType" class="form-control input-lg" placeholder="Menu Type">
					<?php
					 foreach ($menus as $menuTypes)
					 {
					     if ($menuTypes['menuType']->id == (int) $this->objval('widget', 'contents')) {
						 $selected = ' selected';
					     } else {
						 $selected = '';
					     }
					     ?>
     					<option value="<?php echo $menuTypes['menuType']->id; ?>"<?php echo $selected; ?>>
						 <?php echo $menuTypes['menuType']->name; ?>
     					</option>
					 <?php } ?>
				    </select>
				</div>
				<div class="form-group hide" id="htmlGroup">
				    <label for="inputContent">Content (HTML)</label>
				    <textarea id="inputContent" name="htmlcontents" class="textarea" placeholder="Widget Content"><?php echo $this->objval('widget', 'contents'); ?></textarea>
				</div>
				<?php echo $this->csrfToken(); ?>              
			    </div>
			</div>
			<div class="box-footer">
			    <a href="admin/widgets/" class="btn btn-default btn-lg"><i class="fa fa-close" aria-hidden="true"></i> Close</a>
			    <button type="submit" class="btn btn-success btn-lg pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
			</div>
		    </div>
		</div>
		<div class="col-md-4 col-xs-12">
		    <div class="box box-info">
			<div class="box-header with-border">
			    <h3 class="box-title"><i class="fa fa-share"></i> Assign Menu</h3>
			</div>
			<div class="box-body">
			    <div class="form-group" id="menuTypeGroup">
				<label for="inputMenuTypes">Assign To menu</label>
				<input type="text" name="sortMenu" id="menuSearch" class="form-control input-xs" placeholder="Search Items">
				<ul class="assignList" id="assignMenu">
				    <?php
				     if (in_array(0, $currentMenus)) {
					 $checked = ' checked';
				     } else {
					 $checked = '';
				     }
				    ?>
				    <li>
					<input type="checkbox" name="assigned[]" value="0" class="menu-items"<?php echo $checked; ?> />
					All Pages <small>(Outside assigned menus too)</small>
				    </li>
				    <?php
				     foreach ($menus as $menuTypes)
				     {
					 ?>
     				    <li class="list-group-title">
					     <?php echo $menuTypes['menuType']->name; ?> Items
     				    </li>
					 <?php
					 if (!empty($menuTypes['items'])) {
					     foreach ($menuTypes['items'] as $menuItem)
					     {
						 if (in_array($menuItem->id, $currentMenus)) {
						     $checked = ' checked';
						 } else {
						     $checked = '';
						 }
						 ?>
	     				    <li>
	     					<input type="checkbox" name="assigned[]" value="<?php echo $menuItem->id; ?>" <?php echo $checked; ?> class="menu-items" />
						     <?php echo $menuItem->name; ?>
	     				    </li>
						 <?php
						 if (!empty($menuItem->child)) {
						     foreach ($menuItem->child as $menuChild)
						     {
							 if (in_array($menuChild->id, $currentMenus)) {
							     $checked = ' checked';
							 } else {
							     $checked = '';
							 }
							 ?>
		     				    <li class="item-child">
		     					<i class="fa fa-level-up fa-rotate-90 ml-40"></i>
		     					<input type="checkbox" name="assigned[]" value="<?php echo $menuChild->id; ?>" <?php echo $checked; ?> class="menu-items parent-<?php echo $menuItem->id; ?>" />
							     <?php echo $menuChild->name; ?>
		     				    </li>
							 <?php
							 if (!empty($menuChild->child)) {
							     foreach ($menuChild->child as $menuGrandChild)
							     {
								 if (in_array($menuGrandChild->id, $currentMenus)) {
								     $checked = ' checked';
								 } else {
								     $checked = '';
								 }
								 ?>
			     				    <li class="item-grand-child">
			     					<i class="fa fa-level-up fa-rotate-90 ml-40"></i>
			     					<input type="checkbox" name="assigned[]" value="<?php echo $menuGrandChild->id; ?>" <?php echo $checked; ?> class="menu-items parent-<?php echo $menuChild->id; ?>" />
								     <?php echo $menuGrandChild->name; ?>
			     				    </li>
								 <?php
							     }
							 }
						     }
						 }
					     }
					 }
				     }
				    ?>
				</ul>
				<div class="text-right">
				    <small>
					<a href="#" class="select-menu-items select-all">Select All</a>
					|
					<a href="#" class="select-menu-items select-none">Select None</a>
				    </small>
				</div>
				<?php //pr($menus);    ?>
			    </div>
			</div>
		    </div>
		    <div class="box box-info">
			<div class="box-header with-border">
			    <h3 class="box-title"><i class="fa fa-cog"></i> Other Settings</h3>
			</div>
			<div class="box-body">          
			    <div class="form-group">
				<label for="inputLayout">Layout</label>
				<input type="text" name="layout" class="form-control input-lg" placeholder="Widget Layout" value="<?php echo $this->objval('widget', 'layout'); ?>">
			    </div>
			    <div class="form-group">
				<label for="inputOrdering">Ordering</label>
				<input type="text" name="ordering" class="form-control input-lg" placeholder="Widget Ordering" value="<?php echo $this->objval('widget', 'ordering'); ?>">
			    </div>
			    <div class="form-group text-right">
				<a class="text-red popup" href="admin/widget/delete/<?php echo $this->objval('widget', 'id'); ?>">
				    <i class="fa fa-trash" aria-hidden="true"></i> Delete this widget
				</a>
			    </div>
			</div>
		    </div>
		</div>
	    </form>
	</div>
    </section>
</div>
<script>
    var thisURL = '<?php echo current(explode('?', CURRENT_URL)); ?>';
    console.log("<?php echo CURRENT_URL; ?>");
    $(document).ready(function () {
        triggerWidgetTypes($('#widgetType').val(), false, "#menuType");
        //triggerWidgetTypes($('#widgetType').val(), true, "#assignMenuType");
        //populateMenuTypes(false, "#assignMenuType");
        //populateMenus(0, "#assignMenu");
        //triggerMenus($('#menuType').val());

        $('#widgetType').on('change', function () {
            triggerWidgetTypes($(this).val());
        });
        /*
         $('#menuType').on('change', function () {
         triggerMenus($(this).val(), "#menu");
         });
         */
        $('#assignMenuType').on('change', function () {
            triggerMenus($(this).val(), "#assignMenu");
        });
    });
    function triggerWidgetTypes(widgetType, isTriggerMenus = false, target = "#menuType") {
        //var widgetType = $(this).val();

        $("#menuGroup").addClass('hide');
        $("#menu-typeGroup").addClass('hide');
        $("#htmlGroup").addClass('hide');
        if (widgetType == 'menu') {
            $("#menuGroup").removeClass('hide');
        } else if (widgetType == 'menu-type') {
            $("#menu-typeGroup").removeClass('hide');
        } else {
            $("#htmlGroup").removeClass('hide');
    }
    }

    function triggerMenus(menuType, target = "#assignMenu") {
        //populateMenus(menuType, target);
    }

    function populateMenuTypes(isTriggerMenus = false, target) {
        $(target).empty();
        if (target == "#assignMenuType") {
            $(target).append($('<option>', {
                value: 0,
                text: 'All'
            }));
        }
        //console.log(cityName);
        $.ajax({
            type: 'GET',
            url: thisURL + '?returnMenuTypes',
            cache: false,
            success: function (html) {
                //console.log(JSON.stringify(html));
                if (html.length != 0) {
                    $.each(html, function (i, item) {
                        var id = html[i].id;
                        var name = html[i].name;
                        $(target).append(
                                $('<option>', {
                                    value: id,
                                    text: name
                                })
                                );
                    });
                }
                $('#menuTypeGroup').removeClass('hide');
                if (isTriggerMenus == true) {
                    triggerMenus($('#menuType').val());
                }
            }
        });
    }

    function populateMenus(menuType, target) {
        $(target).empty();
        $(target).append($('<option>', {
            value: 0,
            text: 'All'
        }));
        console.log(thisURL + '?menuType=' + menuType);
        $.ajax({
            type: 'GET',
            url: thisURL + '?menuType=' + menuType,
            cache: false,
            success: function (html) {
                //console.log(JSON.stringify(html));
                var parent = 0;
                var id;
                var name;
                if (html.length != 0) {
                    $.each(html, function (i, item) {
                        id = html[i].id;
                        name = html[i].name;
                        parent = html[i].pid;
                        //console.log(item);
                        $(target).append($('<option>', {
                            value: id,
                            text: name
                        }));
                        if (item.child !== undefined) {
                            $.each(item.child, function (j, childItem) {
                                $(target).append($('<option>', {
                                    value: childItem.id,
                                    text: " --- " + childItem.name
                                }));
                                if (childItem.child !== undefined) {
                                    $.each(childItem.child, function (k, grandChildItem) {
                                        $(target).append($('<option>', {
                                            value: grandChildItem.id,
                                            text: " --- --- " + grandChildItem.name
                                        }));
                                    });
                                }
                            });
                        }
                    });
                }
                $('#menuGroup').removeClass('hide');
            }
        });
    }

    $('#menuSearch').keyup(function () {
        var valthis = $(this).val().toLowerCase();
        $('#assignMenu>li').each(function () {
            var text = $(this).text().toLowerCase();
            if (text.indexOf(valthis) !== -1) {
                $(this).show();
                //$(this).prop('selected',true);
            } else {
                $(this).hide();
            }
        });
    });
    $(document).ready(function () {
        $(".menu-items").click(function (e) {
            $('.parent-' + $(e.target).val()).prop('checked', $(e.target).is(':checked'));
        });
        $('.select-menu-items').click(function (e) {
            e.preventDefault();
            $(".menu-items").prop('checked', $(e.target).hasClass('select-all'));
        });
    });
</script>
 