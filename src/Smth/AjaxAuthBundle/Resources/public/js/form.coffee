class AjaxAuthForm
	constructor: (@form) ->
		console.log 'form:',@form
		@username = @form.find 'input[name=_username]'
		@password = @form.find 'input[name=_password]'

		@form.bind 'submit', @_onSubmit

	_beforeSubmit: (_callback) => _callback.apply @

	_onSubmit: (e) =>
		console.log arguments
		e.preventDefault()
		@_beforeSubmit @_ajax

	_ajax: =>
		$.ajax
			url: '/app_dev.php/login_check',
			type: 'POST',
			dataType: 'json',
			data:
				_username: @username.val()
				_password: @password.val()
				_remember_me: true
			success: (response) =>
				console.log arguments
			error: (response) =>
				console.log arguments

# window.formHandler = new AjaxAuthForm $ 'form'