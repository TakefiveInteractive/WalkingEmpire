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

    var tempBase: Base!

    var general: ObjectsOnMap!
    
    var constructionOverlay: GMSGroundOverlay!
    
    var setUpped: Bool = false
    
    var bases = [Base]()
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        var camera: GMSCameraPosition = GMSCameraPosition.cameraWithLatitude(-33.86, longitude: 151.23, zoom:17)
    
        map = GMSMapView.mapWithFrame(CGRectZero, camera: camera)
        map.mapType = kGMSTypeTerrain
        map.delegate = self
        map.setMinZoom(1, maxZoom: 15)
        map.myLocationEnabled = false
        map.indoorEnabled = false
        map.settings.scrollGestures = true
        
        map.animateToViewingAngle(60)
        self.view = map
        
        
        // Do any additional setup after loading the view.
    }

    func mapView(mapView: GMSMapView!, willMove gesture: Bool) {

        if gesture{
            //resetPosition()
        }
    }
    
    func setUpMap(){
        
        resetPosition()

        general = ObjectsOnMap(user: UserInfo.name, longitude: LocationInfo.getCurrentLocation().coordinate.longitude, latitude: LocationInfo.getCurrentLocation().coordinate.latitude, map: map)
        general.icon = UsefulFunctions.changeImageSize(UIImage(named: "UserIconCrown")!, size: CGSizeMake(80, 80))
        
    }
    
    func setUpOverlay(){
        var southWest: CLLocationCoordinate2D = CLLocationCoordinate2DMake(LocationInfo.getCurrentLocation().coordinate.latitude + 0.01,LocationInfo.getCurrentLocation().coordinate.longitude + 0.0117);
        var northEast: CLLocationCoordinate2D = CLLocationCoordinate2DMake(LocationInfo.getCurrentLocation().coordinate.latitude - 0.01,LocationInfo.getCurrentLocation().coordinate.longitude - 0.0117)
        var overlayBounds: GMSCoordinateBounds = GMSCoordinateBounds(coordinate: northEast, coordinate: southWest)
        
        constructionOverlay = GMSGroundOverlay(bounds: overlayBounds, icon: UIImage(named: "RegionCircle"))
        constructionOverlay.bearing = 0
        constructionOverlay.map = map
    }
    
    func mapView(mapView: GMSMapView!, didTapAtCoordinate coordinate: CLLocationCoordinate2D) {

        if (self.parentViewController as ViewController).buildButton.selected{
            var distance = UsefulFunctions.calculateCoordinateDistanceOfTwoPoints(coordinate, coordinate2: LocationInfo.getCurrentLocation().coordinate)
            if distance < 0.03{
                buildTheTower(coordinate)
            }
        }
    }
        
    func buildTheTower(coordinate: CLLocationCoordinate2D){
        
        (self.parentViewController as ViewController).buildBaseConfirm()
        
        map.camera = GMSCameraPosition.cameraWithLatitude(coordinate.latitude + 0.00033, longitude: coordinate.longitude, zoom: 15)
        
        tempBase = Base(user: UserInfo.userid, longitude: coordinate.longitude, latitude: coordinate.latitude, map: map, identifier: "")
        tempBase.map = nil
        tempBase.icon = UsefulFunctions.imageByApplyingAlpha(tempBase.icon, alpha: 0.6)
        
    }
    func mapView(mapView: GMSMapView!, didTapMarker marker: GMSMarker!) -> Bool {
        
    
        if find(bases as [GMSMarker], marker) != nil {
            (self.parentViewController as ViewController).displayBaseInfo()
        }
        
        return true
    }

    
    func mapView(mapView: GMSMapView!, didTapOverlay overlay: GMSOverlay!) {
        
    }
    
    func resetPosition(){
        
        map.animateToCameraPosition(GMSCameraPosition.cameraWithLatitude(LocationInfo.getCurrentLocation().coordinate.latitude,
            longitude: LocationInfo.getCurrentLocation().coordinate.longitude, zoom: 15))
        
    }
    
    func updateLocation(){
        
        
        if !setUpped{
            setUpMap()
            setUpped = true
        }
        
        general.position = LocationInfo.getCurrentLocation().coordinate

       // resetPosition()
        
        if constructionOverlay? != nil{
            updateOverlay()
        }
        
    }
    
    func updateOverlay(){
        var southWest: CLLocationCoordinate2D = CLLocationCoordinate2DMake(LocationInfo.getCurrentLocation().coordinate.latitude + 0.01,LocationInfo.getCurrentLocation().coordinate.longitude + 0.0117);
        var northEast: CLLocationCoordinate2D = CLLocationCoordinate2DMake(LocationInfo.getCurrentLocation().coordinate.latitude - 0.01,LocationInfo.getCurrentLocation().coordinate.longitude - 0.0117)
        var overlayBounds: GMSCoordinateBounds = GMSCoordinateBounds(coordinate: northEast, coordinate: southWest)
        constructionOverlay?.bounds = overlayBounds

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
