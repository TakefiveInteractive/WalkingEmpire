Assuming at this stage the entire map is limited to a 1km x 1km rectangle, centered around Wildhacks auditorium.

#Login using Facebook UserID and Access Token
URL: `/login`
Method: POST

Client request
```
{
    "userid": "whatever",
    "token": "your facebook access token"
}
```

Server response
```
{
    "success": true,
    "comment": "some description of the result"
}
```
In addition, a cookie will be set such that subsequent authentications only uses cookies (iOS automatically adds them).

#Check if a cookie is valid
URL: `/check_cookie`
Method: Get

Client request
```
(Nothing! XD)
```

Server response
```
{
    "success": true,
    "comment": "some description of the result"
}

```
If the check succeeded, the client may continue using the cookie (means they dont have to do anything extra).
If the check failed, the client must re-authenticate using facebook token.

#Update position
URL: `/update_location`
Method: POST

Client request
```
{
	username: “xxxx”,
	latitude: 0,
	longitude: 0,
	distance: 0,

	// time when client last fetched buildings data from server
	last_updated: 341294028		// epoch time in seconds
}
```

Server response
```
{
	success: true,
	buildings_removed: ["", ""],
	buildings_changed: {
	},
	buildings_added: {
		“yyyy-1”: {
			type: “base”,
			username: “yyyy”,
			hp: 100,
			latitude: 0,
			longitude: 0
		},
		“xxxx-1”: {
			type: “turret”,
			username: “xxxx”,
			hp: 1,
			latitude: 2,
			longitude: 3.14159
		}
	}
}
```

#Get 
