<?php
	$this->assign('title','SAFEBASE | SafNotifications');
	$this->assign('nav','safnotifications');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/safnotifications.js").wait(function(){
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
	<i class="icon-th-list"></i> SafNotifications
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="safNotificationCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Id">Id<% if (page.orderBy == 'Id') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_FkWorkerOrigin">Fk Worker Origin<% if (page.orderBy == 'FkWorkerOrigin') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_FkWorkerDestiny">Fk Worker Destiny<% if (page.orderBy == 'FkWorkerDestiny') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_FkReport">Fk Report<% if (page.orderBy == 'FkReport') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Enabled">Enabled<% if (page.orderBy == 'Enabled') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
			</tr>
		</thead>
		<tbody>
		<% items.each(function(item) { %>
			<tr id="<%= _.escape(item.get('id')) %>">
				<td><%= _.escape(item.get('id') || '') %></td>
				<td><%= _.escape(item.get('fkWorkerOrigin') || '') %></td>
				<td><%= _.escape(item.get('fkWorkerDestiny') || '') %></td>
				<td><%= _.escape(item.get('fkReport') || '') %></td>
				<td><%= _.escape(item.get('enabled') || '') %></td>
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="safNotificationModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="idInputContainer" class="control-group">
					<label class="control-label" for="id">Id</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="id"><%= _.escape(item.get('id') || '') %></span>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="fkWorkerOriginInputContainer" class="control-group">
					<label class="control-label" for="fkWorkerOrigin">Fk Worker Origin</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="fkWorkerOrigin" placeholder="Fk Worker Origin" value="<%= _.escape(item.get('fkWorkerOrigin') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="fkWorkerDestinyInputContainer" class="control-group">
					<label class="control-label" for="fkWorkerDestiny">Fk Worker Destiny</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="fkWorkerDestiny" placeholder="Fk Worker Destiny" value="<%= _.escape(item.get('fkWorkerDestiny') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="fkReportInputContainer" class="control-group">
					<label class="control-label" for="fkReport">Fk Report</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="fkReport" placeholder="Fk Report" value="<%= _.escape(item.get('fkReport') || '') %>">
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
		<form id="deleteSafNotificationButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteSafNotificationButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete SafNotification</button>
						<span id="confirmDeleteSafNotificationContainer" class="hide">
							<button id="cancelDeleteSafNotificationButton" class="btn btn-mini">Cancel</button>
							<button id="confirmDeleteSafNotificationButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="safNotificationDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit SafNotification
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="safNotificationModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancel</button>
			<button id="saveSafNotificationButton" class="btn btn-primary">Save Changes</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="safNotificationCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newSafNotificationButton" class="btn btn-primary">Add SafNotification</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
