
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
   
    var controller: ViewController!

    var theLocations = [CLLocation]()
    
    var location:CLLocationManager = CLLocationManager()
    
    func setup(control: ViewController){
        
        controller = control
        self.location.delegate = self
        self.location.desiredAccuracy = kCLLocationAccuracyBest

        
    }
    
    func start(){
        self.location.startUpdatingLocation()
        
    }
    
    func locationManager(manager: CLLocationManager!, didChangeAuthorizationStatus status: CLAuthorizationStatus) {
        
    }
    
    func locationManager(manager: CLLocationManager!, didFailWithError error: NSError!) {
        println(error)
    }
    
    func locationManager(manager: CLLocationManager!, didUpdateLocations locations: [AnyObject]!) {
        
        for var index: Int = 0; index < locations.count; index++ {
            theLocations.append(locations[index] as CLLocation)
        }
        
        if theLocations.count > 1{
            var distance = calculateDistance() * 10000

            if distance > 1{
                MoneyResoursePopulationManager.addValue(distance)
                (controller.childViewControllers[2] as ResourcesViewController).updateResources()
                removeAlldistance()
            }
        }
        (controller.childViewControllers[0] as MapViewController).updateLocation()
    }
    
    func removeAlldistance(){
        while theLocations.count > 1
        {
            theLocations.removeAtIndex(0)
        }
    }
    
    func calculateDistance()->Double{
        var x :Double = theLocations[0].coordinate.latitude - theLocations[theLocations.count - 1].coordinate.latitude
        var y :Double = theLocations[0].coordinate.longitude - theLocations[theLocations.count - 1].coordinate.longitude

        var distance = sqrt(x * x + y * y)
        
        return distance
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
