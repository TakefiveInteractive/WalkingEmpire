//
//  ViewController.swift
//  WalkingEmpire
//
//  Created by Kedan Li on 14/11/20.
//  Copyright (c) 2014年 Kedan Li. All rights reserved.
//

import UIKit


class ViewController: UIViewController {

    //var map: GMSMapView!
    
    
    let latitude = 42.0534
    let longitude = -87.672
    
    override func viewDidLoad() {
        super.viewDidLoad()

        // Do any additional setup after loading the view, typically from a nib.
    }

    override func viewDidAppear(animated: Bool) {

    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }

    /*
    var camera: GMSCameraPosition = GMSCameraPosition.cameraWithLatitude(latitude, longitude: longitude, zoom:19)
    
    map = GMSMapView.mapWithFrame(CGRectZero, camera: camera)
    map.myLocationEnabled = true
    //Type None   no label
    map.mapType = kGMSTypeNormal
    self.view = map
    
    var marker = GMSMarker(position: CLLocationCoordinate2DMake(latitude, longitude))
    marker.title = "sdfds"
    marker.snippet = "sdfdssddssdf"
    marker.map = map
    
    marker.icon = UIImage(named: "circle")
    
    var southWest = CLLocationCoordinate2DMake(latitude + 0.0004, longitude - 0.0004)
    var northEast = CLLocationCoordinate2DMake(latitude - 0.0004, longitude + 0.0004)
    
    var overlayBounds = GMSCoordinateBounds(coordinate: southWest, coordinate: northEast)
    var overlay: GMSGroundOverlay = GMSGroundOverlay(bounds: overlayBounds, icon: UIImage(named: "bg"))
    overlay.bearing = 0
    
    overlay.map = map
    */
}

