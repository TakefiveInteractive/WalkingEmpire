//
//  MapViewController.swift
//  WalkingEmpire
//
//  Created by Kedan Li on 14/11/22.
//  Copyright (c) 2014年 Kedan Li. All rights reserved.
//

import UIKit

class MapViewController: UIViewController, GMSMapViewDelegate{

    var map: GMSMapView!

    var general: GMSMarker!
    
    var setUpped: Bool = false
    
    var bases = [AnyObject]()
    
    override func viewDidLoad() {
        super.viewDidLoad()
        

        var camera: GMSCameraPosition = GMSCameraPosition.cameraWithLatitude(-33.86, longitude: 151.23, zoom:18)
    
        map = GMSMapView.mapWithFrame(CGRectZero, camera: camera)
        map.myLocationEnabled = false
        self.view = map

        // Do any additional setup after loading the view.
    }

    
    
    func setUpMap(){
        
        resetPosition()
        
        general = GMSMarker(position: LocationInfo.getCurrentLocation().coordinate)
        general.title = UserInfo.name
        general.snippet = "general"
        general.appearAnimation = kGMSMarkerAnimationPop
        general.map = map
        general.icon = UIImage(named: "UserIconBrown80x80MK2")
        general.groundAnchor = CGPointMake(0.5, 0.5)
        
    }
    
    func mapView(mapView: GMSMapView!, didTapAtCoordinate coordinate: CLLocationCoordinate2D) {
        
    }
    
    func resetPosition(){
        map.camera = GMSCameraPosition.cameraWithLatitude(LocationInfo.getCurrentLocation().coordinate.latitude, longitude: LocationInfo.getCurrentLocation().coordinate.longitude, zoom: 18)
    }
    
    func updateLocation(){
        
        if !setUpped{
            setUpMap()
            setUpped = true
        }
        
        general.position = LocationInfo.getCurrentLocation().coordinate

    }
    
    
    func mapView(mapView: GMSMapView!, didChangeCameraPosition position: GMSCameraPosition!) {
        
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    

    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
    }
    */

}
