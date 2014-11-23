//
//  ObjectsOnMap.swift
//  WalkingEmpire
//
//  Created by Kedan Li on 14/11/22.
//  Copyright (c) 2014年 Kedan Li. All rights reserved.
//

import UIKit
import CoreLocation

class ObjectsOnMap: GMSMarker {
    
    var user: String!
    
    init(user: String, longitude: CLLocationDegrees, latitude: CLLocationDegrees, map: GMSMapView){
        super.init()
        self.user = user
        self.map = map
        self.appearAnimation = kGMSMarkerAnimationPop
        self.position = CLLocationCoordinate2DMake(latitude, longitude)
        self.groundAnchor = CGPointMake(0.5, 0.5)
    }
    
}

class General: ObjectsOnMap{
    
    override init(user: String, longitude: CLLocationDegrees, latitude: CLLocationDegrees, map: GMSMapView){
        
        super.init(user: user, longitude: longitude, latitude: latitude, map: map)
        self.icon = UsefulFunctions.changeImageSize(UIImage(named: "OtherUserIcon")!, size: CGSizeMake(80, 80))
    }
    
}

class Base: ObjectsOnMap{
    
    var identifier: String!
    
    init(user: String, longitude: CLLocationDegrees, latitude: CLLocationDegrees, map: GMSMapView, identifier: String){
        
        super.init(user: user, longitude: longitude, latitude: latitude, map: map)

        self.identifier = identifier

        if user == UserInfo.userid{
            self.icon = UsefulFunctions.changeImageSize(UIImage(named: "ViewTowerBrown")!, size: CGSizeMake(50, 50))
        }else{
            self.icon = UsefulFunctions.changeImageSize(UIImage(named: "ViewTowerBlack")!, size: CGSizeMake(50, 50))
        }
    }
    
}


