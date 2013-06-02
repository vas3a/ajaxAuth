d = document
class AjaxAuthBaseController
	constructor: ->
		@form = $ 'form#ajax-login'
		@username = @form.find 'input[name=_username]'
		@password = @form.find 'input[name=_password]'

	server_responded: (response) => @[response.result](response); @form.trigger 'done'
	login_succeded: (response) => @redirect response.redirect_url
	login_failed: (response) => @invalid $(@username,@password), response.message

	redirect: (url) -> window.location.href = url
	invalid: (input, msg)-> input.trigger type: 'invalid', message: msg

class AjaxAuthController extends AjaxAuthBaseController
	constructor: ->
		super
		@submitURL = @form.attr 'action'
		@form.bind 'submit', @_onSubmit

	_beforeSubmit: (_callback) => 
		return @invalid @username, 'Type your username' if !@username.val().length
		return @invalid @password, 'Type your password' if !@password.val().length
		_callback.apply @

	_onSubmit: (e) =>
		e.preventDefault()
		@_beforeSubmit @_ajax

	_ajax: =>
		@form.trigger 'loading'

		$.ajax
			url: @submitURL
			type: 'POST'
			dataType: 'json'
			data: {_username: @username.val(), _password: @password.val()}
			success: @server_responded

class AjaxAuthFbController extends AjaxAuthController
	constructor: (@loginRoute, @appId)->
		super
		@loadFBApi()
		@fBtn =  $ '#ajax-fb-btn' #, $ '#ajax-g-btn'
		@fBtn.bind 'click', => FB.login @fbCallback,{scope:"email"}

	fbCallback: (response)=>
		if response.status is 'connected'
			$.ajax
				url: @loginRoute
				type: 'POST'
				dataType: 'json'
				data: {token: response.authResponse.accessToken}
				success: @server_responded
	loadFBApi: =>
		if window.facebookReady isnt true
			return if d.getElementById id = 'facebook-jssdk'
			ref = d.getElementsByTagName('script')[0]
			
			js = d.createElement('script')
			js.id = id
			js.async = true
			js.src = "//connect.facebook.net/en_US/all.js";
			ref.parentNode.insertBefore(js, ref)

			window.fbAsyncInit = @fbReady
	fbReady: =>
		FB.init
			appId : @appId
			status: true
			cookie: true
			xfbml : true
		window.facebookReady = true
		$(window).trigger('facebookReady')

class AjaxAuthGoogleController extends AjaxAuthController
	constructor: (@loginRoute, @clientId) ->
		super
		@loadGApi()
		@gBtn =  $ '#ajax-g-btn'
		@gBtn.bind 'click', => @login = true

	saveResponse: (@response) => @doLogin() if @login

	doLogin: =>
		response = @response
		if response.code? and response.code and response.state is @token and not response.error?
			$.ajax
				url: @loginRoute
				type: 'POST'
				dataType: 'json'
				data: {token: response.access_token}
				success: @server_responded

	renderSignInButton: =>
		@googleBtn =
			'callback': @saveResponse
			'clientid': @clientId+'.apps.googleusercontent.com'
			'cookiepolicy': 'single_host_origin'
			'requestvisibleactions': 'http://schemas.google.com/AddActivity'
			'scope': 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'
			'state': (@token = 'test123_merely_is_a_token')

		gapi.signin.render 'ajax-g-btn', @googleBtn

	loadGApi: =>
		if window.gApiReady isnt true
			window.gApiReady = => window.gApiReady = true; @renderSignInButton()
			
			s = d.createElement('script')
			s.type = 'text/javascript'
			s.async = true
			s.src = 'https://apis.google.com/js/client:plusone.js?onload=gApiReady'

			c = d.getElementsByTagName('script')[0];
			c.parentNode.insertBefore(s, c);

new AjaxAuthController
new AjaxAuthFbController
new AjaxAuthGoogleController