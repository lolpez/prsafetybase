<?php
	$this->assign('title','PrSafetyBase WEB | SafReports');
	$this->assign('nav','safreports');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/safreports.js").wait(function(){
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
	<i class="icon-th-list"></i> SafReports
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="safReportCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Id">Id<% if (page.orderBy == 'Id') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_FkTrabajador">Fk Trabajador<% if (page.orderBy == 'FkTrabajador') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Date">Date<% if (page.orderBy == 'Date') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Time">Time<% if (page.orderBy == 'Time') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Description">Description<% if (page.orderBy == 'Description') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<th id="header_Latitude">Latitude<% if (page.orderBy == 'Latitude') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Longitude">Longitude<% if (page.orderBy == 'Longitude') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_ReportType">Report Type<% if (page.orderBy == 'ReportType') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Enabled">Enabled<% if (page.orderBy == 'Enabled') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
-->
			</tr>
		</thead>
		<tbody>
		<% items.each(function(item) { %>
			<tr id="<%= _.escape(item.get('id')) %>">
				<td><%= _.escape(item.get('id') || '') %></td>
				<td><%= _.escape(item.get('fkTrabajador') || '') %></td>
				<td><%if (item.get('date')) { %><%= _date(app.parseDate(item.get('date'))).format('MMM D, YYYY') %><% } else { %>NULL<% } %></td>
				<td><%if (item.get('time')) { %><%= _date(app.parseDate(item.get('time'))).format('h:mm A') %><% } else { %>NULL<% } %></td>
				<td><%= _.escape(item.get('description') || '') %></td>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<td><%= _.escape(item.get('latitude') || '') %></td>
				<td><%= _.escape(item.get('longitude') || '') %></td>
				<td><%= _.escape(item.get('reportType') || '') %></td>
				<td><%= _.escape(item.get('enabled') || '') %></td>
-->
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="safReportModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="idInputContainer" class="control-group">
					<label class="control-label" for="id">Id</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="id"><%= _.escape(item.get('id') || '') %></span>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="fkTrabajadorInputContainer" class="control-group">
					<label class="control-label" for="fkTrabajador">Fk Trabajador</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="fkTrabajador" placeholder="Fk Trabajador" value="<%= _.escape(item.get('fkTrabajador') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="dateInputContainer" class="control-group">
					<label class="control-label" for="date">Date</label>
					<div class="controls inline-inputs">
						<div class="input-append date date-picker" data-date-format="yyyy-mm-dd">
							<input id="date" type="text" value="<%= _date(app.parseDate(item.get('date'))).format('YYYY-MM-DD') %>" />
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="timeInputContainer" class="control-group">
					<label class="control-label" for="time">Time</label>
					<div class="controls inline-inputs">
						<div class="input-append bootstrap-timepicker-component">
							<input id="time" type="text" class="timepicker-default input-small" value="<%= _date(app.parseDate(item.get('time'))).format('h:mm A') %>" />
							<span class="add-on"><i class="icon-time"></i></span>
						</div>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="descriptionInputContainer" class="control-group">
					<label class="control-label" for="description">Description</label>
					<div class="controls inline-inputs">
						<textarea class="input-xlarge" id="description" rows="3"><%= _.escape(item.get('description') || '') %></textarea>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="latitudeInputContainer" class="control-group">
					<label class="control-label" for="latitude">Latitude</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="latitude" placeholder="Latitude" value="<%= _.escape(item.get('latitude') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="longitudeInputContainer" class="control-group">
					<label class="control-label" for="longitude">Longitude</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="longitude" placeholder="Longitude" value="<%= _.escape(item.get('longitude') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="reportTypeInputContainer" class="control-group">
					<label class="control-label" for="reportType">Report Type</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="reportType" placeholder="Report Type" value="<%= _.escape(item.get('reportType') || '') %>">
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
		<form id="deleteSafReportButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteSafReportButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete SafReport</button>
						<span id="confirmDeleteSafReportContainer" class="hide">
							<button id="cancelDeleteSafReportButton" class="btn btn-mini">Cancel</button>
							<button id="confirmDeleteSafReportButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="safReportDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit SafReport
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="safReportModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancel</button>
			<button id="saveSafReportButton" class="btn btn-primary">Save Changes</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="safReportCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newSafReportButton" class="btn btn-primary">Add SafReport</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
