/**
 * backbone model definitions for SAFEBASE
 */

/**
 * Use emulated HTTP if the server doesn't support PUT/DELETE or application/json requests
 */
Backbone.emulateHTTP = false;
Backbone.emulateJSON = false;

var model = {};

/**
 * long polling duration in miliseconds.  (5000 = recommended, 0 = disabled)
 * warning: setting this to a low number will increase server load
 */
model.longPollDuration = 0;

/**
 * whether to refresh the collection immediately after a model is updated
 */
model.reloadCollectionOnModelUpdate = true;


/**
 * a default sort method for sorting collection items.  this will sort the collection
 * based on the orderBy and orderDesc property that was used on the last fetch call
 * to the server. 
 */
model.AbstractCollection = Backbone.Collection.extend({
	totalResults: 0,
	totalPages: 0,
	currentPage: 0,
	pageSize: 0,
	orderBy: '',
	orderDesc: false,
	lastResponseText: null,
	lastRequestParams: null,
	collectionHasChanged: true,
	
	/**
	 * fetch the collection from the server using the same options and 
	 * parameters as the previous fetch
	 */
	refetch: function() {
		this.fetch({ data: this.lastRequestParams })
	},
	
	/* uncomment to debug fetch event triggers
	fetch: function(options) {
            this.constructor.__super__.fetch.apply(this, arguments);
	},
	// */
	
	/**
	 * client-side sorting baesd on the orderBy and orderDesc parameters that
	 * were used to fetch the data from the server.  Backbone ignores the
	 * order of records coming from the server so we have to sort them ourselves
	 */
	comparator: function(a,b) {
		
		var result = 0;
		var options = this.lastRequestParams;
		
		if (options && options.orderBy) {
			
			// lcase the first letter of the property name
			var propName = options.orderBy.charAt(0).toLowerCase() + options.orderBy.slice(1);
			var aVal = a.get(propName);
			var bVal = b.get(propName);
			
			if (isNaN(aVal) || isNaN(bVal)) {
				// treat comparison as case-insensitive strings
				aVal = aVal ? aVal.toLowerCase() : '';
				bVal = bVal ? bVal.toLowerCase() : '';
			} else {
				// treat comparision as a number
				aVal = Number(aVal);
				bVal = Number(bVal);
			}
			
			if (aVal < bVal) {
				result = options.orderDesc ? 1 : -1;
			} else if (aVal > bVal) {
				result = options.orderDesc ? -1 : 1;
			}
		}
		
		return result;

	},
	/**
	 * override parse to track changes and handle pagination
	 * if the server call has returned page data
	 */
	parse: function(response, options) {

		// the response is already decoded into object form, but it's easier to
		// compary the stringified version.  some earlier versions of backbone did
		// not include the raw response so there is some legacy support here
		var responseText = options && options.xhr ? options.xhr.responseText : JSON.stringify(response);
		this.collectionHasChanged = (this.lastResponseText != responseText);
		this.lastRequestParams = options ? options.data : undefined;
		
		// if the collection has changed then we need to force a re-sort because backbone will
		// only resort the data if a property in the model has changed
		if (this.lastResponseText && this.collectionHasChanged) this.sort({ silent:true });
		
		this.lastResponseText = responseText;
		
		var rows;

		if (response.currentPage) {
			rows = response.rows;
			this.totalResults = response.totalResults;
			this.totalPages = response.totalPages;
			this.currentPage = response.currentPage;
			this.pageSize = response.pageSize;
			this.orderBy = response.orderBy;
			this.orderDesc = response.orderDesc;
		} else {
			rows = response;
			this.totalResults = rows.length;
			this.totalPages = 1;
			this.currentPage = 1;
			this.pageSize = this.totalResults;
			this.orderBy = response.orderBy;
			this.orderDesc = response.orderDesc;
		}

		return rows;
	}
});

/**
 * SafDepartment Backbone Model
 */
model.SafDepartmentModel = Backbone.Model.extend({
	urlRoot: 'api/safdepartment',
	idAttribute: 'id',
	id: '',
	name: '',
	enabled: '',
	defaults: {
		'id': null,
		'name': '',
		'enabled': ''
	}
});

/**
 * SafDepartment Backbone Collection
 */
model.SafDepartmentCollection = model.AbstractCollection.extend({
	url: 'api/safdepartments',
	model: model.SafDepartmentModel
});

/**
 * SafHuman Backbone Model
 */
