<?php
	$this->assign('title','PrSafetyBase WEB | SafDepartmentDetails');
	$this->assign('nav','safdepartmentdetails');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/safdepartmentdetails.js").wait(function(){
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
	<i class="icon-th-list"></i> SafDepartmentDetails
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="safDepartmentDetailCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Id">Id<% if (page.orderBy == 'Id') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_FkDepartment">Fk Department<% if (page.orderBy == 'FkDepartment') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_FkMultimedia">Fk Multimedia<% if (page.orderBy == 'FkMultimedia') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Enabled">Enabled<% if (page.orderBy == 'Enabled') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
			</tr>
		</thead>
		<tbody>
		<% items.each(function(item) { %>
			<tr id="<%= _.escape(item.get('id')) %>">
				<td><%= _.escape(item.get('id') || '') %></td>
				<td><%= _.escape(item.get('fkDepartment') || '') %></td>
				<td><%= _.escape(item.get('fkMultimedia') || '') %></td>
				<td><%= _.escape(item.get('enabled') || '') %></td>
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="safDepartmentDetailModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="idInputContainer" class="control-group">
					<label class="control-label" for="id">Id</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="id"><%= _.escape(item.get('id') || '') %></span>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="fkDepartmentInputContainer" class="control-group">
					<label class="control-label" for="fkDepartment">Fk Department</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="fkDepartment" placeholder="Fk Department" value="<%= _.escape(item.get('fkDepartment') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="fkMultimediaInputContainer" class="control-group">
					<label class="control-label" for="fkMultimedia">Fk Multimedia</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="fkMultimedia" placeholder="Fk Multimedia" value="<%= _.escape(item.get('fkMultimedia') || '') %>">
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
		<form id="deleteSafDepartmentDetailButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteSafDepartmentDetailButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete SafDepartmentDetail</button>
						<span id="confirmDeleteSafDepartmentDetailContainer" class="hide">
							<button id="cancelDeleteSafDepartmentDetailButton" class="btn btn-mini">Cancel</button>
							<button id="confirmDeleteSafDepartmentDetailButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="safDepartmentDetailDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit SafDepartmentDetail
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="safDepartmentDetailModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancel</button>
			<button id="saveSafDepartmentDetailButton" class="btn btn-primary">Save Changes</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="safDepartmentDetailCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newSafDepartmentDetailButton" class="btn btn-primary">Add SafDepartmentDetail</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
