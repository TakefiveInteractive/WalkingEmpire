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
    var constructionOverlay: GMSGroundOverlay!
    
    var setUpped: Bool = false
    
    var bases = [AnyObject]()
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        var camera: GMSCameraPosition = GMSCameraPosition.cameraWithLatitude(-33.86, longitude: 151.23, zoom:18)
    
        map = GMSMapView.mapWithFrame(CGRectZero, camera: camera)
        map.delegate = self
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
        general.icon = UIImage(named: "UserIconBrown80x80Quantz")
        general.groundAnchor = CGPointMake(0.5, 0.5)
        
    }
    
    func setUpOverlay(){
        var southWest: CLLocationCoordinate2D = CLLocationCoordinate2DMake(LocationInfo.getCurrentLocation().coordinate.latitude + 0.01,LocationInfo.getCurrentLocation().coordinate.longitude + 0.01);
        var northEast: CLLocationCoordinate2D = CLLocationCoordinate2DMake(LocationInfo.getCurrentLocation().coordinate.latitude - 0.01,LocationInfo.getCurrentLocation().coordinate.longitude - 0.01)
        var overlayBounds: GMSCoordinateBounds = GMSCoordinateBounds(coordinate: northEast, coordinate: southWest)
        
        constructionOverlay = GMSGroundOverlay(bounds: overlayBounds, icon: UIImage(named: "circle"))
        constructionOverlay.bearing = 0
        constructionOverlay.map = map
    }
    
    func mapView(mapView: GMSMapView!, didTapAtCoordinate coordinate: CLLocationCoordinate2D) {
        println("sddsfsdf")
        if (self.parentViewController as ViewController).buildButton.selected{
            
        }
    }
    
    func mapView(mapView: GMSMapView!, didTapOverlay overlay: GMSOverlay!) {
        println("q134231f")
        
    }
    
    func resetPosition(){
        map.camera = GMSCameraPosition.cameraWithLatitude(LocationInfo.getCurrentLocation().coordinate.latitude,
            longitude: LocationInfo.getCurrentLocation().coordinate.longitude, zoom: 18)
    }
    
    func updateLocation(){
        
        if !setUpped{
            setUpMap()
            setUpped = true
        }
        
        general.position = LocationInfo.getCurrentLocation().coordinate

    }
    func updateOverlay(){
        
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
