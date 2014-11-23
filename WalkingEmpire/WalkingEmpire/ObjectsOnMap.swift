//
//  ObjectsOnMap.swift
//  WalkingEmpire
//
//  Created by Kedan Li on 14/11/22.
//  Copyright (c) 2014年 Kedan Li. All rights reserved.
//

import UIKit
import CoreLocation

class ObjectsOnMap: NSObject {
    
    var user: String!
    var coordinate: CLLocationCoordinate2D!
    
    init(user: String, longitude: CLLocationDegrees, latitude: CLLocationDegrees){
        self.user = user
        self.coordinate.latitude = latitude
        self.coordinate.longitude = longitude
    }
    
}

class General: ObjectsOnMap{
    
    var icon: UIImage = UIImage(named: "UserIconDarkGray80x80MK2")!
    
    override init(user: String, longitude: CLLocationDegrees, latitude: CLLocationDegrees) {
        
        super.init(user: user, longitude: longitude, latitude: latitude)
        
    }
    
}

class Building: ObjectsOnMap{
    /*
    var icon: UIImage = UIImage(named: "UserIconDarkGray80x80MK2")!
    
    override init(user: String, longitude: CLLocationDegrees, latitude: CLLocationDegrees, blo) {
        
        super.init(user: user, longitude: longitude, latitude: latitude)
        
    }
    */
}


