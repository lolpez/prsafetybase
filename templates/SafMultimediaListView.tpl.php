<?php
	$this->assign('title','PrSafetyBase WEB | SafMultimedias');
	$this->assign('nav','safmultimedias');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/safmultimedias.js").wait(function(){
		$(document).ready(function(){
			page.init();
		});
		
		// hack for IE9 which may respond inconsistently with document.ready
		setTimeout(function(){
			if (!page.isInitialized) page.init();
		},1000);
	});
</script>

<div class="container">

<h1>
	<i class="icon-th-list"></i> SafMultimedias
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="safMultimediaCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Id">Id<% if (page.orderBy == 'Id') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Filename">Filename<% if (page.orderBy == 'Filename') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Extension">Extension<% if (page.orderBy == 'Extension') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Location">Location<% if (page.orderBy == 'Location') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Type">Type<% if (page.orderBy == 'Type') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<th id="header_Enabled">Enabled<% if (page.orderBy == 'Enabled') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
-->
			</tr>
		</thead>
		<tbody>
		<% items.each(function(item) { %>
			<tr id="<%= _.escape(item.get('id')) %>">
				<td><%= _.escape(item.get('id') || '') %></td>
				<td><%= _.escape(item.get('filename') || '') %></td>
				<td><%= _.escape(item.get('extension') || '') %></td>
				<td><%= _.escape(item.get('location') || '') %></td>
				<td><%= _.escape(item.get('type') || '') %></td>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<td><%= _.escape(item.get('enabled') || '') %></td>
-->
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="safMultimediaModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="idInputContainer" class="control-group">
					<label class="control-label" for="id">Id</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="id"><%= _.escape(item.get('id') || '') %></span>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="filenameInputContainer" class="control-group">
					<label class="control-label" for="filename">Filename</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="filename" placeholder="Filename" value="<%= _.escape(item.get('filename') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="extensionInputContainer" class="control-group">
					<label class="control-label" for="extension">Extension</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="extension" placeholder="Extension" value="<%= _.escape(item.get('extension') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="locationInputContainer" class="control-group">
					<label class="control-label" for="location">Location</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="location" placeholder="Location" value="<%= _.escape(item.get('location') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="typeInputContainer" class="control-group">
					<label class="control-label" for="type">Type</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="type" placeholder="Type" value="<%= _.escape(item.get('type') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="enabledInputContainer" class="control-group">
					<label class="control-label" for="enabled">Enabled</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="enabled" placeholder="Enabled" value="<%= _.escape(item.get('enabled') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
			</fieldset>
		</form>

		<!-- delete button is is a separate form to prevent enter key from triggering a delete -->
		<form id="deleteSafMultimediaButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteSafMultimediaButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete SafMultimedia</button>
						<span id="confirmDeleteSafMultimediaContainer" class="hide">
							<button id="cancelDeleteSafMultimediaButton" class="btn btn-mini">Cancel</button>
							<button id="confirmDeleteSafMultimediaButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="safMultimediaDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit SafMultimedia
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="safMultimediaModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancel</button>
			<button id="saveSafMultimediaButton" class="btn btn-primary">Save Changes</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="safMultimediaCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newSafMultimediaButton" class="btn btn-primary">Add SafMultimedia</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
