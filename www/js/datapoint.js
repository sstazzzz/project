var ODataPointGate = function(_url) {
	var self = this;
	var RequestType = 'SimpleJson';
	var ResponseType = 'SimpleJson';

	var URL = _url;
	self.Token = null;

	this.Request = function(_function, _request, _callback, _error_callback) {

		var Request = {
			Function: _function,
			RequestType: RequestType,
			ResponseType: ResponseType,
			Data: _request,
			Token: self.Token?self.Token:undefined
		}

		var JsonRequest = $.toJSON(Request);

		$.ajax({
			url: URL,
			data: {
				Data: JsonRequest,
				RequestType: RequestType
			},
			type: 'GET',
			dataType: 'jsonp',
			success: function(_response) {
				var Result = "";
				try
				{
					Result = _response;
				}
				catch (e)
				{
					if (_error_callback != undefined)
					{
						_error_callback(_response, _function, _request);
					}
				}
				if (Result.StatusCode != undefined)
				{
					if (parseInt(Result.StatusCode) == 200 && _callback != undefined)
					{
						_callback(Result.Data, _function, _request);
					}
					else if (_error_callback != undefined)
					{
						_error_callback(Result, _function, _request);
					}

				}
			},
			error: function(_jqXHR) {
				if (_error_callback != undefined)
				{
					_error_callback("Datapoint unknown error.", _function, _request);
				}
			}
		});
	};
};

var datapoint = new Object();