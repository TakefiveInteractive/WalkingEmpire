Assuming at this stage the entire map is limited to a 1km x 1km rectangle, centered around Wildhacks auditorium.

##Login using Facebook UserID and Access Token
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

##Check if a cookie is valid
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

##Update position
URL: `/update_location`

Method: POST

Client request
```
{
	username: "xxxx",
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
	"success": true,
	"base_removed": ["", ""],   // array of building IDs
	"base_changed": {           // when someone captured the base
	},
	"buildings_added": {        // when someone built a base
		"1234124": {
			"userid": "yyyy",
			"latitude": 0,
			"longitude": 0
		},
		"2345234": {
			"userid": "xxxx",
			"latitude": 2,
			"longitude": 3.14159
		}
	}
}
```

##Add a base
URL: `/add_base`

Method: POST

Client request
```
{
    "latitude": 0,
    "longtitude": 0
}
```

Server response
```
{
    "success": true,
    "baseID": "4141325"
}
```

##Get strctures in base before attacking a base
URL: `/lookup_base`

Method: POST

Client request
```
{
    "baseID": "4809483"
}
```

Server response
```
{
    "success": true,
    "structures": [
        {
            "id": "12341324231",
            "hp": 100,
            "type": "arrow_tower"
            "tileX": 3,     // 16x16 block of space
            "tileY": 5
        },
        {
            "id": "90147984721",
            "hp": 55,
            "type": "fire_tower"
            "tileX": 2,
            "tileY": 7
        }
    ]
}
```

##Submit results after attacking a base
URL: `/fought_base`

Method: POST

Client request
```
{
    "baseID": "2349080",
    "structures": [
        // as aforementioned
    ]
}
```

Server response
```
{
    "success": true
}
```

##Building new structures in a base
URL: `/build_structure`

Method: POST

Client request
```
{
    "baseID": "420893",
    "structure": {
        "type": "bombardier",
        "tileX": 3,
        "tileY": 12
    }
}
```

Server response
```
{
    "success": true,
    "structureID": "43124343"
}
```

