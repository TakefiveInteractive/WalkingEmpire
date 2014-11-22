
//
//  LocationManager.swift
//  WalkingEmpire
//
//  Created by Kedan Li on 14/11/22.
//  Copyright (c) 2014年 Kedan Li. All rights reserved.
//

import UIKit
import CoreLocation

var LocationInfo: LocationManager = LocationManager()

class LocationManager: NSObject, CLLocationManagerDelegate{
   

    var theLocations = [CLLocation]()
    
    var location = CLLocationManager()
    
    func start(){
        
        self.location.delegate = self
        self.location.desiredAccuracy = kCLLocationAccuracyBest
        self.location.startUpdatingLocation()
        
        println(location)
    }
    
    func locationManager(manager: CLLocationManager!, didUpdateLocations locations: [AnyObject]!) {
        
        for var index: Int = 0; index < locations.count; index++ {
            theLocations.append(locations[index] as CLLocation)
        }
        println(locations)
    }
    
    
    func hasLocation()->Bool{
        if theLocations.count > 0{
        
            return true
        
        }else{
            return false
        }
        
    }
    func getCurrentLocation()->CLLocation{
        return theLocations[theLocations.count - 1]
    }
}
