
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
   
    var viewController: ViewController!
    
    var location:CLLocation!
    
    var locationManager:CLLocationManager = CLLocationManager()
    
    var acceptBound = 0.02
    
    func setup(controller: ViewController){
        
        viewController = controller
        
        self.locationManager.delegate = self
        self.locationManager.desiredAccuracy = kCLLocationAccuracyBest
        self.locationManager.requestAlwaysAuthorization()
        
        //For testing
        start()
    }
    
    func start(){
        
        self.locationManager.startUpdatingLocation()
        
    }
    
    func locationManager(manager: CLLocationManager!, didChangeAuthorizationStatus status: CLAuthorizationStatus) {
        
    }
    
    func locationManager(manager: CLLocationManager!, didFailWithError error: NSError!) {

    }
    
    func locationManager(manager: CLLocationManager!, didUpdateLocations locations: [AnyObject]!) {
        
        location = locations[locations.count - 1] as CLLocation

        viewController.mapView.setToCenter(true)
        
        //setup the objects on the map if needed
        //else update the position of the general
        if objectsOnMap.myGeneral == nil{
            
            startGame()
            
        }else{
            objectsOnMap.updateAllPosition(location)
        }
        
    }
    
    func changeAcceptBound(zoomLevel: Double){
        acceptBound = 2 * pow(2, 18 - zoomLevel) / 100
    }
    
    func startGame(){
        
        objectsOnMap.setup(location)
        Resources.setValues(342.0, populations: 430, resource: 2343.0)
        
    }

    // get the latest location stored in the phone
    func getCurrentLocation()->CLLocation?{
        if location != nil{
            return location
        }else{
            return nil
        }
    }
    
}
