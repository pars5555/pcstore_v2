function onFacebookLogin(response)
{
    var userId = response.id;
    var firstName = response.first_name;
    var lastName = response.last_name;
    var jsonProfile = JSON.stringify(response);
    ngs.action("social_login", {"login_type": 'facebook', 'social_user_id': userId, 'first_name': firstName, 'last_name': lastName, 'json_profile': jsonProfile});
}