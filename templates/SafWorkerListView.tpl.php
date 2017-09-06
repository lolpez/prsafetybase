<?php
	$this->assign('title','PrSafetyBase WEB | SafWorkers');
	$this->assign('nav','safworkers');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/safworkers.js").wait(function(){
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
	<i class="icon-th-list"></i> SafWorkers
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="safWorkerCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Id">Id<% if (page.orderBy == 'Id') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_User">User<% if (page.orderBy == 'User') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Password">Password<% if (page.orderBy == 'Password') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_FkHuman">Fk Human<% if (page.orderBy == 'FkHuman') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_FkRole">Fk Role<% if (page.orderBy == 'FkRole') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<th id="header_FkDepartment">Fk Department<% if (page.orderBy == 'FkDepartment') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Enabled">Enabled<% if (page.orderBy == 'Enabled') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
-->
			</tr>
		</thead>
		<tbody>
		<% items.each(function(item) { %>
			<tr id="<%= _.escape(item.get('id')) %>">
				<td><%= _.escape(item.get('id') || '') %></td>
				<td><%= _.escape(item.get('user') || '') %></td>
				<td><%= _.escape(item.get('password') || '') %></td>
				<td><%= _.escape(item.get('fkHuman') || '') %></td>
				<td><%= _.escape(item.get('fkRole') || '') %></td>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<td><%= _.escape(item.get('fkDepartment') || '') %></td>
				<td><%= _.escape(item.get('enabled') || '') %></td>
-->
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="safWorkerModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="idInputContainer" class="control-group">
					<label class="control-label" for="id">Id</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="id"><%= _.escape(item.get('id') || '') %></span>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="userInputContainer" class="control-group">
					<label class="control-label" for="user">User</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="user" placeholder="User" value="<%= _.escape(item.get('user') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="passwordInputContainer" class="control-group">
					<label class="control-label" for="password">Password</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="password" placeholder="Password" value="<%= _.escape(item.get('password') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="fkHumanInputContainer" class="control-group">
					<label class="control-label" for="fkHuman">Fk Human</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="fkHuman" placeholder="Fk Human" value="<%= _.escape(item.get('fkHuman') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="fkRoleInputContainer" class="control-group">
					<label class="control-label" for="fkRole">Fk Role</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="fkRole" placeholder="Fk Role" value="<%= _.escape(item.get('fkRole') || '') %>">
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
		<form id="deleteSafWorkerButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteSafWorkerButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete SafWorker</button>
						<span id="confirmDeleteSafWorkerContainer" class="hide">
							<button id="cancelDeleteSafWorkerButton" class="btn btn-mini">Cancel</button>
							<button id="confirmDeleteSafWorkerButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="safWorkerDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit SafWorker
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="safWorkerModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancel</button>
			<button id="saveSafWorkerButton" class="btn btn-primary">Save Changes</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="safWorkerCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newSafWorkerButton" class="btn btn-primary">Add SafWorker</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
