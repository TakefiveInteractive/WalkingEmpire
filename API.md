Assuming at this stage the entire map is limited to a 1km x 1km rectangle, centered around Wildhacks auditorium.

##Makeshift Server IP: 104.236.3.152

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
	"latitude": 0,
	"longitude": 0,
    "money": 10000          // or points, or score, or whatever

	// time when client last fetched buildings data from server
	"last_updated": 341294028		// epoch time in seconds
}
```
The client may sent 0 for last_updated during the first API call. Subsequent calls should specify the last_updated value provided by the server.

Server response: Case I
```
{
	"success": true,
	"base_removed": ["", ""],   // array of building IDs
	"base_changed": {           // when someone captured the base
	},
	"bases_added": {            // when someone built a base
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
	},
    "users": {      // shows other users
        // indexed by their facebook userIDs
        "4893210483": {
            "latitude": 0.4234,
            "longitude": 23
        },
        "4243242134": {
            "latitude": 43,
            "longitude": 11
        }
    },
    "last_updated": 4891243240
}
```
Server response: Case II
```
{
	"success": true,
	"bases": {        // list of all buildings
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
	},
    "users": {      // shows other users
        // indexed by their facebook userIDs
        "4893210483": {
            "latitude": 0.4234,
            "longitude": 23
        },
        "4243242134": {
            "latitude": 43,
            "longitude": 11
        }
    }
    "last_updated": 4213094897
}
```
The client is responsible for checking cases (e.g. by detecting whether `buildings` key is in the dictionary). In case one, the client should apply the changes to its local buildings data structure. In case two, the client have to rebuild the entire buildings data structure from the `bases` list. Case two will only happen if the client have not pulled changes from the server for a very long time (like five days). The list of changes is prohibitively expensive to maintain in the long run, so it is capped to five days max.

##Add a base
URL: `/add_base`

Method: POST

Client request
```
{
    "latitude": 0,
    "longitude": 0
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

Each base consists of 160 squares, layed out in 10 rows and 16 columns. They are to be shown in landscape mode in the mobile app.

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
            "tileX": 3,     // 10 x 16 block of space
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

##Submit results after attacking a base and failing
The client will maintain no. of soldiers as of now. This is called when all soldiers are expended but the base is still standing.

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

##Taking over a base
URL: `/takeover_base`

Method: POST

Client request
```
{
    "baseID": "414301280"
}
```

Server response
```
{
    "success": true
}
```

##Destroying a base
URL: `/destroy_base`

Method: POST

Client request
```
{
    "baseID": "48320948"
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