model.SafHumanModel = Backbone.Model.extend({
	urlRoot: 'api/safhuman',
	idAttribute: 'id',
	id: '',
	ci: '',
	name: '',
	bloodType: '',
	phoneNumber: '',
	enabled: '',
	defaults: {
		'id': null,
		'ci': '',
		'name': '',
		'bloodType': '',
		'phoneNumber': '',
		'enabled': ''
	}
});

/**
 * SafHuman Backbone Collection
 */
model.SafHumanCollection = model.AbstractCollection.extend({
	url: 'api/safhumans',
	model: model.SafHumanModel
});

/**
 * SafMultimedia Backbone Model
 */
model.SafMultimediaModel = Backbone.Model.extend({
	urlRoot: 'api/safmultimedia',
	idAttribute: 'id',
	id: '',
	filename: '',
	extension: '',
	location: '',
	thumbLocation: '',
	type: '',
	enabled: '',
	defaults: {
		'id': null,
		'filename': '',
		'extension': '',
		'location': '',
		'thumbLocation': '',
		'type': '',
		'enabled': ''
	}
});

/**
 * SafMultimedia Backbone Collection
 */
model.SafMultimediaCollection = model.AbstractCollection.extend({
	url: 'api/safmultimedias',
	model: model.SafMultimediaModel
});

/**
 * SafNotification Backbone Model
 */
model.SafNotificationModel = Backbone.Model.extend({
	urlRoot: 'api/safnotification',
	idAttribute: 'id',
	id: '',
	fkWorkerOrigin: '',
	fkWorkerDestiny: '',
	fkReport: '',
	enabled: '',
	defaults: {
		'id': null,
		'fkWorkerOrigin': '',
		'fkWorkerDestiny': '',
		'fkReport': '',
		'enabled': ''
	}
});

/**
 * SafNotification Backbone Collection
 */
model.SafNotificationCollection = model.AbstractCollection.extend({
	url: 'api/safnotifications',
	model: model.SafNotificationModel
});

/**
 * SafReport Backbone Model
 */
model.SafReportModel = Backbone.Model.extend({
	urlRoot: 'api/safreport',
	idAttribute: 'id',
	id: '',
	fkWorker: '',
	date: '',
	time: '',
	description: '',
	latitude: '',
	longitude: '',
	reportType: '',
	enabled: '',
	defaults: {
		'id': null,
		'fkWorker': '',
		'date': new Date(),
		'time': '',
		'description': '',
		'latitude': '',
		'longitude': '',
		'reportType': '',
		'enabled': ''
	}
});

/**
 * SafReport Backbone Collection
 */
model.SafReportCollection = model.AbstractCollection.extend({
	url: 'api/safreports',
	model: model.SafReportModel
});

/**
 * SafReportDetail Backbone Model
 */
model.SafReportDetailModel = Backbone.Model.extend({
	urlRoot: 'api/safreportdetail',
	idAttribute: 'id',
	id: '',
	fkReport: '',
	fkMultimedia: '',
	enabled: '',
	defaults: {
		'id': null,
		'fkReport': '',
		'fkMultimedia': '',
		'enabled': ''
	}
});

/**
 * SafReportDetail Backbone Collection
 */
model.SafReportDetailCollection = model.AbstractCollection.extend({
	url: 'api/safreportdetails',
	model: model.SafReportDetailModel
});

/**
 * SafRole Backbone Model
 */
model.SafRoleModel = Backbone.Model.extend({
	urlRoot: 'api/safrole',
	idAttribute: 'id',
	id: '',
	name: '',
	enabled: '',
	defaults: {
		'id': null,
		'name': '',
		'enabled': ''
	}
});

/**
 * SafRole Backbone Collection
 */
model.SafRoleCollection = model.AbstractCollection.extend({
	url: 'api/safroles',
	model: model.SafRoleModel
});

/**
 * SafWorker Backbone Model
 */
model.SafWorkerModel = Backbone.Model.extend({
	urlRoot: 'api/safworker',
	idAttribute: 'id',
	id: '',
	user: '',
	password: '',
	enrollment: '',
	fkHuman: '',
	fkRole: '',
	fkDepartment: '',
	enabled: '',
	defaults: {
		'id': null,
		'user': '',
		'password': '',
		'enrollment': '',
		'fkHuman': '',
		'fkRole': '',
		'fkDepartment': '',
		'enabled': ''
	}
});

/**
 * SafWorker Backbone Collection
 */
model.SafWorkerCollection = model.AbstractCollection.extend({
	url: 'api/safworkers',
	model: model.SafWorkerModel
});

